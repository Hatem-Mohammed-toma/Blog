# BlogDB

BlogDB is a simple blog application that allows users to register, log in, and manage blog posts. The application is built using PHP and MySQL.

## Features

- User registration and login
- User roles (admin and user)
- Create, edit, view, and delete blog posts
- Authentication and authorization

## Database Schema

The application uses a MySQL database with the following schema:

```sql
CREATE DATABASE BlogDB COLLATE utf8mb4_unicode_ci;

USE BlogDB;

CREATE TABLE users (
    id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(64) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at DATETIME NOT NULL DEFAULT NOW(),
    PRIMARY KEY(id)
);

CREATE TABLE posts(
    `id` int unsigned  auto_increment PRIMARY KEY,
    `title` varchar(255) not null,
    `content` text not null,
    `created_at` datetime default now()
);
```
