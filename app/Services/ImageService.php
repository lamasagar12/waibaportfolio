<?php

class ImageService
{
    public static function upload(array $file, array $meta = []): ?array
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $config = app_config();
        if ($file['size'] > $config['max_upload_size']) {
            return null;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $config['allowed_image_types'], true)) {
            return null;
        }

        $ext = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            default => 'jpg',
        };

        $uploadDir = $config['upload_path'];
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = uniqid('sg_', true) . '.' . $ext;
        $filepath = $uploadDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $filepath)) {
            return null;
        }

        $width = null;
        $height = null;
        $info = @getimagesize($filepath);
        if ($info) {
            $width = $info[0];
            $height = $info[1];
        }

        $fileUrl = upload_url($filename);
        $db = get_db();
        $stmt = $db->prepare(
            'INSERT INTO media_files (filename, original_name, file_path, file_url, mime_type, file_size, alt_text, title, caption, description, width, height)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $filename,
            $file['name'],
            $filepath,
            $fileUrl,
            $mime,
            $file['size'],
            $meta['alt_text'] ?? '',
            $meta['title'] ?? pathinfo($file['name'], PATHINFO_FILENAME),
            $meta['caption'] ?? '',
            $meta['description'] ?? '',
            $width,
            $height,
        ]);

        $id = (int)$db->lastInsertId();
        return self::find($id);
    }

    public static function find(int $id): ?array
    {
        $db = get_db();
        $stmt = $db->prepare('SELECT * FROM media_files WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function all(array $filters = []): array
    {
        $db = get_db();
        $sql = 'SELECT * FROM media_files WHERE 1=1';
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= ' AND (original_name LIKE ? OR alt_text LIKE ? OR title LIKE ?)';
            $search = '%' . $filters['search'] . '%';
            $params = array_merge($params, [$search, $search, $search]);
        }

        if (!empty($filters['mime'])) {
            $sql .= ' AND mime_type LIKE ?';
            $params[] = $filters['mime'] . '%';
        }

        $sql .= ' ORDER BY created_at DESC';

        if (!empty($filters['limit'])) {
            $sql .= ' LIMIT ' . (int)$filters['limit'];
        }

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function update(int $id, array $data): bool
    {
        $db = get_db();
        $stmt = $db->prepare(
            'UPDATE media_files SET alt_text = ?, title = ?, caption = ?, description = ? WHERE id = ?'
        );
        return $stmt->execute([
            $data['alt_text'] ?? '',
            $data['title'] ?? '',
            $data['caption'] ?? '',
            $data['description'] ?? '',
            $id,
        ]);
    }

    public static function delete(int $id): bool
    {
        $media = self::find($id);
        if (!$media) return false;
        if (file_exists($media['file_path'])) {
            @unlink($media['file_path']);
        }
        $db = get_db();
        $stmt = $db->prepare('DELETE FROM media_files WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
