<?php
ob_start(); // Thêm dòng này vào đầu file để giải quyết lỗi session_start()
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Danh sách bài viết - Danh mục Kỹ năng</title>
    <link rel="stylesheet" href="/studentdiary/public/css/style.css">
    <link rel="stylesheet" href="/studentdiary/public/css/category.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
  <?php include '../../layouts/header.php'; ?>
  <div class="container">
    <div class="intro-box">
      <p class="intro-text">
        Kỹ năng là chìa khóa giúp bạn phát triển bản thân và thành công trong học tập cũng như công việc. Tại đây, mình sẽ chia sẻ những bài viết bổ ích giúp bạn nâng cao kỹ năng mềm, quản lý thời gian và giao tiếp hiệu quả trong cuộc sống đại học.
      </p>
    </div>

  <div class="posts-list" id="postsList">
    </div>
</div>

<script>
    const postsList = document.getElementById("postsList");

    fetch("index.php?controller=post&action=skill_list")
        .then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            renderPosts(data);
        })
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
                <img src="${post.thumbnail}" alt="${post.title}">
                <div class="post-content">
                    <div class="post-title">${post.title}</div>
                    <a href="Detail.php?id=${post.id}" class="btn-view">Xem tiếp</a>
                </div>
            `;
            postsList.appendChild(postCard);
        });
    }
</script>
<?php 
// ĐÃ SỬA: Thay thế '../../footer/header.php' bằng đường dẫn phổ biến nhất: '../../layouts/footer.php'
include '../../layouts/footer.php'; 
?>
