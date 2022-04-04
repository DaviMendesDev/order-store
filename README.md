
# .env File
You may copy/paste the `.env.example` file to a new `.env` file and everything should work fine

# Commands:

First, you need to build the Docker container, you must run the following command:

```
$ docker compose up -d
```

This command will run `$ composer install`, `$ npm install` and `$ npm run dev` for you from `Dockerfile` steps, so you don't need to run it twice.

After you will need to run the migrations to set up the database:

(<b>Notice: To run migrations, and any database artisan service, you first need to set up properly your `.env` file. To set up your `.env` file properly, please see the [.env](#env-file) section</b>)
```
$ docker exec order-store php artisan migrate:fresh
```

Finally, all that you need to do now is run the schedule (it's like a CRON job locally), to do this you will need to run the artisan's command below:

```
$ docker exec order-store php artisan schedule:work
```

That's all folks, if you got any error message, please contact-me :D.


# Testing
To run all tests you need to type the following command:

```
$ docker exec order-store php artisan test
```
