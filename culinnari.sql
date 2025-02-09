-- CREATE DATABASE
DROP DATABASE IF EXISTS `culinnari`;
CREATE DATABASE IF NOT EXISTS `culinnari`
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
USE `culinnari`;

-- CREATE TABLES
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
  `recipe_rating_total_ratings` INT DEFAULT 0,
  `recipe_id` INT,
  CONSTRAINT recipe_rating_summary_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE
);

CREATE TABLE `ingredient` (
  `ingredient_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `ingredient_name` VARCHAR(255) NOT NULL,
  `ingredient_quantity` DECIMAL(5,2),
  `ingredient_measurement_name` ENUM('teaspoon', 'tablespoon','fluid ounce', 'cup', 'pint','quart','gallon','milliliter','liter','ounce','pound'),
  `ingredient_recipe_order` INT,
  `recipe_id` INT NOT NULL,
  CONSTRAINT ingredient_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE
);

CREATE TABLE `step` (
  `step_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `step_number` INT,
  `step_description` text,
  CONSTRAINT step_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE,
  CONSTRAINT unique_step_num_per_recipe UNIQUE(recipe_id, step_number) 
);

CREATE TABLE `diet` (
  `diet_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `diet_name` VARCHAR(50),
  `diet_icon_url` VARCHAR(255)
);

CREATE TABLE `meal_type` (
  `meal_type_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `meal_type_name` VARCHAR(50)
);

CREATE TABLE `style` (
  `style_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `style_name` VARCHAR(50)
);

CREATE TABLE `recipe_meal_type` (
  `recipe_meal_type_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `meal_type_id` INT,
  CONSTRAINT recipe_meal_type_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE,
  CONSTRAINT recipe_meal_type_fk_meal_type FOREIGN KEY (meal_type_id) REFERENCES meal_type(meal_type_id) ON DELETE CASCADE
);

CREATE TABLE `cookbook` (
  `cookbook_id` INT  PRIMARY KEY AUTO_INCREMENT,
  `cookbook_name` VARCHAR(50),
  `user_id` INT,
  CONSTRAINT cookbook_fk_user FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
);

CREATE TABLE `cookbook_recipe` (
  `cookbook_recipe_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `cookbook_id` INT,
  `recipe_id` INT,
  CONSTRAINT cookbook_recipe_fk_cookbook FOREIGN KEY (cookbook_id) REFERENCES cookbook(cookbook_id) ON DELETE CASCADE,
  CONSTRAINT cookbook_recipe_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE
);

CREATE TABLE `recipe_diet` (
  `recipe_diet_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `diet_id` INT,
  CONSTRAINT recipe_diet_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE,
  CONSTRAINT recipe_diet_fk_diet FOREIGN KEY (diet_id) REFERENCES diet(diet_id) ON DELETE CASCADE
);

CREATE TABLE `recipe_style` (
  `recipe_style_id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `style_id` INT,
  CONSTRAINT recipe_style_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(recipe_id) ON DELETE CASCADE,
  CONSTRAINT recipe_style_fk_style FOREIGN KEY (style_id) REFERENCES style(style_id) ON DELETE CASCADE
);

-- INSERT TESTING TABLE DATA
INSERT INTO user(user_id, username, user_email_address, user_first_name, user_last_name)
VALUES (1, 'testinguser', 'test@testing.com', 'Jane', 'Doe');
