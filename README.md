# PHP Test Optimy

This is a PHP application built for testing purposes. It utilizes the Slim framework for routing and PSR-7 compliant HTTP message handling.

## Installation

1. Clone the repository to your local machine:

   ```bash
   git clone <repository_url>
   ```

2. Navigate to the project directory:

   ```bash
   cd PHP_Test_Optimy
   ```

3. Install dependencies using Composer:

   ```bash
   composer install
   ```

4. Set up environment variables:

   - Create a `.env` file in the project root.
   - Add the following environment variables to the `.env` file:

     ```plaintext
     DB_DSN=<your_database_dsn>
     DB_USER=<your_database_username>
     DB_PASSWORD=<your_database_password>
     ```

   Replace `<your_database_dsn>`, `<your_database_username>`, and `<your_database_password>` with your actual database connection details.

## Running Unit Tests

To run the unit tests for this project, execute the following command in the project root directory:

```bash
vendor/bin/phpunit
```

## Also you can access it using routes just uncomment the following line in index.php

## Usage

1. Start the PHP built-in server:

   ```bash
   php -S localhost:8000 -t public
   ```

2. Access the application in your web browser at `http://localhost:8000`.

## Routes

- `/news`: List all news items.
- `/comments`: List all comments.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvement, feel free to open an issue or submit a pull request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
