<?php

class BlogModel
{
    public static function all(array $filters = [], int $page = 1, int $perPage = 10): array
    {
        $db = get_db();
        $where = ['1=1'];
        $params = [];

        if (!empty($filters['status'])) {
            $where[] = 'bp.status = ?';
            $params[] = $filters['status'];
        }
        if (!empty($filters['category_id'])) {
            $where[] = 'bp.category_id = ?';
            $params[] = $filters['category_id'];
        }
        if (!empty($filters['author_id'])) {
            $where[] = 'bp.author_id = ?';
            $params[] = $filters['author_id'];
        }
        if (!empty($filters['search'])) {
            $where[] = '(bp.title LIKE ? OR bp.slug LIKE ? OR bp.excerpt LIKE ?)';
            $search = '%' . $filters['search'] . '%';
            $params = array_merge($params, [$search, $search, $search]);
        }

        $whereSql = implode(' AND ', $where);
        $offset = ($page - 1) * $perPage;

        $countStmt = $db->prepare("SELECT COUNT(*) FROM blog_posts bp WHERE $whereSql");
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();

        $sql = "SELECT bp.*, bc.name as category_name, mf.file_url as featured_image_url
                FROM blog_posts bp
                LEFT JOIN blog_categories bc ON bc.id = bp.category_id
                LEFT JOIN media_files mf ON mf.id = bp.featured_image_id
                WHERE $whereSql
                ORDER BY bp.updated_at DESC
                LIMIT $perPage OFFSET $offset";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        return ['data' => $stmt->fetchAll(), 'total' => $total, 'pages' => (int)ceil($total / $perPage)];
    }

