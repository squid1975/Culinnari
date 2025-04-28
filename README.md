![image](https://github.com/user-attachments/assets/5cd7f070-de7c-4508-9fb2-919ec3c06fa3)

# Culinnari
Culinnari is a recipe-sharing platform created as part of my Capstone Project using a combination of HTML, CSS, JavaScript, PHP, and MySQL. The goal of this project was to create a simple platform that focuses on the food itself, rather than requiring users to read through the recipe author's life story. This was my first code-only web development project.

## Features
- User authentication (login/signup/logout)
- Search recipes by categories, total time, recipe name/description, recipe difficulty. 
- Sort recipe searches by post date, name, or rating value.
- Responsive design (400px - 1300px) 

- **Members Only** 
    - Create a cookbook and save recipes into your cookbook
    - Remove recipes from cookbook
    - Create and delete recipes
    - Rate recipes 


## Tech Stack
- Backend: PHP (OOP), MySQL
- Frontend: HTML, CSS, JavaScript (Vanilla)
- Database: MySQL
- Other Tools: dbdiagram.io (ERD/schema design)

## Image and Media Sources
All images used in this project were either created by me, my husband, or sourced from free Image platforms. 
Images uploaded by users are stored in the images/uploads/recipe_image/ directory. For a complete list of media sources, please reference /assets/media_sources/. 

## Installation
1. **Clone the repository**
   ```` bash
   git clone https://github.com/squid1975/Culinnari.git
2. **Import the database**
- Open your database management tool (phpMyAdmin)
- Create a new database if one does not exist
- Import the provided .sql file into the newly created database

3. **Configure the database connection**
- Update the database credentials in /private/initialize.php. 
    - define('DB_SERVER', 'localhost');  // The server hosting the database
    - define('DB_USER', 'root');         // Your database username
    - define('DB_PASSWORD', 'password'); // Your database password
    - define('DB_NAME', 'your_db_name'); // The name of your database

4. **Set up server environment**
- Make sure you're running a local server (ex: XAMPP, MAMP, WAMP) and that PHP is enabled, installed, and running. Check by visiting localhost in your browser and ensure the server is working. I used [Laragon](https://laragon.org/) for this project. 
- Once the server environment is set up, place the project folder in the htdocs directory (for XAMPP) or the equivalent for your server (e.g. www for MAMP, www for Laragon)
- Start the local server (Apache and MySQL) and navigate to http://localhost/ followed by the folder name of the project (http://localhost/Culinnari/)

## Project Structure
- Public: Publicly available files (css, js, images, members only pages, admin only pages)
- Private: Backend and sensitive files (initialization, database connection)

## TODO/ Future Improvements
- [ ] Edit recipe functionality 
- [ ] Add user profile customization (profile picture, user info)
- [ ] Implement comment system for recipes
- [ ] Dark mode toggle
- [ ] Support multiple image uploads per recipe
- [ ] Manage multiple cookbooks 
- [ ] Diet icon uploads (Admin Area)

## Contributing
Interested in contributing or offering suggestions? Open an issue or submit a pull request. For questions, email sydneyrfarrington@gmail.com.

## License
MIT License - See LICENSE 

## Inspiration 
Culinnari was created as part of my Capstone project for AB Tech to complete my Associates in Web & Software Development. This project was intended to blend my interest in baking/food with web development. 

## Contact/Support
For bug reports / questions, please contact sydneyrfarrington@gmail.com.

## Acknowledgements
A huge thank you to Alec for pushing me into this program.
Thank you to Charlie for always being kind and an amazing teacher. 
To my classmates, husband, and friends who sat through multiple usability tests and contributed their own ideas to this project, I'm grateful for you. 

