DROP DATABASE IF EXISTS culinnari;
CREATE DATABASE IF NOT EXISTS culinnari
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_unicode_ci;
USE culinnari;


CREATE TABLE `user` (
  `user_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(15) UNIQUE,
  `user_email_address` VARCHAR(50) UNIQUE,
  `user_hash_password` VARCHAR(255),
  `user_first_name` VARCHAR(50),
  `user_last_name` VARCHAR(50),
  `user_create_account_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `user_role` ENUM('member', 'admin','super admin') DEFAULT 'member',
  `user_is_active` BOOLEAN DEFAULT true
);

CREATE TABLE `recipe` (
  `recipe_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_name` VARCHAR(255),
  `recipe_description` text,
  `recipe_total_servings` INT,
  `recipe_post_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `recipe_prep_time_seconds` INT,
  `recipe_cook_time_seconds` INT,
  `recipe_difficulty` ENUM('beginner','intermediate','advanced'),
  `user_id` INT NOT NULL,
  CONSTRAINT recipe_fk_user FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
);

CREATE TABLE `recipe_image` (
  `recipe_image_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_image` VARCHAR(255),
  `recipe_id` INT NOT NULL, 
  CONSTRAINT recipe_image_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE
);

CREATE TABLE `recipe_video` (
  `recipe_video_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_video_url` VARCHAR(255),
  `recipe_id` INT,
  CONSTRAINT recipe_video_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE
);

CREATE TABLE `rating` (
  `rating_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT,
  `recipe_id` INT,
  `rating_value` DECIMAL(2,1) DEFAULT 0.0,
  `rating_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT rating_fk_user FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
  CONSTRAINT rating_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE
);

CREATE TABLE `recipe_rating_summary` (
  `recipe_rating_summary_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_rating_average` DECIMAL(3,2) DEFAULT 0.00,
  `recipe_rating_total_ratings` INT,
  `recipe_id` INT,
  CONSTRAINT recipe_rating_summary_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE
);

CREATE TABLE `ingredient` (
  `ingredient_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `ingredient_name` VARCHAR(255) NOT NULL,
  `ingredient_quantity` DECIMAL(5,2) CHECK(ingredient_quantity > 0),
  `measurement_id` INT,
  `recipe_id` INT,
  FOREIGN KEY (measurement_id) REFERENCES measurement(measurement_id) ON DELETE CASCADE,
  FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE
);

CREATE TABLE `measurement` (
  `measurement_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `measurement_name` VARCHAR(50) NOT NULL
);

CREATE TABLE `step` (
  `step_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `step_number` INT,
  `step_description` text,
  FOREIGN KEY (recipe_id) REFERENCES 
);

CREATE TABLE `diet` (
  `diet_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `diet_name` VARCHAR(50),
  `diet_icon_url` VARCHAR(255)
);

CREATE TABLE `recipe_meal_type` (
  `recipe_meal_type_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `meal_type_id` INT
);

CREATE TABLE `meal_type` (
  `meal_type_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `meal_type_name` VARCHAR(50)
);

CREATE TABLE `style` (
  `style_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `style_name` VARCHAR(50)
);

CREATE TABLE `cookbook` (
  `cookbook_id` INT  INT PRIMARY KEY AUTO_INCREMENT,
  `cookbook_name` VARCHAR(50),
  `user_id` INT
);

CREATE TABLE `cookbook_recipe` (
  `cookbook_recipe_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `cookbook_id` INT,
  `recipe_id` INT
);

CREATE TABLE `recipe_diet` (
  `recipe_diet_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `diet_id` INT
);

CREATE TABLE `recipe_style` (
  `recipe_style_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `style_id` INT
);

