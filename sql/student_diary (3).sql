-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 21, 2025 lúc 04:56 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.1.25

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
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Kỹ năng', 'ky-nang', '2025-11-13 22:15:10', '2025-11-21 18:55:34'),
(2, 'Đời sống', 'doi-song', '2025-11-13 22:15:10', '2025-11-21 17:25:34'),
(3, 'Học tập', 'hoc-tap', '2025-11-13 22:15:10', '2025-11-21 11:00:36');

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
(28, 39, NULL, 0, 'Kiên', NULL, NULL, 'Cảm ơn ad nhiều vì chia sẻ trên', '2025-11-14 00:19:27', '2025-11-21 10:48:16', 1, 0),
(29, 39, NULL, 28, 'Student Diary', NULL, NULL, 'Cảm ơn bạn', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 1),
(72, 39, NULL, 0, 'Người dùng thử', 'testuser@example.com', NULL, 'hi', '2025-11-14 00:19:27', '2025-11-14 00:19:27', 1, 0),
(74, 39, NULL, 72, 'Student Diary', NULL, NULL, 'hi', '2025-11-21 10:36:29', NULL, 1, 1),
(75, 39, NULL, 28, 'Student Diary', NULL, NULL, 'ok', '2025-11-21 10:48:27', NULL, 1, 1);

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
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `author`, `created_at`, `updated_at`, `image`, `status`, `category_id`) VALUES
(39, 'Phân Tích Nghiệp Vụ - Bí Kíp Nhập Vai \"Người Biết Tuốt\" Trong Dự Án Phần Mềm', '<p data-start=\"316\" data-end=\"354\"><em>Chào bạn thân mến của Student Diary,</em></p>\r\n<p data-start=\"356\" data-end=\"866\">Nếu bạn đang là sinh viên ngành Hệ thống thông tin, chắc chắn bạn đã từng nghe tới môn Phân tích nghiệp vụ phần mềm. Nghe tên thôi đã thấy có chút gì đó “căng thẳng”, đúng không? Mình cũng từng như vậy. Những buổi đầu làm quen với BA, mình thật sự hoang mang với đủ loại khái niệm: từ Use Case, BPMN cho đến những đặc tả yêu cầu khô khan. Nhưng bạn biết không, càng học mình càng nhận ra đây là một môn rất “đời”, rất thực tế, và cực kỳ hữu ích nếu bạn muốn làm việc trong môi trường công nghệ chuyên nghiệp.</p>\r\n<p data-start=\"868\" data-end=\"1561\">   Mình còn nhớ bài tập đầu tiên của nhóm là xây dựng yêu cầu nghiệp vụ cho một tiệm trà sữa online. Nghe thì đơn giản, nhưng khi bắt tay vào làm, mình mới nhận ra: việc hiểu đúng nhu cầu khách hàng và truyền đạt lại cho bên kỹ thuật là cả một nghệ thuật. Có lần, cả nhóm tranh luận gần hai tiếng chỉ để xác định xem \"tính năng đặt hàng\" cần những bước nào. Từ những cuộc thảo luận như vậy, mình học được cách đặt câu hỏi đúng, cách đào sâu vào vấn đề và không ngừng tự hỏi: “Liệu đây đã là nhu cầu thực sự chưa?” BA, hóa ra, không chỉ là viết tài liệu. Đó là việc đứng ở giữa khách hàng và đội phát triển, là người lắng nghe, người tổng hợp, người điều phối và đôi khi còn là người... làm hoà.</p>\r\n<p data-start=\"1563\" data-end=\"1989\">   Học BA, mình bắt đầu thay đổi cách nhìn về mọi thứ xung quanh. Mình không còn thấy việc đi siêu thị là chuyện đơn thuần mua sắm nữa, mà bắt đầu “vẽ hệ thống” trong đầu: làm sao khách đặt hàng? Ai xử lý đơn? Giao hàng diễn ra như thế nào? Mỗi hành động nhỏ đều trở thành một quy trình mà BA cần hiểu rõ. Và khi hiểu rõ, mình mới thấy: để hệ thống chạy trơn tru, thì bước phân tích nghiệp vụ phải thật sự kỹ lưỡng ngay từ đầu.</p>\r\n<p data-start=\"1991\" data-end=\"2399\">  Mình cũng từng “toát mồ hôi” khi viết tài liệu SRS đầu tiên. Cứ tưởng chỉ cần ghi ra yêu cầu là xong, ai ngờ cần diễn đạt logic, ngắn gọn, không mơ hồ, và quan trọng là đủ để lập trình viên hiểu và code đúng. Mình học được cách viết rõ ràng hơn, biết đâu là thông tin quan trọng, đâu là chi tiết cần phân tích thêm. Và tuyệt vời hơn cả, là sau mỗi lần chỉnh sửa, mình thấy tư duy của mình cũng sắc bén hơn.</p>\r\n<p data-start=\"2401\" data-end=\"2857\">   Nếu bạn đang học môn này, mình thật lòng khuyên: đừng chỉ học để qua môn. Hãy coi đây là cơ hội để rèn luyện tư duy, kỹ năng giao tiếp, khả năng tổ chức và nhìn nhận vấn đề một cách hệ thống. Bạn không cần phải là người giỏi giao tiếp nhất lớp, nhưng nếu bạn biết lắng nghe và biết đặt câu hỏi, bạn hoàn toàn có thể trở thành một BA tốt trong tương lai. Mỗi sơ đồ bạn vẽ, mỗi dòng bạn viết đều giúp bạn tiến gần hơn với môi trường làm việc chuyên nghiệp.</p>\r\n<p data-start=\"2859\" data-end=\"3238\">  Học BA không chỉ là học cách làm tài liệu, mà là học cách hiểu con người, hiểu quy trình và hiểu công nghệ. Đó là hành trình để bạn trở thành cầu nối giữa nhu cầu và giải pháp, giữa người dùng và hệ thống. Và đôi khi, chính từ những môn học tưởng như khô khan này, bạn sẽ tìm thấy niềm yêu thích mới, một hướng đi nghề nghiệp đầy triển vọng mà trước đây bạn chưa từng nghĩ đến.</p>\r\n<p data-start=\"3240\" data-end=\"3416\">    Chúc bạn học BA thật tốt và tìm thấy sự hứng thú trên hành trình phân tích những điều tưởng chừng phức tạp nhưng lại rất thú vị này. Student Diary sẽ luôn đồng hành cùng bạn!</p>', 'Admin', '2025-11-13 22:15:34', '2025-11-13 22:15:34', 'PTNV.jpg', 'published', 3),
(43, 'Kỹ năng mềm là gì?', 'Kỹ năng mềm là một thuật ngữ xã hội học chỉ những kỹ năng có liên quan đến việc sử dụng ngôn ngữ, khả năng hòa nhập xã hội, thái độ và hành vi ứng xử áp dụng vào việc giao tiếp giữa người với người. kỹ năng mềm là những kỹ năng có liên quan đến việc hòa mình vào, sống với hay tương tác với xã hội, cộng đồng, tập thể hoặc tổ chức.\r\n\r\nKỹ năng mềm: Tìm hiểu khái niệm & tầm quan trọng của việc học kỹ năng mềm\r\n\r\nKỹ năng mềm (hay còn gọi là Kỹ năng thực hành xã hội) là thuật ngữ dùng để chỉ các kỹ năng quan trọng trong cuộc sống con người như: kỹ năng sống, giao tiếp, lãnh đạo, làm việc theo nhóm, kỹ năng quản lý thời gian, thư giãn, vượt qua khủng hoảng, sáng tạo và đổi mới...\r\n\r\nKỹ năng mềm khác với kỹ năng cứng để chỉ trình độ chuyên môn, kiến thức chuyên môn hay bằng cấp và chứng chỉ chuyên môn. Thực tế cho thấy người thành đạt chỉ có 25% là do những kiến thức chuyên môn, 75% còn lại được quyết định bởi những kỹ năng mềm họ được trang bị. Tìm hiểu thêm về những kỹ năng mềm dễ mang lại cơ hội cho bạn\r\n\r\nKỹ năng mềm chủ yếu là những kỹ năng thuộc về tính cách con người, không mang tính chuyên môn, không thể sờ nắm, không phải là kỹ năng cá tính đặc biệt, chúng quyết định khả năng bạn có thể trở thành nhà lãnh đạo, thính giả, nhà thương thuyết hay người hòa giải xung đột. Những kỹ năng “cứng” ở nghĩa trái ngược thường xuất hiện trên bản lý lịch-khả năng học vấn của bạn, kinh nghiệm và sự thành thạo về chuyên môn.\r\n\r\nKỹ năng mềm khác kỹ năng sống?\r\nKhi bạn quan tâm tới các vấn đề về kỹ năng, điều đầu tiên và quan trọng nhất bạn cần nắm rõ là: Kỹ năng sống và kỹ năng mềm không phải là hai thứ khác nhau, và càng không phải là hai thứ giống nhau, mà kỹ năng mềm chính là một phần của kỹ năng sống, hay kỹ năng sống bao gồm kỹ năng mềm và một số kỹ năng khác sẽ được lần lượt giới thiệu trong các bài tiếp theo hoặc bạn cũng có thể theo dõi trực tiếp tại academy.vn\r\n\r\n \r\n\r\nKỹ năng cứng là gì?\r\n \r\n\r\nKỹ năng cứng thường được hiểu là những kiến thức, đúc kết và thực hành có tính chất kỹ thuật nghề nghiệp. Kỹ năng cứng được cung cấp thông qua các môn học đào tạo chính khóa, có liên kết lô-gich chặt chẽ, và xây dựng tuần tự. Thời gian để có được kỹ năng cứng thường rất dài, hàng chục năm, bắt đầu từ những kiến thức kỹ năng cơ bản ở nhà trường phổ thông qua các cấp như: Tư duy hình học, tư duy ngôn ngữ-văn phạm, các hệ thống khái niệm lý thuyết cơ bản vật lý hóa học sinh học toán học... và những kiến thức kỹ năng này được phát triển dần lên các mức độ cao hơn, thông qua giảng dạy, thực hành và tự học một cách hệ thống.\r\n\r\nĐối với các kỹ năng cứng, khả năng tự tìm hiểu toàn bộ gần như không thể, mà người ta bắt buộc phải trải qua những giai đoạn có xây dựng tính hệ thống của tư duy lô-gich và dựa trên \"vai các nhà khổng lồ\" Thông thường, vai trò của giáo dục chính thức đặc biệt quan trọng để hình thành kỹ năng cứng dần theo thời gian, cho tới khi đạt tới năng lực tự học.\r\n\r\nVì quá trình rèn luyện dài, vất vả và đi kèm với những kỳ thi chứng minh khả năng đã vượt qua các mức độ nhất định, các kỹ năng cứng được dành nhiều thời gian hơn kỹ năng mềm; và về tuần tự thời gian, thường được đầu tư trước khi sở hữu kỹ năng mềm trong cuộc sống.\r\n\r\nTầm quan trọng của kỹ năng mềm\r\nKỹ năng mềm ngày được chứng minh có ảnh hưởng lớn đến sự thành bại trong sự nghiệp và cuộc sống của một cá nhân, tuy nhiên, tầm quan trọng của nó ít được giới sinh viên và phụ huynh nhắc đến. Bạn là một người đang có rất nhiều dự định và kế hoạch cho tương lai của chính bản thân mình và người thân, kỹ năng mềm có thực sự quan trọng đối với bạn ? Bạn có chuyên môn giỏi, điều đó đã đủ để giúp bạn thành công? Bạn có biết chỉ 30% người có IQ cao đạt được thành công trong cuộc sống? Tại sao thanh niên Việt Nam học rất giỏi trên ghế nhà trường nhưng khi tốt nghiệp đi làm vẫn chưa đạt được thành công như mong muốn?\r\n\r\nThực tế cho thấy người thành đạt chỉ có 15% là do những kiến thức chuyên môn, 85% còn lại được quyết định bởi những kỹ năng mềm họ được trang bị (theo Wikipedia). Những người sử dụng lao động coi trọng các kỹ năng “mềm”, bởi vì các nghiên cứu cho thấy chúng là một nhân tố đánh giá rất hiệu quả bên cạnh những kỹ năng công việc truyền thống hay còn gọi là kỹ năng “cứng”. Một cuộc nghiên cứu mới đây cho thấy những tiêu chuẩn để đánh giá con người như sự tận tâm, tính dễ chịu cũng là những nhân tố dự báo quan trọng đối với sự thành công trong nghề nghiệp giống như khả năng về nhận thức và kinh nghiệm làm việc (theo BWPortal).\r\n\r\nNhững kỹ năng mềm quan trọng\r\n1. Có sự tự tin, ý chí chiến thắng & Quan điểm lạc quan\r\n\r\nTất cả chúng ta đã từng nghe lời khuyên hãy nhìn cốc nước còn đầy một nửa tốt hơn là nhìn nó đã vơi đi một nửa. Ở nơi làm việc, cách nghĩ lạc quan này có thể giúp bạn phát triển trên một chặng đường dài. Tất cả mọi cái nhìn lạc quan đều dẫn đến một thái độ lạc quan và có thể là một vốn quý trong môi trường làm việc, đánh bại thái độ yếm thế và bi quan.\r\n\r\nChìa khóa để có một thái độ lạc quan là bạn giải quyết một sự trở ngại hay thách thức như thế nào khi gặp phải. Ví dụ, thay vì than phiền về khối lượng công việc gây stress, hãy nghĩ về nó như một cơ hội để thể hiện khả năng làm việc tích cực và hiệu quả của bạn.\r\n\r\n2. Kỹ năng làm việc nhóm\r\n\r\nBạn có khả năng làm việc tốt theo nhóm? Bạn đóng góp tích cực và đôi khi như kiêm vai trò là người lãnh đạo?\r\n\r\n- Các nhà tuyển dụng rất thích những nhân viên thể hiện được khả năng làm việc tốt trong tập thể. Hòa đồng với tập thể không chỉ có nghĩa là có tính cộng tác mà còn thể hiện được khả năng lãnh đạo tốt khi có thời điểm thích hợp.\r\n\r\n- Có thể tới một lúc nào đó, sự xung đột xuất hiện trong tập thể của bạn, hãy tỏ ra chủ động dàn xếp. Khi bạn thấy tập thể của mình đang bị sa lầy trong một dự án, hãy cố gắng xoay chuyển tình thế, đưa cách giải quyết theo một hướng khác. Và bạn làm gì nếu bình thường bạn không làm việc trong một nhóm? Hãy cố gắng tỏ ra sẵn sàng hợp tác trong công việc và thiết lập nên các mối quan hệ công việc với mọi đồng nghiệp nếu có thể. Học cách nói những điều bạn nghĩ như thế nào và thể hiện bằng ngôn ngữ cử chỉ ra sao.\r\n\r\n3. Kỹ năng giao tiếp\r\nBạn có phải là người vừa biết nói chuyện, vừa biết lắng nghe? Bạn có thể chia sẻ những tình huống trong công việc và yêu cầu của mình với các đồng nghiệp, khách hàng… một cách tích cực và xây dựng. Kỹ năng giao tiếp tốt là một thế mạnh đối với bất cứ ai trong công việc. Giao tiếp là phương tiện cho phép bạn xây dựng cầu nối với đồng nghiệp, thuyết phục người khác chấp nhận ý kiến của bạn và bày tỏ được nhu cầu của bạn.\r\n\r\nNhiều điều nhỏ nhặt bạn đã từng thực hiện hàng ngày - có thể có những điều bạn không từng nghĩ đến lại có một sự ảnh hưởng rất lớn tới kỹ năng giao tiếp của bạn. Sau đây là những điều bạn nên lưu ý khi giao tiếp với những người khác. Nói chung, bạn nên để ý tới cách sử dụng từ ngữ của mình để tạo ấn tượng với người đối thoại. Cũng đừng quên rằng một trong những kỹ năng giao tiếp là biết lắng nghe.\r\n\r\nNếu bạn thiếu ngoại ngữ, bạn sẽ bỏ lỡ cơ hội làm việc ở các công ty lớn. Nếu bạn thiếu bằng cấp, bạn khó thăng tiến ở những bậc cao hơn. Nhưng thiếu Kỹ năng giao tiếp, bạn sẽ bỏ lỡ tất cả: cơ hội nghề nghiệp, những mối quan hệ và cơ hội được chứng tỏ bản thân mình kể cả trong công việc lẫn trong cuộc sống. Nếu bạn chưa thực sự tự tin với việc ăn nói, diễn đạt và giao tiếp với người khác, hãy tìm hiểu thêm về các phương pháp cải thiện kỹ năng này thông qua chương trình đào tạo kỹ năng giao tiếp ứng xử trên kenhtuyensinh.vn.\r\n\r\n4. Sự tự tin\r\nBạn có thực sự tin rằng mình có thể làm được công việc này? Bạn có thể hiện thái độ bình tĩnh và tạo sự tự tin cho người khác? Bạn có khuyến khích được mọi người đặt các câu hỏi cần thiết để đóng góp ý kiến xây dựng? Trong hầu hết các trường hợp, khi bạn muốn gây ấn tượng với một ai đó, sự tự tin là một thái độ rất hiệu quả. Trong khi sự khiêm nhường khi bạn nhận được lời tán dương là rất quan trọng thì sự thừa nhận thế mạnh của mình cũng quan trọng không kém. Hãy tin chắc rằng bạn có sự nhận biết và kỹ năng để có thể bày tỏ được sự tự tin của mình. Xem thêm bài viết: Làm sao để tự tin.\r\n\r\n5. Kỹ năng tư duy sáng tạo\r\nBạn có thể thích nghi được với những tình huống và những thách thức mới? Bạn có sẵn sàng đón nhận những thay đổi và đưa ra những ý tưởng mới?\r\n\r\nTính sáng tạo và lối suy nghĩ thông minh được đánh giá cao ở bất cứ công việc nào. Thậm chí công việc mang tính kỹ thuật nhất cũng đòi hỏi khả năng suy nghĩ thoát ra khỏi khuôn khổ. Vì vậy đừng bao giờ đánh giá thấp sức mạnh của việc giải quyết vấn đề theo cách sáng tạo. Bạn có thể đang phải làm một công việc chán ngắt, buồn tẻ, hãy cố gắng khắc phục nó theo cách hiệu quả hơn. Khi một vấn đề khiến người ta phải miễn cưỡng bắt tay vào làm, hãy nghĩ ra một giải pháp sáng tạo hơn. Nếu không được, ít ra bạn đã từng thử nó.\r\n\r\n6. Kỹ năng tiếp nhận và học hỏi\r\nBạn có thể biến những lời phê bình thành những kinh nghiệm và bài học cho bản thân? Bạn có thể học hỏi và tự phát triển để trở thành một người chuyên nghiệp?\r\n\r\nĐây là một trong những kỹ năng mang tính thử thách nhất, và cũng chính là kỹ năng gây ấn tượng nhất đối với người tuyển dụng. Khả năng ứng xử trước lời phê bình phản ánh rất nhiều về thái độ sẵn sàng cải thiện của bạn. Đồng thời có khả năng đánh giá, nhận xét mang tính xây dựng đối với công việc của những người khác cũng mang ý nghĩa quan trọng không kém. Hãy nhận thức xem bạn thủ thế như thế nào khi phản ứng trước những lời nhận xét tiêu cực. Đừng bao giờ ném đá vào những lời phê bình mang tính xây dựng mà không nhận thấy rằng ít nhất nó cũng có ích một phần. Khi bạn đưa ra lời nhận xét với người khác, hãy thể hiện sao cho thật khéo léo và chân thành. Cố gắng dự đoán trước phản ứng của người nghe dựa vào tính cách của họ để có cách nói phù hợp nhất.\r\n\r\n\r\n7. Thúc đẩy bản thân và dẫn dắt người khác\r\n\r\nMột điều rất quan trọng đối với nhà tuyển dụng là làm sao để biết được bạn có là người năng động và hay đề ra các sáng kiến hay không? Điều này có nghĩa là bạn liên tục tìm ra những giải pháp mới cho công việc của mình khiến cho nó hấp dẫn hơn thậm chí đối với cả những công việc mang tính lặp đi lặp lại. Sự sáng tạo có vai trò rất lớn trong việc thúc đẩy, nó khiến bạn đủ dũng cảm để theo đuổi một ý tưởng vốn bị mắc kẹt trong suy nghĩ và cuối cùng là bạn vượt qua được nó. Dẫn dắt những người khác theo cùng một hướng để đạt một mục đích chung, và người lãnh đạo giỏi là người có thể lãnh đạo được người khác bằng chính tấm gương của mình.\r\n\r\n8. Kỹ năng thiết lập và thực hiện mục tiêu\r\n\r\nBạn năng động và sáng tạo trong việc giải quyết các vấn đề chắc chắn sẽ nảy sinh trong quá trình làm việc? Bạn sẽ đảm nhận giải quyết công việc hay \"nhường phần\" cho người khác? Ở công sở ngày nay, một nhân viên tốt là một nhân viên có khả năng kiêm nhiệm thêm một số công việc khác, hay nhiều dự án cùng một lúc. Liệu bạn có thể theo dõi được tiến trình của các dự án khác nhau hay không? Bạn có biết lựa chọn để ưu tiên những việc quan trọng nhất không? Nếu có thể, bạn được gọi là người đa năng. Đừng than phiền rằng bạn phải làm thêm các công việc khác. Hãy thể hiện khả năng đa kỹ năng của bạn. Chắc chắn cái bạn nhận lại sẽ là rất lớn như kinh nghiệm hay các mối quan hệ mới.', 'Admin', '2025-11-20 11:27:54', '2025-11-20 11:27:54', '691e98cab8999.png', 'published', 1),
(44, 'haha', 'sfsdfew', 'Admin', '2025-11-20 14:32:22', '2025-11-20 14:32:22', '', 'published', 3),
(45, 'Kỹ năng mềm là gì? Tầm quan trọng trong công việc và sự thăng tiến ', 'Kỹ năng mềm là gì? Kỹ năng mềm hay Soft skills còn được biết đến là Kỹ năng thực hành xã hội và là thuật ngữ có liên quan đến trí tuệ xúc cảm dùng để chỉ các kỹ năng quan trọng của cuộc sống con người: kỹ năng sống, giao tiếp, làm việc nhóm, quản lý thời gian, thư giãn, sáng tạo, vượt qua khủng hoảng,… \r\n\r\nTrong công việc, chúng ta sẽ cần có chuyên môn và kỹ năng mềm. Nhưng một người giỏi chuyên môn nhưng không có kỹ năng mềm hay không thể làm việc cùng nhiều người khác thì sẽ không thể tạo ra kết quả khi làm việc nhóm. Do đó, bên cạnh chuyên môn chúng ta cần trau dồi thêm các kỹ năng mềm cho mình. \r\n\r\nPhân biệt kỹ năng mềm và kỹ năng cứng \r\nKỹ năng cứng và kỹ năng mềm đều có vai trò quan trọng đối với mỗi người. Tuy vậy, vẫn khó tránh khỏi việc nhầm lẫn giữa các kỹ năng này. \r\n\r\nBạn có thể dễ dàng phân biệt các kỹ năng này như sau: \r\n\r\nKỹ năng cứng: Là những kỹ năng chuyên môn và có thể đong đếm và có được là nhờ quá trình đào tạo, giáo dục và thực hành. Để có thể làm tốt công việc, bạn cần có kỹ năng cứng. \r\nVí dụ: Là một giáo viên thì cần có kỹ năng sư phạm và được đào tạo qua quá trình học tập và thực hành ở trường, lớp. Là ca sĩ cần có kỹ năng thanh nhạc,…\r\n\r\nKỹ năng mềm: Là cách mà con người tương tác, đối xử, giao tiếp,…với người khác. Kỹ năng mềm cũng có thể có được là nhờ luyện tập và trau dồi. \r\nTầm quan trọng của kỹ năng mềm là gì trong công việc và thăng tiến.\r\nKỹ năng mềm có tầm ảnh hưởng rất lớn trong sự thành bại của sự nghiệp của mỗi người. Theo thống kê thì những người có được sự thành công chủ yếu chỉ từ 25% kiến thức chuyên môn, còn 75% là những kỹ năng mềm mà họ đúc kết. \r\n\r\nMột nghiên cứu khác với những danh sách những người giàu nhất thế giới thì có tời 90% người sở hữu các kỹ năng mềm nhất định. Nhờ có những kỹ năng mềm họ có thể tạo ra những thành tựu đột phá trong công việc và cả cuộc sống. \r\n\r\nKhông giống với kỹ năng cứng mà con người có thể học, đo lường và xác định rõ ràng. Kỹ năng mềm không chứa tính chuyên môn và sờ nắm mà được đúc kết và trau dồi qua thời gian. \r\n\r\nVí dụ: Kỹ năng chia sẻ, xử lý tình huống, làm việc nhóm,… tạo ra nhiều giá trị thiết thực trong cuộc sống. Đây chính là yếu tố bổ trợ hàng đầu để phát triển các kỹ năng khác. \r\n\r\nThực trạng về kỹ năng mềm của giới trẻ hiện nay \r\nHiện nay, số lượng sinh viên tốt nghiệp mỗi năng tương đối lớn, tuy nhiên, tỷ lệ xin được việc làm lại không cao như vậy. Nguyên nhân chính mà các nhà tuyển dụng đưa ra cho thực trạng này chính là các bạn trẻ ứng viên hiện nay có kiến thức cơ bản nhưng lại thiếu các kỹ năng mềm có liên quan, khó hòa nhập với môi trường làm việc. \r\n\r\nTheo các chuyên gia, ngay từ khi còn đi học, các bạn trẻ nên rèn luyện dần các kỹ năng mềm như giao tiếp, phỏng vấn, lãnh đạo, lắng nghe,… để có thể hỗ trợ cho công việc. Với từng chuyên môn công việc cũng sẽ cần các kỹ năng mềm khác nhau. Việc trang bị đầy đủ các kỹ năng sẽ giúp hoàn thiện bản thân tốt hơn, mang đến nhiều cơ hội việc làm tốt và mức lương hấp dẫn hơn. \r\n\r\nThực trạng về kỹ năng mềm của giới trẻ hiện nay \r\n\r\n10 kỹ năng mềm cực quan trọng giúp bạn thành công \r\nDưới đây chính là 10 kỹ năng mềm vô cùng quan trọng, giúp chúng ta thành công trong cuộc sống và công việc \r\n\r\nKỹ năng giao tiếp \r\nĐây là kỹ năng giúp chúng ta có thể xây dựng các mối quan hệ với những người xung quanh, với đồng nghiệp và có thể hòa nhập vào cộng đồng. Góp phần quan trọng trong việc xây dựng thương hiệu cá nhân. Kỹ năng giao tiếp là công cụ không thể thiếu trong cuộc sống và công việc thường ngày. \r\n\r\nKhông chỉ đơn thuần là việc sử dụng ngôn ngữ để nói chuyện mà nó còn thể hiện qua việc chủ động lắng nghe, khả năng trình bày, viết lách. Có thể giải thích cho những người khác một cách dễ hiểu về những khái niệm phức tạp,… \r\n\r\nKỹ năng lập kế hoạch \r\nKỹ năng lập kế hoạch chính là khả năng căn cứ vào mục tiêu đã xác định để lập ra chiến lược, phương pháp, quy trình nhằm thực hiện các mục tiêu trong thời gian nhất định. Đây là một trong những mềm thực sự cần thiết, giúp bạn làm việc hiệu quả hơn,.m \r\n\r\nLập kế hoạch giúp bạn có thể cân bằng và quản lý tốt quỹ thời gian của mình, đồng thời hoàn thành mục tiêu đúng kế hoạch đề ra mà không bị dồn và trì trệ công việc. \r\n\r\nKỹ năng quản lý thời gian \r\nĐây là kỹ năng cần rèn luyện nhiều và liên quan đến hiệu quả công việc. Việc đến đúng giờ trong cuộc họp, hoàn thành KPI đúng thời gian, làm việc đúng deadline chính là biểu hiện bạn là người làm việc có nguyên tắc và quản lý người khác. \r\n\r\nBiết quản lý thời gian giúp bạn có thể sắp xếp và làm việc hiệu quả, không để bị lãng phí thời gian hay tránh việc quá gấp gáp trong công việc khiến hiệu quả không tốt. \r\n\r\n10 kỹ năng mềm cực quan trọng giúp bạn thành công \r\n\r\nKỹ năng lắng nghe \r\nLắng nghe tưởng chừng như đơn giản nhưng không phải ai cũng làm được. Kỹ năng lắng nghe chính là biết tiếp nhận các ý kiến, thu thập và phân tích từ đó giúp thực hiện công việc, yêu cầu đề ra tốt hơn. Đồng thời biết lắng nghe cũng giúp bạn học hỏi được nhiều điều và kinh nghiệm hơn từ những người đi trước. \r\n\r\nKỹ năng thuyết phục \r\nKỹ năng thuyết phục là khả năng thay đổi thái độ, niềm tin hoặc hành vi của một người hoặc nhóm người về một ai đó, nhóm, sự kiện, đối tượng hoặc ý tưởng. Thường được thực hiện bằng cách truyền đạt, trong một thông điệp, một số cảm xúc, thông tin, lý luận hoặc kết hợp.\r\n\r\nKỹ năng làm việc nhóm \r\nĐây là kỹ năng thể hiện sự kết hợp với người khác nhằm đạt được mục tiêu chung. Trong việc học ở trường hay môi trường làm việc thì kỹ năng làm việc nhóm luôn có vị trí quan trọng. Giúp các công việc và hoạt động có đạt kết quả tốt hơn. \r\n\r\nĐây là kỹ năng mềm trong công việc mà ai cũng cần có. Bởi khi gia nhập một công ty, tổ chức, bạn không chỉ làm việc một mình mà còn cần phối hợp với nhiều người hay các phòng ban khác để có thể thực hiện và hoàn thành công việc. \r\n\r\nBạn có thể khám phá thêm về interpersonal skills là gì để phát triển kỹ năng giao tiếp tại đây.\r\n\r\nKỹ năng lãnh đạo \r\nMột người sẽ không thể nào đi lên vị trí quản lý hay lãnh đạo ngay từ khi mới ra trường. Nhưng nếu là một người có tố chất lãnh đạo thì chắc chắn sẽ có cơ hội để tỏa sáng và thăng tiến hơn trong công việc. \r\n\r\nĐể có thể lãnh đạo người khác tốt, bạn cần học cách quản lý, lãnh đạo bản thân. Bạn cần vạch ra mục tiêu, kế hoạch và trau dồi kiến thức, kỹ năng chuyên môn, quản lý công việc, thời gian,… Có như thế bạn mới được tín nhiệm và đảm nhiệm vị trí lãnh đạo. \r\n\r\nKỹ năng phản biện \r\nTư duy phản biện được hiểu đơn giản là việc tiếp nhận thông tin, sau đó sàng lọc và nhận định xem nó có thực sự đúng đắn hay không chứ không tin tưởng hoàn toàn. Đây không có nghĩa là nghi ngờ hay phủ nhận tất cả mà nó giúp đánh giá thông tin một cách toàn diện. \r\n\r\nTư duy còn thúc đẩy sự sáng tạo và có những phát kiến mang tính đột phá. Để có thể rèn luyện tư duy này cần phải tích lũy kiến thức, đặt ra các câu hỏi và phân tích vấn đề dưới nhiều góc độ cũng như không giới hạn vào khuôn mẫu hay định kiến nào. \r\n\r\nKỹ năng thích ứng nhanh \r\nVới sự phát triển của công nghệ, xã hội hiện nay, thì cuộc sống của chúng ta sẽ có những sự biến đổi không ngừng. Để có thể bắt kịp với thời đại, công việc,…chúng ta cần có khả năng thích ứng nhanh với những thay đổi này nếu không muốn bị tụt lại phía sau. \r\n\r\nKỹ năng này thể hiện ở chỗ bạn dễ thích nghi với môi trường làm việc, ứng dụng kỹ thuật công nghệ mới vào công việc của mình. \r\n\r\nKỹ năng xã hội \r\nCàng tiếp xúc với nhiều người thì bạn càng thấy kỹ năng xã hội sẽ rất quan trọng. Dù muốn hay không thì công việc và cuộc sống hằng ngày sẽ đưa bạn đến những mối quan hệ xã giao, chuyên nghiệp. Lúc này, bạn cần có kỹ năng xã hội để có thể biết cách cư xử đúng mực với từng đối tượng. \r\n\r\nBạn là một người thân thiện, dễ gần, tuy nhiên cách bạn giao tiếp và ứng xử với đồng nghiệp sẽ có những sự khác biệt cần thiết như trong việc ứng xử với sếp. Đó thể hiện sự chuyên nghiệp và kỹ năng xã hội. ', 'Admin', '2025-11-20 19:07:52', '2025-11-20 19:14:17', '691f049837a84_1763640472.png', 'published', 1);

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
  ADD KEY `post_id` (`post_id`),
  ADD KEY `fk_comment_user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
