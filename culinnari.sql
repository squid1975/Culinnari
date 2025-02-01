DROP DATABASE IF EXISTS culinnari;
CREATE DATABASE IF NOT EXISTS culinnari
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_unicode_ci;



CREATE TABLE `user` (
  `user_id` pk,
  `username` varchar(15) UNIQUE,
  `user_email_address` varchar(50) UNIQUE,
  `user_hash_password` varchar(255),
  `user_first_name` varchar(50),
  `user_last_name` varchar(50),
  `user_create_account_date` timestamp,
  `user_role` ENUM(member,admin,super admin) DEFAULT 'member',
  `user_is_active` bool DEFAULT true
);

CREATE TABLE `recipe` (
  `recipe_id` pk,
  `recipe_name` varchar(255),
  `recipe_description` text,
  `recipe_total_servings` int,
  `recipe_post_date` timestamp,
  `recipe_prep_time_seconds` int,
  `recipe_cook_time_seconds` int,
  `recipe_difficulty` ENUM(beginner,intermediate,advanced),
  `user_id` int
);

CREATE TABLE `recipe_image` (
  `recipe_image_id` pk,
  `recipe_image` varchar(255),
  `recipe_id` int
);

CREATE TABLE `recipe_video` (
  `recipe_video_id` pk,
  `recipe_video_url` varchar(255),
  `recipe_id` int
);

CREATE TABLE `rating` (
  `rating_id` pk,
  `user_id` int,
  `recipe_id` int,
  `rating_value` decimal(2,1),
  `rating_date` timestamp
);

CREATE TABLE `recipe_rating_summary` (
  `recipe_rating_summary_id` pk,
  `recipe_rating_average` decimal(3,2),
  `recipe_rating_total_ratings` int,
  `recipe_id` int
);

CREATE TABLE `ingredient` (
  `ingredient_id` pk,
  `ingredient_name` varchar(255),
  `ingredient_quantity` decimal(5,2),
  `measurement_id` int,
  `recipe_id` int
);

CREATE TABLE `measurement` (
  `measurement_id` pk,
  `measurement_name` varchar(50)
);

CREATE TABLE `step` (
  `step_id` pk,
  `recipe_id` int,
  `step_number` int,
  `step_description` text
);

CREATE TABLE `diet` (
  `diet_id` pk,
  `diet_name` varchar(50),
  `diet_icon_url` varchar(255)
);

CREATE TABLE `recipe_meal_type` (
  `recipe_meal_type_id` pk,
  `recipe_id` int,
  `meal_type_id` int
);

CREATE TABLE `meal_type` (
  `meal_type_id` pk,
  `meal_type_name` varchar(50)
);

CREATE TABLE `style` (
  `style_id` pk,
  `style_name` varchar(50)
);

CREATE TABLE `cookbook` (
  `cookbook_id` int PRIMARY KEY,
  `cookbook_name` varchar(50),
  `user_id` int
);

CREATE TABLE `cookbook_recipe` (
  `cookbook_recipe_id` pk,
  `cookbook_id` int,
  `recipe_id` int
);

CREATE TABLE `recipe_diet` (
  `recipe_diet_id` pk,
  `recipe_id` int,
  `diet_id` int
);

CREATE TABLE `recipe_style` (
  `recipe_style_id` pk,
  `recipe_id` int,
  `style_id` int
);

ALTER TABLE `recipe` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

ALTER TABLE `cookbook` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

ALTER TABLE `cookbook_recipe` ADD FOREIGN KEY (`cookbook_id`) REFERENCES `cookbook` (`cookbook_id`);

ALTER TABLE `cookbook_recipe` ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

ALTER TABLE `ingredient` ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

ALTER TABLE `step` ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

ALTER TABLE `recipe_diet` ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

ALTER TABLE `recipe_meal_type` ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

ALTER TABLE `recipe_diet` ADD FOREIGN KEY (`diet_id`) REFERENCES `diet` (`diet_id`);

ALTER TABLE `recipe_meal_type` ADD FOREIGN KEY (`meal_type_id`) REFERENCES `meal_type` (`meal_type_id`);

ALTER TABLE `recipe_style` ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

ALTER TABLE `style` ADD FOREIGN KEY (`style_id`) REFERENCES `recipe_style` (`style_id`);

ALTER TABLE `recipe_image` ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

ALTER TABLE `ingredient` ADD FOREIGN KEY (`measurement_id`) REFERENCES `measurement` (`measurement_id`);

ALTER TABLE `recipe_video` ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

ALTER TABLE `rating` ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);

ALTER TABLE `rating` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

ALTER TABLE `recipe_rating_summary` ADD FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`recipe_id`);
