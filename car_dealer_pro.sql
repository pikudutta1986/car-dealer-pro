-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2025 at 08:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_dealer_pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_changed` enum('Y','N') NOT NULL DEFAULT 'N',
  `phone` varchar(50) NOT NULL,
  `businessname` varchar(255) NOT NULL,
  `business_logo` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `distance_unit` enum('KM','MILES') NOT NULL DEFAULT 'KM',
  `current_theme` varchar(50) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `username`, `password`, `password_changed`, `phone`, `businessname`, `business_logo`, `address`, `city`, `state`, `country`, `zip`, `currency`, `distance_unit`, `current_theme`, `password_reset_token`) VALUES
(1, 'admin@yourdomain.com', 'admin', '$2y$10$8T2JCnfRGzezk6fgBWgfmu4Y/DmAxBExoJR5Zzs1/doKUhplBh2lS', 'Y', '1234567890', 'Car Dealer Pro', 'logo.png', 'Your Business Address', 'Your City', 'Your State', 'Your Country', '12345', '$', 'MILES', 'theme1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cars_bodystyle`
--

CREATE TABLE `cars_bodystyle` (
  `bodystyle_id` int(11) NOT NULL,
  `bodystyle` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cars_bodystyle`
--

INSERT INTO `cars_bodystyle` (`bodystyle_id`, `bodystyle`, `slug`, `image`, `status`) VALUES
(1, 'Convertible', 'convertible', 'convertible.png', 'ACTIVE'),
(2, 'Coupe', 'coupe', 'coupe.png', 'ACTIVE'),
(4, 'Hatchback', 'hatchback', 'hatchback.png', 'ACTIVE'),
(6, 'Minivan', 'minivan', 'minivan.png', 'ACTIVE'),
(7, 'Pickup', 'pickup', 'pickup.png', 'ACTIVE'),
(8, 'Sedan', 'sedan', 'sedan.png', 'ACTIVE'),
(9, 'SUV', 'suv', 'suv.png', 'ACTIVE'),
(10, 'Van', 'van', 'van.png', 'ACTIVE'),
(11, 'Wagon', 'wagon', 'wagon.png', 'ACTIVE'),
(12, 'Cab', 'cab', 'cab.png', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `cars_images`
--

CREATE TABLE `cars_images` (
  `id` int(11) NOT NULL,
  `vin` varchar(50) NOT NULL,
  `imagename` varchar(100) NOT NULL,
  `imageorder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars_images`
--

INSERT INTO `cars_images` (`id`, `vin`, `imagename`, `imageorder`) VALUES
(1, '1HGBH41JXMN109186', '2014-hyundai-sonata-gls-4dr-sedan.jpg', 1),
(2, '1HGBH41JXMN109186', '2014-hyundai-sonata-gls-4dr-sedan (1).jpg', 2),
(3, '1HGBH41JXMN109186', '2014-hyundai-sonata-gls-4dr-sedan (2).jpg', 3),
(4, 'WAU2MAFC9EN093287', 'WhatsApp Image 2025-05-05 at 9.56.33 PM.jpeg', 1),
(5, 'WAU2MAFC9EN093287', 'WhatsApp Image 2025-05-05 at 9.56.33 PM (1).jpeg', 2),
(6, 'WAU2MAFC9EN093287', 'WhatsApp Image 2025-05-05 at 9.56.33 PM (2).jpeg', 3),
(7, 'WBA5B1C5XED480087', '2014-bmw-5-series-535i-4dr-sedan.jpg', 1),
(8, 'WBA5B1C5XED480087', '2014-bmw-5-series-535i-4dr-sedan (1).jpg', 2),
(9, 'WBA5B1C5XED480087', '2014-bmw-5-series-535i-4dr-sedan (3).jpg', 3),
(10, 'KMHDU46D48U429052', '202503-6ea9248c3c2b491b9de4338238c146c4.jpg', 1),
(11, '1C6SRFET4LN227811', '1744377215322bgremoved-image.png', 1),
(12, '5FNYF5H39JB000233', '1744377215322bgremoved-image.png', 1),
(13, 'JT4RN67P8G0005116', '1744377215322bgremoved-image.png', 1),
(14, 'KMHEC4A42DA101851', '2013-hyundai-sonata-hybrid-limited-4dr-sedan.jpg', 1),
(15, 'KMHEC4A42DA101851', '2013-hyundai-sonata-hybrid-limited-4dr-sedan (1).jpg', 2),
(16, 'KMHEC4A42DA101851', '2013-hyundai-sonata-hybrid-limited-4dr-sedan (2).jpg', 3),
(17, 'KMHEC4A42DA101851', '2013-hyundai-sonata-hybrid-limited-4dr-sedan (3).jpg', 4),
(18, 'KMHEC4A42DA101851', '2013-hyundai-sonata-hybrid-limited-4dr-sedan (4).jpg', 5),
(19, 'KMHEC4A42DA101851', '2013-hyundai-sonata-hybrid-limited-4dr-sedan (5).jpg', 6),
(20, 'SAJWA0FS8FPU86557', '2015-jaguar-xf-2-0t-premium-4dr-sedan.jpg', 1),
(21, 'SAJWA0FS8FPU86557', '2015-jaguar-xf-2-0t-premium-4dr-sedan (1).jpg', 2),
(22, 'SAJWA0FS8FPU86557', '2015-jaguar-xf-2-0t-premium-4dr-sedan (2).jpg', 3),
(23, 'SAJWA0FS8FPU86557', '2015-jaguar-xf-2-0t-premium-4dr-sedan (3).jpg', 4),
(24, 'VABJHGHG', 'BIGBOBS.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cars_listings`
--

CREATE TABLE `cars_listings` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `vin` varchar(255) NOT NULL,
  `carcondition` enum('NEW','USED') NOT NULL DEFAULT 'USED',
  `make_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `bodystyle_id` int(11) NOT NULL,
  `owner_price` varchar(50) NOT NULL,
  `website_price` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `varient` varchar(50) NOT NULL,
  `transmission` varchar(50) NOT NULL,
  `fuel_type` varchar(50) NOT NULL,
  `max_power` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `engine` varchar(100) NOT NULL,
  `mileage` varchar(20) NOT NULL,
  `boot_space` varchar(100) NOT NULL,
  `ground_clearance` varchar(100) NOT NULL,
  `cylinders` varchar(50) NOT NULL,
  `max_torque` varchar(50) NOT NULL,
  `seating_capacity` varchar(100) NOT NULL,
  `airbags` varchar(5) NOT NULL,
  `details` text NOT NULL,
  `features` text NOT NULL,
  `status` enum('AVAILABLE','SOLD OUT') NOT NULL DEFAULT 'AVAILABLE',
  `dateadded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars_listings`
--

INSERT INTO `cars_listings` (`id`, `owner_id`, `vin`, `carcondition`, `make_id`, `model_id`, `bodystyle_id`, `owner_price`, `website_price`, `year`, `varient`, `transmission`, `fuel_type`, `max_power`, `color`, `engine`, `mileage`, `boot_space`, `ground_clearance`, `cylinders`, `max_torque`, `seating_capacity`, `airbags`, `details`, `features`, `status`, `dateadded`) VALUES
(1, 1, '1HGBH41JXMN109186', 'USED', 29, 1, 8, '15000', '18500', 2020, 'LE', 'Automatic', 'Gasoline', '203 HP', 'Silver', '2.5L', '45000', '15.1 cu ft', '5.9 inches', '4', '184 lb-ft', '5', '8', 'This 2020 Toyota Camry LE is in excellent condition with low mileage. Perfect for daily commuting with great fuel economy and reliability.', 'Bluetooth|Backup Camera|Cruise Control|Keyless Entry|Air Conditioning|Power Windows|Power Locks|USB Port|Navigation System', 'AVAILABLE', '2024-01-15'),
(2, 1, 'WAU2MAFC9EN093287', 'USED', 1, 2, 8, '25000', '29900', 2019, 'Premium Plus', 'Automatic', 'Gasoline', '252 HP', 'Black', '2.0L', '32000', '13.7 cu ft', '4.9 inches', '4', '273 lb-ft', '5', '10', 'Well-maintained 2019 Audi A4 Premium Plus with premium features and excellent performance. Single owner vehicle.', 'Leather Seats|Sunroof|Premium Audio|Heated Seats|Navigation|Blind Spot Monitor|Lane Assist|Adaptive Cruise Control|Parking Sensors', 'AVAILABLE', '2024-01-20'),
(3, 1, 'WBA5B1C5XED480087', 'USED', 5, 3, 8, '35000', '41900', 2021, 'xDrive', 'Automatic', 'Gasoline', '382 HP', 'White', '3.0L', '18000', '17.0 cu ft', '8.1 inches', '6', '369 lb-ft', '5', '8', '2021 BMW 3 Series xDrive in pristine condition. Low mileage with premium features and excellent handling.', 'All-Wheel Drive|Premium Package|M Sport Package|Heated Steering Wheel|Wireless Charging|Apple CarPlay|Android Auto|Premium Sound System', 'AVAILABLE', '2024-02-01'),
(4, 1, 'KMHDU46D48U429052', 'USED', 12, 4, 9, '22000', '26900', 2020, 'Limited', 'Automatic', 'Gasoline', '290 HP', 'Blue', '2.0L', '38000', '31.9 cu ft', '8.2 inches', '4', '310 lb-ft', '7', '8', '2020 Hyundai Santa Fe Limited with third-row seating. Perfect family SUV with advanced safety features.', 'Third Row Seating|Panoramic Sunroof|Premium Audio|Heated/Cooled Seats|Wireless Charging|Smart Cruise Control|Blind Spot Collision Avoidance|Rear Cross Traffic Alert', 'AVAILABLE', '2024-02-05'),
(5, 1, '1C6SRFET4LN227811', 'NEW', 13, 5, 9, '45000', '52900', 2024, 'Rubicon', 'Automatic', 'Gasoline', '285 HP', 'Red', '3.6L', '0', '31.7 cu ft', '10.8 inches', '6', '260 lb-ft', '5', '6', 'Brand new 2024 Jeep Wrangler Rubicon ready for adventure. Off-road capable with premium features.', '4WD|Locking Differentials|Rock Rails|Premium Audio|Navigation|Bluetooth|USB Ports|Heated Seats|Remote Start', 'AVAILABLE', '2024-02-10'),
(6, 1, '5FNYF5H39JB000233', 'USED', 7, 6, 1, '18000', '22900', 2019, 'EcoBoost', 'Automatic', 'Gasoline', '310 HP', 'Gray', '2.3L', '42000', '13.5 cu ft', '5.0 inches', '4', '350 lb-ft', '4', '6', '2019 Ford Mustang EcoBoost convertible in excellent condition. Perfect for weekend drives and summer cruising.', 'Convertible Top|Premium Audio|Navigation|Bluetooth|USB Ports|Cruise Control|Keyless Entry|Push Button Start|Backup Camera', 'AVAILABLE', '2024-02-15'),
(7, 1, 'JT4RN67P8G0005116', 'USED', 29, 7, 9, '28000', '33900', 2021, 'TRD Off-Road', 'Automatic', 'Gasoline', '278 HP', 'Black', '3.5L', '25000', '16.1 cu ft', '9.6 inches', '6', '265 lb-ft', '5', '8', '2021 Toyota Tacoma TRD Off-Road with excellent off-road capabilities. Perfect for work and play.', '4WD|Locking Rear Differential|Skid Plates|Premium Audio|Navigation|Bluetooth|USB Ports|Cruise Control|Backup Camera|Bed Liner', 'AVAILABLE', '2024-02-20'),
(8, 1, 'KMHEC4A42DA101851', 'USED', 12, 8, 8, '16000', '19900', 2018, 'SE', 'Automatic', 'Gasoline', '185 HP', 'Silver', '2.4L', '55000', '16.3 cu ft', '5.3 inches', '4', '178 lb-ft', '5', '6', '2018 Hyundai Sonata SE with great fuel economy and comfortable ride. Well-maintained single owner vehicle.', 'Bluetooth|Backup Camera|Cruise Control|Keyless Entry|Air Conditioning|Power Windows|Power Locks|USB Port|Heated Seats', 'AVAILABLE', '2024-02-25'),
(9, 1, 'SAJWA0FS8FPU86557', 'USED', 28, 9, 9, '24000', '28900', 2020, 'Outback', 'Automatic', 'Gasoline', '182 HP', 'Green', '2.5L', '35000', '32.5 cu ft', '8.7 inches', '4', '176 lb-ft', '5', '7', '2020 Subaru Outback with all-wheel drive and excellent safety ratings. Perfect for all weather conditions.', 'All-Wheel Drive|Eyesight Safety System|Premium Audio|Navigation|Bluetooth|USB Ports|Cruise Control|Keyless Entry|Backup Camera|Roof Rails', 'AVAILABLE', '2024-03-01'),
(10, 1, 'VABJHGHG', 'USED', 20, 10, 8, '42000', '49900', 2022, 'C-Class', 'Automatic', 'Gasoline', '255 HP', 'White', '2.0L', '15000', '12.6 cu ft', '4.7 inches', '4', '273 lb-ft', '5', '7', '2022 Mercedes-Benz C-Class in excellent condition with premium features and luxury amenities.', 'Premium Package|Leather Seats|Sunroof|Premium Audio|Navigation|Bluetooth|USB Ports|Cruise Control|Keyless Entry|Backup Camera|Heated Seats', 'AVAILABLE', '2024-03-05');

-- --------------------------------------------------------

--
-- Table structure for table `cars_make`
--

CREATE TABLE `cars_make` (
  `make_id` int(11) NOT NULL,
  `make` varchar(255) NOT NULL,
  `make_slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cars_make`
--

INSERT INTO `cars_make` (`make_id`, `make`, `make_slug`, `image`, `status`) VALUES
(1, 'Audi', 'audi', 'audi.webp', 'ACTIVE'),
(2, 'Chevrolet', 'chevrolet', 'images__1__imresizer__1_-removebg-preview.png', 'ACTIVE'),
(3, 'Cadillac', 'cadillac', 'png-clipart-cadillac-cts-v-car-general-motors-cadillac-catera-cars-logo-brands-emblem-logo.svg', 'ACTIVE'),
(4, 'Acura', 'acura', 'acura.svg', 'ACTIVE'),
(5, 'BMW', 'bmw', 'bmw.svg', 'ACTIVE'),
(6, 'Chrysler', 'chrysler', 'chrysler.svg', 'ACTIVE'),
(7, 'Ford', 'ford', 'ford.svg', 'ACTIVE'),
(8, 'Buick', 'buick', 'buick.svg', 'ACTIVE'),
(9, 'INFINITI', 'infiniti', 'images (1)_imresizer (1).jpg', 'ACTIVE'),
(10, 'GMC', 'gmc', 'GMC-Logo-PNG-Free-Fi..._imresizer.jpg', 'ACTIVE'),
(11, 'Honda', 'honda', 'images.png', 'ACTIVE'),
(12, 'Hyundai', 'hyundai', 'hyundai.svg', 'ACTIVE'),
(13, 'Jeep', 'jeep', 'jeep.svg', 'ACTIVE'),
(14, 'Genesis', 'genesis', 'genesis_motor-logo-b..._imresizer.jpg', 'ACTIVE'),
(15, 'Dodge', 'dodge', 'dodge.jpg', 'ACTIVE'),
(16, 'Jaguar', 'jaguar', 'jaguar.svg', 'ACTIVE'),
(17, 'Kia', 'kia', 'kia.svg', 'ACTIVE'),
(18, 'Land Rover', 'land-rover', 'land-rover-logo-png_..._imresizer.jpg', 'ACTIVE'),
(19, 'Lexus', 'lexus', 'lexus.svg', 'ACTIVE'),
(20, 'Mercedes-Benz', 'mercedes-benz', 'images (5)_imresizer.jpg', 'ACTIVE'),
(21, 'Mitsubishi', 'mitsubishi', 'mitsubishi.webp', 'ACTIVE'),
(22, 'Lincoln', 'lincoln', 'images__3__imresizer-removebg-preview.png', 'ACTIVE'),
(23, 'MAZDA', 'mazda', 'mazda-logo-png_seekl..._imresizer.jpg', 'ACTIVE'),
(24, 'Nissan', 'nissan', 'png-transparent-niss..._imresizer-removebg-preview.png', 'ACTIVE'),
(25, 'MINI', 'mini', 'mini.svg', 'ACTIVE'),
(26, 'Porsche', 'porsche', 'porsche.jpg', 'ACTIVE'),
(27, 'Ram', 'ram', 'Ramchryslerlogo_imresizer-removebg-preview.png', 'ACTIVE'),
(28, 'Subaru', 'subaru', 'subaru.png', 'ACTIVE'),
(29, 'Toyota', 'toyota', 'toyota.webp', 'ACTIVE'),
(30, 'Volkswagen', 'volkswagen', 'volkswagen.png', 'ACTIVE'),
(31, 'Volvo', 'volvo', 'images__4__imresizer-removebg-preview.png', 'ACTIVE'),
(32, 'Alfa Romeo', 'alfa-romeo', 'alfaromeo.svg', 'ACTIVE'),
(33, 'FIAT', 'fiat', 'images (6)_imresizer (1).jpg', 'ACTIVE'),
(34, 'Freightliner', 'freightliner', 'freightliner-trucks-..._imresizer.jpg', 'ACTIVE'),
(35, 'Maserati', 'maserati', 'maserati-logo-vector..._imresizer-removebg-preview.png', 'ACTIVE'),
(36, 'Tesla', 'tesla', 'images (4).png', 'ACTIVE'),
(37, 'Aston Martin', 'aston-martin', 'astonmartin_imresizer.svg', 'ACTIVE'),
(38, 'Bentley', 'bentley', 'bentleymotors.svg', 'ACTIVE'),
(39, 'Ferrari', 'ferrari', 'ferrari-logo-png_see..._imresizer.jpg', 'ACTIVE'),
(40, 'Lamborghini', 'lamborghini', 'images (2)_imresizer.jpg', 'ACTIVE'),
(41, 'Lotus', 'lotus', 'images (7)_imresizer.jpg', 'ACTIVE'),
(42, 'McLaren', 'mclaren', 'mclaren-logo-vector-..._imresizer-removebg-preview.png', 'ACTIVE'),
(43, 'Rolls-Royce', 'rolls-royce', 'png-clipart-rolls-ro..._imresizer-removebg-preview.png', 'ACTIVE'),
(44, 'smart', 'smart', 'smart-removebg-previ..._imresizer (1).jpg', 'ACTIVE'),
(45, 'Scion', 'scion', 'scion-logo-png_seekl..._imresizer.jpg', 'ACTIVE'),
(46, 'SRT', 'srt', 'images__5_-removebg-..._imresizer.jpg', 'ACTIVE'),
(47, 'Suzuki', 'suzuki', 'suzuki-logo_imresizer-removebg-preview.png', 'ACTIVE'),
(48, 'Fisker', 'fisker', 'fisker-logo_imresizer.jpg', 'ACTIVE'),
(49, 'Maybach', 'maybach', 'maybach-brand-logo-c..._imresizer.jpg', 'ACTIVE'),
(50, 'Mercury', 'mercury', '26cd3a3e42c2ba374e64..._imresizer.jpg', 'ACTIVE'),
(51, 'Saab', 'saab', 'saab-scania-logo-png..._imresizer-removebg-preview.png', 'ACTIVE'),
(52, 'HUMMER', 'hummer', 'Hummer_Logo_imresizer.jpg', 'ACTIVE'),
(53, 'Pontiac', 'pontiac', 'Pontiac_logo_and_wor..._imresizer.png', 'ACTIVE'),
(54, 'Saturn', 'saturn', 'saturn-logo-png_seek..._imresizer-removebg-preview.png', 'ACTIVE'),
(55, 'Isuzu', 'isuzu', 'isuzu-logo-png_seekl..._imresizer.jpg', 'ACTIVE'),
(56, 'Panoz', 'panoz', 'panoz_imresizer.png', 'ACTIVE'),
(57, 'Oldsmobile', 'oldsmobile', 'images__7__imresizer-removebg-preview.png', 'ACTIVE'),
(58, 'Daewoo', 'daewoo', 'car-daewoo-motors-da..._imresizer-removebg-preview.png', 'ACTIVE'),
(61, 'Geo', 'geo', 'b9ae2e21d7d0ea07f57a371ba6716054.jpg', 'ACTIVE'),
(62, 'Daihatsu', 'daihatsu', 'daihatsu-logo-png_se..._imresizer.jpg', 'ACTIVE'),
(63, 'Polestar', 'polestar', 'Polestar-logo_imresizer.png', 'ACTIVE'),
(64, 'Rivian', 'rivian', 'images__6__imresizer-removebg-preview.png', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `cars_model`
--

CREATE TABLE `cars_model` (
  `model_id` int(11) NOT NULL,
  `make_id` int(11) NOT NULL,
  `make_slug` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_slug` varchar(255) NOT NULL,
  `status` enum('ACTIVE','INACTIVE') NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cars_model`
--

INSERT INTO `cars_model` (`model_id`, `make_id`, `make_slug`, `model`, `model_slug`, `status`) VALUES
(1, 1, 'audi', 'Q3', 'q3', 'ACTIVE'),
(2, 2, 'chevrolet', 'Malibu', 'malibu', 'ACTIVE'),
(4, 2, 'chevrolet', 'Corvette', 'corvette', 'ACTIVE'),
(5, 4, 'acura', 'RLX', 'rlx', 'ACTIVE'),
(7, 5, 'bmw', '3 Series', '3-series', 'ACTIVE'),
(8, 6, 'chrysler', 'Pacifica', 'pacifica', 'ACTIVE'),
(9, 2, 'chevrolet', 'Colorado', 'colorado', 'ACTIVE'),
(10, 5, 'bmw', 'X3', 'x3', 'ACTIVE'),
(11, 4, 'acura', 'TLX', 'tlx', 'ACTIVE'),
(13, 5, 'bmw', '7 Series', '7-series', 'ACTIVE'),
(14, 7, 'ford', 'Fusion', 'fusion', 'ACTIVE'),
(15, 8, 'buick', 'Envision', 'envision', 'ACTIVE'),
(16, 1, 'audi', 'SQ5', 'sq5', 'ACTIVE'),
(17, 1, 'audi', 'R8', 'r8', 'ACTIVE'),
(18, 2, 'chevrolet', 'Traverse', 'traverse', 'ACTIVE'),
(19, 4, 'acura', 'MDX', 'mdx', 'ACTIVE'),
(20, 9, 'infiniti', 'QX80', 'qx80', 'ACTIVE'),
(21, 8, 'buick', 'Encore', 'encore', 'ACTIVE'),
(23, 11, 'honda', 'Insight', 'insight', 'ACTIVE'),
(24, 3, 'cadillac', 'XT6', 'xt6', 'ACTIVE'),
(25, 3, 'cadillac', 'XT5', 'xt5', 'ACTIVE'),
(26, 3, 'cadillac', 'XT4', 'xt4', 'ACTIVE'),
(27, 8, 'buick', 'Enclave', 'enclave', 'ACTIVE'),
(28, 1, 'audi', 'Q5', 'q5', 'ACTIVE'),
(29, 12, 'hyundai', 'Santa Fe', 'santa-fe', 'ACTIVE'),
(31, 7, 'ford', 'Escape', 'escape', 'ACTIVE'),
(32, 7, 'ford', 'Mustang', 'mustang', 'ACTIVE'),
(33, 12, 'hyundai', 'Sonata', 'sonata', 'ACTIVE'),
(34, 7, 'ford', 'Edge', 'edge', 'ACTIVE'),
(35, 2, 'chevrolet', 'Camaro', 'camaro', 'ACTIVE'),
(37, 2, 'chevrolet', 'Equinox', 'equinox', 'ACTIVE'),
(39, 0, 'jeep', 'Gladiator', 'gladiator', 'ACTIVE'),
(40, 5, 'bmw', 'X7', 'x7', 'ACTIVE'),
(42, 1, 'audi', 'A7', 'a7', 'ACTIVE'),
(43, 2, 'chevrolet', 'Blazer', 'blazer', 'ACTIVE'),
(45, 2, 'chevrolet', 'Suburban', 'suburban', 'ACTIVE'),
(46, 11, 'honda', 'Civic', 'civic', 'ACTIVE'),
(47, 0, 'jeep', 'Compass', 'compass', 'ACTIVE'),
(48, 3, 'cadillac', 'Escalade', 'escalade', 'ACTIVE'),
(49, 6, 'chrysler', 'Voyager', 'voyager', 'ACTIVE'),
(51, 10, 'gmc', 'Terrain', 'terrain', 'ACTIVE'),
(52, 2, 'chevrolet', 'Spark', 'spark', 'ACTIVE'),
(53, 10, 'gmc', 'Sierra 1500', 'sierra-1500', 'ACTIVE'),
(54, 12, 'hyundai', 'NEXO', 'nexo', 'ACTIVE'),
(55, 12, 'hyundai', 'Veloster', 'veloster', 'ACTIVE'),
(56, 2, 'chevrolet', 'Silverado 1500', 'silverado-1500', 'ACTIVE'),
(57, 14, 'genesis', 'G70', 'g70', 'ACTIVE'),
(58, 3, 'cadillac', 'CT5', 'ct5', 'ACTIVE'),
(59, 11, 'honda', 'Odyssey', 'odyssey', 'ACTIVE'),
(61, 4, 'acura', 'RDX', 'rdx', 'ACTIVE'),
(65, 12, 'hyundai', 'Kona', 'kona', 'ACTIVE'),
(66, 9, 'infiniti', 'QX50', 'qx50', 'ACTIVE'),
(67, 15, 'dodge', 'Durango', 'durango', 'ACTIVE'),
(68, 10, 'gmc', 'Yukon', 'yukon', 'ACTIVE'),
(69, 12, 'hyundai', 'Palisade', 'palisade', 'ACTIVE'),
(70, 11, 'honda', 'Ridgeline', 'ridgeline', 'ACTIVE'),
(71, 0, 'jeep', 'Cherokee', 'cherokee', 'ACTIVE'),
(72, 2, 'chevrolet', 'Bolt', 'bolt', 'ACTIVE'),
(73, 7, 'ford', 'Expedition', 'expedition', 'ACTIVE'),
(74, 12, 'hyundai', 'Elantra', 'elantra', 'ACTIVE'),
(75, 11, 'honda', 'Passport', 'passport', 'ACTIVE'),
(76, 15, 'dodge', 'Charger', 'charger', 'ACTIVE'),
(77, 11, 'honda', 'Accord', 'accord', 'ACTIVE'),
(78, 9, 'infiniti', 'QX60', 'qx60', 'ACTIVE'),
(79, 12, 'hyundai', 'Venue', 'venue', 'ACTIVE'),
(80, 11, 'honda', 'Pilot', 'pilot', 'ACTIVE'),
(82, 2, 'chevrolet', 'Tahoe', 'tahoe', 'ACTIVE'),
(83, 10, 'gmc', 'Acadia', 'acadia', 'ACTIVE'),
(84, 2, 'chevrolet', 'Impala', 'impala', 'ACTIVE'),
(85, 11, 'honda', 'CR-V', 'cr-v', 'ACTIVE'),
(86, 5, 'bmw', 'X5', 'x5', 'ACTIVE'),
(87, 9, 'infiniti', 'Q60', 'q60', 'ACTIVE'),
(89, 2, 'chevrolet', 'Trax', 'trax', 'ACTIVE'),
(91, 0, 'jaguar', 'E-PACE', 'e-pace', 'ACTIVE'),
(92, 12, 'hyundai', 'Tucson', 'tucson', 'ACTIVE'),
(93, 7, 'ford', 'Explorer', 'explorer', 'ACTIVE'),
(94, 11, 'honda', 'HR-V', 'hr-v', 'ACTIVE'),
(95, 0, 'jaguar', 'I-PACE', 'i-pace', 'ACTIVE'),
(96, 9, 'infiniti', 'Q50', 'q50', 'ACTIVE'),
(97, 14, 'genesis', 'G80', 'g80', 'ACTIVE'),
(98, 0, 'jaguar', 'F-PACE', 'f-pace', 'ACTIVE'),
(99, 0, 'jeep', 'Renegade', 'renegade', 'ACTIVE'),
(100, 12, 'hyundai', 'Accent', 'accent', 'ACTIVE'),
(101, 0, 'jaguar', 'F-TYPE', 'f-type', 'ACTIVE'),
(102, 0, 'jeep', 'Wrangler', 'wrangler', 'ACTIVE'),
(103, 0, 'kia', 'Sorento', 'sorento', 'ACTIVE'),
(104, 0, 'kia', 'Rio', 'rio', 'ACTIVE'),
(106, 0, 'kia', 'Sedona', 'sedona', 'ACTIVE'),
(107, 0, 'kia', 'Optima', 'optima', 'ACTIVE'),
(108, 0, 'kia', 'Sportage', 'sportage', 'ACTIVE'),
(112, 0, 'kia', 'Telluride', 'telluride', 'ACTIVE'),
(113, 0, 'kia', 'Forte', 'forte', 'ACTIVE'),
(115, 0, 'kia', 'Soul', 'soul', 'ACTIVE'),
(117, 0, 'land-rover', 'Range Rover', 'range-rover', 'ACTIVE'),
(118, 0, 'kia', 'Stinger', 'stinger', 'ACTIVE'),
(119, 0, 'land-rover', 'Discovery', 'discovery', 'ACTIVE'),
(121, 0, 'lexus', 'ES', 'es', 'ACTIVE'),
(122, 0, 'lexus', 'LC', 'lc', 'ACTIVE'),
(123, 0, 'lexus', 'LX', 'lx', 'ACTIVE'),
(124, 0, 'lexus', 'RC', 'rc', 'ACTIVE'),
(125, 0, 'lexus', 'GX', 'gx', 'ACTIVE'),
(126, 0, 'lexus', 'IS', 'is', 'ACTIVE'),
(127, 0, 'lexus', 'GS', 'gs', 'ACTIVE'),
(128, 0, 'lexus', 'LS', 'ls', 'ACTIVE'),
(129, 0, 'lexus', 'UX', 'ux', 'ACTIVE'),
(130, 0, 'mercedes-benz', 'GLS', 'gls', 'ACTIVE'),
(133, 0, 'lincoln', 'MKZ', 'mkz', 'ACTIVE'),
(134, 0, 'lincoln', 'Aviator', 'aviator', 'ACTIVE'),
(135, 0, 'lexus', 'NX', 'nx', 'ACTIVE'),
(136, 0, 'mazda', 'CX-30', 'cx-30', 'ACTIVE'),
(138, 0, 'mazda', 'MAZDA3', 'mazda3', 'ACTIVE'),
(140, 0, 'lincoln', 'Navigator', 'navigator', 'ACTIVE'),
(141, 0, 'nissan', 'Armada', 'armada', 'ACTIVE'),
(142, 0, 'mazda', 'CX-5', 'cx-5', 'ACTIVE'),
(143, 0, 'lincoln', 'Corsair', 'corsair', 'ACTIVE'),
(145, 0, 'mercedes-benz', 'G-Class', 'g-class', 'ACTIVE'),
(146, 0, 'lincoln', 'Nautilus', 'nautilus', 'ACTIVE'),
(147, 0, 'lexus', 'RX', 'rx', 'ACTIVE'),
(148, 0, 'nissan', 'Kicks', 'kicks', 'ACTIVE'),
(149, 0, 'nissan', 'Murano', 'murano', 'ACTIVE'),
(150, 0, 'mazda', 'MAZDA6', 'mazda6', 'ACTIVE'),
(151, 0, 'mercedes-benz', 'C-Class', 'c-class', 'ACTIVE'),
(154, 0, 'mazda', 'CX-9', 'cx-9', 'ACTIVE'),
(156, 0, 'mercedes-benz', 'E-Class', 'e-class', 'ACTIVE'),
(157, 0, 'mini', 'Countryman', 'countryman', 'ACTIVE'),
(158, 0, 'mercedes-benz', 'GLE', 'gle', 'ACTIVE'),
(159, 0, 'nissan', 'Maxima', 'maxima', 'ACTIVE'),
(160, 0, 'nissan', '370Z', '370z', 'ACTIVE'),
(161, 0, 'mercedes-benz', 'GLC', 'glc', 'ACTIVE'),
(162, 0, 'mitsubishi', 'Mirage', 'mirage', 'ACTIVE'),
(163, 0, 'nissan', 'Altima', 'altima', 'ACTIVE'),
(164, 0, 'nissan', 'GT-R', 'gt-r', 'ACTIVE'),
(165, 0, 'mitsubishi', 'Outlander', 'outlander', 'ACTIVE'),
(168, 0, 'porsche', 'Panamera', 'panamera', 'ACTIVE'),
(169, 0, 'porsche', 'Taycan', 'taycan', 'ACTIVE'),
(170, 0, 'nissan', 'Pathfinder', 'pathfinder', 'ACTIVE'),
(171, 0, 'nissan', 'Rogue', 'rogue', 'ACTIVE'),
(172, 0, 'nissan', 'NV200', 'nv200', 'ACTIVE'),
(173, 0, 'porsche', '911', '911', 'ACTIVE'),
(175, 0, 'porsche', 'Macan', 'macan', 'ACTIVE'),
(177, 0, 'porsche', 'Cayenne', 'cayenne', 'ACTIVE'),
(179, 0, 'ram', '3500 Crew Cab', '3500-crew-cab', 'ACTIVE'),
(180, 0, 'ram', '1500 Crew Cab', '1500-crew-cab', 'ACTIVE'),
(181, 0, 'subaru', 'BRZ', 'brz', 'ACTIVE'),
(182, 0, 'nissan', 'Versa', 'versa', 'ACTIVE'),
(183, 0, 'toyota', 'Avalon', 'avalon', 'ACTIVE'),
(184, 0, 'subaru', 'WRX', 'wrx', 'ACTIVE'),
(185, 0, 'toyota', 'Camry', 'camry', 'ACTIVE'),
(186, 0, 'subaru', 'Impreza', 'impreza', 'ACTIVE'),
(187, 0, 'subaru', 'Ascent', 'ascent', 'ACTIVE'),
(188, 0, 'subaru', 'Legacy', 'legacy', 'ACTIVE'),
(190, 0, 'subaru', 'Crosstrek', 'crosstrek', 'ACTIVE'),
(191, 0, 'toyota', 'Corolla', 'corolla', 'ACTIVE'),
(192, 0, 'toyota', '86', '86', 'ACTIVE'),
(193, 0, 'subaru', 'Forester', 'forester', 'ACTIVE'),
(195, 0, 'ram', '2500 Crew Cab', '2500-crew-cab', 'ACTIVE'),
(196, 0, 'toyota', '4Runner', '4runner', 'ACTIVE'),
(197, 0, 'subaru', 'Outback', 'outback', 'ACTIVE'),
(198, 0, 'toyota', 'C-HR', 'chr', 'ACTIVE'),
(201, 0, 'toyota', 'GR Supra', 'gr-supra', 'ACTIVE'),
(202, 0, 'toyota', 'Highlander', 'highlander', 'ACTIVE'),
(203, 0, 'toyota', 'Prius', 'prius', 'ACTIVE'),
(205, 0, 'toyota', 'RAV4', 'rav4', 'ACTIVE'),
(207, 0, 'toyota', 'Sienna', 'sienna', 'ACTIVE'),
(208, 0, 'toyota', 'Land Cruiser', 'land-cruiser', 'ACTIVE'),
(209, 0, 'toyota', 'Yaris', 'yaris', 'ACTIVE'),
(212, 0, 'toyota', 'Sequoia', 'sequoia', 'ACTIVE'),
(216, 0, 'volkswagen', 'Passat', 'passat', 'ACTIVE'),
(220, 1, 'audi', 'A6', 'a6', 'ACTIVE'),
(221, 0, 'volvo', 'XC40', 'xc40', 'ACTIVE'),
(222, 1, 'audi', 'A4', 'a4', 'ACTIVE'),
(223, 1, 'audi', 'Q7', 'q7', 'ACTIVE'),
(224, 1, 'audi', 'Q8', 'q8', 'ACTIVE'),
(225, 1, 'audi', 'RS 5', 'rs-5', 'ACTIVE'),
(226, 4, 'acura', 'NSX', 'nsx', 'ACTIVE'),
(228, 0, 'volvo', 'XC60', 'xc60', 'ACTIVE'),
(229, 0, 'volkswagen', 'Tiguan', 'tiguan', 'ACTIVE'),
(230, 0, 'volvo', 'XC90', 'xc90', 'ACTIVE'),
(231, 1, 'audi', 'A8', 'a8', 'ACTIVE'),
(232, 5, 'bmw', '4 Series', '4-series', 'ACTIVE'),
(233, 4, 'acura', 'ILX', 'ilx', 'ACTIVE'),
(234, 5, 'bmw', '2 Series', '2-series', 'ACTIVE'),
(235, 1, 'audi', 'A3', 'a3', 'ACTIVE'),
(236, 1, 'audi', 'S5', 's5', 'ACTIVE'),
(238, 1, 'audi', 'e-tron', 'e-tron', 'ACTIVE'),
(239, 0, 'volkswagen', 'Jetta', 'jetta', 'ACTIVE'),
(240, 1, 'audi', 'RS 3', 'rs-3', 'ACTIVE'),
(241, 32, 'alfa-romeo', 'Stelvio', 'stelvio', 'ACTIVE'),
(242, 32, 'alfa-romeo', 'Giulia', 'giulia', 'ACTIVE'),
(243, 1, 'audi', 'A5', 'a5', 'ACTIVE'),
(244, 1, 'audi', 'S3', 's3', 'ACTIVE'),
(245, 1, 'audi', 'S4', 's4', 'ACTIVE'),
(246, 5, 'bmw', '5 Series', '5-series', 'ACTIVE'),
(247, 5, 'bmw', 'M5', 'm5', 'ACTIVE'),
(248, 5, 'bmw', 'i8', 'i8', 'ACTIVE'),
(249, 5, 'bmw', '8 Series', '8-series', 'ACTIVE'),
(250, 5, 'bmw', 'M6', 'm6', 'ACTIVE'),
(251, 5, 'bmw', 'i3', 'i3', 'ACTIVE'),
(252, 5, 'bmw', '6 Series', '6-series', 'ACTIVE'),
(253, 5, 'bmw', 'M4', 'm4', 'ACTIVE'),
(254, 1, 'audi', 'TT', 'tt', 'ACTIVE'),
(257, 5, 'bmw', 'X2', 'x2', 'ACTIVE'),
(259, 5, 'bmw', 'X1', 'x1', 'ACTIVE'),
(260, 5, 'bmw', 'X6', 'x6', 'ACTIVE'),
(261, 5, 'bmw', 'X4', 'x4', 'ACTIVE'),
(262, 3, 'cadillac', 'CT6', 'ct6', 'ACTIVE'),
(264, 5, 'bmw', 'M2', 'm2', 'ACTIVE'),
(265, 8, 'buick', 'Cascada', 'cascada', 'ACTIVE'),
(266, 3, 'cadillac', 'CTS', 'cts', 'ACTIVE'),
(267, 2, 'chevrolet', 'Cruze', 'cruze', 'ACTIVE'),
(268, 5, 'bmw', 'Z4', 'z4', 'ACTIVE'),
(269, 3, 'cadillac', 'XTS', 'xts', 'ACTIVE'),
(270, 8, 'buick', 'LaCrosse', 'lacrosse', 'ACTIVE'),
(272, 3, 'cadillac', 'ATS', 'ats', 'ACTIVE'),
(283, 2, 'chevrolet', 'Sonic', 'sonic', 'ACTIVE'),
(285, 15, 'dodge', 'Challenger', 'challenger', 'ACTIVE'),
(286, 33, 'fiat', '500L', '500l', 'ACTIVE'),
(287, 2, 'chevrolet', 'Volt', 'volt', 'ACTIVE'),
(288, 33, 'fiat', '500e', '500e', 'ACTIVE'),
(289, 33, 'fiat', '500', '500', 'ACTIVE'),
(290, 15, 'dodge', 'Journey', 'journey', 'ACTIVE'),
(294, 6, 'chrysler', '300', '300', 'ACTIVE'),
(295, 33, 'fiat', '500c', '500c', 'ACTIVE'),
(296, 33, 'fiat', '500 Abarth', '500-abarth', 'ACTIVE'),
(297, 33, 'fiat', '124 Spider', '124-spider', 'ACTIVE'),
(299, 33, 'fiat', '500X', '500x', 'ACTIVE'),
(300, 33, 'fiat', '500c Abarth', '500c-abarth', 'ACTIVE'),
(302, 7, 'ford', 'F450', 'f450', 'ACTIVE'),
(304, 7, 'ford', 'Fiesta', 'fiesta', 'ACTIVE'),
(307, 7, 'ford', 'Flex', 'flex', 'ACTIVE'),
(308, 7, 'ford', 'Transit 150', 'transit-150', 'ACTIVE'),
(309, 10, 'gmc', 'Canyon', 'canyon', 'ACTIVE'),
(310, 14, 'genesis', 'G90', 'g90', 'ACTIVE'),
(312, 7, 'ford', 'Transit Connect', 'transit-connect', 'ACTIVE'),
(317, 7, 'ford', 'Transit 250', 'transit-250', 'ACTIVE'),
(321, 7, 'ford', 'Taurus', 'taurus', 'ACTIVE'),
(323, 11, 'honda', 'Clarity', 'clarity', 'ACTIVE'),
(331, 11, 'honda', 'Fit', 'fit', 'ACTIVE'),
(332, 12, 'hyundai', 'Ioniq', 'ioniq', 'ACTIVE'),
(336, 9, 'infiniti', 'Q70', 'q70', 'ACTIVE'),
(337, 9, 'infiniti', 'QX30', 'qx30', 'ACTIVE'),
(338, 0, 'jaguar', 'XE', 'xe', 'ACTIVE'),
(339, 0, 'kia', 'Niro', 'niro', 'ACTIVE'),
(340, 0, 'jaguar', 'XF', 'xf', 'ACTIVE'),
(341, 0, 'jaguar', 'XJ', 'xj', 'ACTIVE'),
(343, 0, 'kia', 'Cadenza', 'cadenza', 'ACTIVE'),
(344, 0, 'kia', 'K900', 'k900', 'ACTIVE'),
(347, 0, 'maserati', 'Levante', 'levante', 'ACTIVE'),
(349, 0, 'mazda', 'MX-5', 'mx-5', 'ACTIVE'),
(350, 0, 'lincoln', 'Continental', 'continental', 'ACTIVE'),
(351, 0, 'lincoln', 'MKT', 'mkt', 'ACTIVE'),
(352, 0, 'mazda', 'CX-3', 'cx-3', 'ACTIVE'),
(353, 0, 'lincoln', 'MKC', 'mkc', 'ACTIVE'),
(354, 0, 'mercedes-benz', 'A-Class', 'a-class', 'ACTIVE'),
(355, 0, 'maserati', 'Ghibli', 'ghibli', 'ACTIVE'),
(356, 0, 'mercedes-benz', 'AMG', 'amg', 'ACTIVE'),
(373, 0, 'mercedes-benz', 'Sprinter 2500', 'sprinter-2500', 'ACTIVE'),
(374, 0, 'mini', 'Convertible', 'convertible', 'ACTIVE'),
(376, 0, 'mercedes-benz', 'Metris', 'metris', 'ACTIVE'),
(383, 0, 'mini', 'Clubman', 'clubman', 'ACTIVE'),
(387, 0, 'porsche', '718 Boxster', '718-boxster', 'ACTIVE'),
(389, 0, 'nissan', 'Frontier', 'frontier', 'ACTIVE'),
(390, 0, 'nissan', 'LEAF', 'leaf', 'ACTIVE'),
(391, 0, 'nissan', 'Sentra', 'sentra', 'ACTIVE'),
(394, 0, 'nissan', 'Titan', 'titan', 'ACTIVE'),
(397, 0, 'ram', '2500 Mega Cab', '2500-mega-cab', 'ACTIVE'),
(399, 0, 'ram', '1500 Classic Quad Cab', '1500-classic-quad-cab', 'ACTIVE'),
(400, 0, 'ram', '1500 Classic Crew Cab', '1500-classic-crew-cab', 'ACTIVE'),
(401, 0, 'ram', '1500 Classic Regular Cab', '1500-classic-regular-cab', 'ACTIVE'),
(403, 0, 'ram', '1500 Quad Cab', '1500-quad-cab', 'ACTIVE'),
(404, 0, 'ram', '2500 Regular Cab', '2500-regular-cab', 'ACTIVE'),
(405, 0, 'ram', '3500 Mega Cab', '3500-mega-cab', 'ACTIVE'),
(406, 0, 'ram', 'ProMaster City', 'promaster-city', 'ACTIVE'),
(409, 0, 'tesla', 'Model X', 'model-x', 'ACTIVE'),
(410, 0, 'tesla', 'Model 3', 'model-3', 'ACTIVE'),
(411, 0, 'ram', '3500 Regular Cab', '3500-regular-cab', 'ACTIVE'),
(412, 0, 'tesla', 'Model S', 'model-s', 'ACTIVE'),
(413, 0, 'toyota', 'Mirai', 'mirai', 'ACTIVE'),
(414, 0, 'volkswagen', 'Atlas', 'atlas', 'ACTIVE'),
(417, 0, 'volkswagen', 'Arteon', 'arteon', 'ACTIVE'),
(418, 0, 'volkswagen', 'e-Golf', 'e-golf', 'ACTIVE'),
(419, 0, 'volkswagen', 'Golf', 'golf', 'ACTIVE'),
(422, 0, 'volkswagen', 'Beetle', 'beetle', 'ACTIVE'),
(424, 0, 'volvo', 'S60', 's60', 'ACTIVE'),
(426, 0, 'volvo', 'V60', 'v60', 'ACTIVE'),
(427, 0, 'volvo', 'V90', 'v90', 'ACTIVE'),
(428, 0, 'volvo', 'S90', 's90', 'ACTIVE'),
(430, 32, 'alfa-romeo', '4C', '4c', 'ACTIVE'),
(431, 37, 'aston-martin', 'DB11', 'db11', 'ACTIVE'),
(433, 1, 'audi', 'S7', 's7', 'ACTIVE'),
(434, 1, 'audi', 'S6', 's6', 'ACTIVE'),
(435, 1, 'audi', 'S8', 's8', 'ACTIVE'),
(436, 1, 'audi', 'RS 7', 'rs-7', 'ACTIVE'),
(437, 38, 'bentley', 'Bentayga', 'bentayga', 'ACTIVE'),
(438, 38, 'bentley', 'Flying Spur', 'flying-spur', 'ACTIVE'),
(439, 5, 'bmw', 'M3', 'm3', 'ACTIVE'),
(440, 38, 'bentley', 'Continental', 'continental', 'ACTIVE'),
(441, 38, 'bentley', 'Mulsanne', 'mulsanne', 'ACTIVE'),
(443, 2, 'chevrolet', 'Express', 'express', 'ACTIVE'),
(446, 39, 'ferrari', 'GTC4Lusso', 'gtc4lusso', 'ACTIVE'),
(447, 39, 'ferrari', '488 GTB', '488-gtb', 'ACTIVE'),
(448, 39, 'ferrari', '812 Superfast', '812-superfast', 'ACTIVE'),
(449, 39, 'ferrari', 'Portofino', 'portofino', 'ACTIVE'),
(450, 39, 'ferrari', '488 Spider', '488-spider', 'ACTIVE'),
(453, 7, 'ford', 'Focus', 'focus', 'ACTIVE'),
(454, 7, 'ford', 'Transit 350', 'transit-350', 'ACTIVE'),
(462, 10, 'gmc', 'Savana 3500', 'savana-3500', 'ACTIVE'),
(463, 10, 'gmc', 'Savana 2500', 'savana-2500', 'ACTIVE'),
(468, 0, 'lamborghini', 'Huracan', 'huracan', 'ACTIVE'),
(469, 0, 'lamborghini', 'Aventador', 'aventador', 'ACTIVE'),
(470, 0, 'maserati', 'Quattroporte', 'quattroporte', 'ACTIVE'),
(471, 0, 'lincoln', 'MKX', 'mkx', 'ACTIVE'),
(472, 0, 'lotus', 'Evora 400', 'evora-400', 'ACTIVE'),
(473, 0, 'mclaren', '570GT', '570gt', 'ACTIVE'),
(474, 0, 'maserati', 'GranTurismo', 'granturismo', 'ACTIVE'),
(475, 0, 'mclaren', '720S', '720s', 'ACTIVE'),
(476, 0, 'mclaren', '570S', '570s', 'ACTIVE'),
(482, 0, 'mercedes-benz', 'Sprinter WORKER', 'sprinter-worker', 'ACTIVE'),
(483, 0, 'mercedes-benz', 'Sprinter 3500', 'sprinter-3500', 'ACTIVE'),
(484, 0, 'rolls-royce', 'Ghost', 'ghost', 'ACTIVE'),
(485, 0, 'ram', '1500 Regular Cab', '1500-regular-cab', 'ACTIVE'),
(487, 0, 'rolls-royce', 'Wraith', 'wraith', 'ACTIVE'),
(488, 0, 'rolls-royce', 'Dawn', 'dawn', 'ACTIVE'),
(490, 0, 'rolls-royce', 'Phantom', 'phantom', 'ACTIVE'),
(495, 37, 'aston-martin', 'Vanquish', 'vanquish', 'ACTIVE'),
(496, 37, 'aston-martin', 'Vantage', 'vantage', 'ACTIVE'),
(498, 8, 'buick', 'Regal', 'regal', 'ACTIVE'),
(499, 8, 'buick', 'Verano', 'verano', 'ACTIVE'),
(500, 6, 'chrysler', '200', '200', 'ACTIVE'),
(502, 39, 'ferrari', 'F12berlinetta', 'f12berlinetta', 'ACTIVE'),
(503, 39, 'ferrari', 'California', 'california', 'ACTIVE'),
(504, 15, 'dodge', 'Viper', 'viper', 'ACTIVE'),
(505, 7, 'ford', 'C-MAX', 'c-max', 'ACTIVE'),
(509, 12, 'hyundai', 'Azera', 'azera', 'ACTIVE'),
(510, 9, 'infiniti', 'QX70', 'qx70', 'ACTIVE'),
(512, 0, 'jeep', 'Patriot', 'patriot', 'ACTIVE'),
(513, 0, 'lexus', 'CT', 'ct', 'ACTIVE'),
(514, 0, 'mercedes-benz', 'B-Class', 'b-class', 'ACTIVE'),
(516, 0, 'mitsubishi', 'Lancer', 'lancer', 'ACTIVE'),
(517, 0, 'mitsubishi', 'i-MiEV', 'i-miev', 'ACTIVE'),
(518, 0, 'nissan', 'Quest', 'quest', 'ACTIVE'),
(519, 0, 'nissan', 'JUKE', 'juke', 'ACTIVE'),
(521, 0, 'smart', 'fortwo', 'fortwo', 'ACTIVE'),
(524, 0, 'volkswagen', 'CC', 'cc', 'ACTIVE'),
(525, 0, 'volkswagen', 'Touareg', 'touareg', 'ACTIVE'),
(527, 1, 'audi', 'allroad', 'allroad', 'ACTIVE'),
(528, 3, 'cadillac', 'ELR', 'elr', 'ACTIVE'),
(529, 3, 'cadillac', 'SRX', 'srx', 'ACTIVE'),
(533, 15, 'dodge', 'Dart', 'dart', 'ACTIVE'),
(536, 39, 'ferrari', 'FF', 'ff', 'ACTIVE'),
(537, 11, 'honda', 'CR-Z', 'cr-z', 'ACTIVE'),
(538, 12, 'hyundai', 'Genesis', 'genesis', 'ACTIVE'),
(540, 12, 'hyundai', 'Equus', 'equus', 'ACTIVE'),
(542, 0, 'land-rover', 'LR4', 'lr4', 'ACTIVE'),
(543, 0, 'mclaren', '650S', '650s', 'ACTIVE'),
(544, 0, 'lincoln', 'MKS', 'mks', 'ACTIVE'),
(545, 0, 'mclaren', '675LT', '675lt', 'ACTIVE'),
(546, 0, 'mercedes-benz', 'CLS-Class', 'cls-class', 'ACTIVE'),
(547, 0, 'mercedes-benz', 'GL-Class', 'gl-class', 'ACTIVE'),
(549, 0, 'mercedes-benz', 'Maybach', 'maybach', 'ACTIVE'),
(552, 0, 'mini', 'Paceman', 'paceman', 'ACTIVE'),
(553, 0, 'porsche', 'Cayman', 'cayman', 'ACTIVE'),
(554, 0, 'porsche', 'Boxster', 'boxster', 'ACTIVE'),
(555, 0, 'scion', 'iA', 'ia', 'ACTIVE'),
(556, 0, 'scion', 'tC', 'tc', 'ACTIVE'),
(557, 0, 'scion', 'iM', 'im', 'ACTIVE'),
(558, 0, 'scion', 'FR-S', 'fr-s', 'ACTIVE'),
(559, 0, 'volkswagen', 'Eos', 'eos', 'ACTIVE'),
(560, 37, 'aston-martin', 'DB9', 'db9', 'ACTIVE'),
(561, 0, 'volvo', 'S80', 's80', 'ACTIVE'),
(562, 0, 'volvo', 'XC70', 'xc70', 'ACTIVE'),
(563, 2, 'chevrolet', 'Captiva', 'captiva', 'ACTIVE'),
(564, 39, 'ferrari', '458 Italia', '458-italia', 'ACTIVE'),
(565, 39, 'ferrari', '458 Speciale', '458-speciale', 'ACTIVE'),
(566, 39, 'ferrari', '458 Spider', '458-spider', 'ACTIVE'),
(567, 7, 'ford', 'Focus ST', 'focus-st', 'ACTIVE'),
(568, 11, 'honda', 'Crosstour', 'crosstour', 'ACTIVE'),
(569, 9, 'infiniti', 'Q40', 'q40', 'ACTIVE'),
(570, 0, 'jaguar', 'XK', 'xk', 'ACTIVE'),
(571, 0, 'land-rover', 'LR2', 'lr2', 'ACTIVE'),
(572, 0, 'mercedes-benz', 'M-Class', 'm-class', 'ACTIVE'),
(573, 0, 'mercedes-benz', 'CLA-Class', 'cla-class', 'ACTIVE'),
(574, 0, 'mazda', 'MAZDA5', 'mazda5', 'ACTIVE'),
(575, 0, 'mercedes-benz', 'GLK-Class', 'glk', 'ACTIVE'),
(576, 0, 'mercedes-benz', 'GLA-Class', 'gla-class', 'ACTIVE'),
(577, 0, 'mercedes-benz', 'SLS-Class', 'sls-class', 'ACTIVE'),
(578, 0, 'mercedes-benz', 'SL-Class', 'slc-class', 'ACTIVE'),
(579, 0, 'mercedes-benz', 'SLK-Class', 'slk-class', 'ACTIVE'),
(580, 0, 'mini', 'Coupe', 'coupe', 'ACTIVE'),
(581, 0, 'mini', 'Roadster', 'roadster', 'ACTIVE'),
(584, 0, 'nissan', 'Xterra', 'xterra', 'ACTIVE'),
(585, 0, 'scion', 'iQ', 'iq', 'ACTIVE'),
(586, 0, 'subaru', 'XV Crosstrek', 'xv-crosstrek', 'ACTIVE'),
(588, 0, 'scion', 'xB', 'xb', 'ACTIVE'),
(590, 0, 'toyota', 'Venza', 'venza', 'ACTIVE'),
(591, 4, 'acura', 'TSX', 'tsx', 'ACTIVE'),
(592, 4, 'acura', 'TL', 'tl', 'ACTIVE'),
(596, 15, 'dodge', 'Avenger', 'avenger', 'ACTIVE'),
(597, 7, 'ford', 'E350', 'e350', 'ACTIVE'),
(599, 7, 'ford', 'E150', 'e150', 'ACTIVE'),
(600, 7, 'ford', 'E250', 'e250', 'ACTIVE'),
(602, 10, 'gmc', 'Savana 1500', 'savana-1500', 'ACTIVE'),
(605, 0, 'lamborghini', 'Gallardo', 'gallardo', 'ACTIVE'),
(606, 0, 'mazda', 'MAZDA2', 'mazda2', 'ACTIVE'),
(607, 0, 'lotus', 'Evora', 'evora', 'ACTIVE'),
(608, 0, 'mclaren', 'MP4-12C', 'mp4-12c', 'ACTIVE'),
(609, 0, 'mercedes-benz', 'CL-Class', 'cl-class', 'ACTIVE'),
(610, 0, 'nissan', 'cube', 'cube', 'ACTIVE'),
(611, 0, 'mini', 'Hardtop', 'hardtop', 'ACTIVE'),
(612, 0, 'subaru', 'Tribeca', 'tribeca', 'ACTIVE'),
(613, 0, 'ram', 'ProMaster 3500', 'promaster-3500', 'ACTIVE'),
(614, 0, 'ram', 'ProMaster 2500', 'promaster-2500', 'ACTIVE'),
(615, 0, 'scion', 'xD', 'xd', 'ACTIVE'),
(616, 0, 'ram', 'ProMaster 1500', 'promaster-1500', 'ACTIVE'),
(617, 0, 'srt', 'Viper', 'viper', 'ACTIVE'),
(618, 0, 'toyota', 'FJ Cruiser', 'fj-cruiser', 'ACTIVE'),
(620, 0, 'volkswagen', 'GTI', 'gti', 'ACTIVE'),
(621, 0, 'volkswagen', 'Routan', 'routan', 'ACTIVE'),
(623, 4, 'acura', 'ZDX', 'zdx', 'ACTIVE'),
(624, 5, 'bmw', '1 Series', '1-series', 'ACTIVE'),
(626, 2, 'chevrolet', 'Avalanche', 'avalanche', 'ACTIVE'),
(635, 9, 'infiniti', 'EX', 'ex', 'ACTIVE'),
(637, 9, 'infiniti', 'G', 'g', 'ACTIVE'),
(638, 9, 'infiniti', 'JX', 'jx', 'ACTIVE'),
(639, 9, 'infiniti', 'FX', 'fx', 'ACTIVE'),
(640, 9, 'infiniti', 'M', 'm', 'ACTIVE'),
(641, 0, 'suzuki', 'SX4', 'sx4', 'ACTIVE'),
(642, 0, 'suzuki', 'Kizashi', 'kizashi', 'ACTIVE'),
(643, 0, 'suzuki', 'Grand Vitara', 'grand-vitara', 'ACTIVE'),
(644, 0, 'toyota', 'Matrix', 'matrix', 'ACTIVE'),
(645, 0, 'volvo', 'C30', 'c30', 'ACTIVE'),
(646, 0, 'volvo', 'C70', 'c70', 'ACTIVE'),
(647, 4, 'acura', 'RL', 'rl', 'ACTIVE'),
(648, 37, 'aston-martin', 'Rapide', 'rapide', 'ACTIVE'),
(649, 37, 'aston-martin', 'DBS', 'dbs', 'ACTIVE'),
(650, 37, 'aston-martin', 'Virage', 'virage', 'ACTIVE'),
(652, 15, 'dodge', 'Caliber', 'caliber', 'ACTIVE'),
(653, 48, 'fisker', 'Karma', 'karma', 'ACTIVE'),
(655, 12, 'hyundai', 'Veracruz', 'veracruz', 'ACTIVE'),
(656, 0, 'jeep', 'Liberty', 'liberty', 'ACTIVE'),
(657, 0, 'lexus', 'HS', 'hs', 'ACTIVE'),
(658, 0, 'lexus', 'LFA', 'lfa', 'ACTIVE'),
(659, 0, 'maybach', '62', '62', 'ACTIVE'),
(660, 0, 'mazda', 'CX-7', 'cx-7', 'ACTIVE'),
(661, 0, 'maybach', '57', '57', 'ACTIVE'),
(662, 0, 'mercedes-benz', 'R-Class', 'r-class', 'ACTIVE'),
(663, 0, 'mitsubishi', 'Eclipse', 'eclipse', 'ACTIVE'),
(664, 0, 'mitsubishi', 'Galant', 'galant', 'ACTIVE'),
(665, 0, 'ram', 'C/V', 'c-v', 'ACTIVE'),
(667, 0, 'suzuki', 'Equator', 'equator', 'ACTIVE'),
(668, 3, 'cadillac', 'DTS', 'dts', 'ACTIVE'),
(669, 8, 'buick', 'Lucerne', 'lucerne', 'ACTIVE'),
(670, 2, 'chevrolet', 'Aveo', 'aveo', 'ACTIVE'),
(671, 2, 'chevrolet', 'HHR', 'hhr', 'ACTIVE'),
(672, 3, 'cadillac', 'STS', 'sts', 'ACTIVE'),
(673, 39, 'ferrari', '599 GTB Fiorano', '599-gtb-fiorano', 'ACTIVE'),
(675, 39, 'ferrari', '599 GTO', '599-gto', 'ACTIVE'),
(676, 39, 'ferrari', '612 Scaglietti', '612-scaglietti', 'ACTIVE'),
(677, 15, 'dodge', 'Nitro', 'nitro', 'ACTIVE'),
(678, 7, 'ford', 'Crown Victoria', 'crown-victoria', 'ACTIVE'),
(680, 7, 'ford', 'Ranger', 'ranger', 'ACTIVE'),
(682, 11, 'honda', 'Element', 'element', 'ACTIVE'),
(683, 0, 'lotus', 'Elise', 'elise', 'ACTIVE'),
(684, 0, 'lexus', 'IS F', 'is-f', 'ACTIVE'),
(685, 0, 'lincoln', 'Town Car', 'town-car', 'ACTIVE'),
(686, 0, 'lotus', 'Exige', 'exige', 'ACTIVE'),
(687, 0, 'mazda', 'RX-8', 'rx-8', 'ACTIVE'),
(688, 0, 'mazda', 'Tribute', 'tribute', 'ACTIVE'),
(689, 0, 'mercury', 'Milan', 'milan', 'ACTIVE'),
(690, 0, 'mercury', 'Mariner', 'mariner', 'ACTIVE'),
(691, 0, 'mercury', 'Grand Marquis', 'grand-marquis', 'ACTIVE'),
(692, 0, 'mitsubishi', 'Endeavor', 'endeavor', 'ACTIVE'),
(693, 0, 'saab', '9-4X', '9-4x', 'ACTIVE'),
(694, 0, 'saab', '3-Sep', '3-sep', 'ACTIVE'),
(697, 0, 'saab', '5-Sep', '5-sep', 'ACTIVE'),
(698, 0, 'volvo', 'V50', 'v50', 'ACTIVE'),
(699, 0, 'volvo', 'S40', 's40', 'ACTIVE'),
(701, 38, 'bentley', 'Brooklands', 'brooklands', 'ACTIVE'),
(702, 2, 'chevrolet', 'Cobalt', 'cobalt', 'ACTIVE'),
(704, 6, 'chrysler', 'PT Cruiser', 'pt-cruiser', 'ACTIVE'),
(705, 6, 'chrysler', 'Sebring', 'sebring', 'ACTIVE'),
(711, 15, 'dodge', 'Ram 1500', 'ram-1500', 'ACTIVE'),
(718, 52, 'hummer', 'H3T', 'h3t', 'ACTIVE'),
(719, 52, 'hummer', 'H3', 'h3', 'ACTIVE'),
(720, 0, 'kia', 'Rondo', 'rondo', 'ACTIVE'),
(721, 0, 'jeep', 'Commander', 'commander', 'ACTIVE'),
(722, 0, 'lamborghini', 'Murcielago', 'murcielago', 'ACTIVE'),
(723, 0, 'lexus', 'SC', 'sc', 'ACTIVE'),
(724, 0, 'mercury', 'Mountaineer', 'mountaineer', 'ACTIVE'),
(725, 0, 'pontiac', 'Vibe', 'vibe', 'ACTIVE'),
(726, 0, 'pontiac', 'G6', 'g6', 'ACTIVE'),
(727, 0, 'pontiac', 'G3', 'g3', 'ACTIVE'),
(728, 0, 'saturn', 'VUE', 'vue', 'ACTIVE'),
(729, 0, 'saturn', 'Outlook', 'outlook', 'ACTIVE'),
(731, 0, 'volvo', 'V70', 'v70', 'ACTIVE'),
(732, 38, 'bentley', 'Arnage', 'arnage', 'ACTIVE'),
(733, 38, 'bentley', 'Azure', 'azure', 'ACTIVE'),
(734, 3, 'cadillac', 'XLR', 'xlr', 'ACTIVE'),
(735, 2, 'chevrolet', 'TrailBlazer', 'trailblazer', 'ACTIVE'),
(737, 6, 'chrysler', 'Aspen', 'aspen', 'ACTIVE'),
(738, 39, 'ferrari', '430 Scuderia', '430-scuderia', 'ACTIVE'),
(740, 15, 'dodge', 'Sprinter 2500', 'sprinter-2500', 'ACTIVE'),
(741, 39, 'ferrari', 'F430', 'f430', 'ACTIVE'),
(743, 10, 'gmc', 'Envoy', 'envoy', 'ACTIVE'),
(744, 11, 'honda', 'S2000', 's2000', 'ACTIVE'),
(745, 52, 'hummer', 'H2', 'h2', 'ACTIVE'),
(746, 0, 'kia', 'Amanti', 'amanti', 'ACTIVE'),
(747, 0, 'kia', 'Borrego', 'borrego', 'ACTIVE'),
(748, 0, 'kia', 'Spectra', 'spectra', 'ACTIVE'),
(749, 0, 'land-rover', 'LR3', 'lr3', 'ACTIVE'),
(750, 0, 'mazda', 'B-Series Regular Cab', 'b-series-regular-cab', 'ACTIVE'),
(751, 0, 'mercedes-benz', 'CLK-Class', 'clk-class', 'ACTIVE'),
(752, 0, 'mazda', 'B-Series Extended Cab', 'b-series-extended-cab', 'ACTIVE'),
(753, 0, 'nissan', '350Z', '350z', 'ACTIVE'),
(754, 0, 'mercury', 'Sable', 'sable', 'ACTIVE'),
(755, 0, 'mercedes-benz', 'SLR McLaren', 'slr-mclaren', 'ACTIVE'),
(756, 0, 'mitsubishi', 'Raider', 'raider', 'ACTIVE'),
(759, 0, 'pontiac', 'Solstice', 'solstice', 'ACTIVE'),
(760, 0, 'pontiac', 'G8', 'g8', 'ACTIVE'),
(761, 0, 'saturn', 'Aura', 'aura', 'ACTIVE'),
(762, 0, 'saab', '9-7X', '9-7x', 'ACTIVE'),
(763, 0, 'pontiac', 'Torrent', 'torrent', 'ACTIVE'),
(764, 0, 'pontiac', 'G5', 'g5', 'ACTIVE'),
(765, 0, 'saturn', 'SKY', 'sky', 'ACTIVE'),
(766, 0, 'suzuki', 'XL7', 'xl7', 'ACTIVE'),
(767, 0, 'volkswagen', 'Rabbit', 'rabbit', 'ACTIVE'),
(769, 0, 'volkswagen', 'GLI', 'gli', 'ACTIVE'),
(770, 1, 'audi', 'RS 4', 'rs-4', 'ACTIVE'),
(772, 5, 'bmw', 'Alpina B7', 'alpina-b7', 'ACTIVE'),
(774, 2, 'chevrolet', 'Uplander', 'uplander', 'ACTIVE'),
(775, 6, 'chrysler', 'Crossfire', 'crossfire', 'ACTIVE'),
(778, 15, 'dodge', 'Magnum', 'magnum', 'ACTIVE'),
(780, 15, 'dodge', 'Sprinter 3500', 'sprinter-3500', 'ACTIVE'),
(781, 12, 'hyundai', 'Entourage', 'entourage', 'ACTIVE'),
(783, 12, 'hyundai', 'Tiburon', 'tiburon', 'ACTIVE'),
(784, 55, 'isuzu', 'i-290', 'i-290', 'ACTIVE'),
(785, 0, 'jaguar', 'S-Type', 's-type', 'ACTIVE'),
(787, 55, 'isuzu', 'Ascender', 'ascender', 'ACTIVE'),
(788, 0, 'jaguar', 'X-Type', 'x-type', 'ACTIVE'),
(789, 0, 'isuzu', 'i-370', 'i-370', 'ACTIVE'),
(790, 0, 'lotus', 'Exige S', 'exige-s', 'ACTIVE'),
(791, 0, 'lincoln', 'Mark', 'mark', 'ACTIVE'),
(792, 0, 'mini', 'Cooper', 'cooper', 'ACTIVE'),
(793, 0, 'pontiac', 'Grand Prix', 'grand-prix', 'ACTIVE'),
(794, 0, 'saturn', 'Astra', 'astra', 'ACTIVE'),
(795, 0, 'suzuki', 'Reno', 'reno', 'ACTIVE'),
(796, 0, 'toyota', 'Solara', 'solara', 'ACTIVE'),
(797, 0, 'volkswagen', 'R32', 'r32', 'ACTIVE'),
(798, 0, 'suzuki', 'Forenza', 'forenza', 'ACTIVE'),
(799, 8, 'buick', 'Rendezvous', 'rendezvous', 'ACTIVE'),
(800, 8, 'buick', 'Terraza', 'terraza', 'ACTIVE'),
(801, 8, 'buick', 'Rainier', 'rainier', 'ACTIVE'),
(809, 2, 'chevrolet', 'Monte Carlo', 'monte-carlo', 'ACTIVE'),
(814, 15, 'dodge', 'Grand Caravan', 'grand-caravan', 'ACTIVE'),
(816, 15, 'dodge', 'Dakota', 'dakota', 'ACTIVE'),
(819, 7, 'ford', 'Freestar', 'freestar', 'ACTIVE'),
(820, 7, 'ford', 'Five Hundred', 'five-hundred', 'ACTIVE'),
(824, 7, 'ford', 'Freestyle', 'freestyle', 'ACTIVE'),
(833, 0, 'mercury', 'Montego', 'montego', 'ACTIVE'),
(834, 0, 'mercury', 'Monterey', 'monterey', 'ACTIVE'),
(835, 0, 'saturn', 'Relay', 'relay', 'ACTIVE'),
(836, 0, 'saturn', 'Ion', 'ion', 'ACTIVE'),
(838, 0, 'suzuki', 'Aerio', 'aerio', 'ACTIVE'),
(839, 4, 'acura', 'RSX', 'rsx', 'ACTIVE'),
(842, 2, 'chevrolet', 'SSR', 'ssr', 'ACTIVE'),
(843, 2, 'chevrolet', 'Silverado 3500', 'silverado-3500', 'ACTIVE'),
(847, 15, 'dodge', 'Stratus', 'stratus', 'ACTIVE'),
(848, 7, 'ford', 'GT', 'gt', 'ACTIVE'),
(850, 10, 'gmc', 'Sierra 3500', 'sierra-3500', 'ACTIVE'),
(854, 52, 'hummer', 'H1', 'h1', 'ACTIVE'),
(856, 0, 'isuzu', 'i-350', 'i-350', 'ACTIVE'),
(857, 0, 'isuzu', 'i-280', 'i-280', 'ACTIVE'),
(859, 0, 'lincoln', 'LS', 'ls', 'ACTIVE'),
(860, 0, 'maserati', 'GranSport', 'gransport', 'ACTIVE'),
(861, 0, 'lincoln', 'Zephyr', 'zephyr', 'ACTIVE'),
(862, 0, 'maserati', 'Coupe', 'coupe', 'ACTIVE'),
(863, 0, 'mazda', 'MPV', 'mpv', 'ACTIVE'),
(864, 0, 'mitsubishi', 'Montero', 'montero', 'ACTIVE'),
(865, 0, 'panoz', 'Esperante', 'esperante', 'ACTIVE'),
(866, 0, 'pontiac', 'GTO', 'gto', 'ACTIVE'),
(868, 0, 'subaru', 'Baja', 'baja', 'ACTIVE'),
(869, 0, 'scion', 'xA', 'xa', 'ACTIVE'),
(870, 0, 'saab', '9-2X', '9-2x', 'ACTIVE'),
(871, 0, 'suzuki', 'XL-7', 'xl-7', 'ACTIVE'),
(872, 0, 'suzuki', 'Verona', 'verona', 'ACTIVE'),
(873, 0, 'toyota', 'Tundra', 'tundra', 'ACTIVE'),
(875, 0, 'volkswagen', 'Phaeton', 'phaeton', 'ACTIVE'),
(876, 8, 'buick', 'Century', 'century', 'ACTIVE'),
(878, 8, 'buick', 'Park Avenue', 'park-avenue', 'ACTIVE'),
(879, 2, 'chevrolet', 'Astro', 'astro', 'ACTIVE'),
(880, 3, 'cadillac', 'DeVille', 'deville', 'ACTIVE'),
(881, 8, 'buick', 'LeSabre', 'lesabre', 'ACTIVE'),
(882, 2, 'chevrolet', 'Classic', 'classic', 'ACTIVE'),
(884, 2, 'chevrolet', 'Cavalier', 'cavalier', 'ACTIVE'),
(886, 2, 'chevrolet', 'Venture', 'venture', 'ACTIVE'),
(887, 15, 'dodge', 'Neon', 'neon', 'ACTIVE'),
(888, 7, 'ford', 'Excursion', 'excursion', 'ACTIVE'),
(890, 10, 'gmc', 'Safari', 'safari', 'ACTIVE'),
(891, 7, 'ford', 'Thunderbird', 'thunderbird', 'ACTIVE'),
(893, 12, 'hyundai', 'XG350', 'xg350', 'ACTIVE'),
(894, 0, 'land-rover', 'Freelander', 'freelander', 'ACTIVE'),
(895, 0, 'pontiac', 'Bonneville', 'bonneville', 'ACTIVE'),
(896, 0, 'pontiac', 'Aztek', 'aztek', 'ACTIVE'),
(897, 0, 'pontiac', 'Grand Am', 'grand-am', 'ACTIVE'),
(898, 0, 'pontiac', 'Montana', 'montana', 'ACTIVE'),
(899, 0, 'pontiac', 'Sunfire', 'sunfire', 'ACTIVE'),
(900, 0, 'porsche', 'Carrera GT', 'carrera-gt', 'ACTIVE'),
(901, 0, 'saturn', 'L-Series', 'l-series', 'ACTIVE'),
(902, 0, 'toyota', 'Celica', 'celica', 'ACTIVE'),
(903, 0, 'toyota', 'Echo', 'echo', 'ACTIVE'),
(904, 0, 'toyota', 'MR2', 'mr2', 'ACTIVE'),
(906, 3, 'cadillac', 'Seville', 'seville', 'ACTIVE'),
(909, 2, 'chevrolet', 'Silverado 2500', 'silverado-2500', 'ACTIVE'),
(912, 6, 'chrysler', 'Concorde', 'concorde', 'ACTIVE'),
(913, 2, 'chevrolet', 'Tracker', 'tracker', 'ACTIVE'),
(915, 15, 'dodge', 'Intrepid', 'intrepid', 'ACTIVE'),
(917, 7, 'ford', 'F150', 'f150', 'ACTIVE'),
(920, 10, 'gmc', 'Sierra 2500', 'sierra-2500', 'ACTIVE'),
(922, 0, 'isuzu', 'Axiom', 'axiom', 'ACTIVE'),
(923, 0, 'isuzu', 'Rodeo', 'rodeo', 'ACTIVE'),
(925, 0, 'mazda', 'B-Series Cab Plus', 'b-series-cab-plus', 'ACTIVE'),
(926, 0, 'mercury', 'Marauder', 'marauder', 'ACTIVE'),
(927, 0, 'mitsubishi', 'Diamante', 'diamante', 'ACTIVE'),
(929, 0, 'oldsmobile', 'Bravada', 'bravada', 'ACTIVE'),
(930, 0, 'oldsmobile', 'Alero', 'alero', 'ACTIVE'),
(932, 0, 'oldsmobile', 'Silhouette', 'silhouette', 'ACTIVE'),
(933, 0, 'suzuki', 'Vitara', 'vitara', 'ACTIVE'),
(936, 0, 'volvo', 'V40', 'v40', 'ACTIVE'),
(937, 4, 'acura', 'CL', 'cl', 'ACTIVE'),
(938, 5, 'bmw', 'Z8', 'z8', 'ACTIVE'),
(939, 1, 'audi', 'RS 6', 'rs-6', 'ACTIVE'),
(942, 15, 'dodge', 'Ram Van 1500', 'ram-van-1500', 'ACTIVE'),
(943, 15, 'dodge', 'Ram Van 2500', 'ram-van-2500', 'ACTIVE'),
(944, 15, 'dodge', 'Ram Van 3500', 'ram-van-3500', 'ACTIVE'),
(946, 7, 'ford', 'Windstar', 'windstar', 'ACTIVE'),
(947, 7, 'ford', 'ZX2', 'zx2', 'ACTIVE'),
(952, 0, 'mazda', 'Protege5', 'protege5', 'ACTIVE'),
(953, 0, 'mazda', 'Protege', 'protege', 'ACTIVE'),
(954, 0, 'oldsmobile', 'Aurora', 'aurora', 'ACTIVE'),
(955, 0, 'volkswagen', 'Eurovan', 'eurovan', 'ACTIVE'),
(956, 5, 'bmw', 'Z3', 'z3', 'ACTIVE'),
(957, 3, 'cadillac', 'Eldorado', 'eldorado', 'ACTIVE'),
(958, 5, 'bmw', 'M', 'm', 'ACTIVE'),
(959, 2, 'chevrolet', 'Prizm', 'prizm', 'ACTIVE'),
(960, 6, 'chrysler', 'Prowler', 'prowler', 'ACTIVE'),
(961, 58, 'daewoo', 'Nubira', 'nubira', 'ACTIVE'),
(962, 58, 'daewoo', 'Leganza', 'leganza', 'ACTIVE'),
(963, 58, 'daewoo', 'Lanos', 'lanos', 'ACTIVE'),
(966, 15, 'dodge', 'Ram Wagon 2500', 'ram-wagon-2500', 'ACTIVE'),
(969, 15, 'dodge', 'Ram Wagon 1500', 'ram-wagon-1500', 'ACTIVE'),
(971, 7, 'ford', 'Escort', 'escort', 'ACTIVE'),
(972, 15, 'dodge', 'Ram Wagon 3500', 'ram-wagon-3500', 'ACTIVE'),
(973, 0, 'isuzu', 'Trooper', 'trooper', 'ACTIVE'),
(975, 0, 'lincoln', 'Blackwood', 'blackwood', 'ACTIVE'),
(976, 0, 'mazda', '626', '626', 'ACTIVE'),
(977, 0, 'mazda', 'Millenia', 'millenia', 'ACTIVE'),
(978, 0, 'mercury', 'Villager', 'villager', 'ACTIVE'),
(979, 0, 'mercury', 'Cougar', 'cougar', 'ACTIVE'),
(980, 0, 'oldsmobile', 'Intrigue', 'intrigue', 'ACTIVE'),
(981, 0, 'saturn', 'S-Series', 's-series', 'ACTIVE'),
(982, 0, 'pontiac', 'Firebird', 'firebird', 'ACTIVE'),
(983, 0, 'suzuki', 'Esteem', 'esteem', 'ACTIVE'),
(984, 0, 'volkswagen', 'Cabrio', 'cabrio', 'ACTIVE'),
(985, 4, 'acura', 'Integra', 'integra', 'ACTIVE'),
(986, 3, 'cadillac', 'Catera', 'catera', 'ACTIVE'),
(987, 2, 'chevrolet', 'Metro', 'metro', 'ACTIVE'),
(988, 2, 'chevrolet', 'Lumina', 'lumina', 'ACTIVE'),
(989, 6, 'chrysler', 'LHS', 'lhs', 'ACTIVE'),
(991, 10, 'gmc', 'Jimmy', 'jimmy', 'ACTIVE'),
(992, 11, 'honda', 'Prelude', 'prelude', 'ACTIVE'),
(993, 12, 'hyundai', 'XG300', 'xg300', 'ACTIVE'),
(994, 0, 'isuzu', 'VehiCROSS', 'vehicross', 'ACTIVE'),
(995, 0, 'kia', 'Sephia', 'sephia', 'ACTIVE'),
(997, 0, 'suzuki', 'Swift', 'swift', 'ACTIVE'),
(998, 0, 'plymouth', 'Neon', 'neon', 'ACTIVE'),
(1007, 6, 'chrysler', 'Cirrus', 'cirrus', 'ACTIVE'),
(1008, 6, 'chrysler', 'Grand Voyager', 'grand-voyager', 'ACTIVE'),
(1009, 7, 'ford', 'Contour', 'contour', 'ACTIVE'),
(1012, 55, 'isuzu', 'Amigo', 'amigo', 'ACTIVE'),
(1014, 55, 'isuzu', 'Hombre', 'hombre', 'ACTIVE'),
(1015, 0, 'mercury', 'Mystique', 'mystique', 'ACTIVE'),
(1016, 0, 'plymouth', 'Grand Voyager', 'grand-voyager', 'ACTIVE'),
(1017, 0, 'plymouth', 'Breeze', 'breeze', 'ACTIVE'),
(1018, 0, 'plymouth', 'Voyager', 'voyager', 'ACTIVE'),
(1019, 0, 'plymouth', 'Prowler', 'prowler', 'ACTIVE'),
(1020, 0, 'volvo', 'S70', 's70', 'ACTIVE'),
(1021, 4, 'acura', 'SLX', 'slx', 'ACTIVE'),
(1022, 8, 'buick', 'Riviera', 'riviera', 'ACTIVE'),
(1024, 15, 'dodge', 'Ram 2500', 'ram-2500', 'ACTIVE'),
(1035, 10, 'gmc', 'Suburban 2500', 'suburban-2500', 'ACTIVE'),
(1036, 10, 'gmc', 'Suburban 1500', 'suburban-1500', 'ACTIVE'),
(1037, 0, 'isuzu', 'Oasis', 'oasis', 'ACTIVE'),
(1038, 0, 'oldsmobile', 'Cutlass', 'cutlass', 'ACTIVE'),
(1039, 0, 'mercury', 'Tracer', 'tracer', 'ACTIVE'),
(1040, 0, 'mitsubishi', '3000GT', '3000gt', 'ACTIVE'),
(1041, 0, 'oldsmobile', 'LSS', 'lss', 'ACTIVE'),
(1042, 0, 'oldsmobile', '88', '88', 'ACTIVE'),
(1046, 1, 'audi', 'Cabriolet', 'cabriolet', 'ACTIVE'),
(1047, 8, 'buick', 'Skylark', 'skylark', 'ACTIVE'),
(1049, 2, 'chevrolet', 'G-Series 1500', 'g-series-1500', 'ACTIVE'),
(1052, 2, 'chevrolet', 'G-Series 3500', 'g-series-3500', 'ACTIVE'),
(1053, 2, 'chevrolet', 'G-Series 2500', 'g-series-2500', 'ACTIVE'),
(1054, 7, 'ford', 'Club Wagon', 'club-wagon', 'ACTIVE'),
(1055, 60, 'eagle', 'Talon', 'talon', 'ACTIVE'),
(1063, 0, 'nissan', '200SX', '200sx', 'ACTIVE'),
(1064, 0, 'nissan', '240SX', '240sx', 'ACTIVE'),
(1065, 0, 'oldsmobile', 'Achieva', 'achieva', 'ACTIVE'),
(1066, 0, 'oldsmobile', 'Regency', 'regency', 'ACTIVE'),
(1067, 0, 'suzuki', 'Sidekick', 'sidekick', 'ACTIVE'),
(1068, 0, 'pontiac', 'Trans Sport', 'trans-sport', 'ACTIVE'),
(1069, 0, 'toyota', 'Supra', 'supra', 'ACTIVE'),
(1070, 0, 'saab', '900', '900', 'ACTIVE'),
(1071, 0, 'toyota', 'T100', 't100', 'ACTIVE'),
(1072, 0, 'saab', '9000', '9000', 'ACTIVE'),
(1073, 0, 'suzuki', 'X-90', 'x-90', 'ACTIVE'),
(1075, 0, 'toyota', 'Tercel', 'tercel', 'ACTIVE'),
(1077, 7, 'ford', 'Aspire', 'aspire', 'ACTIVE'),
(1078, 15, 'dodge', 'Ram 3500', 'ram-3500', 'ACTIVE'),
(1079, 7, 'ford', 'Aerostar', 'aerostar', 'ACTIVE'),
(1080, 60, 'eagle', 'Vision', 'vision', 'ACTIVE'),
(1081, 7, 'ford', 'Probe', 'probe', 'ACTIVE'),
(1082, 7, 'ford', 'F350', 'f350', 'ACTIVE'),
(1084, 7, 'ford', 'F250', 'f250', 'ACTIVE'),
(1086, 61, 'geo', 'Metro', 'metro', 'ACTIVE'),
(1087, 61, 'geo', 'Prizm', 'prizm', 'ACTIVE'),
(1088, 61, 'geo', 'Tracker', 'tracker', 'ACTIVE'),
(1089, 11, 'honda', 'del Sol', 'del-sol', 'ACTIVE'),
(1092, 0, 'mazda', 'MX-6', 'mx-6', 'ACTIVE'),
(1093, 0, 'nissan', 'Regular Cab', 'regular-cab', 'ACTIVE'),
(1094, 0, 'nissan', 'King Cab', 'king-cab', 'ACTIVE'),
(1096, 0, 'subaru', 'SVX', 'svx', 'ACTIVE'),
(1097, 0, 'toyota', 'Paseo', 'paseo', 'ACTIVE'),
(1098, 0, 'toyota', 'Previa', 'previa', 'ACTIVE'),
(1099, 0, 'volvo', '850', '850', 'ACTIVE'),
(1100, 0, 'volvo', '960', '960', 'ACTIVE'),
(1101, 8, 'buick', 'Roadmaster', 'roadmaster', 'ACTIVE'),
(1102, 3, 'cadillac', 'Fleetwood', 'fleetwood', 'ACTIVE'),
(1103, 2, 'chevrolet', 'Beretta', 'beretta', 'ACTIVE'),
(1104, 2, 'chevrolet', 'G-Series G30', 'g-series-g30', 'ACTIVE'),
(1106, 2, 'chevrolet', 'Sportvan G30', 'sportvan-g30', 'ACTIVE'),
(1107, 2, 'chevrolet', 'Corsica', 'corsica', 'ACTIVE'),
(1110, 6, 'chrysler', 'New Yorker', 'new-yorker', 'ACTIVE'),
(1111, 15, 'dodge', 'Stealth', 'stealth', 'ACTIVE'),
(1112, 7, 'ford', 'Bronco', 'bronco', 'ACTIVE'),
(1113, 60, 'eagle', 'Summit', 'summit', 'ACTIVE'),
(1114, 10, 'gmc', 'Rally Wagon G3500', 'rally-wagon-g3500', 'ACTIVE'),
(1115, 10, 'gmc', 'Vandura G3500', 'vandura-g3500', 'ACTIVE'),
(1117, 0, 'nissan', '300ZX', '300zx', 'ACTIVE'),
(1118, 0, 'oldsmobile', 'Ciera', 'ciera', 'ACTIVE'),
(1119, 0, 'oldsmobile', '98', '98', 'ACTIVE'),
(1120, 32, 'alfa-romeo', '164', '164', 'ACTIVE'),
(1121, 1, 'audi', '90', '90', 'ACTIVE'),
(1122, 4, 'acura', 'Legend', 'legend', 'ACTIVE'),
(1124, 2, 'chevrolet', 'G-Series G20', 'g-series-g20', 'ACTIVE'),
(1125, 2, 'chevrolet', 'G-Series G10', 'g-series-g10', 'ACTIVE'),
(1127, 6, 'chrysler', 'LeBaron', 'lebaron', 'ACTIVE'),
(1128, 2, 'chevrolet', 'Sportvan G20', 'sportvan-g20', 'ACTIVE'),
(1129, 15, 'dodge', 'Spirit', 'spirit', 'ACTIVE'),
(1130, 10, 'gmc', 'Rally Wagon G2500', 'rally-wagon-g2500', 'ACTIVE'),
(1131, 10, 'gmc', 'Vandura G2500', 'vandura-g2500', 'ACTIVE'),
(1132, 10, 'gmc', 'Vandura G1500', 'vandura-g1500', 'ACTIVE'),
(1133, 12, 'hyundai', 'Scoupe', 'scoupe', 'ACTIVE'),
(1134, 55, 'isuzu', 'Regular Cab', 'regular-cab', 'ACTIVE'),
(1135, 0, 'mazda', 'MX-3', 'mx-3', 'ACTIVE'),
(1136, 0, 'mazda', '929', '929', 'ACTIVE'),
(1137, 0, 'mitsubishi', 'Expo', 'expo', 'ACTIVE'),
(1138, 0, 'mazda', 'RX-7', 'rx-7', 'ACTIVE'),
(1139, 0, 'plymouth', 'Acclaim', 'acclaim', 'ACTIVE'),
(1141, 0, 'suzuki', 'Samurai', 'samurai', 'ACTIVE'),
(1142, 0, 'porsche', '968', '968', 'ACTIVE'),
(1143, 0, 'porsche', '928', '928', 'ACTIVE'),
(1144, 0, 'toyota', 'Regular Cab', 'regular-cab', 'ACTIVE'),
(1146, 1, 'audi', 'Quattro', 'quattro', 'ACTIVE'),
(1147, 32, 'alfa-romeo', 'Spider', 'spider', 'ACTIVE'),
(1148, 0, 'toyota', 'Xtra Cab', 'xtra-cab', 'ACTIVE'),
(1150, 1, 'audi', '100', '100', 'ACTIVE'),
(1151, 4, 'acura', 'Vigor', 'vigor', 'ACTIVE'),
(1152, 0, 'volvo', '940', '940', 'ACTIVE'),
(1153, 2, 'chevrolet', 'S10', 's10', 'ACTIVE'),
(1154, 15, 'dodge', 'Ram Van B250', 'ram-van-b250', 'ACTIVE'),
(1155, 15, 'dodge', 'Ram Wagon B350', 'ram-wagon-b350', 'ACTIVE'),
(1156, 15, 'dodge', 'Colt', 'colt', 'ACTIVE'),
(1157, 15, 'dodge', 'Ram Van B150', 'ram-van-b150', 'ACTIVE'),
(1158, 15, 'dodge', 'Ram Van B350', 'ram-van-b350', 'ACTIVE'),
(1159, 15, 'dodge', 'Ram Wagon B150', 'ram-wagon-b150', 'ACTIVE'),
(1160, 15, 'dodge', 'Shadow', 'shadow', 'ACTIVE'),
(1161, 15, 'dodge', 'Ram Wagon B250', 'ram-wagon-b250', 'ACTIVE'),
(1162, 10, 'gmc', 'Rally Wagon 2500', 'rally-wagon-2500', 'ACTIVE'),
(1163, 7, 'ford', 'Tempo', 'tempo', 'ACTIVE'),
(1164, 10, 'gmc', 'Rally Wagon 3500', 'rally-wagon-3500', 'ACTIVE'),
(1165, 10, 'gmc', 'Vandura 1500', 'vandura-1500', 'ACTIVE'),
(1166, 10, 'gmc', 'Vandura 3500', 'vandura-3500', 'ACTIVE'),
(1167, 10, 'gmc', 'Vandura 2500', 'vandura-2500', 'ACTIVE'),
(1168, 12, 'hyundai', 'Excel', 'excel', 'ACTIVE'),
(1169, 0, 'isuzu', 'Spacecab', 'spacecab', 'ACTIVE'),
(1170, 0, 'mazda', '323', '323', 'ACTIVE'),
(1171, 0, 'mazda', 'Navajo', 'navajo', 'ACTIVE'),
(1172, 0, 'mercury', 'Capri', 'capri', 'ACTIVE'),
(1173, 0, 'mitsubishi', 'Mighty Max', 'mighty-max', 'ACTIVE'),
(1174, 0, 'mitsubishi', 'Precis', 'precis', 'ACTIVE'),
(1175, 0, 'mercury', 'Topaz', 'topaz', 'ACTIVE'),
(1176, 0, 'plymouth', 'Laser', 'laser', 'ACTIVE'),
(1178, 0, 'plymouth', 'Colt', 'colt', 'ACTIVE'),
(1179, 0, 'plymouth', 'Colt Vista', 'colt-vista', 'ACTIVE'),
(1180, 0, 'pontiac', 'Sunbird', 'sunbird', 'ACTIVE'),
(1181, 0, 'subaru', 'Loyale', 'loyale', 'ACTIVE'),
(1182, 0, 'plymouth', 'Sundance', 'sundance', 'ACTIVE'),
(1183, 0, 'subaru', 'Justy', 'justy', 'ACTIVE'),
(1184, 0, 'volkswagen', 'Corrado', 'corrado', 'ACTIVE'),
(1185, 3, 'cadillac', 'Allante', 'allante', 'ACTIVE'),
(1186, 3, 'cadillac', 'Sixty Special', 'sixty-special', 'ACTIVE'),
(1188, 2, 'chevrolet', 'Sportvan G10', 'sportvan-g10', 'ACTIVE'),
(1189, 2, 'chevrolet', 'APV', 'apv', 'ACTIVE'),
(1190, 15, 'dodge', 'D350', 'd350', 'ACTIVE'),
(1191, 6, 'chrysler', 'Fifth Ave', 'fifth-ave', 'ACTIVE'),
(1192, 15, 'dodge', 'D250', 'd250', 'ACTIVE'),
(1193, 15, 'dodge', 'D150', 'd150', 'ACTIVE'),
(1194, 6, 'chrysler', 'Imperial', 'imperial', 'ACTIVE'),
(1198, 15, 'dodge', 'Dynasty', 'dynasty', 'ACTIVE'),
(1199, 15, 'dodge', 'Ram 50', 'ram-50', 'ACTIVE'),
(1200, 15, 'dodge', 'Daytona', 'daytona', 'ACTIVE'),
(1201, 15, 'dodge', 'Ramcharger', 'ramcharger', 'ACTIVE'),
(1202, 7, 'ford', 'Festiva', 'festiva', 'ACTIVE'),
(1203, 61, 'geo', 'Storm', 'storm', 'ACTIVE'),
(1204, 10, 'gmc', 'Rally Wagon 1500', 'rally-wagon-1500', 'ACTIVE'),
(1205, 55, 'isuzu', 'Stylus', 'stylus', 'ACTIVE'),
(1206, 0, 'land-rover', 'Defender', 'defender', 'ACTIVE'),
(1207, 0, 'mercedes-benz', '300 E', '300-e', 'ACTIVE'),
(1208, 0, 'mercedes-benz', '190 E', '190-e', 'ACTIVE'),
(1209, 0, 'mercedes-benz', '300 D', '300-d', 'ACTIVE'),
(1210, 0, 'mercedes-benz', '300 SD', '300-sd', 'ACTIVE'),
(1211, 0, 'mercedes-benz', '300 CE', '300-ce', 'ACTIVE'),
(1212, 0, 'mercedes-benz', '500 SEL', '500-sel', 'ACTIVE'),
(1213, 0, 'mercedes-benz', '400 SEL', '400-sel', 'ACTIVE'),
(1214, 0, 'mercedes-benz', '500 SL', '500-sl', 'ACTIVE'),
(1215, 0, 'mercedes-benz', '500', '500', 'ACTIVE'),
(1216, 0, 'mercedes-benz', '300 SL', '300-sl', 'ACTIVE'),
(1217, 0, 'mercedes-benz', '600 SEC', '600-sec', 'ACTIVE'),
(1218, 0, 'mercedes-benz', '300 TE', '300-te', 'ACTIVE'),
(1219, 0, 'mercedes-benz', '400 E', '400-e', 'ACTIVE'),
(1220, 0, 'mercedes-benz', '300 SE', '300-se', 'ACTIVE'),
(1221, 0, 'mercedes-benz', '600 SL', '600-sl', 'ACTIVE'),
(1222, 0, 'mercedes-benz', '600 SEL', '600-sel', 'ACTIVE'),
(1223, 0, 'mercedes-benz', '500 SEC', '500-sec', 'ACTIVE'),
(1224, 0, 'nissan', 'NX', 'nx', 'ACTIVE'),
(1225, 0, 'pontiac', 'LeMans', 'lemans', 'ACTIVE'),
(1226, 0, 'volkswagen', 'Cabriolet', 'cabriolet', 'ACTIVE'),
(1227, 0, 'volkswagen', 'Fox', 'fox', 'ACTIVE'),
(1228, 0, 'volvo', '240', '240', 'ACTIVE'),
(1229, 1, 'audi', '80', '80', 'ACTIVE'),
(1230, 3, 'cadillac', 'Brougham', 'brougham', 'ACTIVE'),
(1231, 2, 'chevrolet', 'Caprice', 'caprice', 'ACTIVE'),
(1232, 62, 'daihatsu', 'Rocky', 'rocky', 'ACTIVE'),
(1233, 62, 'daihatsu', 'Charade', 'charade', 'ACTIVE'),
(1234, 15, 'dodge', 'Monaco', 'monaco', 'ACTIVE'),
(1235, 60, 'eagle', 'Premier', 'premier', 'ACTIVE'),
(1236, 10, 'gmc', 'Sonoma', 'sonoma', 'ACTIVE'),
(1237, 55, 'isuzu', 'Impulse', 'impulse', 'ACTIVE'),
(1238, 0, 'jeep', 'Comanche', 'comanche', 'ACTIVE'),
(1240, 0, 'mercedes-benz', '400 SE', '400-se', 'ACTIVE'),
(1241, 0, 'nissan', 'Stanza', 'stanza', 'ACTIVE'),
(1242, 0, 'oldsmobile', 'Toronado', 'toronado', 'ACTIVE'),
(1243, 0, 'oldsmobile', 'Custom Cruiser', 'custom-cruiser', 'ACTIVE'),
(1244, 0, 'toyota', 'Cressida', 'cressida', 'ACTIVE'),
(1245, 0, 'volvo', '740', '740', 'ACTIVE'),
(1248, 3, 'cadillac', 'CT4', 'ct4', 'ACTIVE'),
(1251, 14, 'genesis', 'GV80', 'gv80', 'ACTIVE'),
(1254, 0, 'kia', 'K5', 'k5', 'ACTIVE'),
(1255, 0, 'kia', 'Seltos', 'seltos', 'ACTIVE'),
(1256, 0, 'mercedes-benz', 'GLB', 'glb', 'ACTIVE'),
(1257, 0, 'polestar', '2', '2', 'ACTIVE'),
(1258, 0, 'porsche', '718 Spyder', '718-spyder', 'ACTIVE'),
(1259, 0, 'rivian', 'R1S', 'r1s', 'ACTIVE'),
(1260, 0, 'rivian', 'R1T', 'r1t', 'ACTIVE'),
(1263, 10, 'gmc', 'Hummer EV', 'hummer-ev', 'ACTIVE'),
(1264, 0, 'jeep', 'Grand Wagoneer', 'grand-wagoneer', 'ACTIVE'),
(1265, 34, 'freightliner', 'S2RV', 's2rv', 'ACTIVE'),
(1266, 34, 'freightliner', 'M2', 'm2', 'ACTIVE'),
(1267, 34, 'freightliner', 'FL70', 'fl70', 'ACTIVE'),
(1268, 34, 'freightliner', 'XC-S', 'xc-s', 'ACTIVE'),
(1269, 34, 'freightliner', 'XC-R', 'xc-r', 'ACTIVE'),
(1270, 34, 'freightliner', 'Columbia', 'columbia', 'ACTIVE'),
(1271, 34, 'freightliner', 'Cascadia', 'cascadia', 'ACTIVE'),
(1272, 34, 'freightliner', 'Sprinter', 'sprinter', 'ACTIVE'),
(1273, 34, 'freightliner', 'Coronado', 'coronado', 'ACTIVE'),
(1274, 34, 'freightliner', 'MT 45 Chassis', 'mt-45-chassis', 'ACTIVE'),
(1275, 34, 'freightliner', 'M2-106', 'm2-106', 'ACTIVE'),
(1279, 0, 'toyota', 'Tacoma', 'tacoma', 'ACTIVE'),
(1282, 2, 'chevrolet', 'C7500', 'c7500', 'ACTIVE'),
(1283, 2, 'chevrolet', 'C5500', 'c5500', 'ACTIVE'),
(1284, 2, 'chevrolet', 'C4500', 'c4500', 'ACTIVE'),
(1285, 2, 'chevrolet', 'C3500', 'c3500', 'ACTIVE'),
(1286, 9, 'infiniti', 'QX56', 'qx56', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `cars_sale`
--

CREATE TABLE `cars_sale` (
  `sale_id` int(11) NOT NULL,
  `vin` varchar(50) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `owner_price` varchar(50) NOT NULL,
  `sale_price` varchar(50) NOT NULL,
  `saledate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cars_sale`
--

INSERT INTO `cars_sale` (`sale_id`, `vin`, `owner_id`, `buyer_id`, `owner_price`, `sale_price`, `saledate`) VALUES
(1, '1HGBH41JXMN109186', 1, 1, '15000', '18500', '2024-01-20'),
(2, 'WAU2MAFC9EN093287', 1, 2, '25000', '29900', '2024-01-25'),
(3, 'WBA5B1C5XED480087', 1, 3, '35000', '41900', '2024-02-05');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `short_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `symbol`, `name`, `short_code`) VALUES
(1, '$', 'US Dollar', 'USD'),
(2, '€', 'Euro', 'EUR'),
(3, '₹', 'Indian Rupee', 'INR'),
(4, '£', 'British Pound', 'GBP'),
(5, '¥', 'Japanese Yen', 'JPY'),
(6, '$', 'Australian Dollar', 'AUD'),
(7, '$', 'Canadian Dollar', 'CAD'),
(8, 'CHF', 'Swiss Franc', 'CHF'),
(9, '¥', 'Chinese Yuan', 'CNY'),
(10, 'kr', 'Swedish Krona', 'SEK'),
(11, '$', 'New Zealand Dollar', 'NZD'),
(12, '$', 'Mexican Peso', 'MXN'),
(13, '$', 'Singapore Dollar', 'SGD'),
(14, '$', 'Hong Kong Dollar', 'HKD'),
(15, 'kr', 'Norwegian Krone', 'NOK'),
(16, '₩', 'South Korean Won', 'KRW'),
(17, '₺', 'Turkish Lira', 'TRY'),
(18, '₽', 'Russian Ruble', 'RUB'),
(19, 'R', 'South African Rand', 'ZAR'),
(20, 'R$', 'Brazilian Real', 'BRL'),
(21, 'NT$', 'Taiwan Dollar', 'TWD'),
(22, 'kr', 'Danish Krone', 'DKK'),
(23, 'zł', 'Polish Zloty', 'PLN'),
(24, '฿', 'Thai Baht', 'THB'),
(25, 'Rp', 'Indonesian Rupiah', 'IDR'),
(26, 'Ft', 'Hungarian Forint', 'HUF'),
(27, 'Kč', 'Czech Koruna', 'CZK'),
(28, '₪', 'Israeli Shekel', 'ILS'),
(29, '﷼', 'Saudi Riyal', 'SAR'),
(30, 'د.إ', 'UAE Dirham', 'AED'),
(31, 'RM', 'Malaysian Ringgit', 'MYR'),
(32, '₱', 'Philippine Peso', 'PHP'),
(33, '₨', 'Pakistani Rupee', 'PKR'),
(34, '৳', 'Bangladeshi Taka', 'BDT'),
(35, '₦', 'Nigerian Naira', 'NGN'),
(36, '£', 'Egyptian Pound', 'EGP'),
(37, 'د.ك', 'Kuwaiti Dinar', 'KWD'),
(38, '﷼', 'Qatari Riyal', 'QAR'),
(39, 'Rs', 'Sri Lankan Rupee', 'LKR'),
(40, '₫', 'Vietnamese Dong', 'VND');

