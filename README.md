# Customer Portal

## Overview
The **Customer Portal** is a backend service built with **Laravel** for managing customer profiles and handling user authentication. It supports features like login, user registration, password management, and Multi-Factor Authentication (MFA). The API ensures secure communication using JWT tokens for authentication.

This service is containerized using Docker to ensure a consistent and portable development environment. The application runs in isolated containers, making it easy to set up and deploy across various environments.

## Technologies Used
- **Laravel** (PHP Framework)
- **Laravel Passport** for API Authentication (JWT)
- **MySQL** for database management
- **PHPUnit** for testing
- **Swagger UI** for interactive API documentation
- **Dockerized** Setup for Easy Deployment

## Clone and Setup

### 1. Clone the Repository
Clone the repository to your local machine:

    git clone [https://github.com/your-username/Customer-Portal.git](https://github.com/Sukhpal77/Customer-Portal.git

### 2.Navigate to the project directory:

    cd Customer-Portal

### Database Configuration:
Set up your MySQL database details:

env

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=customer_portal
    DB_USERNAME=root
    DB_PASSWORD=your_database_password
    
### Email Configuration:
Configure email settings to send emails for password resets and other notifications:

 env
 
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=your_mailtrap_username
    MAIL_PASSWORD=your_mailtrap_password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS=noreply@yourdomain.com
    MAIL_FROM_NAME="${APP_NAME}"

Note: You can replace MAIL_HOST, MAIL_USERNAME, and MAIL_PASSWORD with the credentials from your email service provider (e.g., Mailgun, SendGrid, etc.).

## Docker Setup:

### 4. Start Docker Containers:

    docker-compose up -d
  This command starts your Docker containers defined in docker-compose.yml file in detached mode (-d).  
    
### 5. Migrate Database:

    docker-compose exec laravel.test php artisan migrate
Use this command to run migrations and set up the database schema. Replace laravel.test with your Laravel service name defined in your docker-compose.yml file if it's different.

### 6. Install Passport Client Keys (if needed):

    docker-compose exec laravel.test php artisan passport:client --personal --no-interaction
  This command generates the necessary keys for Laravel Passport if you're using it for API authentication. It creates the client ID and secret used for authentication. Replace laravel.test with your 
  Laravel service name as needed.


### 7. Access the API
  Once the containers are up and running, the API will be available at:
   
    http://localhost:80.
![Screenshot 2025-01-12 160110](https://github.com/user-attachments/assets/58ec349a-81a1-427e-b29b-3c8b24475cbf)
    
### 8. API Endpoints
   - Authentication API
     - POST /login
     - POST /register
     - POST /verify-mfa
     - POST /forgot-password
     - POST /reset-password
  - Customer Management API
    - GET /customers
    - POST /customers
    - GET /customers/{id}
    - PUT /customers/{id}
    - DELETE /customers/{id}
    - POST /logout
    
## To ensure API reliability, unit tests are written using PHPUnit. To run the tests, use the following command:

    docker-compose exec laravel.test php artisan test
![Screenshot 2025-01-12 171412](https://github.com/user-attachments/assets/a937d3e9-3e34-4705-9bd8-e0a5b6d85b18)

## Swagger UI Documentation

Access the interactive API documentation via Swagger UI at:

    http://localhost/api/documentation
![Screenshot 2025-01-12 160053](https://github.com/user-attachments/assets/005451e6-daf6-4209-9be8-20d1227c7fe8)   

### License

- This project is licensed under the MIT License - see the LICENSE file for details.

