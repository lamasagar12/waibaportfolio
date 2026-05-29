CREATE DATABASE IF NOT EXISTS sagarportfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sagarportfolio;

CREATE TABLE IF NOT EXISTS admin_users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    username VARCHAR(80) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NULL,
    reset_token VARCHAR(100) NULL,
    reset_expires DATETIME NULL,
    last_login DATETIME NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS seo_settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    website_title VARCHAR(255) DEFAULT 'Sagar Waiba',
    website_tagline VARCHAR(255) DEFAULT 'SEO Strategist & Digital Growth Expert',
    default_meta_title VARCHAR(255) NULL,
    default_meta_description TEXT NULL,
    default_meta_keywords TEXT NULL,
    site_author VARCHAR(150) NULL,
    canonical_url VARCHAR(255) NULL,
    robots_index ENUM('index','noindex') DEFAULT 'index',
    robots_follow ENUM('follow','nofollow') DEFAULT 'follow',
    og_title VARCHAR(255) NULL,
    og_description TEXT NULL,
    og_image VARCHAR(255) NULL,
    twitter_title VARCHAR(255) NULL,
    twitter_description TEXT NULL,
    twitter_image VARCHAR(255) NULL,
    twitter_card_type VARCHAR(50) DEFAULT 'summary_large_image',
    ga4_id VARCHAR(50) NULL,
    gtm_id VARCHAR(50) NULL,
    gsc_verification VARCHAR(255) NULL,
    bing_verification VARCHAR(255) NULL,
    facebook_pixel_id VARCHAR(50) NULL,
    custom_head_scripts TEXT NULL,
    custom_body_scripts TEXT NULL,
    person_schema JSON NULL,
    organization_schema JSON NULL,
    website_schema JSON NULL,
    breadcrumb_schema TINYINT(1) DEFAULT 1,
    article_schema TINYINT(1) DEFAULT 1,
    local_business_schema JSON NULL,
    sitemap_enabled TINYINT(1) DEFAULT 1,
    robots_txt TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS page_seo (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_key VARCHAR(50) NOT NULL UNIQUE,
    page_title VARCHAR(255) NOT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    focus_keyword VARCHAR(150) NULL,
    secondary_keywords TEXT NULL,
    slug VARCHAR(150) NOT NULL,
    canonical_url VARCHAR(255) NULL,
    og_title VARCHAR(255) NULL,
    og_description TEXT NULL,
    og_image VARCHAR(255) NULL,
    twitter_title VARCHAR(255) NULL,
    twitter_description TEXT NULL,
    twitter_image VARCHAR(255) NULL,
    robots_index ENUM('index','noindex') DEFAULT 'index',
    robots_follow ENUM('follow','nofollow') DEFAULT 'follow',
    schema_type VARCHAR(50) DEFAULT 'WebPage',
    custom_schema JSON NULL,
    seo_notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS blog_categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    description TEXT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS blog_tags (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS media_files (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_url VARCHAR(255) NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    file_size INT UNSIGNED DEFAULT 0,
    alt_text VARCHAR(255) NULL,
    title VARCHAR(255) NULL,
    caption TEXT NULL,
    description TEXT NULL,
    width INT UNSIGNED NULL,
    height INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS blog_posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT NULL,
    content LONGTEXT NULL,
    featured_image_id INT UNSIGNED NULL,
    category_id INT UNSIGNED NULL,
    author_id INT UNSIGNED NULL,
    author_name VARCHAR(150) NULL,
    status ENUM('draft','published','scheduled') DEFAULT 'draft',
    publish_date DATETIME NULL,
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    focus_keyword VARCHAR(150) NULL,
    secondary_keywords TEXT NULL,
    lsi_keywords TEXT NULL,
    canonical_url VARCHAR(255) NULL,
    robots_index ENUM('index','noindex') DEFAULT 'index',
    robots_follow ENUM('follow','nofollow') DEFAULT 'follow',
    reading_time INT UNSIGNED DEFAULT 0,
    word_count INT UNSIGNED DEFAULT 0,
    seo_score INT UNSIGNED DEFAULT 0,
    og_title VARCHAR(255) NULL,
    og_description TEXT NULL,
    og_image_id INT UNSIGNED NULL,
    twitter_title VARCHAR(255) NULL,
    twitter_description TEXT NULL,
    twitter_image_id INT UNSIGNED NULL,
    twitter_card_type VARCHAR(50) DEFAULT 'summary_large_image',
    custom_schema JSON NULL,
    featured_image_alt VARCHAR(255) NULL,
    featured_image_title VARCHAR(255) NULL,
    featured_image_caption TEXT NULL,
    featured_image_description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (featured_image_id) REFERENCES media_files(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES admin_users(id) ON DELETE SET NULL,
    FOREIGN KEY (og_image_id) REFERENCES media_files(id) ON DELETE SET NULL,
    FOREIGN KEY (twitter_image_id) REFERENCES media_files(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS blog_post_tags (
    post_id INT UNSIGNED NOT NULL,
    tag_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES blog_tags(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS blog_faqs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id INT UNSIGNED NOT NULL,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS anchor_links (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id INT UNSIGNED NULL,
    anchor_text VARCHAR(255) NOT NULL,
    target_url VARCHAR(500) NOT NULL,
    link_type ENUM('internal','external') DEFAULT 'internal',
    rel_attribute VARCHAR(100) DEFAULT 'follow',
    open_new_tab TINYINT(1) DEFAULT 0,
    location_hint VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS redirects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    source_url VARCHAR(255) NOT NULL,
    target_url VARCHAR(255) NOT NULL,
    redirect_type SMALLINT DEFAULT 301,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS seo_activity_log (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    entity_type VARCHAR(50) NOT NULL,
    entity_id INT UNSIGNED NULL,
    action VARCHAR(100) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO seo_settings (website_title, website_tagline, default_meta_title, default_meta_description, site_author, canonical_url, robots_txt)
VALUES (
    'Sagar Waiba',
    'SEO Strategist & Digital Growth Expert',
    'Sagar Waiba | SEO Strategist & Digital Growth Expert',
    'Premium SEO strategist helping brands grow with data-driven search optimization, content strategy, and digital growth.',
    'Sagar Waiba',
    'http://localhost/sagarportfolio',
    "User-agent: *\nAllow: /\nSitemap: http://localhost/sagarportfolio/sitemap.xml"
);

INSERT INTO page_seo (page_key, page_title, meta_title, meta_description, slug, focus_keyword) VALUES
('home', 'Home', 'Sagar Waiba | SEO Strategist & Digital Growth Expert', 'Data-driven SEO strategist specializing in organic growth, technical SEO, and content optimization.', 'home', 'SEO strategist'),
('about', 'About', 'About Sagar Waiba | SEO Expert', 'Learn about Sagar Waiba — SEO strategist focused on measurable digital growth.', 'about', 'about sagar waiba'),
('skills', 'Skills', 'SEO Skills & Expertise | Sagar Waiba', 'Technical SEO, content strategy, link building, analytics, and growth marketing skills.', 'skills', 'SEO skills'),
('experience', 'Experience', 'Professional Experience | Sagar Waiba', 'Professional SEO and digital marketing experience across multiple industries.', 'experience', 'SEO experience'),
('projects', 'Projects', 'SEO Projects & Case Studies | Sagar Waiba', 'Explore SEO projects, case studies, and digital growth results.', 'projects', 'SEO projects'),
('certifications', 'Certifications', 'Certifications | Sagar Waiba', 'Professional certifications in SEO, analytics, and digital marketing.', 'certifications', 'SEO certifications'),
('contact', 'Contact', 'Contact Sagar Waiba | SEO Consultation', 'Get in touch for SEO consultation and digital growth strategy.', 'contact', 'contact SEO expert'),
('blog', 'Blog', 'SEO Blog & Insights | Sagar Waiba', 'Latest SEO tips, strategies, and digital growth insights.', 'blog', 'SEO blog');

INSERT INTO blog_categories (name, slug, description, meta_title, meta_description) VALUES
('SEO Strategy', 'seo-strategy', 'SEO strategy articles and guides', 'SEO Strategy Articles', 'Expert SEO strategy articles'),
('Technical SEO', 'technical-seo', 'Technical SEO tips and tutorials', 'Technical SEO Articles', 'Technical SEO guides and tutorials'),
('Content Marketing', 'content-marketing', 'Content marketing and optimization', 'Content Marketing Articles', 'Content marketing insights');

INSERT INTO admin_users (name, email, username, password, status)
VALUES ('Sagar Waiba', 'admin@sagarwaiba.com', 'admin', '$2y$10$qqeq4C.vp01Dnu17zFR41u7YqFIhISSQ7KYfgauhpMZsL.6wwe0Mq', 'active');