-- --------------------------------------------------------

--
-- Table structure for table `email_setting`
--

CREATE TABLE `email_setting` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `send_add_inventory` enum('Y','N') NOT NULL DEFAULT 'Y',
  `send_sold_out` enum('Y','N') NOT NULL DEFAULT 'Y',
  `send_sold_out_buyer` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_setting`
--

INSERT INTO `email_setting` (`id`, `username`, `password`, `smtp_host`, `smtp_port`, `send_add_inventory`, `send_sold_out`, `send_sold_out_buyer`) VALUES
(1, 'your-email@gmail.com', 'your-app-password', 'smtp.gmail.com', 587, 'Y', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_setting`
--

CREATE TABLE `homepage_setting` (
  `id` int(11) NOT NULL,
  `banner_image` varchar(255) NOT NULL,
  `banner_heading1` varchar(255) NOT NULL,
  `banner_heading2` varchar(255) NOT NULL,
  `show_bodystyle` enum('Y','N') NOT NULL DEFAULT 'Y',
  `cargrid_heading` varchar(255) NOT NULL,
  `numberofcars` int(11) NOT NULL,
  `content` text NOT NULL,
  `show_make` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `homepage_setting`
--

INSERT INTO `homepage_setting` (`id`, `banner_image`, `banner_heading1`, `banner_heading2`, `show_bodystyle`, `cargrid_heading`, `numberofcars`, `content`, `show_make`) VALUES
(1, 'hero-bg.jpg', 'Find Your Perfect Car Today', 'Browse our extensive inventory of quality pre-owned and new vehicles', 'Y', 'Featured Vehicles', 6, 'We are committed to providing the best car buying experience with quality vehicles, competitive prices, and excellent customer service. Your trusted partner in finding the perfect vehicle.', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `lead_id` int(11) NOT NULL,
  `vin` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`lead_id`, `vin`, `name`, `email`, `phone`, `message`) VALUES
(1, '1HGBH41JXMN109186', 'Alice Cooper', 'alice.cooper@email.com', '555-0201', 'Interested in the Toyota Camry. When can I schedule a test drive?'),
(2, 'KMHDU46D48U429052', 'Bob Miller', 'bob.miller@email.com', '555-0202', 'Looking for a family SUV. The Hyundai Santa Fe looks perfect.'),
(3, 'WBA5B1C5XED480087', 'Carol White', 'carol.white@email.com', '555-0203', 'Interested in the BMW 3 Series. What financing options do you have?'),
(4, '5FNYF5H39JB000233', 'David Lee', 'david.lee@email.com', '555-0204', 'Looking for a convertible for summer driving.'),
(5, '1HGBH41JXMN109186', 'Emma Taylor', 'emma.taylor@email.com', '555-0205', 'Need a reliable car for daily commute. The Toyota Camry seems ideal.');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `page_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `showonmenu` enum('Y','N') NOT NULL DEFAULT 'N',
  `showcontactform` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`page_id`, `title`, `slug`, `showonmenu`, `showcontactform`, `content`, `status`) VALUES
(1, 'About Us', 'about-us', 'Y', 'N', '<div class=\"row\">\n<div class=\"col-lg-12\">\n<div class=\"section-title about-title\">\n<h2>Welcome To <!--?php echo $SITE_NAME;?--> Online Service</h2>\n<p>First I will explain what contextual advertising is. Contextual advertising means the advertising of products on a website according to<br>the content the page is displaying. For example if the content of a website was information on a Ford truck then the advertisements</p>\n</div>\n</div>\n</div>\n<div class=\"about__feature\">\n<div class=\"row\">\n<div class=\"col-lg-4 col-md-6 col-sm-6\">\n<div class=\"about__feature__item\"><img src=\"img/about/af-1.png\" alt=\"\">\n<h5>Quality Assurance System</h5>\n<p>It seems though that some of the biggest problems with the internet advertising trends are the lack of</p>\n</div>\n</div>\n<div class=\"col-lg-4 col-md-6 col-sm-6\">\n<div class=\"about__feature__item\"><img src=\"img/about/af-2.png\" alt=\"\">\n<h5>Accurate Testing Processes</h5>\n<p>Where do you register your complaints? How can you protest in any form against companies whose</p>\n</div>\n</div>\n<div class=\"col-lg-4 col-md-6 col-sm-6\">\n<div class=\"about__feature__item\"><img src=\"img/about/af-3.png\" alt=\"\">\n<h5>Infrastructure Integration Technology</h5>\n<p>So in final analysis: it&rsquo;s true, I hate peeping Toms, but if I had to choose, I&rsquo;d take one any day over an</p>\n</div>\n</div>\n</div>\n</div>\n<div class=\"row\">\n<div class=\"col-lg-12\">\n<div class=\"about__pic\"><img src=\"img/about/about-pic.jpg\" alt=\"\"></div>\n</div>\n<div class=\"col-lg-6 col-md-6 col-sm-6\">\n<div class=\"about__item\">\n<h5>Our Mission</h5>\n<p>Now, I&rsquo;m not like Robin, that weirdo from my cultural anthropology class; I think that advertising is something that has its place in our society; which for better or worse is structured along a marketplace economy. But, simply because I feel advertising has a right to exist, doesn&rsquo;t mean that I like or agree with it, in its</p>\n</div>\n</div>\n<div class=\"col-lg-6 col-md-6 col-sm-6\">\n<div class=\"about__item\">\n<h5>Our Vision</h5>\n<p>Where do you register your complaints? How can you protest in any form against companies whose advertising techniques you don&rsquo;t agree with? You don&rsquo;t. And on another point of difference between traditional products and their advertising and those of the internet nature, simply ignoring internet advertising is</p>\n</div>\n</div>\n</div>', 'Y'),
(4, 'Contact Us', 'contact-us', 'Y', 'Y', '<div class=\"contact__text\">\n<div class=\"section-title\">\n<h2>Let&rsquo;s Work Together</h2>\n<p>To make requests for further information, contact us via our social channels.</p>\n</div>\n<ul>\n<li>Weekday 08:00 am to 18:00 pm</li>\n<li>Saturday: 10:00 am to 16:00 pm</li>\n<li>Sunday: Closed</li>\n</ul>\n</div>', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `fb_page_link` varchar(400) NOT NULL,
  `twitter_page_link` varchar(400) NOT NULL,
  `yt_page_link` varchar(400) NOT NULL,
  `insta_page_link` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `fb_page_link`, `twitter_page_link`, `yt_page_link`, `insta_page_link`) VALUES
(1, 'https://facebook.com/cardealerpro', 'https://twitter.com/cardealerpro', 'https://youtube.com/cardealerpro', 'https://instagram.com/cardealerpro');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `phone`, `address`) VALUES
(1, 'John Smith', 'john.smith@email.com', '555-1001', '123 Main Street, Anytown, ST 12345'),
(2, 'Sarah Johnson', 'sarah.j@email.com', '555-1002', '456 Oak Avenue, Somewhere, ST 67890'),
(3, 'Mike Davis', 'mike.davis@email.com', '555-1003', '789 Pine Road, Elsewhere, ST 54321'),
(4, 'Lisa Wilson', 'lisa.wilson@email.com', '555-1004', '321 Elm Street, Nowhere, ST 98765'),
(5, 'Robert Brown', 'robert.brown@email.com', '555-1005', '654 Maple Drive, Anywhere, ST 13579');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cars_bodystyle`
--
ALTER TABLE `cars_bodystyle`
  ADD PRIMARY KEY (`bodystyle_id`);

--
-- Indexes for table `cars_images`
--
ALTER TABLE `cars_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars_listings`
--
ALTER TABLE `cars_listings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars_make`
--
ALTER TABLE `cars_make`
  ADD PRIMARY KEY (`make_id`);

--
-- Indexes for table `cars_model`
--
ALTER TABLE `cars_model`
  ADD PRIMARY KEY (`model_id`);

--
-- Indexes for table `cars_sale`
--
ALTER TABLE `cars_sale`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_setting`
--
ALTER TABLE `email_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage_setting`
--
ALTER TABLE `homepage_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`lead_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cars_bodystyle`
--
ALTER TABLE `cars_bodystyle`
  MODIFY `bodystyle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cars_images`
--
ALTER TABLE `cars_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `cars_listings`
--
ALTER TABLE `cars_listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cars_make`
--
ALTER TABLE `cars_make`
  MODIFY `make_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `cars_model`
--
ALTER TABLE `cars_model`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1288;

--
-- AUTO_INCREMENT for table `cars_sale`
--
ALTER TABLE `cars_sale`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `email_setting`
--
ALTER TABLE `email_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `homepage_setting`
--
ALTER TABLE `homepage_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `lead_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
