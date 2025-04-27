# Task Management App API

**Author:** Tauseef Ahamed  
**Email:** tauseef.offl@gmail.com  
**Portfolio:** [tauseef-ahamed.vercel.app](https://tauseef-ahamed.vercel.app/)  
**Stack:** Laravel 12, PHP 8.3, MySQL 8, Redis, Mailhog  
**Version:** v1

## Overview

This is a Task Management API built with Laravel 12, using a MySQL database, Redis caching, and Mailhog for mail testing. The application provides functionality for user authentication, task management, and more.

## Setup Instructions

### Prerequisites

- Docker
- Docker Compose

### Docker Setup

1. Clone this repository to your local machine:
    ```bash
    git clone <repository_url>
    cd <repository_directory>
    ```

2. Build and start the application containers using Docker Compose:
    ```bash
    docker-compose up --build
    ```

3. The application will be accessible at:
    - **Application URL:** [http://localhost:8000](http://localhost:8000)
    - **Swagger API Documentation URL:** [http://localhost:5000/](http://localhost:5000/)
    - **PhpMyAdmin URL:** [http://localhost:8080/](http://localhost:8080/)  
      DB Username/Password: `root/root`
    - **Mailhog URL:** [http://localhost:8025/](http://localhost:8025/)

### Environment Variables

The application uses environment variables for configuration. They are already set in the `.env` file, but you can adjust them as needed for your local or production environment.

## Running the Application

After starting the containers with `docker-compose up --build`, the application will be up and running at `http://localhost:8000`.

## API Documentation

You can access the Swagger API documentation at the following URL:  
[http://localhost:5000/](http://localhost:5000/)

## PhpMyAdmin

You can access PhpMyAdmin for database management at:  
[http://localhost:8080/](http://localhost:8080/)  
**DB Credentials:**  
- Username: `root`
- Password: `root`

## Mailhog

Mailhog is used to capture outgoing emails for testing purposes. You can access it at:  
[http://localhost:8025/](http://localhost:8025/)

## Testing

To run tests, use the following command:
```bash
docker-compose exec php artisan test
```

feature specific test commands:

for Auth: 
```bash
docker-compose exec php artisan test --testsuite=Auth
```

for Tasks: 
```bash
docker-compose exec php artisan test --testsuite=Tasks
```
