# Learn how to integrate PlanetScale with a sample Symfony application

This sample application demonstrates how to connect to a PlanetScale MySQL database, create and run migrations, seed the database, and display the data.

For the full tutorial, see the [Symfony PlanetScale documentation](https://docs.planetscale.com/tutorials/connect-symfony-app).

## Set up the Symfony app

1. Clone the starter Symfony application:

```bash
git clone git@github.com:planetscale/symfony-example.git
```

2. Navigate into the folder and install the dependencies:

```bash
cd symfony-example
composer install
```

3. Copy the `.env` file into `.env.local`:

```bash
cp .env .env.local
```

4. Start the application:

```bash
symfony serve
```

View the application at [http://localhost:8000](http://localhost:8000).


## Set up the database

1. Authenticate the CLI with the following command:

```bash
pscale auth login
```

2. Create a new database with a default `main` branch with the following command:

```bash
pscale database create <DATABASE_NAME> --region <REGION_SLUG>
```

This tutorial uses `symfony-example` for `DATABASE_NAME`, but you can use any name with lowercase, alphanumeric characters and dashes or underscores.

For `REGION_SLUG`, choose a region closest to you from the [available regions](/concepts/regions#available-regions) or leave it blank.

## Connect to the Symfony app

There are **two ways to connect** to PlanetScale:

- Using client certificates with the CLI
- With an auto-generated username and password

Both options are covered below.

### Connect with username and password

1. Create a username and password with the PlanetScale CLI by running:

```bash
pscale password create <DATABASE_NAME> <BRANCH_NAME> <PASSWORD_NAME>
```

> Note: `PASSWORD_NAME` represents the name of the username and password being generated.

Take note of the values returned to you, as you won't be able to see them again.

2. Open the `.env.local` file in your Symfony app, find the database connection string shown below and replace it with:

```
DATABASE_URL="mysql://<USERNAME>:<PASSWORD>@<ACCESS_HOST_URL>:3306/<DATABASE_NAME>?serverVersion=8.0"
```
Don't forget to replace the placeholders `<USERNAME>`, `<PASSWORD>`, `<ACCESS HOST URL>` and `<DATABASE_NAME>` with the appropriate values from the output above.

### Connect with client certificates

To connect with client certificates, you'll need the [PlanetScale CLI](https://github.com/planetscale/cli).

1. Open a connection by running the following:

```bash
pscale connect <DATABASE_NAME> <BRANCH_NAME>
```

The default branch is `main`.

2. A secure connection to your database will be established, and you'll see a local address you can use to connect to your application.

3. Open the `.env.local` file in your Symfony app and update it as follows:

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=
DATABASE_URL=${DB_HOST}:${DB_PORT}/${DB_NAME}?serverVersion=8.0
```

The connection uses port `3306` by default, but if that's being used, it will pick a random port. Make sure you paste in whatever port is returned in the terminal. You can leave `DB_USERNAME` and `DB_PASSWORD` blank.

Refresh your Symfony homepage and you should see the message that you're connected to your database!

## Run migrations and seeder

1. Make sure your database connection has been established. You'll see the message "You are connected to your-database-name" on the [Symfony app homepage](http://localhost:8000/) if everything is configured properly.

2. In the root of the Symfony project, run the following to run migrations:

```bash
symfony console doctrine:migrations:migrate
```

You will get a message to confirm your action, just type "yes" and hit enter to proceed.

3. Seed the database by running:

```bash
symfony console doctrine:fixtures:load
```

This will purge your database and load the random data into it.

4. Refresh your Symfony homepage, and you'll see a list of Ecommerce products and their category printed out.

## Need help?

If you need further assistance, you can reach out to [PlanetScale's support team](https://www.planetscale.com/support), or join our [GitHub Discussion board](https://github.com/planetscale/beta/discussions) to see how others are using PlanetScale.
