-- CREATE DATABASE
DROP DATABASE IF EXISTS `culinnari`;
CREATE DATABASE IF NOT EXISTS `culinnari`
DEFAULT CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
USE `culinnari`;

-- CREATE TABLES
CREATE TABLE `user` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(15) UNIQUE,
  `user_email_address` VARCHAR(50) UNIQUE,
  `user_hash_password` TEXT,
  `user_first_name` VARCHAR(50),
  `user_last_name` VARCHAR(50),
  `user_create_account_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `user_role` ENUM('m', 'a','s') DEFAULT 'm',
  `user_is_active` BOOLEAN DEFAULT true
);

CREATE TABLE `recipe` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_name` VARCHAR(255),
  `recipe_description` TEXT,
  `recipe_total_servings` INT,
  `recipe_post_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `recipe_prep_time_seconds` INT,
  `recipe_cook_time_seconds` INT,
  `recipe_difficulty` ENUM('beginner','intermediate','advanced'),
  `user_id` INT NOT NULL,
  CONSTRAINT recipe_fk_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE `recipe_image` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_image` VARCHAR(255),
  `recipe_id` INT NOT NULL, 
  CONSTRAINT recipe_image_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(id) ON DELETE CASCADE
);

CREATE TABLE `recipe_video` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_video_url` VARCHAR(255),
  `recipe_id` INT,
  CONSTRAINT recipe_video_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(id) ON DELETE CASCADE
);

CREATE TABLE `rating` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT,
  `recipe_id` INT,
  `rating_value` DECIMAL(2,1) DEFAULT 0.0,
  `rating_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT rating_fk_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
  CONSTRAINT rating_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(id) ON DELETE CASCADE
);


CREATE TABLE `ingredient` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `ingredient_quantity` DECIMAL(5,2),
  `ingredient_measurement_name` ENUM('teaspoon', 'tablespoon','fluid ounce', 'cup', 'pint','quart','gallon','milliliter','liter','ounce','pound', 'n/a'),
  `ingredient_name` VARCHAR(255) NOT NULL,
  `ingredient_recipe_order` INT, 
  `recipe_id` INT NOT NULL,
  CONSTRAINT ingredient_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(id) ON DELETE CASCADE
);

CREATE TABLE `step` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `step_number` INT,
  `step_description` TEXT,
  CONSTRAINT step_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(id) ON DELETE CASCADE
);

CREATE TABLE `diet` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `diet_name` VARCHAR(50),
  `diet_icon_url` VARCHAR(255)
);

CREATE TABLE `meal_type` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `meal_type_name` VARCHAR(50)
);

CREATE TABLE `style` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `style_name` VARCHAR(50)
);

CREATE TABLE `recipe_meal_type` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `meal_type_id` INT,
  CONSTRAINT recipe_meal_type_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(id) ON DELETE CASCADE,
  CONSTRAINT recipe_meal_type_fk_meal_type FOREIGN KEY (meal_type_id) REFERENCES meal_type(id) ON DELETE CASCADE
);


CREATE TABLE `recipe_diet` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `diet_id` INT,
  CONSTRAINT recipe_diet_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(id) ON DELETE CASCADE,
  CONSTRAINT recipe_diet_fk_diet FOREIGN KEY (diet_id) REFERENCES diet(id) ON DELETE CASCADE
);

CREATE TABLE `recipe_style` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `recipe_id` INT,
  `style_id` INT,
  CONSTRAINT recipe_style_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(id) ON DELETE CASCADE,
  CONSTRAINT recipe_style_fk_style FOREIGN KEY (style_id) REFERENCES style(id) ON DELETE CASCADE
);

CREATE TABLE `cookbook` (
  `id` INT  PRIMARY KEY AUTO_INCREMENT,
  `cookbook_name` VARCHAR(50),
  `user_id` INT,
  CONSTRAINT cookbook_fk_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

CREATE TABLE `cookbook_recipe` (
  `id`  INT PRIMARY KEY AUTO_INCREMENT,
  `cookbook_id` INT,
  `recipe_id` INT,
  CONSTRAINT cookbook_recipe_fk_cookbook FOREIGN KEY (cookbook_id) REFERENCES cookbook(id) ON DELETE CASCADE,
  CONSTRAINT cookbook_recipe_fk_recipe FOREIGN KEY (recipe_id) REFERENCES recipe(id) ON DELETE CASCADE
);

INSERT INTO diet(diet_name, diet_icon_url)
VALUES ('Gluten-Free', 'images/icon/dietIcons/glutenFree.svg'),
       ('Keto', 'images/icon/dietIcons/keto.svg'),
       ('Low Carb', 'images/icon/dietIcons/lowCarb.svg'),
       ('Paleo', 'images/icon/dietIcons/paleo.svg'),
       ('Sugar-Free', 'images/icon/dietIcons/sugarFree.svg'),
       ('Vegan', 'images/icon/dietIcons/vegan.svg'),
       ('Vegetarian', 'images/icon/dietIcons/vegetarian.svg');

INSERT INTO meal_type(meal_type_name)
VALUES ('Appetizer'),
       ('Breakfast'),
       ('Brunch'),
       ('Dessert'),
       ('Dinner'),
       ('Lunch'),
       ('Snack');

INSERT INTO style(style_name)
VALUES ('Asian'),
       ('Caribbean'),
       ('Fusion'),
       ('Greek'),
       ('Italian'),
       ('Latin American'),
       ('Mediterranean'),
       ('Thai');

