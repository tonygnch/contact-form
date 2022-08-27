# Atom interview task

This is an interview task.

You can see the result on this domain https://ganchev.click or by clicking [here](https://ganchev.click).

Receiving email messages from [admin@ganchev.click](mailto:admin@ganchev.click) - Notice that they may go to Spam folder.

---

## Local setup

To run the app on local environment:

1. Pull the project

2. Run composer

        composer install

4. Generate unique application key to encrypt Laravel sessions

        php artisan key:generate

5. Copy .env.example file to configure your app local name, database connection and mail server

6. Install npm dependencies

        npm install

7. Run the npm dev script
    
        npm run dev

---

## Tests

Tests can be executed by running this command.

        php artisan test --testsuite=Feature