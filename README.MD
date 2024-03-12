# User Management System

## Objective

This project aims to create a secure and robust web application for managing user accounts. Users can register, log in, view their profiles, edit information, and (for authorized administrators) delete accounts.

## Technical Specifications

- **Backend Framework:** Laravel (compatible with PHP 8.1+)
- **Frontend Framework:** Vue.js with Vuetify
- **Database:** MySQL or SQLite (your choice)
- **Authentication:** JWT (JSON Web Tokens) for secure session management
- **Testing Framework:** PHPUnit or PEST (for Laravel unit and feature testing)

## Requirements

### API Development:

Design and implement RESTful APIs for core user management functionalities:

- Create (user registration)
- Read (user profile retrieval)
- Update (user profile editing)
- Delete (user deletion - for administrators)

Utilize Laravel to build these APIs, adhering to a Test-Driven Development (TDD) approach for thorough testing. Ensure API endpoints are secure and accessible only to authenticated users with proper authorization checks.

### Frontend Development:

Develop the user interface using Vue.js for a dynamic and interactive experience. Leverage Vuetify for sleek and efficient UI components. Implement a login page that allows users to authenticate seamlessly through the API. Design a dashboard accessible to authenticated users, featuring functionalities for:

- Viewing a list of users (for administrators)
- Creating new user accounts
- Editing existing user profiles
- Deleting user accounts (for administrators with appropriate permissions)

Implement data validation on both the front end (Vue.js) and back end (Laravel) to maintain data integrity and prevent invalid inputs.

### Authentication:

Implement a secure login mechanism for user authentication. Leverage JWTs (JSON Web Tokens) to manage user sessions and protect API routes by requiring valid tokens for access.

### Testing:

Write comprehensive unit and feature tests using PHPUnit or PEST to ensure the stability and reliability of your application. Conduct tests covering:

- API endpoints for each user management action
- Authentication mechanisms and JWT handling
- User interactions on the front end (Vue.js components)

## Getting Started

### Prerequisites:

- Ensure you have PHP 8.1 or above and Composer installed on your development machine.
- Download and install a Node.js version compatible with Vue.js (refer to official documentation).

### Clone the Repository:

```bash
git clone https://github.com/juperameza/user-managment-app
```

**Use the code with caution.**

## Set up the Project:

1. Navigate to the project directory: `cd user-management-system`
2. Install Laravel dependencies using Composer: `composer install`
3. Generate an application key: `php artisan key:generate`
4. Set up your database by configuring the `.env` file according to your chosen database (MySQL or SQLite) and credentials.
5. Create and migrate the database tables: `php artisan migrate`

## Run the Application:

1. Start the Laravel development server: `php artisan serve`
2. Access the application in your browser: `http://localhost:8000` (or the port specified in `.env`)

## Frontend Development (Vue.js):

1. Navigate to the `resources/js` directory.
2. Install Vue.js and Vuetify dependencies using npm or yarn: `npm install` (or `yarn install`)
3. Follow Vue.js and Vuetify documentation to set up your front-end development workflow (compiling components, etc.).

## Additional Notes:

- This README serves as a high-level overview. Refer to the project's code for specific implementation details.
- Consider implementing additional security best practices, such as input sanitization and password hashing.
- Unit and feature test examples might be provided within the codebase depending on your chosen testing framework.
- For further assistance or questions, feel free to contribute to this project on GitHub or reach out to the maintainers.
