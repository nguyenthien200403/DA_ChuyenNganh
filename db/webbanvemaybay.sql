-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th12 16, 2024 lúc 01:59 PM
-- Phiên bản máy phục vụ: 5.7.31
-- Phiên bản PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webbanvemaybay`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `airlines`
--

DROP TABLE IF EXISTS `airlines`;
CREATE TABLE IF NOT EXISTS `airlines` (
  `airline_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`airline_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `airlines`
--

INSERT INTO `airlines` (`airline_id`, `name`, `contact_info`) VALUES
(1, 'Vietnam Airlines', 'contact@vietnamairlines.com'),
(2, 'Bamboo Airways', 'contact@bambooairways.com'),
(3, 'VietJet Air', 'contact@vietjetair.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `flight_id` int(11) NOT NULL,
  `booking_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `number_of_adult_tickets` int(11) NOT NULL,
  `number_of_child_tickets` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `user_id` (`user_id`),
  KEY `flight_id` (`flight_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `flight_id`, `booking_date`, `number_of_adult_tickets`, `number_of_child_tickets`, `total_price`) VALUES
(1, 1, 1, '2024-11-15 10:00:00', 2, 1, '375.00'),
(2, 2, 2, '2024-11-14 11:00:00', 1, 1, '150.00'),
(3, 3, 1, '2024-11-15 10:00:00', 2, 0, '300.00'),
(4, 4, 3, '2024-11-13 12:00:00', 1, 0, '120.00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `flights`
--

DROP TABLE IF EXISTS `flights`;
CREATE TABLE IF NOT EXISTS `flights` (
  `flight_id` int(11) NOT NULL AUTO_INCREMENT,
  `flight_number` varchar(10) NOT NULL,
  `departure_airport` varchar(100) NOT NULL,
  `arrival_airport` varchar(100) NOT NULL,
  `departure_time` datetime NOT NULL,
  `arrival_time` datetime NOT NULL,
  `airline_id` int(11) DEFAULT NULL,
  `seat_capacity` int(11) DEFAULT NULL,
  `adult_price` decimal(10,2) NOT NULL,
  `child_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`flight_id`),
  KEY `airline_id` (`airline_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `flights`
--

INSERT INTO `flights` (`flight_id`, `flight_number`, `departure_airport`, `arrival_airport`, `departure_time`, `arrival_time`, `airline_id`, `seat_capacity`, `adult_price`, `child_price`) VALUES
(1, 'VN123', 'Hanoi', 'Ho Chi Minh', '2024-12-01 08:00:00', '2024-12-01 10:00:00', 1, 180, '150.00', '75.00'),
(2, 'BL456', 'Da Nang', 'Hanoi', '2024-12-02 12:00:00', '2024-12-02 14:00:00', 2, 200, '100.00', '50.00'),
(3, 'VJ789', 'Ho Chi Minh', 'Nha Trang', '2024-12-03 15:00:00', '2024-12-03 16:30:00', 3, 150, '120.00', '60.00'),
(4, 'VN4466', 'Ho Chi Minh', 'Ca Mau', '2024-12-16 18:37:00', '2024-12-16 22:37:00', 3, 118, '130000.00', '5000.00'),
(5, 'VN4444', 'Nha Trang', 'Tp Vinh', '2024-12-17 07:00:00', '2024-12-17 11:00:00', 1, 200, '100000.00', '200000.00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `passengers`
--

DROP TABLE IF EXISTS `passengers`;
CREATE TABLE IF NOT EXISTS `passengers` (
  `passenger_id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `passport_number` varchar(20) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`passenger_id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `passengers`
--

INSERT INTO `passengers` (`passenger_id`, `booking_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `passport_number`, `nationality`, `email`, `phone_number`) VALUES
(1, 1, 'Nguyễn', 'Thị A', '1990-01-15', 'Female', 'P123456789', 'Vietnam', 'a.nguyen@example.com', '0912345678'),
(2, 1, 'Trần', 'Văn B', '2012-05-20', 'Male', 'P987654321', 'Vietnam', 'b.tran@example.com', '0987654321'),
(3, 1, 'Trần', 'Văn E', '2024-05-20', 'Male', '', 'Vietnam', '', ''),
(4, 2, 'Lê', 'Thị C', '1988-05-20', 'Female', 'P123456788', 'Vietnam', 'c.le@example.com', '0901234567'),
(5, 2, 'Lê', 'Thị F', '1988-05-20', 'Female', 'P123456758', 'Vietnam', 'f.le@example.com', '0901234568'),
(6, 3, 'Nguyen', 'Van G', '1988-05-20', 'Male', 'P123456758', 'Vietnam', 'g.le@example.com', '0901234668'),
(7, 3, 'Nguyen', 'Thi G', '1988-05-20', 'Female', 'P113456758', 'Vietnam', 'g.le@example.com', '090334668'),
(8, 4, 'Hoàng', 'Văn D', '2003-07-10', 'Male', 'P111111111', 'Vietnam', 'd.hoang@example.com', '0912345679');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `payment_date`, `amount`) VALUES
(1, 1, '2024-12-16 15:06:04', '375.00'),
(2, 2, '2024-12-16 15:06:04', '150.00'),
(3, 3, '2024-12-16 15:06:04', '300.00'),
(4, 4, '2024-12-16 15:06:04', '120.00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `phone_number`, `address`, `created_at`) VALUES
(1, 'user1', 'user1@example.com', '0912345678', '123', '2024-12-16 15:06:04'),
(2, 'user2', 'user2@example.com', '0923456789', '1654', '2024-12-16 15:06:04'),
(3, 'user3', 'user3@example.com', '0934567890', 'TG', '2024-12-16 15:06:04'),
(4, 'user4', 'user4@example.com', '0934557890', 'HCM', '2024-12-16 15:06:04');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
