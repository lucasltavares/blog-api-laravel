# Blog API using Laravel

## Table of Contents

1. [Overview](#overview)
2. [Features](#features)
3. [Installation](#installation)
4. [API Endpoints](#api-endpoints)
5. [Authentication](#authentication)
6. [Roadmap](#roadmap)
7. [License](#license)

## Overview

This is a simple CRUD API for a blog built with Laravel. The API includes basic functionality for managing blog posts, user authentication using JWT, and more.

## Features

- **Post Management:** Create, Read, Update, and Delete blog posts.
- **User Authentication:** Secure endpoints using JWT (JSON Web Tokens).
- **Clean and Modular Code:** Well-organized codebase following Laravel best practices.

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/seu-usuario/nome-do-projeto.git
2. Install dependencies using Composer:
   ```bash
   composer install
3. Set up the .env file with your configuration, including database settings and JWT secret.
4. Run migrations:
   ```bash
   php artisan migrate 
5. Launch the server:
   ```bash
   php artisan serve
   
## API endpoints
- POST /api/register: Register a new user.
- POST /api/login: User login and JWT generation.
- GET /api/posts: Retrieve all blog posts.
- GET /api/posts/{id}: Retrieve a specific blog post.
- POST /api/posts: Create a new blog post.
- PUT /api/posts/{id}: Update an existing blog post.
- DELETE /api/posts/{id}: Delete a blog post.

## Authentication
To access protected routes, include the JWT token in the Authorization header:
 ```bash
 Authorization: Bearer your_token_here
```

## Roadmap
### Next Steps
- Implement categories for blog posts.
- Add user roles for different levels of access.
...
