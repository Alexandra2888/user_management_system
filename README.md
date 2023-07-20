# User Management System

This is a simple user management system built with PHP and MySQL. It allows users to register, login, view their profile, edit their profile, and delete their account.

# Repo:

https://github.com/Alexandra2888/user_management_system

## Features

- User Registration: New users can create an account by providing a unique username, password, full name, email, age, and bio.

- User Login: Registered users can log in using their username and password to access their profile.

- Profile Management: Users can view their profile information, including their full name, email, age, and bio. They can also edit their profile to update this information.

- Account Deletion: Users have the option to delete their account, which permanently removes their profile and associated data.

## Installation

1. Clone the repository or download the project files.

2. Configure the database settings by updating the `connect.php` file with your MySQL server details.

3. Create the necessary database tables by executing the SQL queries provided in the `database.sql` file. Make sure to use the InnoDB storage engine for better referential integrity.

4. Ensure that you have PHP and a compatible web server (e.g., Apache) installed on your machine.

5. Copy the project files to your web server's document root directory.

6. Access the application in your web browser by visiting the appropriate URL.

## Usage

1. Register a new user by providing the required information on the registration page.

2. Log in with your registered username and password on the login page.

3. Once logged in, you will be redirected to your profile page, where you can view and edit your profile information.

4. To edit your profile, click on the "Edit Profile" button and make the desired changes. Click "Save" to update your profile.

5. If you wish to delete your account, click on the "Delete Account" button and confirm the deletion in the pop-up dialog. Please note that this action is irreversible.

## Dependencies

- PHP: Ensure that you have PHP installed on your server. The minimum required version may vary based on your setup.

- MySQL: You will need a MySQL server to store user and profile data. Make sure you have a compatible version installed.



