-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 27, 2025 at 08:26 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `culinnari`
--

-- --------------------------------------------------------

--
-- Table structure for table `cookbook`
--

CREATE TABLE `cookbook` (
  `id` int NOT NULL,
  `cookbook_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cookbook`
--

INSERT INTO `cookbook` (`id`, `cookbook_name`, `user_id`) VALUES
(2, 'squidtheadmin\'s cookbook', 1),
(6, 'Goodies', 2),
(7, 'Cooky', 3),
(8, 'My cookbook', 10),
(9, 'Yum Yum Stuff', 4),
(10, 'My first cookbook', 11),
(11, '', 12);

-- --------------------------------------------------------

--
-- Table structure for table `cookbook_recipe`
--

CREATE TABLE `cookbook_recipe` (
  `id` int NOT NULL,
  `cookbook_id` int DEFAULT NULL,
  `recipe_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cookbook_recipe`
--

INSERT INTO `cookbook_recipe` (`id`, `cookbook_id`, `recipe_id`) VALUES
(5, 2, 99),
(6, 2, 100),
(7, 2, 89),
(11, 6, 90),
(12, 6, 99);

-- --------------------------------------------------------

--
-- Table structure for table `diet`
--

CREATE TABLE `diet` (
  `id` int NOT NULL,
  `diet_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diet_icon_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `diet`
--

INSERT INTO `diet` (`id`, `diet_name`, `diet_icon_url`) VALUES
(1, 'Gluten-Free', 'images/icon/dietIcons/glutenFree.svg'),
(2, 'Keto', 'images/icon/dietIcons/keto.svg'),
(3, 'Low Carb', 'images/icon/dietIcons/lowCarb.svg'),
(4, 'Paleo', 'images/icon/dietIcons/paleo.svg'),
(5, 'Sugar-Free', 'images/icon/dietIcons/sugarFree.svg'),
(6, 'Vegan', 'images/icon/dietIcons/vegan.svg'),
(7, 'Vegetarian', 'images/icon/dietIcons/vegetarian.svg');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int NOT NULL,
  `ingredient_quantity` decimal(5,2) DEFAULT NULL,
  `ingredient_measurement_name` enum('teaspoon','tablespoon','fluid ounce','cup','pint','quart','gallon','milliliter','liter','ounce','pound','n/a') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ingredient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingredient_recipe_order` int DEFAULT NULL,
  `recipe_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ingredient`
--

INSERT INTO `ingredient` (`id`, `ingredient_quantity`, `ingredient_measurement_name`, `ingredient_name`, `ingredient_recipe_order`, `recipe_id`) VALUES
(90, 1.00, 'cup', 'Spinach (chopped)', 1, 89),
(91, 0.50, 'cup', 'Feta cheese (crumbled)', 2, 89),
(92, 0.25, 'cup', 'Ricotta cheese', 3, 89),
(93, 1.00, 'n/a', 'egg (beaten)', 4, 89),
(94, 0.50, 'n/a', 'Garlic powder', 5, 89),
(95, 0.25, 'n/a', 'black pepper', 6, 89),
(96, 8.00, 'n/a', 'Phyllo dough sheets, cut in squares', 7, 89),
(97, 2.00, 'tablespoon', 'Butter (melted)', 8, 89),
(98, 3.00, 'cup', 'chicken broth', 1, 90),
(99, 2.00, 'n/a', 'eggs (beaten)', 2, 90),
(100, 1.00, 'n/a', 'sesame oil', 3, 90),
(101, 0.50, 'n/a', 'Soy sauce (or coconut aminos)', 4, 90),
(102, 0.25, 'n/a', 'ground ginger', 5, 90),
(103, 0.25, 'n/a', 'white pepper', 6, 90),
(104, 2.00, 'n/a', 'green onions (chopped)', 7, 90),
(145, 2.00, 'tablespoon', 'Peanut Butter', 1, 99),
(146, 1.00, 'n/a', 'Honey', 2, 99),
(147, 2.00, 'n/a', 'Honey wheat bread slices', 3, 99),
(148, 1.00, 'cup', 'Self-Rising Flour', 1, 100),
(149, 1.00, 'cup', 'Sugar', 2, 100),
(150, 1.00, 'n/a', 'Can of Fruit Cocktail with Juice', 3, 100),
(151, 0.25, 'cup', 'Fresh Strawberries (sliced)', 1, 101),
(152, 0.50, 'tablespoon', 'Fresh blueberries', 2, 101),
(153, 0.50, 'cup', 'Ricotta Cheese', 3, 101),
(154, 0.50, 'tablespoon', 'Sliced Almonds', 4, 101),
(155, 2.00, 'teaspoon', 'Honey', 5, 101),
(156, 1.00, 'n/a', 'Ciabatta Roll, sliced', 6, 101),
(159, 8.00, 'n/a', 'Dill pickle spears', 1, 103),
(160, 1.00, 'cup', 'All-purpose flour', 2, 103),
(161, 1.00, 'teaspoon', 'Garlic powder', 3, 103),
(162, 1.00, 'teaspoon', 'salt', 4, 103),
(163, 0.50, 'teaspoon', 'seasoned salt', 5, 103),
(164, 0.50, 'teaspoon', 'ground black pepper', 6, 103),
(165, 2.00, 'n/a', 'Large eggs (beaten)', 7, 103),
(166, 1.00, 'cup', 'Panko breadcrumbs', 8, 103),
(167, 1.00, 'quart', 'vegetable oil for frying', 9, 103),
(168, 1.00, 'n/a', 'Slice of Bread', 1, 104),
(169, 0.50, 'n/a', 'Ripe Avocado', 2, 104),
(170, 4.00, 'n/a', 'Fresh Basil Leaves', 3, 104),
(171, 1.00, 'teaspoon', 'Olive Oil', 4, 104),
(172, 1.00, 'cup', 'Jasmine or Basmati Rice', 1, 105),
(173, 2.00, 'cup', 'water', 2, 105),
(174, 0.50, 'teaspoon', 'salt', 3, 105),
(175, 1.00, 'tablespoon', 'oil', 4, 105),
(176, 1.00, 'n/a', 'small onion (diced)', 5, 105),
(177, 2.00, 'n/a', 'garlic cloves (minced)', 6, 105),
(178, 1.00, 'teaspoon', 'grated ginger', 7, 105),
(179, 1.00, 'tablespoon', 'curry powder', 8, 105),
(180, 1.00, 'n/a', 'tomato (chopped)', 9, 105),
(181, 1.00, 'cup', 'diced chicken', 10, 105),
(182, 0.50, 'cup', 'coconut milk', 11, 105),
(183, 4.00, 'n/a', 'ears of corn (husked)', 1, 106),
(184, 0.25, 'cup', 'Mayonnaise', 2, 106),
(185, 0.25, 'cup', 'sour cream', 3, 106),
(186, 0.50, 'cup', 'crumbled cotija cheese', 4, 106),
(187, 1.00, 'teaspoon', 'chili powder', 5, 106),
(188, 1.00, 'tablespoon', 'fresh cilantro (chopped)', 6, 106),
(189, 1.00, 'n/a', 'lime (cut into wedges)', 7, 106),
(190, 1.00, 'tablespoon', 'melted butter', 8, 106),
(191, 2.25, 'cup', 'all-purpose flour', 1, 107),
(192, 0.50, 'teaspoon', 'salt', 2, 107),
(193, 0.50, 'cup', 'cold unsalted butter (cubed)', 3, 107),
(194, 1.00, 'n/a', 'egg', 4, 107),
(195, 0.33, 'cup', 'cold water', 5, 107),
(196, 1.00, 'tablespoon', 'white vinegar', 6, 107),
(197, 1.00, 'tablespoon', 'olive oil', 7, 107),
(198, 0.50, 'pound', 'ground beef', 8, 107),
(199, 0.50, 'n/a', 'small onion (finely chopped)', 9, 107),
(200, 1.00, 'n/a', 'garlic clove, minced', 10, 107),
(201, 0.25, 'cup', 'green olives (chopped, optional)', 11, 107),
(202, 0.50, 'teaspoon', 'cumin', 12, 107),
(203, 0.50, 'teaspoon', 'smoked paprika', 13, 107),
(204, 1.00, 'n/a', 'hard-boiled egg (chopped, optional)', 14, 107),
(205, 2.00, 'tablespoon', 'tomato paste', 15, 107),
(206, 1.00, 'n/a', 'egg (for egg wash)', 16, 107),
(210, 1.00, 'pound', 'Trimmed Beef Tenderloin', 1, 109),
(211, 1.00, 'pint', 'Cherry Tomatoes', 2, 109),
(212, 1.00, 'tablespoon', 'Canola Oil', 3, 109),
(213, 1.00, 'teaspoon', 'Salt', 4, 109),
(214, 1.00, 'teaspoon', 'Cracked Pepper', 5, 109),
(215, 1.00, 'ounce', 'Balsamic Glaze', 6, 109),
(220, 20.00, 'n/a', 'Gluten-Free Oreo Cookies', 1, 111),
(221, 0.25, 'cup', 'Melted butter', 2, 111),
(222, 2.00, 'cup', 'cream cheese', 3, 111),
(223, 0.50, 'cup', 'powdered sugar', 4, 111),
(224, 1.00, 'teaspoon', 'vanilla extract', 5, 111),
(225, 1.00, 'cup', 'heavy whipping cream', 6, 111),
(226, 0.50, 'cup', 'crushed gluten free Oreo cookies', 7, 111),
(227, 6.00, 'n/a', 'gluten free oreos (crushed)', 8, 111),
(228, 1.00, 'cup', 'unsalted butter (softened)', 1, 112),
(229, 0.50, 'cup', 'vegetable oil', 2, 112),
(230, 1.00, 'cup', 'granulated sugar', 3, 112),
(231, 0.50, 'cup', 'light brown sugar', 4, 112),
(232, 4.00, 'n/a', 'large eggs', 5, 112),
(233, 0.50, 'cup', 'milk', 6, 112),
(234, 0.50, 'cup', 'dark rum', 7, 112),
(235, 1.00, 'teaspoon', 'vanilla extract', 8, 112),
(236, 2.50, 'cup', 'all purpose flour', 9, 112),
(237, 3.00, 'ounce', 'instant vanilla pudding mix', 10, 112),
(238, 0.50, 'teaspoon', 'salt', 11, 112),
(239, 2.00, 'teaspoon', 'baking powder', 12, 112),
(240, 0.50, 'cup', 'unsalted butter', 13, 112),
(241, 0.25, 'cup', 'water', 14, 112),
(242, 1.00, 'cup', 'granulated sugar', 15, 112),
(243, 0.25, 'cup', 'dark rum', 16, 112),
(244, 1.00, 'teaspoon', 'vanilla extract', 17, 112),
(245, 1.00, 'n/a', 'Salmon Fillet', 1, 113),
(246, 1.00, 'n/a', '8oz jar roasted red peppers', 2, 113),
(247, 1.00, 'teaspoon', 'Salt and pepper', 3, 113),
(248, 1.00, 'teaspoon', 'minced garlic', 4, 113),
(249, 0.50, 'cup', 'melted butter', 5, 113),
(250, 0.50, 'cup', 'panko bread crumbs', 6, 113),
(251, 2.00, 'ounce', 'Arugula', 7, 113),
(252, 3.00, 'n/a', 'Tomatoes', 1, 114),
(253, 2.00, 'tablespoon', 'chopped garlic', 2, 114),
(254, 1.00, 'teaspoon', 'salt', 3, 114),
(255, 1.00, 'teaspoon', 'black pepper', 4, 114),
(256, 2.00, 'ounce', 'olive oil', 5, 114),
(257, 3.00, 'ounce', 'White wine (chablis preferred)', 6, 114),
(258, 2.00, 'ounce', 'shaved parmesan', 7, 114),
(259, 2.00, 'ounce', 'Fresh Julienned Basil', 8, 114),
(260, 1.00, 'ounce', 'Loaf French Bread', 9, 114),
(261, 1.00, 'fluid ounce', 'Balsamic glaze', 10, 114),
(262, 2.00, 'n/a', 'Portobello Mushrooms', 1, 115),
(263, 0.50, 'pound', 'Frozen Spinach', 2, 115),
(264, 1.00, 'cup', 'Heavy Cream', 3, 115),
(265, 3.00, 'ounce', 'Cream Cheese', 4, 115),
(266, 2.00, 'tablespoon', 'Salted Butter', 5, 115),
(267, 1.00, 'tablespoon', 'Blackening Seasoning', 6, 115),
(270, 1.00, 'pound', 'shredded duck meat', 1, 118),
(271, 1.00, 'n/a', 'loaf of ciabatta bread', 2, 118),
(272, 1.00, 'cup', 'Strawberry Jalapeno BBQ Sauce', 3, 118),
(273, 1.00, 'tablespoon', 'sliced green onions', 4, 118),
(274, 2.25, 'cup', 'All-purpose flour', 1, 119),
(275, 0.50, 'teaspoon', 'baking soda', 2, 119),
(276, 1.00, 'cup', 'unsalted butter, room temperature', 3, 119),
(277, 0.50, 'cup', 'granulated sugar', 4, 119),
(278, 1.00, 'cup', 'packed brown sugar', 5, 119),
(279, 2.00, 'teaspoon', 'vanilla extract', 6, 119),
(280, 2.00, 'n/a', 'large eggs', 7, 119),
(281, 2.00, 'cup', 'semisweet chocolate chips', 8, 119);

-- --------------------------------------------------------

--
-- Table structure for table `meal_type`
--

CREATE TABLE `meal_type` (
  `id` int NOT NULL,
  `meal_type_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meal_type`
--

INSERT INTO `meal_type` (`id`, `meal_type_name`) VALUES
(2, 'Breakfast'),
(3, 'Brunch'),
(4, 'Dessert'),
(5, 'Dinner'),
(6, 'Lunch'),
(7, 'Snack'),
(22, 'Appetizer');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `recipe_id` int DEFAULT NULL,
  `rating_value` decimal(2,1) DEFAULT '0.0',
  `rating_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `user_id`, `recipe_id`, `rating_value`, `rating_date`) VALUES
(25, 2, 90, 5.0, '2025-03-28 13:03:56'),
(27, 3, 89, 4.0, '2025-03-30 16:03:19'),
(28, 2, 89, 3.0, '2025-03-30 08:03:49'),
(30, 1, 99, 5.0, '2025-04-05 07:04:07'),
(31, 3, 99, 4.0, '2025-04-13 15:04:05'),
(32, 9, 101, 4.0, '2025-04-15 11:04:37'),
(33, 1, 100, 4.0, '2025-04-21 12:04:15'),
(35, 1, 114, 4.0, '2025-04-23 14:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `id` int NOT NULL,
  `recipe_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipe_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipe_total_servings` int DEFAULT NULL,
  `recipe_post_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `recipe_prep_time_seconds` int DEFAULT NULL,
  `recipe_cook_time_seconds` int DEFAULT NULL,
  `recipe_difficulty` enum('beginner','intermediate','advanced') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`id`, `recipe_name`, `recipe_description`, `recipe_total_servings`, `recipe_post_date`, `recipe_prep_time_seconds`, `recipe_cook_time_seconds`, `recipe_difficulty`, `user_id`) VALUES
(89, 'Spanakopita Bites', 'Flaky phyllo pastries filled with a savory mix of spinach, feta, and ricotta, baked to golden perfection. A perfect Greek appetizer!', 14, '2025-03-28 06:03:48', 1200, 1200, 'beginner', 1),
(90, 'Keto Egg Drop Soup', ' A warm and comforting Asian soup with silky egg ribbons in a flavorful broth, perfect for a low-carb breakfast.', 3, '2025-03-28 06:03:21', 300, 600, 'beginner', 1),
(99, 'Peanut Butter & Honey Sandwich', 'This sandwich got me through my last semester of college. ', 1, '2025-04-05 07:04:05', 300, 0, 'beginner', 2),
(100, 'Cuppa Cake', 'Inspired by the movie \"Steel Magnolias\", this cuppa cake recipe uses a few ingredients to create maximum flavor. ', 12, '2025-04-05 07:04:04', 300, 1800, 'beginner', 3),
(101, 'Ricotta Berry Delight', 'Inspired by a breakfast I had on my honeymoon. Delicious fresh fruit on a ciabatta roll with smooth ricotta cheese, sliced almonds, and sweetened with honey. ', 1, '2025-04-13 15:04:49', 600, 0, 'beginner', 3),
(103, 'Southern Fried Pickles', 'These delicious fried pickles are a great snack or appetizer. They can easily be paired with your favorite dipping sauce. ', 8, '2025-04-21 13:04:18', 1800, 900, 'intermediate', 1),
(104, 'Basil & Avocado Toast', 'Fresh, simple, and full of flavor—this Basil & Avocado Toast brings together creamy avocado and aromatic basil on a crispy slice of bread. Perfect for a quick breakfast, light lunch, or a plant-powered snack that looks as good as it tastes.', 1, '2025-04-21 15:04:18', 300, 0, 'beginner', 2),
(105, 'Cooked Rice & Curry', 'This Cooked Rice and Curry dish is a quick and comforting meal perfect for weeknights or meal prep. Fluffy rice pairs with a flavorful, spiced curry made with chicken. Simple and satisfying in under 40 minutes!', 2, '2025-04-22 16:04:40', 600, 1500, 'intermediate', 2),
(106, 'Elotes Asado', 'Smoky, creamy, and packed with flavor—Elotes Asado is grilled Mexican street corn slathered in tangy crema, chili, lime, and cotija cheese. A bold and irresistible side or snack that brings street food vibes to your table!', 4, '2025-04-22 06:04:08', 600, 600, 'beginner', 2),
(107, 'Classic Beef Empanadas', 'Golden, flaky empanadas filled with savory spiced beef, onions, and optional olives—perfect as a snack, appetizer, or main dish. A handheld classic packed with bold Latin flavor!', 12, '2025-04-22 06:04:39', 1500, 1200, 'intermediate', 2),
(109, 'Tenderloin Skewers', 'Tender bites of filet with roasted tomato and balsamic', 10, '2025-04-22 06:04:23', 1800, 360, 'beginner', 4),
(111, 'Gluten-Free Oreo Cheesecake', 'This gluten-free no-bake Oreo cheesecake features a crunchy Oreo crust, a creamy, smooth cheesecake filling, and a topping of crushed Oreos. Quick to make and perfect for any occasion, it\'s a delicious treat for those avoiding gluten!', 8, '2025-04-22 10:04:44', 900, 10800, 'intermediate', 1),
(112, 'Classic Rum Cake', 'Moist, rich, buttery, and that warm rum vibe all the way through. Here’s a classic Caribbean-style rum cake recipe that’ll taste like vacation in every bite.', 14, '2025-04-22 10:04:47', 5400, 3600, 'intermediate', 1),
(113, 'Garlic Crusted Salmon', 'Garlic crusted salmon over red pepper puree and arugula', 2, '2025-04-23 05:04:35', 1800, 1200, 'intermediate', 2),
(114, 'Tomato Bruschetta', 'Tomato bruschetta with French bread crostini\'s. ', 4, '2025-04-23 06:04:50', 1800, 600, 'intermediate', 2),
(115, 'Stuffed Portobello', 'Large portobello mushroom stuffed with spinach and cheese.', 2, '2025-04-23 06:04:21', 3600, 1800, 'intermediate', 2),
(118, 'BBQ Duck on Ciabatta', 'Pulled duck meat in strawberry jalapeno BBQ sauce on toasted ciabatta', 2, '2025-04-26 04:00:00', 1800, 1800, 'intermediate', 2),
(119, 'Chocolate Chip Cookies', ' Just a classic delicious chocolate chip cookie recipe.          ', 12, '2025-04-26 04:00:00', 900, 900, 'beginner', 2);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_diet`
--

CREATE TABLE `recipe_diet` (
  `id` int NOT NULL,
  `recipe_id` int DEFAULT NULL,
  `diet_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe_diet`
--

INSERT INTO `recipe_diet` (`id`, `recipe_id`, `diet_id`) VALUES
(27, 89, 7),
(28, 90, 2),
(36, 99, 7),
(37, 101, 5),
(38, 101, 7),
(42, 103, 7),
(43, 104, 1),
(44, 104, 6),
(45, 104, 7),
(46, 106, 1),
(47, 106, 7),
(51, 111, 1),
(52, 111, 7),
(53, 112, 7),
(54, 114, 7),
(55, 115, 1),
(56, 115, 7),
(57, 119, 7);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_image`
--

CREATE TABLE `recipe_image` (
  `id` int NOT NULL,
  `recipe_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipe_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe_image`
--

INSERT INTO `recipe_image` (`id`, `recipe_image`, `recipe_id`) VALUES
(23, '/images/default_recipe_image.webp', 89),
(24, '/images/default_recipe_image.webp', 90),
(33, '/images/default_recipe_image.webp', 99),
(34, '/images/uploads/recipe_image/67f1503cc7fcf_cuppa_cake.webp', 100),
(35, '/images/uploads/recipe_image/67fc42210fc9c_20240527_112549.webp', 101),
(37, '/images/uploads/recipe_image/6806bb7e257c3_22731289-cda3-4247-a4a6-0414e347281f.webp', 103),
(38, '/images/uploads/recipe_image/6806d852c494a_pexels-fotios-photos-1351238.webp', 104),
(39, '/images/uploads/recipe_image/6806dc6426662_pexels-catscoming-674574.webp', 105),
(40, '/images/uploads/recipe_image/6806f9548ded2_pexels-leonardo-aquino-246345118-27551936.webp', 106),
(41, '/images/uploads/recipe_image/6806fb53312be_pexels-lucas-porras-1937324539-30771118.webp', 107),
(43, '/images/uploads/recipe_image/6807042ae4969_Steak_Skewer.webp', 109),
(45, '/images/uploads/recipe_image/6807e0900d424_oreo-cheesecake.webp', 111),
(46, '/images/uploads/recipe_image/6807e66ea4f61_pexels-cottonbro-3992196.webp', 112),
(47, '/images/uploads/recipe_image/680846b7788aa_67c91f80df0e5_Salmon.webp', 113),
(48, '/images/uploads/recipe_image/68084ac21027d_67c90d4748b31_Bruschetta.webp', 114),
(49, '/images/uploads/recipe_image/68084bd1750f7_67c91cb94a33d_Mushroom.webp', 115),
(52, '/images/uploads/recipe_image/680c3dfc2b430_6807068058a0a_bbqduck.webp', 118),
(53, '/images/uploads/recipe_image/680c3fd3e718e_pexels-carlosadr-17028187.webp', 119);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_meal_type`
--

CREATE TABLE `recipe_meal_type` (
  `id` int NOT NULL,
  `recipe_id` int DEFAULT NULL,
  `meal_type_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe_meal_type`
--

INSERT INTO `recipe_meal_type` (`id`, `recipe_id`, `meal_type_id`) VALUES
(41, 90, 2),
(52, 99, 5),
(53, 99, 6),
(54, 99, 7),
(55, 100, 4),
(56, 101, 2),
(57, 101, 3),
(58, 101, 7),
(63, 103, 6),
(64, 103, 7),
(65, 104, 2),
(66, 104, 3),
(67, 104, 7),
(68, 105, 5),
(69, 105, 6),
(71, 106, 6),
(72, 106, 7),
(74, 107, 5),
(75, 107, 6),
(77, 109, 3),
(78, 109, 5),
(81, 111, 4),
(82, 112, 4),
(83, 113, 5),
(85, 114, 5),
(86, 115, 5),
(87, 118, 5),
(88, 118, 6),
(89, 119, 4);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_style`
--

CREATE TABLE `recipe_style` (
  `id` int NOT NULL,
  `recipe_id` int DEFAULT NULL,
  `style_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe_style`
--

INSERT INTO `recipe_style` (`id`, `recipe_id`, `style_id`) VALUES
(22, 89, 4),
(23, 90, 1),
(30, 100, 13),
(33, 103, 13),
(34, 104, 3),
(35, 105, 3),
(36, 106, 6),
(37, 107, 6),
(38, 109, 5),
(40, 112, 2),
(41, 113, 3),
(42, 114, 3),
(43, 115, 6),
(44, 118, 6);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_video`
--

CREATE TABLE `recipe_video` (
  `id` int NOT NULL,
  `recipe_video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipe_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipe_video`
--

INSERT INTO `recipe_video` (`id`, `recipe_video_url`, `recipe_id`) VALUES
(5, 'https://www.youtube.com/embed/oTibXFNgf8s', 100),
(7, 'https://www.youtube.com/embed/WnS4y84ht8I', 119);

-- --------------------------------------------------------

--
-- Table structure for table `step`
--

CREATE TABLE `step` (
  `id` int NOT NULL,
  `recipe_id` int DEFAULT NULL,
  `step_number` int DEFAULT NULL,
  `step_description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `step`
--

INSERT INTO `step` (`id`, `recipe_id`, `step_number`, `step_description`) VALUES
(128, 89, 1, 'Preheat oven to 375°F (190°C).'),
(129, 89, 2, 'In a bowl, mix spinach, feta, ricotta, egg, garlic powder, and black pepper.'),
(130, 89, 3, 'Brush phyllo squares with melted butter and place a spoonful of filling in the center.'),
(131, 89, 4, 'Fold into triangles and bake for 15-20 minutes or until golden brown.'),
(132, 90, 1, 'Heat chicken broth in a pot over medium heat.'),
(133, 90, 2, 'Add soy sauce, sesame oil, ginger, and white pepper.'),
(134, 90, 3, 'Slowly drizzle in beaten eggs while stirring gently to create ribbons.'),
(135, 90, 4, 'Garnish with green onions and serve warm.'),
(171, 99, 1, 'Combine peanut butter and honey in a small bowl until smooth. '),
(172, 99, 2, 'Spread on 1 bread slice. Top with remaining bread slice.'),
(173, 100, 1, 'Preheat oven to 350 degrees. '),
(174, 100, 2, 'Stir together flour, sugar, and fruit cocktail with juice until just combined.'),
(175, 100, 3, 'Pour into pan/dish and bake until warm and bubbly (for about 30 minutes or until top is golden brown) '),
(176, 100, 4, 'Serve warm. (Top with whipped cream or soft vanilla ice cream for that extra sweetness!) '),
(177, 101, 1, 'Lay out the ciabatta role. Spread ricotta cheese over the top of the roll. '),
(178, 101, 2, 'Take sliced strawberries and spread evenly over ricotta cheese. '),
(179, 101, 3, 'Sprinkle fresh blueberries over the strawberries. '),
(180, 101, 4, 'Sprinkle sliced almonds over the berry mix. '),
(181, 101, 5, 'Drizzle with honey. Enjoy as two half roll pieces or stack! '),
(185, 103, 1, 'Pat pickles dry with paper towel; set aside.'),
(186, 103, 2, 'Combine flour, garlic powder, salt, seasoned salt, and ground black pepper in a small bowl.'),
(187, 103, 3, 'In another bowl, whisk eggs until beaten.'),
(188, 103, 4, 'In a third bowl, add panko breadcrumbs.'),
(189, 103, 5, 'Take one pickle spear and thoroughly coat in the seasoned flour mix.'),
(190, 103, 6, 'Dip floured pickle in beaten egg wash. '),
(191, 103, 7, 'Dip pickle back into seasoned flour mix for second coat, then dip again in the egg wash. '),
(192, 103, 8, 'Roll pickle in breadcrumbs and press softly so crumbs stick. '),
(193, 103, 9, 'Repeat for all spears. Place pickles in fridge for 15 minutes to allow coating to stick. '),
(194, 103, 10, 'Heat vegetable oil in frying pan to 350.'),
(195, 103, 11, 'Place coated pickles in hot oil and fry for 2 minutes or until breading is a golden brown. '),
(196, 103, 12, 'Remove from oil and let drain on a cooling rack or on a paper towel. '),
(197, 103, 13, 'Serve while warm with your favorite dipping sauce. '),
(198, 104, 1, 'Toast the bread slice to your desired crispness.'),
(199, 104, 2, 'In a small bowl, mash the avocado with a fork until smooth. '),
(200, 104, 3, 'Evenly spread mashed avocado onto the toasted bread slice. '),
(201, 104, 4, 'Tear or leave the basil leaves whole and layer them evenly on top of avocado spread.'),
(202, 104, 5, 'Drizzle lightly with olive oil. '),
(203, 104, 6, 'If desired, sprinkle with salt and pepper to taste.'),
(204, 104, 7, 'Serve immediately and enjoy! '),
(205, 105, 1, 'Rinse the rice until the water runs mostly clear.'),
(206, 105, 2, 'Add rice, water, and salt to a pot. Bring to a boil.'),
(207, 105, 3, 'Reduce heat, cover, and simmer for 15 minutes.'),
(208, 105, 4, 'Turn off heat and let sit (covered) for 5 minutes. Fluff with a fork.'),
(209, 105, 5, 'Heat oil in a pan over medium heat.'),
(210, 105, 6, 'Add onion, garlic, and ginger. Sauté until soft (about 3–5 mins).\r\n'),
(211, 105, 7, 'Stir in curry powder and cook for 30 seconds.'),
(212, 105, 8, 'Add tomatoes and cook until soft and saucy.\r\n'),
(213, 105, 9, 'Add chicken and coconut milk.'),
(214, 105, 10, 'Simmer for 10 minutes, stirring occasionally.'),
(215, 105, 11, 'Taste and adjust salt, pepper, or add spices accordingly.'),
(216, 105, 12, 'Scoop fluffy rice onto a plate or bowl and ladle the curry over the top. Garnish with cilantro if desired. Enjoy hot!'),
(217, 106, 1, 'Heat your grill or grill pan over medium-high heat.'),
(218, 106, 2, 'Lightly brush the corn with butter, if desired.'),
(219, 106, 3, 'Grill the ears for 10 minutes, turning occasionally, until charred and slightly golden on all sides.'),
(220, 106, 4, 'In a small bowl, combine mayonnaise and sour cream.'),
(221, 106, 5, 'While the corn is still warm, slather it generously with the mayo and sour cream mix.'),
(222, 106, 6, 'Sprinkle with cotija cheese, a dash of chili powder, and chopped cilantro.'),
(223, 106, 7, 'Serve each ear with a lime wedge for squeezing over the top.'),
(224, 107, 1, 'Make the Dough: In a bowl, mix flour and salt. Cut in butter until crumbly. Whisk egg, water, and vinegar in a separate bowl, then add to flour mixture. Knead into dough. Chill for 30 minutes.'),
(225, 107, 2, 'Prepare the Filling: Heat oil in a skillet. Sauté onion and garlic until soft. Add beef, spices, tomato paste, and cook until browned. Stir in olives and hard-boiled egg (if using). Let cool.'),
(226, 107, 3, 'Assemble: Roll out dough and cut into 4-6 inch circles. Add a spoonful of filling to each. Fold, seal edges with a fork, and place on a lined baking sheet.'),
(227, 107, 4, 'Bake: Brush with egg wash. Bake at 400°F (200°C) for 18–22 minutes, or until golden brown.'),
(232, 109, 1, 'Cut filet into 10 evenly sized pieces and place in a mixing bowl'),
(233, 109, 2, 'Toss with oil, salt, and pepper'),
(234, 109, 3, 'Push skewer through meat and into cherry tomato'),
(235, 109, 4, 'Cook in preheated 400° oven for 3 minutes'),
(236, 109, 5, 'Open oven, flip each skewer over, allow to cook for another 3-5 minutes depending on your preferred internal temperature'),
(237, 109, 6, 'Garnish with zig zag of balsamic glaze'),
(243, 111, 1, 'Prepare the crust: Crush the gluten-free Oreo cookies into fine crumbs using a food processor or by placing them in a sealed bag and crushing them with a rolling pin.'),
(244, 111, 2, 'Mix the crumbs with the melted butter until combined.'),
(245, 111, 3, 'Press the mixture into the bottom of a pie dish or spring-form pan to form a firm crust.'),
(246, 111, 4, 'Place the crust in the fridge for 30 minutes to chill while making the filling. '),
(247, 111, 5, 'In a large mixing bowl, combine the softened cream cheese with powdered sugar and vanilla extract until smooth and creamy.'),
(248, 111, 6, 'In a separate bowl, whip the heavy cream until stiff peaks form.'),
(249, 111, 7, 'Gently fold the whipped cream into the cream cheese mixture until fully combined.'),
(250, 111, 8, 'Slowly stir in crushed gluten-free Oreo’s for added texture and flavor.'),
(251, 111, 9, 'Remove the chilled pie crust from the fridge.'),
(252, 111, 10, 'Pour the cheesecake filling over the chilled crust and smooth the top with a spatula.'),
(253, 111, 11, 'Sprinkle crushed Oreo’s on top to garnish.'),
(254, 111, 13, 'After the cheesecake is set, slice and serve chilled. '),
(255, 112, 1, 'Preheat oven to 325°F (163°C). Grease and flour a Bundt pan well (this is key so it doesn’t stick).'),
(256, 112, 2, 'In a big bowl, cream together the butter, oil, and both sugars until light and fluffy.'),
(257, 112, 3, 'Add eggs one at a time, mixing well after each.'),
(258, 112, 4, 'Stir in the milk, rum, and vanilla.'),
(259, 112, 5, 'In a separate bowl, whisk together flour, pudding mix, salt, and baking powder.'),
(260, 112, 6, 'Gradually mix the dry into the wet until just combined. Don’t overmix!'),
(261, 112, 7, 'Pour into the Bundt pan and smooth the top.'),
(262, 112, 8, 'Bake for 55–60 minutes, or until a skewer comes out clean. Let it cool in the pan for 10 minutes before flipping it out.'),
(263, 112, 9, 'While the cake is cooling, begin making the rum syrup by melting butter in a small saucepan.'),
(264, 112, 10, 'Add the water and sugar, stir constantly and bring to a boil. Let it bubble for about 5 minutes.'),
(265, 112, 11, 'Remove from heat, stir in the rum and vanilla.'),
(266, 112, 12, 'While the cake is still warm (after flipping out of the pan), poke holes all over the top with a skewer or toothpick.'),
(267, 112, 13, 'Slowly spoon or brush the warm syrup over the cake in layers. Let it soak, then go again. Get that cake tipsy.'),
(268, 112, 14, 'Let it sit for a few hours for max flavor. Serve with a dusting of powdered sugar or a dollop of whipped cream.\r\n'),
(269, 113, 1, 'Chop roasted red peppers and heat them on the stove over low heat. Season to your preference'),
(270, 113, 2, 'Create crust by mixing garlic, melted butter, and panko bread crumbs in a small bowl'),
(271, 113, 3, 'Cut salmon in half to make 2 portions. Season with salt and pepper'),
(272, 113, 4, 'Heat a pan over high heat and add a little bit of cooking oil or spray to coat the pan'),
(273, 113, 5, 'Add salmon and sear each side for 1 minute'),
(274, 113, 6, 'Spread garlic crust over the salmon and place into a preheated 400° oven for 10 minutes or until crust toasty on top'),
(275, 113, 7, 'Place red peppers in a blender and pulse for 10 seconds. Add to plate'),
(276, 113, 8, 'Put a handful of arugula in the red pepper puree, you can saute first but the heat of the red pepper puree is enough to wilt the arugula'),
(277, 113, 9, 'Place salmon on top of the arugula and serve'),
(278, 114, 1, 'Chop tomatoes into 1/4\" squares and place in mixing bowl'),
(279, 114, 2, 'Add minced garlic and gently combine with tomatoes'),
(280, 114, 3, 'Add oil, salt, pepper, and wine. Mix well'),
(281, 114, 4, 'Let mixture sit in mixing bowl for 30 minutes to fully absorb flavor'),
(282, 114, 5, 'While mix is marinating, slice french bread into 16-20 even slices'),
(283, 114, 6, 'Lightly brush bread slices with olive oil and place in pre-heated 300° oven for 10 minutes'),
(284, 114, 7, 'To serve; use a slotted spoon to scoop bruschetta into serving bowl to remove most liquid'),
(285, 114, 8, 'Top the bruschetta with parmesan cheese and drizzle balsamic glaze across bread and bruschetta'),
(286, 114, 9, 'Garnish with fresh basil and enjoy'),
(287, 115, 1, 'Remove the stalk of the mushrooms, scrape out the gills, and wash thoroughly under cool water'),
(288, 115, 2, 'Thaw frozen spinach and squeeze it in a paper towel to remove water content'),
(289, 115, 3, 'Heat a pan over medium-high heat, add butter to pan and sear both sides of mushrooms. About 1 minute each side'),
(290, 115, 4, 'Set mushrooms aside on a paper towel to soak up excess oils'),
(291, 115, 5, 'In a small sauce pot over medium heat, heat heavy cream until it begins to simmer'),
(292, 115, 6, 'Break up cream cheese into small pieces and stir them into the heavy cream until combined'),
(293, 115, 7, 'Add spinach and cook until hot throughout. Final product should be thick and not runny'),
(294, 115, 8, 'Preheat over to 400°'),
(295, 115, 9, 'Place even scoops of spinach mixture into each mushroom. Season the tops with blackening seasoning\r\n'),
(296, 115, 10, 'Place in oven for 10-15 minutes. '),
(299, 118, 1, 'In a small pot on the stove, heat BBQ sauce over low heat until it bubbles.'),
(300, 118, 2, 'Slowly stir in the duck meat'),
(301, 118, 3, 'Cover it and cook on low for 10 minutes, stirring occasionally'),
(302, 118, 4, 'Toast ciabatta in 350° oven for 5 minutes'),
(303, 118, 5, 'Garnish with green onions'),
(304, 119, 1, 'Preheat your oven to 350°F (175°C). Line a baking sheet with parchment paper or a silicone baking mat.'),
(305, 119, 2, 'Mix dry ingredients: In a medium bowl, whisk together the flour, and baking soda. Set aside.'),
(306, 119, 3, 'Cream butter and sugars: In a large bowl, beat the butter, granulated sugar, and brown sugar until light and fluffy. This should take about 3 minutes with an electric mixer.'),
(307, 119, 4, 'Add eggs and vanilla: Beat in the eggs one at a time, making sure to mix well after each addition. Then add the vanilla extract and beat until incorporated.'),
(308, 119, 5, 'Combine dry and wet ingredients: Gradually add the dry ingredients to the wet ingredients, mixing until just combined.'),
(309, 119, 6, 'Add chocolate chips: Fold in the chocolate chips with a spatula until evenly distributed.'),
(310, 119, 7, 'Scoop dough: Use a cookie scoop or a tablespoon to drop rounded balls of dough onto the prepared baking sheet. Leave about 2 inches between each cookie to allow for spreading.'),
(311, 119, 8, 'Bake: Bake for 10-12 minutes or until the edges are golden, but the centers are still soft.'),
(312, 119, 9, 'Cool: Let the cookies cool on the baking sheet for a few minutes before transferring them to a wire rack to cool completely.');

-- --------------------------------------------------------

--
-- Table structure for table `style`
--

CREATE TABLE `style` (
  `id` int NOT NULL,
  `style_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `style`
--

INSERT INTO `style` (`id`, `style_name`) VALUES
(1, 'Asian'),
(2, 'Caribbean'),
(3, 'Fusion'),
(4, 'Greek'),
(5, 'Italian'),
(6, 'Latin American'),
(8, 'Thai'),
(13, 'Southern');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_email_address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_hash_password` text COLLATE utf8mb4_unicode_ci,
  `user_first_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_last_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_create_account_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_role` enum('m','a','s') COLLATE utf8mb4_unicode_ci DEFAULT 'm',
  `user_is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `user_email_address`, `user_hash_password`, `user_first_name`, `user_last_name`, `user_create_account_date`, `user_role`, `user_is_active`) VALUES
(1, 'squidtheadmin', 'sydneyp@gmail.com', '$2y$10$GIFJOBRTwtyY1vtjpVAUVeqKkee8yTK.gwzfiMxg5bFpNLSCqBzpK', 'Syd', 'Penix', '2025-03-02 05:00:00', 's', 1),
(2, 'culinnari_user', 'testing@gmail.com', '$2y$10$7ZWskbDSwUR715MB40aSEOmDFNIhVEcAp14XuNG8lHEnc38B7EIX6', 'test', 'user', '2025-03-02 05:00:00', 'm', 1),
(3, 'culinnari_admin', 'testingadmin@test.com', '$2y$10$X9iBQcVIxI4E7q9.RufMuO0r5Rx0SCfB2guY6MtSstbCmgB5HgkHW', 'test', 'Admin', '2025-03-04 05:00:00', 'a', 1),
(4, 'chefMike', 'chefmike1234@gmail.com', '$2y$10$2sZULSA2LDuoGI1Df7cKjuvwZY92qYNbBOMjoi3aaKsWTwMjjmlj2', 'Mike', 'Farrin', '2025-03-05 05:00:00', 'm', 1),
(5, 'coopcooks', 'coopdacook@gmail.com', '$2y$10$L2bZNHXrKvHaqzXZ3PfsyeLuk0YCLygU2vvUtc/UrW926lYxKHVQa', 'John', 'Cheffin', '2025-03-23 04:00:00', 'm', 1),
(6, 'BirdDog42', 'flaminghotcheetos@gmail.com', '$2y$10$xYk/.IXZKkA1SfaJE2Ijxu8lhMyYeKWsj3r9rCgcWLU.ydBAz1xi2', 'Dave N\'', 'Busters', '2025-03-24 04:00:00', 'm', 1),
(7, 'cookie829', 'cookiebaker@gmail.com', '$2y$10$P5B8fcxxD17RmTIYncvKIeRPuWZ6iO1c5KWRF22EP4RPD38H5LJCq', 'Jane', 'Baker', '2025-03-24 04:00:00', 'm', 1),
(9, 'exampleUser', 'example@ex.com', '$2y$10$N/UY29tIqKP0CaMRB0E/ReALKiZl7wDBFzrdpese4n7sPZyTCnEjW', 'example', 'example', '2025-04-15 04:00:00', 'm', 1),
(10, 'testinguser', 'test@gmail.com', '$2y$10$PfJ7cr3SrkVBf2/EwQsZiezpGeFO96xaa6UV4eo/w2X1UpLaEk1ZK', 'test', 'test', '2025-04-21 04:00:00', 'm', 0),
(11, 'testinguserprofile', 'testingprofile@gmail.com', '$2y$10$Eb/8eNptyYNsL.DUgEV4gekaoq3Fg9xmppDR.hCMjFr0eJCy4QGcm', 'testing', 'user', '2025-04-24 04:00:00', 'm', 1),
(12, 'cookingbigstuff1234', 'thattestaccount@gmail.com', '$2y$10$EaIONUJ2uv2h6thdnPt9cuwim7aozy1YnwCtKlYrayJ8lrXwZuJG2', 'cooking', 'cook', '2025-04-25 04:00:00', 'm', 1),
(13, 'example81', 'example@test.com', '$2y$10$/VqP1kcr89/3mJB8dslXSOeE1gBBifzYoLXpfOaHCMraQxtvFdF2e', 'Cheffy', 'Chefman', '2025-04-25 04:00:00', 'm', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cookbook`
--
ALTER TABLE `cookbook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cookbook_fk_user` (`user_id`);

--
-- Indexes for table `cookbook_recipe`
--
ALTER TABLE `cookbook_recipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cookbook_recipe_fk_cookbook` (`cookbook_id`),
  ADD KEY `cookbook_recipe_fk_recipe` (`recipe_id`);

--
-- Indexes for table `diet`
--
ALTER TABLE `diet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredient_fk_recipe` (`recipe_id`);

--
-- Indexes for table `meal_type`
--
ALTER TABLE `meal_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rating_fk_user` (`user_id`),
  ADD KEY `rating_fk_recipe` (`recipe_id`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_fk_user` (`user_id`);

--
-- Indexes for table `recipe_diet`
--
ALTER TABLE `recipe_diet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_diet_fk_recipe` (`recipe_id`),
  ADD KEY `recipe_diet_fk_diet` (`diet_id`);

--
-- Indexes for table `recipe_image`
--
ALTER TABLE `recipe_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_image_fk_recipe` (`recipe_id`);

--
-- Indexes for table `recipe_meal_type`
--
ALTER TABLE `recipe_meal_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_meal_type_fk_recipe` (`recipe_id`),
  ADD KEY `recipe_meal_type_fk_meal_type` (`meal_type_id`);

--
-- Indexes for table `recipe_style`
--
ALTER TABLE `recipe_style`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_style_fk_recipe` (`recipe_id`),
  ADD KEY `recipe_style_fk_style` (`style_id`);

--
-- Indexes for table `recipe_video`
--
ALTER TABLE `recipe_video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_video_fk_recipe` (`recipe_id`);

--
-- Indexes for table `step`
--
ALTER TABLE `step`
  ADD PRIMARY KEY (`id`),
  ADD KEY `step_fk_recipe` (`recipe_id`);

--
-- Indexes for table `style`
--
ALTER TABLE `style`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `user_email_address` (`user_email_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cookbook`
--
ALTER TABLE `cookbook`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cookbook_recipe`
--
ALTER TABLE `cookbook_recipe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `diet`
--
ALTER TABLE `diet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;

--
-- AUTO_INCREMENT for table `meal_type`
--
ALTER TABLE `meal_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `recipe_diet`
--
ALTER TABLE `recipe_diet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `recipe_image`
--
ALTER TABLE `recipe_image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `recipe_meal_type`
--
ALTER TABLE `recipe_meal_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `recipe_style`
--
ALTER TABLE `recipe_style`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `recipe_video`
--
ALTER TABLE `recipe_video`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `step`
--
ALTER TABLE `step`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=317;

--
-- AUTO_INCREMENT for table `style`
--
ALTER TABLE `style`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cookbook`
--
ALTER TABLE `cookbook`
  ADD CONSTRAINT `cookbook_fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cookbook_recipe`
--
ALTER TABLE `cookbook_recipe`
  ADD CONSTRAINT `cookbook_recipe_fk_cookbook` FOREIGN KEY (`cookbook_id`) REFERENCES `cookbook` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cookbook_recipe_fk_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `ingredient_fk_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_fk_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rating_fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_diet`
--
ALTER TABLE `recipe_diet`
  ADD CONSTRAINT `recipe_diet_fk_diet` FOREIGN KEY (`diet_id`) REFERENCES `diet` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_diet_fk_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_image`
--
ALTER TABLE `recipe_image`
  ADD CONSTRAINT `recipe_image_fk_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_meal_type`
--
ALTER TABLE `recipe_meal_type`
  ADD CONSTRAINT `recipe_meal_type_fk_meal_type` FOREIGN KEY (`meal_type_id`) REFERENCES `meal_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_meal_type_fk_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_style`
--
ALTER TABLE `recipe_style`
  ADD CONSTRAINT `recipe_style_fk_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_style_fk_style` FOREIGN KEY (`style_id`) REFERENCES `style` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_video`
--
ALTER TABLE `recipe_video`
  ADD CONSTRAINT `recipe_video_fk_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `step`
--
ALTER TABLE `step`
  ADD CONSTRAINT `step_fk_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
