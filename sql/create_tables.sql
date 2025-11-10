
CREATE DATABASE IF NOT EXISTS studentdb
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE studentdb;


-- BẢNG QUẢN TRỊ VIÊN

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100),
    role VARCHAR(50) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- BẢNG NGƯỜI DÙNG (SINH VIÊN)

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE COMMENT 'Tên đăng nhập (có thể là email)',
    password VARCHAR(255) NOT NULL COMMENT 'Mật khẩu đã hash',
    fullname VARCHAR(100),
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- BẢNG DANH MỤC BÀI VIẾT

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    slug VARCHAR(255) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- BẢNG BÀI VIẾT (POSTS)

CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT,
    author VARCHAR(100) DEFAULT 'Admin',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    image VARCHAR(255),
    status VARCHAR(20) DEFAULT 'published',
    category_id INT,
    category VARCHAR(50) DEFAULT 'Đời sống',
    FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================
-- BẢNG BÌNH LUẬN (COMMENTS)
-- ==============================
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT DEFAULT NULL,
    parent_id INT DEFAULT 0,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    comment TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT NULL,
    status TINYINT(1) DEFAULT 1,
    is_admin TINYINT(1) DEFAULT 0,
    FOREIGN KEY (post_id) REFERENCES posts(id)
        ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- BẢNG ĐÁNH GIÁ BÌNH LUẬN (LIKE/DISLIKE)

CREATE TABLE IF NOT EXISTS comment_ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comment_id INT NOT NULL,
    user_id INT DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    rating_type ENUM('like','dislike') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (comment_id) REFERENCES comments(id)
        ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    UNIQUE KEY unique_rating_user (comment_id, user_id),
    UNIQUE KEY unique_rating_ip (comment_id, ip_address)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
