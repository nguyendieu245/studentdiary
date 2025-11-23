-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 23, 2025 lúc 01:42 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

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
  `comment` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `parent_id`, `name`, `comment`, `created_at`, `status`, `is_admin`) VALUES
(87, 48, 10, 0, 'Nam', 'bài viết khá hay', '2025-11-23 11:09:37', 1, 0);

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
(48, '⭐ KỸ NĂNG QUẢN LÝ THỜI GIAN CHO SINH VIÊN', 'Kỹ năng quản lý thời gian là một trong những năng lực quan trọng nhất đối với sinh viên, bởi nó quyết định hiệu quả học tập, khả năng cân bằng cuộc sống và mức độ stress hằng ngày. Nhiều bạn luôn cảm thấy một ngày trôi qua quá nhanh, bài tập chưa xong, công việc làm thêm bị dồn, còn thời gian cho bản thân thì gần như không có. Trong khi đó, cũng có những sinh viên vẫn có thể học tốt, tham gia câu lạc bộ, duy trì việc tập thể thao và tận hưởng cuộc sống. Sự khác biệt không nằm ở việc ai bận hơn, mà ở cách mỗi người quản lý quỹ thời gian 24 giờ giống nhau.\r\n\r\nĐể quản lý thời gian hiệu quả hơn, điều quan trọng đầu tiên là xác định được những việc thật sự quan trọng. Thay vì liệt kê một danh sách dài khiến bản thân dễ chán nản, sinh viên chỉ cần chọn ra ba nhiệm vụ quan trọng nhất mỗi ngày. Đây là quy tắc MIT (Most Important Tasks). Khi giới hạn số lượng, bạn sẽ tập trung đúng trọng tâm, tránh lan man và cảm thấy thoải mái hơn khi hoàn thành được mục tiêu rõ ràng. Ngay cả những ngày bận rộn nhất, việc hoàn thành ba nhiệm vụ cốt lõi cũng mang lại cảm giác “ngày hôm nay mình đã làm được điều có ý nghĩa”.\r\n\r\nBên cạnh đó, phương pháp Pomodoro cũng là một công cụ cực kỳ hiệu quả giúp tăng khả năng tập trung. Chia thời gian thành chu kỳ 25 phút làm việc và 5 phút nghỉ giúp não bộ không bị quá tải, giảm sự xao nhãng và tăng hiệu suất tiếp thu kiến thức. Với mỗi 25 phút tập trung tuyệt đối, sinh viên có thể làm được nhiều hơn so với việc ngồi 2–3 giờ nhưng liên tục mất tập trung vì điện thoại, mạng xã hội hay tin nhắn. Một buổi học chỉ cần 4–5 Pomodoro cũng đã khiến lượng kiến thức tiếp thu tăng đáng kể.\r\n\r\nMột sai lầm mà nhiều sinh viên thường mắc phải là đa nhiệm – làm nhiều việc cùng lúc. Điều này nghe có vẻ hiệu quả, nhưng thực tế não bộ phải liên tục chuyển trạng thái giữa các nhiệm vụ, khiến thời gian xử lý lâu hơn và chất lượng công việc giảm sút. Thay vì mở 6 tab để học cùng lúc, hãy chọn một việc duy nhất và tập trung hoàn toàn vào việc đó. Khi làm việc đơn nhiệm, bạn sẽ thấy đầu óc nhẹ nhàng hơn, tốc độ hoàn thành cũng nhanh hơn nhiều.\r\n\r\nNgoài ra, lên kế hoạch theo tuần là một thói quen nhỏ nhưng mang lại giá trị lớn. Chỉ cần dành khoảng 10 phút vào cuối tuần để xác định các buổi học, lịch thi, lịch làm thêm và các thời gian quan trọng khác, bạn sẽ chủ động hơn và không bị cuống vào phút cuối. Lịch tuần cũng giúp bạn phân bố đều thời gian nghỉ ngơi, tránh tình trạng “cày” liên tục rồi kiệt sức.\r\n\r\nCuối cùng, một điều quan trọng mà sinh viên cần ghi nhớ: đừng chờ cảm hứng để bắt đầu. Cảm hứng không phải lúc nào cũng xuất hiện, nhưng thời gian thì vẫn trôi. Hãy bắt đầu bằng 5 phút. Năm phút đó sẽ khiến bạn “vào guồng”, và phần khó nhất của việc học luôn là bắt đầu. Khi vượt qua được rào cản ban đầu, bạn sẽ bất ngờ với năng lượng mà mình có thể duy trì.\r\n\r\nQuản lý thời gian không phải là kỹ năng bẩm sinh, mà là thói quen được xây dựng mỗi ngày. Chỉ cần thay đổi vài điều nhỏ – tập trung hơn, ưu tiên đúng việc, lên lịch rõ ràng – em sẽ thấy cuộc sống của mình trở nên gọn gàng, chủ động và dễ thở hơn rất nhiều. Đây chính là nền tảng để học tốt hơn, làm việc hiệu quả hơn và sống hạnh phúc hơn.', 'Admin', '2025-11-23 00:35:40', '2025-11-23 00:38:42', '6921f522447d8_1763833122.jpg', 'published', 1),
(50, '📚 Cánh Cửa Đại Học: Hành Trình Rực Rỡ Của Đời Sống Sinh Viên', 'Đời sống sinh viên là một chương mới, mở ra một thế giới đầy tự do, trách nhiệm và cơ hội khám phá bản thân. Đây không chỉ là bốn năm (hoặc hơn) học tập chuyên môn, mà còn là thời kỳ quan trọng nhất để xây dựng nền tảng cho tương lai và hình thành nhân cách.\r\n\r\nI. Cân Bằng Giữa Học Tập và Trải Nghiệm\r\nThử thách lớn nhất của sinh viên là tìm được điểm cân bằng hoàn hảo giữa học thuật và các hoạt động bên ngoài.\r\n\r\n🎯 1. Nhiệm Vụ Học Thuật\r\nĐại học đòi hỏi sự tự giác cao. Không chỉ dừng lại ở việc lên lớp, sinh viên cần chủ động:\r\n\r\nTự học chuyên sâu: Nghiên cứu ngoài giáo trình, tìm hiểu các tài liệu tham khảo và ứng dụng thực tế kiến thức đã học.\r\n\r\nQuản lý thời gian: Lập kế hoạch rõ ràng cho các bài tập nhóm, bài kiểm tra và thời gian ôn thi để tránh tình trạng \"nước đến chân mới nhảy.\"\r\n\r\n🤝 2. Phát Triển Kỹ Năng Mềm\r\nNhững kỹ năng được rèn luyện ngoài giảng đường thường quyết định sự thành công sau này:\r\n\r\nTham gia Câu lạc bộ (CLB): Đây là nơi tốt nhất để trau dồi kỹ năng giao tiếp, làm việc nhóm, lãnh đạo và tổ chức sự kiện.\r\n\r\nHoạt động tình nguyện/xã hội: Giúp sinh viên mở rộng góc nhìn, hiểu rõ hơn về cộng đồng và phát triển lòng trắc ẩn.\r\n\r\nTìm kiếm kinh nghiệm thực tế: Các công việc bán thời gian hoặc thực tập (internship) giúp kết nối lý thuyết với thực tiễn, tạo lợi thế lớn khi ra trường.\r\n\r\nII. Quản Lý Cuộc Sống Cá Nhân\r\nLần đầu xa nhà hoặc sống tự lập là lúc sinh viên phải tự mình giải quyết các vấn đề đời sống.\r\n\r\nQuản lý tài chính: Học cách chi tiêu hợp lý, lập ngân sách cá nhân, và phân biệt giữa nhu cầu (needs) và mong muốn (wants).\r\n\r\nChăm sóc sức khỏe: Duy trì chế độ ăn uống lành mạnh, ngủ đủ giấc, và tập thể dục thường xuyên. Sức khỏe thể chất và tinh thần là \"vốn\" quan trọng nhất để vượt qua áp lực học tập.\r\n\r\nXây dựng Mối quan hệ: Đời sống sinh viên là cơ hội để kết bạn với những người đến từ nhiều vùng miền và nền tảng khác nhau, tạo nên mạng lưới hỗ trợ quý giá.\r\n\r\nIII. Tận Dụng Cơ Hội và Dám Thử\r\nGiai đoạn sinh viên là lúc ít ràng buộc nhất, cho phép bạn thử và sai mà không phải trả giá quá đắt.\r\n\r\nĐừng sợ thất bại: Hãy thử một môn học mới, tham gia một cuộc thi khó, hay thử sức ở một lĩnh vực bạn chưa từng nghĩ tới.\r\n\r\nTận dụng nguồn lực: Trường đại học là nơi có nhiều giảng viên chuyên môn cao, thư viện dồi dào tài liệu, và các chương trình hỗ trợ sinh viên. Hãy chủ động tìm kiếm sự giúp đỡ và học hỏi từ họ.\r\n\r\nĐời sống sinh viên là một khoảng thời gian ngắn ngủi nhưng đầy ắp kỷ niệm. Hãy sống trọn vẹn từng ngày, biến những năm tháng này thành nền tảng vững chắc và đáng tự hào cho tương lai của bạn.', 'Admin', '2025-11-23 01:04:25', '2025-11-23 01:04:25', '6921fb2916afb_1763834665.jpg', 'published', 2),
(51, 'Học tập chủ động - Góc nhìn và cảm nhận', 'Mình nhớ hồi năm nhất đại học, mình thường chỉ ngồi nghe giảng, ghi chép vẹt mà không thực sự hiểu sâu kiến thức. Thú thật, lúc đó mình thấy học hành thật nặng nề và đôi khi mất hứng thú. Nhưng dần dần, mình nhận ra rằng cách học thụ động ấy không giúp mình tiến bộ nhiều.\r\n\r\nSau đó, mình thử học tập chủ động hơn: trước khi đến lớp, mình đọc trước tài liệu, ghi lại những câu hỏi mình chưa hiểu; trong lớp, mình mạnh dạn tham gia thảo luận. Lúc làm vậy, mình mới nhận ra kiến thức “thấm” nhanh và dễ nhớ hơn hẳn. Mỗi lần tự tìm ra câu trả lời cho một vấn đề, mình lại có cảm giác thành tựu nho nhỏ rất vui.\r\n\r\nMột điều mình thấy rõ là học chủ động còn giúp rèn kỹ năng quản lý thời gian. Thay vì ngồi đến phút chót mới làm bài tập, mình lên kế hoạch học theo từng ngày, từng tuần. Ban đầu hơi khó chịu vì phải tự kỷ luật bản thân, nhưng sau vài tuần, mình cảm thấy tự tin hơn và ít áp lực hơn.\r\n\r\nMình cũng thấy việc học chủ động giúp gắn kết với bạn bè hơn. Khi tham gia nhóm học tập hay thảo luận dự án, mình chủ động chia sẻ ý kiến, lắng nghe mọi người, và học được nhiều điều mới. Không chỉ kiến thức, mà cả kỹ năng giao tiếp, hợp tác cũng được cải thiện.\r\n\r\nCuối cùng, mình nhận ra: học tập chủ động không chỉ giúp mình giỏi hơn trong học tập, mà còn giúp mình trưởng thành hơn, biết cách chịu trách nhiệm với bản thân và tận hưởng quá trình học. Nếu bạn là sinh viên, mình khuyên thật: hãy thử học chủ động một lần, bạn sẽ thấy khác biệt ngay.', 'Admin', '2025-11-23 15:28:59', '2025-11-23 15:28:59', '6922c5cbbb69c_1763886539.jpg', 'published', 3),
(52, 'Học IT có khó không?', 'Mình nhớ những ngày đầu bước chân vào ngành Công nghệ thông tin, cảm giác vừa hứng thú vừa… lo lắng. Mình tò mò về lập trình, mạng máy tính, trí tuệ nhân tạo, nhưng cũng tự hỏi liệu mình có theo kịp khối lượng kiến thức đồ sộ này không.\r\n\r\nĐiều mình nhận ra sớm là học chuyên ngành IT không chỉ học trên lớp. Thường thì lý thuyết chỉ là nền tảng, còn để thực sự hiểu và áp dụng, phải tự tay code, tự thử dự án nhỏ, tham gia hackathon hay làm project cá nhân. Ban đầu, nhiều lúc mình gặp bug cả ngày, stress kinh khủng luôn, nhưng khi tìm ra giải pháp, cảm giác “chiến thắng” thật sự rất đã.\r\n\r\nMột điểm mình thấy quan trọng nữa là chủ động tìm hiểu kiến thức mới. Công nghệ thay đổi từng ngày, framework hay ngôn ngữ mới xuất hiện liên tục. Nếu chỉ học theo sách giáo trình, sẽ dễ bị lạc hậu. Vì vậy, mình thường đọc blog, xem tutorial, tham gia forum để học thêm. Thực sự, điều này giúp mình cập nhật xu hướng, hiểu sâu hơn và làm portfolio ấn tượng.\r\n\r\nHọc chuyên ngành IT cũng giúp mình rèn kỹ năng mềm: teamwork khi làm project nhóm, kỹ năng thuyết trình khi báo cáo, và đặc biệt là tư duy logic, giải quyết vấn đề. Những kỹ năng này không chỉ hữu ích trong lớp mà còn rất cần thiết khi đi làm sau này.\r\n\r\nCuối cùng, mình muốn nói rằng: học IT là một hành trình đầy thử thách nhưng rất thú vị. Nếu bạn là sinh viên chuyên ngành này, đừng sợ lỗi sai, hãy chủ động học hỏi, thử sức với dự án thực tế, và kết nối với cộng đồng. Mỗi bước tiến nhỏ đều giúp bạn tiến gần hơn đến mục tiêu trở thành một lập trình viên chuyên nghiệp.', 'Admin', '2025-11-23 15:30:54', '2025-11-23 15:30:54', '6922c63e3aa40_1763886654.jpg', 'published', 3),
(53, 'Cuộc sống sinh viên – Chia sẻ nhỏ từ mình 🎓✨', 'Là sinh viên, mình thường hay nghe mọi người nói: “Cuộc sống đại học thật tự do, thoải mái.” 😅 Thật ra, tự do thì có thật, nhưng cũng đi kèm trách nhiệm và thử thách. Mình muốn chia sẻ một chút về đời sống sinh viên để các bạn chuẩn bị tinh thần nhé.\r\n\r\n1. Quản lý thời gian ⏰\r\nĐại học không còn ai nhắc nhở bạn đi học hay làm bài tập. Mình từng bị “ngập” trong deadline và cảm giác stress cực kì 😵‍💫. Sau này, mình học cách lập kế hoạch hàng tuần, chia nhỏ công việc và ưu tiên việc quan trọng trước. Tin mình đi, khi có kế hoạch, mọi thứ nhẹ nhàng hơn rất nhiều.\r\n\r\n2. Học tập nhưng vẫn vui vẻ 📚🎉\r\nMình nghĩ sinh viên không chỉ học kiến thức chuyên môn mà còn tận hưởng những khoảnh khắc vui vẻ với bạn bè: tham gia câu lạc bộ, học nhóm, café trò chuyện… Những giây phút này giúp tinh thần minh mẫn, học tập hiệu quả hơn và cũng tạo kỷ niệm đáng nhớ.\r\n\r\n3. Chăm sóc bản thân 💪🍎\r\nĐôi khi vì học tập, mình hay bỏ bữa hoặc thức khuya 😴. Nhưng mình nhận ra rằng sức khỏe là quan trọng nhất. Ăn uống đủ chất, tập thể dục nhẹ nhàng, ngủ đủ giấc giúp tinh thần sảng khoái, tập trung hơn khi học.\r\n\r\n4. Kết nối và học hỏi 🌐🤝\r\nCuộc sống đại học cũng là lúc chúng ta gặp gỡ nhiều người mới. Mình thấy việc trao đổi kinh nghiệm, học hỏi từ bạn bè và thầy cô cực kỳ hữu ích. Những mối quan hệ này không chỉ giúp học tập tốt mà còn mở ra cơ hội nghề nghiệp sau này.\r\n\r\nKết luận 💡\r\nĐời sống sinh viên là sự cân bằng giữa học tập, vui chơi và chăm sóc bản thân. Nếu bạn biết cách sắp xếp và tận hưởng, mỗi ngày sẽ đều là trải nghiệm đáng nhớ. Hãy chủ động, tích cực và đừng quên tận hưởng những niềm vui nhỏ trên hành trình này! 🌸', 'Admin', '2025-11-23 15:33:10', '2025-11-23 15:33:10', '6922c6c631f91_1763886790.jpg', 'published', 2),
(54, 'Kỹ năng tự học và thích nghi – Chìa khóa thành công của sinh viên', 'Khi bước vào môi trường đại học, nhiều sinh viên mới nhận ra rằng không ai nhắc nhở mình học như hồi phổ thông. Đây chính là lúc kỹ năng tự học trở nên cực kỳ quan trọng.\r\n\r\n1. Biết tự lập kế hoạch học tập\r\nTự học không chỉ là đọc sách hay làm bài tập. Sinh viên cần biết lập kế hoạch hàng tuần, đặt mục tiêu cụ thể và theo dõi tiến độ. Ví dụ, chia nhỏ chương học, phân chia thời gian cho từng môn và dành thời gian ôn tập định kỳ.\r\n\r\n2. Sử dụng tài nguyên học tập hiệu quả\r\nNgoài giáo trình, sinh viên có thể tìm kiếm tài liệu bổ trợ như video hướng dẫn, bài giảng online, forum chuyên ngành… Việc này giúp mở rộng kiến thức, hiểu sâu vấn đề và rèn luyện khả năng tự tìm kiếm thông tin.\r\n\r\n3. Thử thách bản thân và học từ sai lầm\r\nTrong quá trình tự học, không tránh khỏi gặp khó khăn hay sai sót. Sinh viên cần nhận diện lỗi, phân tích nguyên nhân và thử lại. Đây là cách rèn luyện tư duy phản biện và sự kiên nhẫn.\r\n\r\n4. Thích nghi với môi trường mới\r\nĐại học khác phổ thông ở chỗ môi trường học tập, cách giảng dạy và nhịp sống đều thay đổi. Sinh viên cần học cách thích nghi: tham gia nhóm học tập, tìm mentor, quản lý áp lực và cân bằng giữa học tập và sinh hoạt.\r\n\r\n5. Tạo thói quen học tập bền vững\r\nThói quen tự học đều đặn giúp sinh viên duy trì kiến thức lâu dài và phát triển kỹ năng giải quyết vấn đề. Một chút kỷ luật, kết hợp với việc đặt mục tiêu rõ ràng sẽ tạo ra sự chủ động và tự tin trong học tập.\r\n\r\nKết luận\r\nKỹ năng tự học và thích nghi không chỉ giúp sinh viên nắm vững kiến thức chuyên môn mà còn rèn luyện tính tự lập, tư duy linh hoạt và khả năng vượt qua thử thách. Bắt đầu từ những bước nhỏ mỗi ngày sẽ tạo nền tảng vững chắc cho tương lai.', 'Admin', '2025-11-23 15:36:47', '2025-11-23 15:36:47', '6922c79f46f3f_1763887007.jpg', 'published', 1);

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
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `status`, `created_at`) VALUES
(2, 'annn', '123456', 'Phạm Mai Anh', 'mai@gmail.com', 0, '2025-06-17 15:11:16'),
(4, 'huy', '123456', 'Vũ Đức Huy', 'duchuy@gmail.com', 0, '2025-06-17 16:31:52'),
(5, 'an', '123456', 'Ngọc an', 'anh@gmail.com', 0, '2025-06-17 17:46:14'),
(6, 'anna', '123456', 'linh an', 'linhan@gmail.com', 0, '2025-06-18 07:33:38'),
(7, 'maihy', '123456', 'Nguyễn Ngọc Mai Hy', 'hope@gmail.com', 0, '2025-06-18 10:57:13'),
(8, 'hân', '123456', 'Nguyễn Mai Hân', 'hannguyen@gmail.com', 0, '2025-10-06 14:54:07'),
(9, 'Lannan', '123456', 'Phương Hoàng Lan', 'lanane@gmail.com', 0, '2025-10-27 15:34:14'),
(10, 'Namnam', '123456', 'Nam', 'nam2005@gmail.com', 1, '2025-11-13 23:52:37'),
(12, 'Hanhan', 'Han1234', 'Nguyễn Gia Hân', 'hanhan@gmail.com', 1, '2025-11-14 00:14:28'),
(14, 'dieu11', '12', 'nguyen dieu', 'nguyendieuonce@gmail.com', 1, '2025-11-22 22:43:45'),
(15, 'Hatrang', 'trang123', 'Hà Huyền Trang', 'tranghaha@gmail.com', 1, '2025-11-23 16:01:57');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
