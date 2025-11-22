<?php
ob_start(); // Giải quyết lỗi session_start()
?>

<?php 
// Include header đúng đường dẫn
include __DIR__ . '/../../layouts/header.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Danh sách bài viết - Danh mục Học tập</title>
    <link rel="stylesheet" href="/studentdiary/public/css/style.css">
    <link rel="stylesheet" href="/studentdiary/public/css/category.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
<div class="container">
    <div class="intro-box">
        <p class="intro-text">
         Học tập là hành trình dài không chỉ cần kiến thức mà còn cần chiến lược và động lực. Trong danh mục này, mình sẽ chia sẻ những bài viết hữu ích về cách học hiệu quả, mẹo ghi nhớ, ôn luyện thi cử và kinh nghiệm học đại học để bạn luôn tự tin chinh phục mọi thử thách trên giảng đường.
        </p>
    </div>

    <div class="posts-list" id="postsList"></div>
</div>

<script>
    const postsList = document.getElementById("postsList");

    fetch("index.php?action=study_list") // <-- sửa url fetch cho đúng router frontend
        .then(res => {
            if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
            return res.json();
        })
        .then(data => renderPosts(data))
        .catch(error => {
            console.error("Lỗi khi tải bài viết:", error);
            postsList.innerHTML = "<p>Không thể tải bài viết.</p>";
        });

    function renderPosts(posts) {
        if (!posts.length) {
            postsList.innerHTML = "<p>Chưa có bài viết nào.</p>";
            return;
        }
        postsList.innerHTML = "";
        posts.forEach(post => {
            const postCard = document.createElement("div");
            postCard.className = "post-card";

            postCard.innerHTML = `
                <img src="/studentdiary/public/uploads/${post.image}" alt="${post.title}">
                <div class="post-content">
                    <div class="post-title">${post.title}</div>
                    <a href="index.php?action=show_post&id=${post.id}" class="btn-view">Xem tiếp</a>
                </div>
            `;
            postsList.appendChild(postCard);
        });
    }
</script>

<?php 
// Include footer đúng đường dẫn
include __DIR__ . '/../../layouts/footer.php'; 
?>