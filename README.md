# Learn how to integrate PlanetScale with a sample Symfony application

This sample application demonstrates how to connect to a PlanetScale MySQL database, create and run migrations, seed the database, and display the data.

![Sample app homepage](https://i.imgur.com/UwFAzaR.png)

For the full tutorial, see the [Symfony PlanetScale documentation](https://docs.planetscale.com/tutorials/connect-symfony-app).

## Prerequisites

- [PHP](https://www.php.net/manual/en/install.php) &mdash; This tutorial uses `v8.1`
- [Composer](https://getcomposer.org/)
- A [free PlanetScale account](https://auth.planetscale.com/sign-up)
- [PlanetScale CLI](https://github.com/planetscale/cli) &mdash; You can also follow this tutorial using just the PlanetScale admin dashboard, but the CLI will make setup quicker. For dashboard instructions, see [the full tutorial](https://docs.planetscale.com/tutorials/connect-symfony-app).
- [The Symfony CLI](https://symfony.com/download)

## Set up the Symfony app

1. Clone the starter Symfony application:

```bash
git clone https://github.com/yemiwebby/symfony-planet.git
```

2. Navigate into the folder and install the dependencies:

```bash
cd symfony-planet
composer install
```

3. Copy the `.env` file into `.env.local`:

```bash
cp .env .env.local
```

As suggested by Symfony, the best practise is to create and use environment file that suite your current environment. In this case, using `.env.local` for local environment
is appropriate. Don't forget to use `.env` file once your application is ready for production.

4. Start the application:

```bash
symfony serve
```

View the application at [http://localhost:8000](http://localhost:8000).

![Sample app homepage](https://i.imgur.com/UwFAzaR.png)


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

> Note: `PASSWORD_NAME` represents the name of the username and password being generated. You can have multiple credentials for a branch, so this gives you a way to categorize them.

Take note of the values returned to you, as you won't be able to see them again.

2. Open the `.env.local` file in your Symfony app, find the database connection string shown below and comment it out:

```
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```

and replace it with:

```
DATABASE_URL="mysql://<USERNAME>:<PASSWORD>@<ACCESS HOST URL>:3306/<DATABASE_NAME>?serverVersion=5.7"
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


The connection uses port `3306` by default, but if that's being used, it will pick a random port. Make sure you paste in whatever port is returned in the terminal. You can leave `DB_USERNAME` and `DB_PASSWORD` blank.

Refresh your Symfony homepage and you should see the message that you're connected to your database!

## Run migrations and seeder

Now that you're connected, let's add some data to see it in action. 
The sample application comes with a migration file at `migrations/Version20220120102247.php` that will create `category` and `product` tables in the database. If by chance the migration file is missing,
issue the following command from the terminal to generate a new migration file:

```bash
 symfony console make:migration
```

There's also `src/DataFixtures/CategoryFixtures.php` and `src/DataFixtures/ProductFixtures.php` files that will add ten random categories and ecommerce products to the `category` and `product` tables respectively. Let's run those now.

1. Make sure your database connection has been established. You'll see the message "You are connected to your-database-name" on the [Symfony app homepage](http://localhost:8000/) if everything is configured properly.

2. In the root of the Symfony project, run the following to run migrations:

```bash
symfony console doctrine:migrations:migrate
```

You will get a message to confirm your action, just type "yes" and hit enter to proceed.

If you refresh your Symfony homepage at the moment you should see the message that you're connected to your database!

![Connected to the database](https://i.imgur.com/X9B7ruI.png)

3. Seed the database by running:

```bash
symfony console doctrine:fixtures:load
```

This will purge your database and load the random data into it.

4. Refresh your Symfony homepage, and you'll see a list of Ecommerce products and their category printed out.

![List of products page](https://i.imgur.com/pcoEfX2.png)

The `templates/product/index.html.twig` file pulls this data from the `product` table with the help of the `src/Controller/ProductController.php` file.

## Need help?

If you need further assistance, you can reach out to [PlanetScale's support team](https://www.planetscale.com/support), or join our [GitHub Discussion board](https://github.com/planetscale/beta/discussions) to see how others are using PlanetScale.
