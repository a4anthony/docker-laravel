<p align="center"><img src="https://www.melamartonline.com/images/logo-200.png" width="150" class="img-fluid"></p>

# MelaMart Store

MelaMart is an online grocery store

## Prerequisites

1. php ^v7.4\* (installed globally)
   
2. Composer (installed globally)
   
3. For mac, [laravel valet](https://laravel.com/docs/7.x/valet)
   
4. For windows, [laragon](https://laragon.org/download/index.html)

## Installation

1. Clone this repository from the develop-branch or a create a branch off the develop-branch and clone it to your local computer.
  
2. Rename the env.example file to .env and set the environment to match your local computer.
 
   \*Most importantly, the database configurations.

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    ```
3. In the project directoy, run
   
   ```
   composer install
   ```

4. Run the following command to install composer, generate app key, make migrations and database seeding

    ```
    php artisan project:up
    ```
    This may take about 15 - 20mins to complete :)

5. Enable ssl or tls to secure the site.(optional)

   For valet users, run in the parent directory of the project

    ```
    valet secure [project folder]
    ```
   For windows, you can enable it through the laragon terminal

## Notes
1. Dummy users in the database have a default password set to password
   
2. Every single line of code(including those that have been commented out) is important
   
3. Every pull request to the master branch has to be reviewed by a team member
   
## Features

1. Admin dashboard for managing products
   
2. Api ports for mobile development
   
3. Zoho mail intergration
   
4. Google maps intergration
   
5. Paystack Integration
   
6. Dynamic customer cart system
   
7. Routing for api and admin subdomains

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
