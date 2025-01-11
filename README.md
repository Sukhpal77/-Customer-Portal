# Customer Portal API

## Overview
The **Customer Portal API** is a backend service built with **Laravel** for managing customer profiles and handling user authentication. It supports features like login, user registration, password management, and Multi-Factor Authentication (MFA). The API ensures secure communication using JWT tokens for authentication.

## Technologies Used
- **Laravel** (PHP Framework)
- **Laravel Passport** for API Authentication (JWT)
- **MySQL** for database management
- **PHPUnit** for testing
- **Swagger UI** for interactive API documentation

## Clone and Setup

To set up the Customer Portal API locally, follow these steps:

### 1. Clone the Repository
Clone the repository to your local machine:

    ```bash
    git clone https://github.com/your-username/customer-portal-api.git


### 2.Install Dependencies
Navigate to the project directory and install the required dependencies:

    ```bash
    cd customer-portal-api
    composer install
    npm install
### 3. Set up .env File
Copy the example environment file and configure your environment settings:

    ```bash
    cp .env.example .env
Now, open the .env file and update the following configurations:

### Database Configuration:
Set up your MySQL database details:

env

Copy code
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=customer_portal
DB_USERNAME=root
DB_PASSWORD=your_database_password
    
### Email Configuration:
Configure email settings to send emails for password resets and other notifications:

 env
Copy code
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

Note: You can replace MAIL_HOST, MAIL_USERNAME, and MAIL_PASSWORD with the credentials from your email service provider (e.g., Mailgun, SendGrid, etc.).

### 4. Generate Application Key
Generate the application key for Laravel:

    php artisan key:generate
    
### 5. Generate Client Personal Key (Laravel Passport)
If you're using Laravel Passport for API authentication, you need to generate the personal access client key:

    php artisan passport:install
This command will generate the required keys for Passport authentication and create the client ID and secret used for authentication.

### 6. Set up Database
Make sure the database is correctly set up in your .env file, then run the migrations to set up the database schema:

    php artisan migrate
    
### 7. Update Composer Dependencies
Update your Composer dependencies to ensure you have the latest versions of the packages:

    composer update
    
### 8. Run the Application
Start the Laravel development server:

        php artisan serve
The API will be available at http://localhost:8000.

### API Endpoints
        Authentication API
        POST /login
        POST /register
        POST /verify-mfa
        POST /forgot-password
        POST /reset-password
        Customer Management API
        GET /customers
        POST /customers
        GET /customers/{id}
        PUT /customers/{id}
        DELETE /customers/{id}
        POST /logout
        Testing
To ensure API reliability, unit tests are written using PHPUnit. To run the tests, use the following command:

       php artisan test

Swagger UI Documentation
Access the interactive API documentation via Swagger UI at:

    http://localhost/api/documentation

License

    This project is licensed under the MIT License - see the LICENSE file for details.

