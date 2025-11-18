-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 13, 2025 lúc 06:23 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `student_diary`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `fullname`, `role`) VALUES
(1, 'admin@gmail.com', '12345678', 'Quản trị viên', 'admin');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Kỹ năng', 'ky-nang', '2025-11-13 22:15:10'),
(2, 'Đời sống', 'doi-song', '2025-11-13 22:15:10'),
(3, 'Học tập', 'hoc-tap', '2025-11-13 22:15:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `comment` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `parent_id`, `name`, `email`, `ip_address`, `comment`, `created_at`, `updated_at`, `status`, `is_admin`) VALUES
(19, 38, NULL, 0, 'Lan', NULL, NULL, 'bài viết rất hữu ích', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 0),
(23, 38, NULL, 19, 'Student Diary', NULL, NULL, 'Cảm ơn bạn', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 1),
(28, 39, NULL, 0, 'Kiên', NULL, NULL, 'Cảm ơn ad nhiều vì chia sẻ trên', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 0, 0),
(29, 39, NULL, 28, 'Student Diary', NULL, NULL, 'Cảm ơn bạn', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 1),
(51, 38, 4, 0, 'Vũ Đức Huy', NULL, NULL, 'ok', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 0),
(52, 38, 4, 0, 'Vũ Đức Huy', NULL, NULL, 'bài viết hay', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 0),
(53, 38, 5, 0, 'Ngọc an', NULL, NULL, 'bài viết hay quá', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 0, 0),
(54, 38, NULL, 52, 'Student Diary', 'admin@example.com', NULL, 'Cảm ơn bạn', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 1),
(65, 38, 6, 53, 'linh an', '', NULL, 'hay thật bạn oi', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 0),
(68, 38, 6, 0, 'linh an', 'linhan@gmail.com', NULL, 'hay nha', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 0),
(69, 38, 7, 0, 'Nguyễn Ngọc Mai Hy', 'hope@gmail.com', NULL, 'AD chia sẻ đúng lúc quá', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 0),
(70, 38, NULL, 69, 'Student Diary', 'admin@example.com', NULL, 'Cảm ơn bạn nhé', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 1),
(71, 37, 7, 0, 'Nguyễn Ngọc Mai Hy', 'hope@gmail.com', NULL, 'Cảm ơn vì chia sẻ của ad', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 0),
(72, 39, 1, 0, 'Người dùng thử', 'testuser@example.com', NULL, 'hi', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `author` varchar(100) DEFAULT 'Admin',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'published',
  `category_id` int(11) DEFAULT NULL,
  `category` varchar(50) DEFAULT 'Đời sống'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `author`, `created_at`, `updated_at`, `image`, `status`, `category_id`, `category`) VALUES
(36, 'Trì Hoãn Là Gì Mà Cứ \"Quấn Lấy\" Chúng Mình? 🌷✨ Bí Kíp Nhẹ Nhàng Để Lấy Lại \"Flow\" Học Tập!', '<p data-sourcepos=\"11:1-11:39\"><em><span style=\"font-family: \'times new roman\', times;\">Chào bạn thân mến của Student Diary, 👋</span></em></p>\r\n<p data-sourcepos=\"13:1-13:415\"><span style=\"font-family: \'times new roman\', times;\">Bạn có đang ngồi đọc những dòng này trong khi trong đầu vẫn còn một danh sách dài những việc cần làm không? Từ bài tập nhóm, bài luận cho đến những kế hoạch cá nhân, đôi khi chúng mình cứ \"khất\" từ hôm nay sang ngày mai, rồi bỗng thấy deadline đã \"dí sát nút\" mà mình thì vẫn loay hoay mãi. Cảm giác lúc đó thật sự không dễ chịu chút nào, đúng không? Vừa hơi lo lắng, vừa tự trách mình sao lại chưa bắt tay vào làm.</span></p>\r\n<p data-sourcepos=\"15:1-15:487\"><span style=\"font-family: \'times new roman\', times;\">Mình cũng từng trải qua những cảm giác đó rất nhiều. Có những hôm, chỉ một bài tập đơn giản thôi mà mình cứ trì hoãn mãi, rồi cuối cùng phải thức khuya \"vật lộn\" để hoàn thành. Sau vài lần như vậy, mình nhận ra không thể cứ để \"trì hoãn\" làm bạn mãi được. Mình đã thử tìm hiểu, thử áp dụng nhiều cách khác nhau, và dần dần tìm ra những phương pháp nhẹ nhàng nhưng hiệu quả để \"làm hòa\" với bản thân và vượt qua thói quen này. Hôm nay, mình muốn chia sẻ với bạn những gì mình đã học được.</span></p>\r\n<h3 data-sourcepos=\"17:1-17:68\"><span style=\"font-family: \'times new roman\', times;\"><strong>Góc Nhỏ Tâm Sự: Vì Sao Trì Hoãn Cứ \"Tấn Công\" Chúng Mình? 🤔</strong></span></h3>\r\n<p data-sourcepos=\"19:1-19:1111\"><span style=\"font-family: \'times new roman\', times;\">Trước khi tìm cách vượt qua thói quen trì hoãn, mình nhận ra điều quan trọng là phải hiểu xem tại sao chúng mình lại hay \"khất\" công việc đến thế. Đôi khi, chúng mình trì hoãn không phải vì lười biếng đâu. Có thể là bởi vì nhiệm vụ trông quá \"khổng lồ\", khiến mình cảm thấy choáng ngợp và không biết phải bắt đầu từ đâu. Nhìn vào một dự án lớn hay một bài luận dài cả chục trang, tự nhiên mình lại muốn \"đẩy\" nó lại thôi. Cũng có khi mình muốn làm lắm, nhưng lại thiếu một định hướng rõ ràng về bước đầu tiên là gì, không có một lộ trình cụ thể để đi. Hay đôi khi, nỗi lo lắng về việc không làm tốt, hoặc áp lực về sự hoàn hảo cũng khiến mình cứ mãi chần chừ không dám bắt đầu. Và tất nhiên, chúng ta không thể không kể đến \"tiếng gọi\" của sự xao nhãng từ mạng xã hội, một bộ phim hay, hay những câu chuyện \"tám\" bất tận với bạn bè... Có quá nhiều điều hấp dẫn ngoài kia khiến mình dễ dàng bị cuốn đi. Cuối cùng, cái tâm lý \"tí nữa làm\" hay \"để mai làm\" là một câu nói quen thuộc nhưng lại là khởi nguồn của nhiều sự chậm trễ. \"Tí nữa\", \"chút nữa thôi\", rồi \"mai làm\"... và cái \"tí nữa\" đó cứ thế trôi đi mất. ⏳</span></p>\r\n<h3 data-sourcepos=\"21:1-21:59\"><span style=\"font-family: \'times new roman\', times;\"><strong>Bí Kíp Nhẹ Nhàng Của Mình Để \"Đánh Bay\" Trì Hoãn 🌸</strong></span></h3>\r\n<p data-sourcepos=\"23:1-23:241\"><span style=\"font-family: \'times new roman\', times;\">Sau nhiều lần thử nghiệm, mình đã tìm ra vài \"chiêu\" nhỏ mà mình thấy rất hiệu quả. Chúng không quá \"đao to búa lớn\", mà chỉ đơn giản là những điều chỉnh nhỏ trong cách mình tiếp cận công việc, giúp mình lấy lại \"flow\" một cách tự nhiên hơn.</span></p>\r\n<p data-sourcepos=\"25:1-25:495\"><span style=\"font-family: \'times new roman\', times;\">Thay vì cứ nhìn chằm chằm vào cả một \"núi\" công việc và thấy nản chí, mình học cách \"cắn\" từng miếng nhỏ, chia để trị. Mình chia nhỏ công việc lớn thành những \"hạt giống\" bé xíu. Ví dụ, với một bài luận, mình chỉ đặt mục tiêu \"hôm nay tìm 3 tài liệu\", hay \"viết 2 câu mở bài\" thôi. Khi mục tiêu nhỏ và dễ dàng đạt được, mình có động lực để bắt đầu và cảm thấy tự tin hơn. Cứ hoàn thành từng \"hạt giống\" nhỏ, mình sẽ thấy con đường trở nên rõ ràng hơn rất nhiều và bớt đi cảm giác bị choáng ngợp.</span></p>\r\n<p data-sourcepos=\"27:1-27:555\"><span style=\"font-family: \'times new roman\', times;\">Mình cũng đã áp dụng Kỹ thuật Pomodoro một cách duyên dáng và linh hoạt hơn. Thay vì cứ ngồi lì hàng giờ trước máy tính mà tâm trí lại ở tận đâu, mình đặt hẹn giờ 25 phút, tập trung hoàn toàn vào công việc, tắt hết thông báo điện thoại. Sau 25 phút, mình nghỉ ngơi 5 phút, có thể đứng dậy vươn vai, pha một cốc trà, hoặc ngắm nhìn cây cối bên ngoài. Sau 4 lần tập trung như vậy, mình sẽ có một quãng nghỉ dài hơn (15-30 phút) để thư giãn thật sự. Cách này giúp mình giữ được sự tập trung cao độ mà không bị kiệt sức, và đầu óc cũng \"tỉnh táo\" hơn nhiều. ☕</span></p>\r\n<p data-sourcepos=\"29:1-29:474\"><span style=\"font-family: \'times new roman\', times;\">Một \"quy tắc 2 phút\" thần kỳ cũng đã giúp mình rất nhiều. Thay vì cứ nghĩ \"thôi để lát nữa mình gửi cái link đó\" hay \"mai mình sẽ sắp xếp lại email\", mình tự nhủ: Nếu một việc gì đó chỉ mất khoảng 2 phút (hoặc ít hơn) để hoàn thành, mình sẽ làm nó NGAY LẬP TỨC. Gửi một tin nhắn, trả lời một email ngắn, dọn dẹp một chút trên bàn học... Những việc nhỏ này nếu được giải quyết ngay sẽ không kịp tích tụ lại thành \"gánh nặng\" đâu, mà còn giúp mình cảm thấy nhẹ nhõm hơn nữa. ✨</span></p>\r\n<p data-sourcepos=\"31:1-31:452\"><span style=\"font-family: \'times new roman\', times;\">Để duy trì động lực, mình còn học cách tạo \"năng lượng\" cho bản thân bằng những phần thưởng nhỏ xinh. Thay vì cứ làm việc không ngừng nghỉ mà không có động lực nào, mình đặt ra những \"phần thưởng\" nho nhỏ sau khi hoàn thành một phần công việc. Ví dụ: \"Xong chương này là được nghe bài nhạc yêu thích.\" \"Hoàn thành kế hoạch tuần là đi uống một ly trà sữa.\" Những phần thưởng đáng yêu này giúp mình duy trì sự hứng thú và động lực để tiếp tục cố gắng. 🎀</span></p>\r\n<p data-sourcepos=\"33:1-33:443\"><span style=\"font-family: \'times new roman\', times;\">Và tất nhiên, việc tạo một không gian \"thoáng đãng\" cũng cực kỳ quan trọng. Thay vì cứ để điện thoại \"ting ting\" liên tục hay các tab trình duyệt cứ mở ra, mở vào khiến mình xao nhãng, mình học cách hạn chế chúng. Khi cần tập trung cao độ, mình sẽ đặt điện thoại ở chế độ im lặng hoặc để xa tầm với. Mình chỉ mở những tab cần thiết trên máy tính. Một không gian học tập yên tĩnh và gọn gàng cũng giúp mình dễ dàng \"vào guồng\" hơn rất nhiều. 🍃</span></p>\r\n<p data-sourcepos=\"35:1-35:460\"><span style=\"font-family: \'times new roman\', times;\">Cuối cùng, đôi khi chỉ cần \"kể lể\" ra cũng là một cách. Mình nhận ra việc giấu giếm chuyện mình đang trì hoãn làm chúng ta càng thấy tội lỗi và càng lười. Mình thử kể cho một đứa bạn thân hoặc đứa bạn học cùng biết là mình đang \"deadline dí\" hoặc đang \"lười\" cái gì đó. Đôi khi chỉ cần có người biết thôi là mình đã có thêm trách nhiệm và động lực để làm rồi. Hoặc nếu bạn có nhóm học chung, cùng nhau học nhóm và tạo áp lực \"tích cực\" cũng là một cách hay đó.</span></p>\r\n<h3 data-sourcepos=\"37:1-37:61\"><span style=\"font-family: \'times new roman\', times;\"><strong>Lời Gửi Gắm Cuối Cùng: Cứ Bình Tĩnh Và Tự Tin Nhé! 💖</strong></span></h3>\r\n<p data-sourcepos=\"39:1-39:252\"><span style=\"font-family: \'times new roman\', times;\">Trì hoãn là một phần rất tự nhiên của con người, ai trong chúng ta cũng từng trải qua, mình cũng vậy. Điều quan trọng không phải là loại bỏ nó hoàn toàn, mà là học cách \"chung sống hòa bình\" và tìm ra cách để nó không cản trở hành trình của chúng mình.</span></p>\r\n<p data-sourcepos=\"41:1-41:298\"><span style=\"font-family: \'times new roman\', times;\">Hãy cứ bình tĩnh, nhẹ nhàng với bản thân. Mỗi bước nhỏ bạn tiến lên, mỗi lần bạn chiến thắng được thói quen trì hoãn, dù chỉ là một nhiệm vụ đơn giản, cũng là một chiến thắng đáng ăn mừng. Student Diary tin rằng bạn có đủ khả năng để tự mình làm chủ thời gian và đạt được những điều mình mong muốn.</span></p>\r\n<p data-sourcepos=\"43:1-43:136\"><span style=\"font-family: \'times new roman\', times;\">Hy vọng những chia sẻ này sẽ mang lại chút \"năng lượng\" và động lực cho bạn. Hãy thử áp dụng và kể cho mình nghe cảm nhận của bạn nhé! ✨</span></p>', 'Admin', '2025-11-13 22:15:34', '2025-11-13 22:15:34', '1b07dee89232e2e535a059edcd3e6005.png_wh860.png', 'published', 1, 'Kỹ năng'),
(37, 'Teamwork Là Gì Mà \"Thần Kỳ\" Thế? ✨ Cùng Student Diary Xây Dựng Team \"Bất Bại\"! 🤝', '<p data-sourcepos=\"11:1-11:39\"><em><span style=\"font-family: \'times new roman\', times;\">Chào bạn thân mến của Student Diary, 👋</span></em></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\">Có bao giờ bạn tham gia một dự án nhóm mà mọi người đều ăn ý, công việc trôi chảy và kết quả thật \"đỉnh\" chưa? Đó chính là sức mạnh của teamwork đó! Bài viết này sẽ cùng bạn \"vén màn\" bí mật của làm việc nhóm hiệu quả và bật mí những mẹo nhỏ để chúng mình cùng nhau tạo nên những đội nhóm \"bất bại\", không chỉ trong học tập mà còn trong cuộc sống nữa! Cùng khám phá nhé! 🚀💖</span></p>\r\n<p data-sourcepos=\"13:1-13:468\"><span style=\"font-family: \'times new roman\', times;\">Trong hành trình học tập và cả sau này khi đi làm, chắc chắn chúng mình sẽ không ít lần phải \"chung tay\" cùng nhau hoàn thành một mục tiêu nào đó. Đó có thể là một bài thuyết trình nhóm, một dự án nghiên cứu, hay thậm chí là việc cùng nhau tổ chức một sự kiện. Có những lúc, mọi thứ diễn ra thật suôn sẻ, mọi người cùng nhìn về một hướng, và kết quả thì \"trên cả tuyệt vời\". Nhưng cũng có khi, chỉ nghĩ đến \"làm việc nhóm\" thôi đã thấy hơi... \"ngán\" rồi đúng không? 😅</span></p>\r\n<p data-sourcepos=\"15:1-15:400\"><span style=\"font-family: \'times new roman\', times;\">Mình hiểu cảm giác đó! Đôi khi, sự khác biệt về ý kiến, phong cách làm việc, hay thậm chí là việc ai cũng \"lơ ngơ\" không biết bắt đầu từ đâu có thể khiến teamwork trở thành một thử thách. Nhưng đừng vội \"ngán\" nhé! Làm việc nhóm không chỉ giúp chúng mình hoàn thành công việc hiệu quả hơn, mà còn là cơ hội để học hỏi từ người khác, phát triển bản thân và xây dựng những mối quan hệ tuyệt vời nữa đó.</span></p>\r\n<p data-sourcepos=\"17:1-17:316\"><span style=\"font-family: \'times new roman\', times;\">Vậy thì, teamwork chính là gì? Đó là việc một nhóm người cùng nhau hợp tác, chia sẻ kiến thức, kỹ năng và nỗ lực để đạt được một mục tiêu chung. Nó không chỉ đơn thuần là tập hợp nhiều cá nhân lại với nhau, mà là cách chúng ta kết nối, hỗ trợ và bổ sung cho nhau để tạo ra một sức mạnh tổng hợp lớn hơn rất nhiều! 💪</span></p>\r\n<p data-sourcepos=\"19:1-19:137\"><span style=\"font-family: \'times new roman\', times;\">Làm thế nào để biến \"làm việc nhóm\" thành một trải nghiệm thú vị và hiệu quả đây? Mình có vài \"bí kíp\" nho nhỏ muốn chia sẻ cùng bạn đây:</span></p>\r\n<p data-sourcepos=\"21:1-21:60\"><span style=\"font-family: \'times new roman\', times;\"><strong>1. Rõ ràng về mục tiêu chung - \"Đi cùng một con thuyền\":</strong></span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Biết đích đến:</strong> Trước khi bắt đầu, cả nhóm cần thống nhất rõ ràng về mục tiêu cuối cùng. Mục tiêu chung càng rõ ràng, các thành viên càng dễ dàng định hướng công việc của mình.</span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Vai trò và trách nhiệm:</strong> Mỗi người nên biết rõ mình cần làm gì, trách nhiệm của mình đến đâu để tránh việc chồng chéo hoặc bỏ sót công việc. Ai cũng là một mắt xích quan trọng!</span></p>\r\n<p data-sourcepos=\"25:1-25:44\"><span style=\"font-family: \'times new roman\', times;\"><strong>2. Giao tiếp hiệu quả - \"Tâm đầu ý hợp\":</strong></span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Lắng nghe chủ động:</strong> Đừng chỉ nói, hãy học cách lắng nghe ý kiến của người khác một cách chân thành. Có thể bạn sẽ học được điều mới mẻ, hoặc tìm ra giải pháp tốt hơn.</span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Chia sẻ cởi mở:</strong> Đừng ngại bày tỏ ý kiến, thắc mắc hay cả những lo lắng của mình. Giao tiếp thường xuyên và minh bạch giúp giải quyết vấn đề nhanh hơn và tránh hiểu lầm.</span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>\"Feed-back\" có xây dựng:</strong> Khi góp ý cho nhau, hãy tập trung vào công việc, mang tính xây dựng và luôn giữ thái độ tôn trọng.</span></p>\r\n<p data-sourcepos=\"30:1-30:71\"><span style=\"font-family: \'times new roman\', times;\"><strong>3. Tôn trọng sự khác biệt - \"Mỗi người một vẻ, mười phân vẹn mười\":</strong></span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Đa dạng là sức mạnh:</strong> Mỗi thành viên đều có điểm mạnh, điểm yếu và cách tiếp cận khác nhau. Hãy nhìn nhận sự khác biệt này như một nguồn tài nguyên quý giá để nhóm thêm phong phú và sáng tạo.</span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Học cách nhường nhịn:</strong> Đôi khi, chúng ta cần linh hoạt và sẵn sàng nhượng bộ để tìm ra phương án tốt nhất cho cả nhóm, thay vì cố chấp giữ ý kiến cá nhân.</span></p>\r\n<p data-sourcepos=\"34:1-34:58\"><span style=\"font-family: \'times new roman\', times;\"><strong>4. Cùng nhau giải quyết vấn đề - \"Đồng sức đồng lòng\":</strong></span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Vấn đề của nhóm, không phải của riêng ai:</strong> Khi gặp khó khăn, đừng đổ lỗi hay né tránh. Hãy cùng nhau phân tích vấn đề, đưa ra các giải pháp và chọn ra hướng đi tối ưu nhất.</span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Tinh thần hỗ trợ:</strong> Nếu thấy thành viên nào đó đang gặp khó khăn, đừng ngần ngại ngỏ lời giúp đỡ. \"Một cây làm chẳng nên non, ba cây chụm lại nên hòn núi cao\" mà!</span></p>\r\n<p data-sourcepos=\"38:1-38:52\"><span style=\"font-family: \'times new roman\', times;\"><strong>5. Tin tưởng lẫn nhau - \"Đặt niềm tin đúng chỗ\":</strong></span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Giao phó và hoàn thành:</strong> Hãy tin tưởng vào khả năng của đồng đội khi giao việc, và quan trọng là mỗi cá nhân cần nỗ lực hết mình để hoàn thành phần việc được giao, không làm ảnh hưởng đến cả nhóm.</span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Tạo môi trường an toàn:</strong> Khi mọi người cảm thấy được tin tưởng và tôn trọng, họ sẽ thoải mái hơn để thể hiện bản thân và đóng góp ý tưởng.</span></p>\r\n<p data-sourcepos=\"42:1-42:44\"><span style=\"font-family: \'times new roman\', times;\"><strong>6. Cùng nhau ăn mừng và rút kinh nghiệm:</strong></span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Ghi nhận thành quả:</strong> Khi nhóm đạt được mục tiêu, đừng quên cùng nhau ăn mừng để gắn kết hơn và tạo động lực cho những lần sau.</span></p>\r\n<p><span style=\"font-family: \'times new roman\', times;\"><strong>Rút kinh nghiệm từ mọi dự án:</strong> Dù thành công hay chưa, hãy dành thời gian ngồi lại để đánh giá những gì đã làm tốt và những gì cần cải thiện. Đây là cách để nhóm ngày càng mạnh mẽ hơn.</span></p>\r\n<p data-sourcepos=\"46:1-46:258\"><span style=\"font-family: \'times new roman\', times;\">Teamwork không chỉ là một kỹ năng cần thiết trong học tập và công việc, mà nó còn là bài học về sự hợp tác, chia sẻ và gắn kết giữa con người với con người. Hãy cùng nhau xây dựng những đội nhóm thật \"chất\" và biến mọi thử thách thành cơ hội để tỏa sáng nhé!</span></p>\r\n<p data-sourcepos=\"48:1-48:82\"><span style=\"font-family: \'times new roman\', times;\">Student Diary tin rằng bạn và đội nhóm của mình sẽ làm được! Cùng cố gắng nha! 💪✨</span></p>', 'Admin', '2025-11-13 22:15:34', '2025-11-13 22:15:34', 'teamwork-la-gi-768x502.jpg', 'published', 1, 'Kỹ năng'),
(38, ' Chi Tiêu Hợp Lý: Bí Quyết Đánh Bay \"Ví Xẹp\", Đón Chào Tương Lai Rủng Rỉnh! 💸💖', '<p><span style=\"font-family: \'times new roman\', times;\"><em>Chào bạn thân mến của Student Diary, 👋</em></span></p>\r\n<p data-sourcepos=\"15:1-15:450\"><span style=\"font-family: \'times new roman\', times;\">Cuộc sống sinh viên thật thú vị, đúng không? Có ti tỉ thứ để khám phá, để học hỏi, và cả để chi tiêu nữa! Từ những buổi tụ tập bạn bè, ly trà sữa \"must-have\", đến những món đồ công nghệ mới cáu cạnh hay khóa học online bổ ích... Cứ thế, đôi khi chúng mình cứ \"vung tay quá trán\" một chút, rồi chợt nhận ra ví đã \"xẹp lép\" lúc nào không hay. Cảm giác cuối tháng phải \"ăn mì tôm chống đói\" hay \"đếm từng đồng\" thật không vui vẻ chút nào, đúng không?</span></p>\r\n<p data-sourcepos=\"17:1-17:826\"><span style=\"font-family: \'times new roman\', times;\">Mình cũng từng trải qua những cảm giác \"nhức nhối\" đó! Rất nhiều lần \"thề thốt\" sẽ chi tiêu tiết kiệm hơn, nhưng rồi lại \"đâu đóng đấy\" khi thấy những món đồ xinh xắn hay lời mời gọi hấp dẫn. Nhưng dần dần, mình nhận ra rằng, việc quản lý chi tiêu không phải là \"thắt lưng buộc bụng\" một cách khổ sở, mà là biết cách \"làm bạn\" với tiền, để nó phục vụ cho những mục tiêu và hạnh phúc của mình. Vậy thì, chi tiêu hợp lý chính xác là gì? Đó là khả năng kiểm soát dòng tiền của mình, biết mình kiếm được bao nhiêu, chi tiêu vào những khoản gì và dành dụm được bao nhiêu, từ đó đưa ra những quyết định tài chính khôn ngoan để đạt được mục tiêu cá nhân như mua sắm món đồ mơ ước, đi du lịch, hay đơn giản là không bị \"viêm màng túi\" cuối tháng! Nó không phải là keo kiệt, mà là sự thông thái trong quản lý tài chính cá nhân đó! 🧠💡</span></p>\r\n<p data-sourcepos=\"19:1-19:678\"><span style=\"font-family: \'times new roman\', times;\">Để bắt đầu làm chủ chi tiêu, điều đầu tiên và quan trọng nhất là bạn cần \"biết mình biết ta\" – tức là nắm rõ dòng tiền của mình. Hãy bắt đầu bằng cách liệt kê chính xác mọi nguồn thu nhập bạn có mỗi tháng, dù là tiền từ gia đình, học bổng, hay thu nhập từ công việc làm thêm. Sau đó, một bước không thể thiếu là ghi chép lại tất cả mọi khoản chi, dù lớn hay nhỏ. Bạn có thể dùng một cuốn sổ tay đơn giản, các ứng dụng quản lý chi tiêu trên điện thoại như Sổ Thu Chi Misa hay Money Lover, hoặc một bảng Excel cá nhân. Việc này giúp bạn có cái nhìn tổng quan về việc tiền của mình đang \"đi đâu về đâu\", từ đó dễ dàng nhận ra những khoản chi không cần thiết và điều chỉnh kịp thời.</span></p>\r\n<p data-sourcepos=\"21:1-21:931\"><span style=\"font-family: \'times new roman\', times;\">Khi đã nắm được dòng tiền, bước tiếp theo là lập ngân sách, hay còn gọi là \"khoanh vùng\" cho từng khoản chi tiêu. Một nguyên tắc khá phổ biến mà bạn có thể tham khảo là quy tắc \"50/30/20\". Cụ thể, bạn sẽ dành khoảng 50% thu nhập cho các \"Nhu cầu\" thiết yếu như tiền thuê nhà, ăn uống, đi lại, học phí – những thứ bạn không thể thiếu để duy trì cuộc sống và học tập. Khoảng 30% tiếp theo sẽ dành cho các \"Mong muốn\" cá nhân, ví dụ như mua sắm quần áo mới, đi xem phim, ăn uống bên ngoài, hoặc những chuyến đi chơi nhỏ xinh giúp bạn thư giãn và vui vẻ. Cuối cùng, 20% còn lại sẽ dành cho việc \"Tiết kiệm và Đầu tư\", tạo ra một quỹ dự phòng cho những trường hợp khẩn cấp hoặc để dành cho những mục tiêu lớn hơn như mua một chiếc laptop mới, đi du học, hay thực hiện một ước mơ nào đó trong tương lai. Tất nhiên, bạn hoàn toàn có thể điều chỉnh các tỷ lệ này sao cho phù hợp nhất với hoàn cảnh và mục tiêu tài chính riêng của mình nhé.</span></p>\r\n<p data-sourcepos=\"23:1-23:775\"><span style=\"font-family: \'times new roman\', times;\">Một mẹo quan trọng khác là học cách phân biệt rõ ràng giữa \"Nhu cầu\" và \"Mong muốn\" của bản thân. Nhu cầu là những thứ bạn <strong>phải có</strong> để duy trì cuộc sống và học tập, trong khi mong muốn là những thứ bạn <strong>muốn có</strong> để cuộc sống thêm phần thú vị và thoải mái hơn. Việc ưu tiên các khoản \"nhu cầu\" trước sẽ giúp bạn đảm bảo được các chi tiêu cơ bản, sau đó mới cân nhắc đến các \"mong muốn\". Đừng vội vàng \"xuống tiền\" cho những món đồ chỉ vì thấy thích thú nhất thời mà hãy dành thời gian suy nghĩ kỹ lưỡng, đặc biệt là với những món đồ không nằm trong kế hoạch ban đầu. Quy tắc \"24/48 giờ\" có thể rất hữu ích: nếu bạn muốn mua một món đồ không cần thiết ngay lập tức, hãy đợi 24 hoặc 48 giờ. Rất có thể sau thời gian đó, bạn sẽ nhận ra mình không thực sự cần nó đến vậy đâu.</span></p>\r\n<p data-sourcepos=\"25:1-25:668\"><span style=\"font-family: \'times new roman\', times;\">Cuối cùng, hãy nhớ rằng tiết kiệm nên là một phần của quy trình chi tiêu, chứ không phải là khoản tiền còn thừa lại sau khi đã chi tiêu hết. Một lời khuyên hữu ích là \"Pay yourself first\" – ngay khi nhận được tiền, hãy trích một phần nhỏ (ví dụ 10-20%) bỏ vào tài khoản tiết kiệm hoặc \"con heo đất\" của bạn trước tiên. Việc tạo ra một quỹ khẩn cấp nho nhỏ cũng vô cùng quan trọng, nó sẽ là \"phao cứu sinh\" khi bạn gặp phải những trường hợp bất ngờ như ốm đau hay cần sửa chữa đồ đạc, giúp bạn tránh được những rắc rối tài chính lớn. Đặt ra những mục tiêu tài chính cụ thể, dù là nhỏ hay lớn, sẽ là động lực mạnh mẽ để bạn kiên trì với việc chi tiêu có trách nhiệm hơn.</span></p>\r\n<p data-sourcepos=\"27:1-27:231\"><span style=\"font-family: \'times new roman\', times;\">Kỹ năng chi tiêu hợp lý không chỉ giúp bạn có một tài chính cá nhân ổn định, mà còn mang lại sự an tâm, tự do và khả năng biến những ước mơ thành hiện thực. Hãy bắt đầu ngay hôm nay, từng bước nhỏ để làm chủ \"ví tiền\" của mình nhé!</span></p>\r\n<p data-sourcepos=\"29:1-29:85\"><span style=\"font-family: \'times new roman\', times;\">Student Diary tin rằng bạn sẽ trở thành một \"cao thủ\" chi tiêu! Cùng cố gắng nha! 💪✨</span></p>', 'Admin', '2025-11-13 22:15:34', '2025-11-13 22:15:34', 'grab-1-9743.jpeg', 'published', 1, 'Kỹ năng'),
(39, 'Phân Tích Nghiệp Vụ - Bí Kíp Nhập Vai \"Người Biết Tuốt\" Trong Dự Án Phần Mềm', '<p data-start=\"316\" data-end=\"354\"><em>Chào bạn thân mến của Student Diary,</em></p>\r\n<p data-start=\"356\" data-end=\"866\">Nếu bạn đang là sinh viên ngành Hệ thống thông tin, chắc chắn bạn đã từng nghe tới môn Phân tích nghiệp vụ phần mềm. Nghe tên thôi đã thấy có chút gì đó “căng thẳng”, đúng không? Mình cũng từng như vậy. Những buổi đầu làm quen với BA, mình thật sự hoang mang với đủ loại khái niệm: từ Use Case, BPMN cho đến những đặc tả yêu cầu khô khan. Nhưng bạn biết không, càng học mình càng nhận ra đây là một môn rất “đời”, rất thực tế, và cực kỳ hữu ích nếu bạn muốn làm việc trong môi trường công nghệ chuyên nghiệp.</p>\r\n<p data-start=\"868\" data-end=\"1561\">   Mình còn nhớ bài tập đầu tiên của nhóm là xây dựng yêu cầu nghiệp vụ cho một tiệm trà sữa online. Nghe thì đơn giản, nhưng khi bắt tay vào làm, mình mới nhận ra: việc hiểu đúng nhu cầu khách hàng và truyền đạt lại cho bên kỹ thuật là cả một nghệ thuật. Có lần, cả nhóm tranh luận gần hai tiếng chỉ để xác định xem \"tính năng đặt hàng\" cần những bước nào. Từ những cuộc thảo luận như vậy, mình học được cách đặt câu hỏi đúng, cách đào sâu vào vấn đề và không ngừng tự hỏi: “Liệu đây đã là nhu cầu thực sự chưa?” BA, hóa ra, không chỉ là viết tài liệu. Đó là việc đứng ở giữa khách hàng và đội phát triển, là người lắng nghe, người tổng hợp, người điều phối và đôi khi còn là người... làm hoà.</p>\r\n<p data-start=\"1563\" data-end=\"1989\">   Học BA, mình bắt đầu thay đổi cách nhìn về mọi thứ xung quanh. Mình không còn thấy việc đi siêu thị là chuyện đơn thuần mua sắm nữa, mà bắt đầu “vẽ hệ thống” trong đầu: làm sao khách đặt hàng? Ai xử lý đơn? Giao hàng diễn ra như thế nào? Mỗi hành động nhỏ đều trở thành một quy trình mà BA cần hiểu rõ. Và khi hiểu rõ, mình mới thấy: để hệ thống chạy trơn tru, thì bước phân tích nghiệp vụ phải thật sự kỹ lưỡng ngay từ đầu.</p>\r\n<p data-start=\"1991\" data-end=\"2399\">  Mình cũng từng “toát mồ hôi” khi viết tài liệu SRS đầu tiên. Cứ tưởng chỉ cần ghi ra yêu cầu là xong, ai ngờ cần diễn đạt logic, ngắn gọn, không mơ hồ, và quan trọng là đủ để lập trình viên hiểu và code đúng. Mình học được cách viết rõ ràng hơn, biết đâu là thông tin quan trọng, đâu là chi tiết cần phân tích thêm. Và tuyệt vời hơn cả, là sau mỗi lần chỉnh sửa, mình thấy tư duy của mình cũng sắc bén hơn.</p>\r\n<p data-start=\"2401\" data-end=\"2857\">   Nếu bạn đang học môn này, mình thật lòng khuyên: đừng chỉ học để qua môn. Hãy coi đây là cơ hội để rèn luyện tư duy, kỹ năng giao tiếp, khả năng tổ chức và nhìn nhận vấn đề một cách hệ thống. Bạn không cần phải là người giỏi giao tiếp nhất lớp, nhưng nếu bạn biết lắng nghe và biết đặt câu hỏi, bạn hoàn toàn có thể trở thành một BA tốt trong tương lai. Mỗi sơ đồ bạn vẽ, mỗi dòng bạn viết đều giúp bạn tiến gần hơn với môi trường làm việc chuyên nghiệp.</p>\r\n<p data-start=\"2859\" data-end=\"3238\">  Học BA không chỉ là học cách làm tài liệu, mà là học cách hiểu con người, hiểu quy trình và hiểu công nghệ. Đó là hành trình để bạn trở thành cầu nối giữa nhu cầu và giải pháp, giữa người dùng và hệ thống. Và đôi khi, chính từ những môn học tưởng như khô khan này, bạn sẽ tìm thấy niềm yêu thích mới, một hướng đi nghề nghiệp đầy triển vọng mà trước đây bạn chưa từng nghĩ đến.</p>\r\n<p data-start=\"3240\" data-end=\"3416\">    Chúc bạn học BA thật tốt và tìm thấy sự hứng thú trên hành trình phân tích những điều tưởng chừng phức tạp nhưng lại rất thú vị này. Student Diary sẽ luôn đồng hành cùng bạn!</p>', 'Admin', '2025-11-13 22:15:34', '2025-11-13 22:15:34', 'PTNV.jpg', 'published', 3, 'Học tập'),
(40, 'Hệ thống thông tin ', '<p>Ngành chuyên môn về công nghệ.</p>', 'Admin', '2025-11-13 22:20:12', '2025-11-13 22:20:12', '', 'published', NULL, 'Đời sống');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL COMMENT 'Tên đăng nhập (có thể là email)',
  `password` varchar(255) NOT NULL COMMENT 'Mật khẩu đã hash',
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `created_at`) VALUES
(2, 'annn', '123456', 'Phạm Mai Anh', 'mai@gmail.com', '2025-06-17 15:11:16'),
(4, 'huy', '123456', 'Vũ Đức Huy', 'duchuy@gmail.com', '2025-06-17 16:31:52'),
(5, 'an', '123456', 'Ngọc an', 'anh@gmail.com', '2025-06-17 17:46:14'),
(6, 'anna', '123456', 'linh an', 'linhan@gmail.com', '2025-06-18 07:33:38'),
(7, 'maihy', '123456', 'Nguyễn Ngọc Mai Hy', 'hope@gmail.com', '2025-06-18 10:57:13'),
(8, 'hân', '123456', 'Nguyễn Mai Hân', 'hannguyen@gmail.com', '2025-10-06 14:54:07'),
(9, 'Lannan', '123456', 'Phương Hoàng Lan', 'lanane@gmail.com', '2025-10-27 15:34:14'),
(10, 'Namnam', '123456', 'Nam', 'nam2005@gmail.com', '2025-11-13 23:52:37'),
(12, 'Hanhan', 'Han1234', 'Nguyễn Gia Hân', 'hanhan@gmail.com', '2025-11-14 00:14:28');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_id` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
