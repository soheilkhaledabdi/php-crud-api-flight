## PHP CRUD API with Flight Framework

### Description

This project is a simple CRUD API built using the [Flight PHP framework](https://docs.flightphp.com/). It provides a basic structure to quickly set up a PHP application with CRUD operations and database connectivity.

### Features

- Lightweight and fast setup with Flight framework.
- Basic CRUD (Create, Read, Update, Delete) operations.
- Configurable database connection.
- Suitable for development with Apache, Nginx, or PHP's built-in server.

### Prerequisites

Before you begin, ensure you have the following installed on your machine:

- PHP 7.4 or higher
- A web server (Apache, Nginx, or PHP's built-in server)
- Composer (for dependency management)
- A MySQL or MariaDB database server

### Installation

Follow these steps to set up the project:

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/soheilkhaledabdi/php-crud-api-flight.git
   cd php-crud-api-flight
   ```

2. **Install Dependencies:**

   Install the Flight framework and other dependencies using Composer:

   ```bash
   composer install
   ```

3. **Configure the Database:**

   Update your database connection settings in `config/database.php`. 

   Open the file and edit the following lines with your database credentials:

   ```php
   return [
    'host' => 'your_database_host',
    'database' => 'your_database_name',
    'username' => 'your_database_username',
    'password' => 'your_database_password',
    'charset' => 'utf8mb4'
   ];
   ```

4. **Set Up a Web Server:**

   You can use Apache, Nginx, or PHP’s built-in server to run the project. Choose one of the following options:

   - **Using PHP’s Built-In Server:**

     Navigate to the `public` directory and start the PHP server:

     ```bash
     cd public
     php -S localhost:8000
     ```

     Now, open your web browser and visit `http://localhost:8000`.

   - **Using Apache or Nginx:**

     Set the document root to the `public` directory of the project. Configure the server to point to `public/index.php`.

     For Apache, you might set up a virtual host like this:

     ```apache
     <VirtualHost *:80>
         ServerName yoursite.local
         DocumentRoot /path/to/php-crud-api-flight/public
         <Directory /path/to/php-crud-api-flight/public>
             AllowOverride All
             Require all granted
         </Directory>
     </VirtualHost>
     ```

     For Nginx, your server block might look like this:

     ```nginx
     server {
         listen 80;
         server_name yoursite.local;
         root /path/to/php-crud-api-flight/public;

         index index.php index.html index.htm;

         location / {
             try_files $uri $uri/ /index.php?$query_string;
         }

         location ~ \.php$ {
             include snippets/fastcgi-php.conf;
             fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
             fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
             include fastcgi_params;
         }
     }
     ```

6. **Testing the Application:**

   Once your server is set up, navigate to the URL configured (e.g., `http://localhost:8000` or `http://yoursite.local`) and test the CRUD functionality.

### Validation Package

We use the `php-smart-validator` package for validation. You can find more information and the source code at the following link:

https://github.com/geekGroveOfficial/php-smart-validator

### Contributing

If you wish to contribute to this project, please fork the repository, create a new branch for your feature or bug fix, and submit a pull request.

### License

This project is open-source and available under the [MIT License](LICENSE).
