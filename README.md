# Multi-Project Creator

This application allows you to create and manage multiple types of projects, including WordPress, Laravel, Google Chrome extensions, and Flutter applications.

## Installation

1. Clone this repository to your local machine:
   ```bash
   git clone https://github.com/yourusername/multi-project-creator.git
   ```

2. Move the project files to your web server's document root (e.g., `htdocs` for XAMPP).

3. Create a MySQL database named `wp` (if it doesn't exist already).

4. Update the database connection details in the following files if necessary:
   - `index.php`
   - `process.php`
   - `Laravel.php`
   - `Google.php`
   - `Flutter.php`
   - `delete_record.php`

5. Ensure that your web server (Apache) and MySQL are running.

6. Install Composer if you haven't already: https://getcomposer.org/download/

## Usage

1. Open your web browser and navigate to `http://localhost/multi-project-creator/index.php`.

2. Use the tabs to switch between different project types:
   - WordPress
   - Laravel
   - Google Chrome Extension
   - Flutter

3. Fill in the required information for each project type and click the corresponding "Create" button.

4. The application will create the project and display a success message with a link to access the newly created project.

5. Use the "Table" tab to view and manage all created projects.

### Creating a Laravel Project

1. Click on the "Laravel" tab.
2. Enter the site name, database name, and a brief explanation.
3. Click "Register a new Laravel website".
4. The system will:
   - Create a new Laravel project using Composer
   - Set up the database
   - Update the .env file
   - Run database migrations
   - Provide a link to the new project

## Dependencies

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server
- Composer
- jQuery 3.6.4
- Bootstrap 5.3.0

## Future Improvements

1. Implement user authentication and project ownership.
2. Add more project types (e.g., React, Vue.js, Node.js).
3. Improve error handling and user feedback.
4. Implement a more robust database schema for better project management.
5. Add project templates and customization options.
6. Implement a queue system for handling multiple project creations simultaneously.
7. Add support for different database systems (PostgreSQL, SQLite, etc.).
8. Implement a logging system for better debugging and monitoring.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)