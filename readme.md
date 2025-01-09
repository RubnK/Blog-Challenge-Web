# Blog Challenge Web

**Authors : [@RubnK](https://github.com/RubnK), [@yayou05](https://github.com/yayou05), [@len233](https://github.com/len233), [@skuullking](https://github.com/skuullking)**

This project is a PHP-based web blog application that allows users to:

- Register and login
- Create, edit, and delete posts
- Browse posts from other users

The codebase utilizes PHP for backend logic and CSS for styling.

## Table of content

- [Installation](#installation)
- [Database Setup](#database-setup)
- [Running the application](#running-the-application)
- [Directory Structure](#directory-structure)
- [License](#license)

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/RubnK/Blog-Challenge-Web.git
    cd Blog-Challenge-Web
    ```

2. Install the dependencies using Composer:
    ```sh
    composer install
    ```
    
## Database Setup

1. Create a PostgreSQL database named `blog`:
    ```sql
    CREATE DATABASE blog;
    ```

2. Insert the `bdd.sql` file in the `blog` database

## Running the Application

Start the PHP built-in server:
```sh
php -S localhost:5001 -t public
```

Visit `http://localhost:5001` in your web browser to see the application.

## Directory Structure

- `public/` : Contains the entry point of the application.
- `src/` : Contains the source code of the application.
- `vendor/` : Contains the Composer dependencies.

## License

This project is licensed under the MIT License.