    public static function find(int $id): ?array
    {
        $db = get_db();
        $stmt = $db->prepare(
            'SELECT bp.*, bc.name as category_name, mf.file_url as featured_image_url
             FROM blog_posts bp
             LEFT JOIN blog_categories bc ON bc.id = bp.category_id
             LEFT JOIN media_files mf ON mf.id = bp.featured_image_id
             WHERE bp.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findBySlug(string $slug): ?array
    {
        $db = get_db();
        $stmt = $db->prepare(
            "SELECT bp.*, bc.name as category_name, bc.slug as category_slug, mf.file_url as featured_image_url
             FROM blog_posts bp
             LEFT JOIN blog_categories bc ON bc.id = bp.category_id
             LEFT JOIN media_files mf ON mf.id = bp.featured_image_id
             WHERE bp.slug = ? AND bp.status = 'published' LIMIT 1"
        );
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public static function getTags(int $postId): array
    {
        $db = get_db();
        $stmt = $db->prepare(
            'SELECT bt.* FROM blog_tags bt
             INNER JOIN blog_post_tags bpt ON bpt.tag_id = bt.id
             WHERE bpt.post_id = ?'
        );
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    public static function getFaqs(int $postId): array
    {
        $db = get_db();
        $stmt = $db->prepare('SELECT * FROM blog_faqs WHERE post_id = ? ORDER BY sort_order ASC, id ASC');
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    public static function getAnchors(int $postId): array
    {
        $db = get_db();
        $stmt = $db->prepare('SELECT * FROM anchor_links WHERE post_id = ? ORDER BY id ASC');
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    public static function save(array $data, ?int $id = null): int
    {
        $db = get_db();
        
        // Extract relational data that doesn't belong to the main table
        $tags = $data['tags'] ?? [];
        $faqs = $data['faqs'] ?? [];
        $anchors = $data['anchors'] ?? [];
        unset($data['tags'], $data['faqs'], $data['anchors']);

        $data['word_count'] = count_words($data['content'] ?? '');
        $data['reading_time'] = reading_time($data['content'] ?? '');
        $seo = SeoService::calculateBlogSeoScore($data);
        $data['seo_score'] = $seo['score'];

        if ($id) {
            $fields = array_keys($data);
            $sets = array_map(fn($f) => "$f = ?", $fields);
            $values = array_values($data);
            $values[] = $id;
            $sql = 'UPDATE blog_posts SET ' . implode(', ', $sets) . ' WHERE id = ?';
            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            
            self::syncTags($id, $tags);
            self::syncFaqs($id, $faqs);
            self::syncAnchors($id, $anchors);
            
            log_seo_activity('blog', $id, 'updated', 'Blog post updated: ' . ($data['title'] ?? ''));
            return $id;
        }

        $fields = array_keys($data);
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));
        $sql = 'INSERT INTO blog_posts (' . implode(', ', $fields) . ') VALUES (' . $placeholders . ')';
        $stmt = $db->prepare($sql);
        $stmt->execute(array_values($data));
        $newId = (int)$db->lastInsertId();
        
        self::syncTags($newId, $tags);
        self::syncFaqs($newId, $faqs);
        self::syncAnchors($newId, $anchors);
        
        log_seo_activity('blog', $newId, 'created', 'Blog post created: ' . ($data['title'] ?? ''));
        return $newId;
    }

    public static function delete(int $id): bool
    {
        $db = get_db();
        $stmt = $db->prepare('DELETE FROM blog_posts WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function syncTags(int $postId, array $tagIds): void
    {
        $db = get_db();
        $db->prepare('DELETE FROM blog_post_tags WHERE post_id = ?')->execute([$postId]);
        $stmt = $db->prepare('INSERT INTO blog_post_tags (post_id, tag_id) VALUES (?, ?)');
        foreach ($tagIds as $tagId) {
            if ($tagId) $stmt->execute([$postId, (int)$tagId]);
        }
    }

    public static function syncFaqs(int $postId, array $faqs): void
    {
        $db = get_db();
        $db->prepare('DELETE FROM blog_faqs WHERE post_id = ?')->execute([$postId]);
        $stmt = $db->prepare('INSERT INTO blog_faqs (post_id, question, answer, sort_order) VALUES (?, ?, ?, ?)');
        foreach ($faqs as $i => $faq) {
            if (!empty($faq['question']) && !empty($faq['answer'])) {
                $stmt->execute([$postId, $faq['question'], $faq['answer'], $i]);
            }
        }
    }

    public static function syncAnchors(int $postId, array $anchors): void
    {
        $db = get_db();
        $db->prepare('DELETE FROM anchor_links WHERE post_id = ?')->execute([$postId]);
        $stmt = $db->prepare(
            'INSERT INTO anchor_links (post_id, anchor_text, target_url, link_type, rel_attribute, open_new_tab, location_hint) VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        foreach ($anchors as $anchor) {
            if (!empty($anchor['anchor_text']) && !empty($anchor['target_url'])) {
                $stmt->execute([
                    $postId,
                    $anchor['anchor_text'],
                    $anchor['target_url'],
                    $anchor['link_type'] ?? 'internal',
                    $anchor['rel_attribute'] ?? 'follow',
                    !empty($anchor['open_new_tab']) ? 1 : 0,
                    $anchor['location_hint'] ?? '',
                ]);
            }
        }
    }

    public static function stats(): array
    {
        $db = get_db();
        return [
            'total' => (int)$db->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn(),
            'published' => (int)$db->query("SELECT COUNT(*) FROM blog_posts WHERE status = 'published'")->fetchColumn(),
            'draft' => (int)$db->query("SELECT COUNT(*) FROM blog_posts WHERE status = 'draft'")->fetchColumn(),
            'scheduled' => (int)$db->query("SELECT COUNT(*) FROM blog_posts WHERE status = 'scheduled'")->fetchColumn(),
        ];
    }

    public static function related(int $postId, ?int $categoryId, int $limit = 3): array
    {
        $db = get_db();
        $stmt = $db->prepare(
            "SELECT bp.*, mf.file_url as featured_image_url FROM blog_posts bp
             LEFT JOIN media_files mf ON mf.id = bp.featured_image_id
             WHERE bp.status = 'published' AND bp.id != ? AND bp.category_id = ?
             ORDER BY bp.publish_date DESC LIMIT $limit"
        );
        $stmt->execute([$postId, $categoryId]);
        return $stmt->fetchAll();
    }

    public static function prevNext(int $postId, ?string $publishDate): array
    {
        $db = get_db();
        $prev = $db->prepare("SELECT id, title, slug FROM blog_posts WHERE status = 'published' AND publish_date < ? ORDER BY publish_date DESC LIMIT 1");
        $prev->execute([$publishDate]);
        $next = $db->prepare("SELECT id, title, slug FROM blog_posts WHERE status = 'published' AND publish_date > ? ORDER BY publish_date ASC LIMIT 1");
        $next->execute([$publishDate]);
        return ['prev' => $prev->fetch() ?: null, 'next' => $next->fetch() ?: null];
    }
}
