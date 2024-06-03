# ExpenseTracker

The Expense Tracker application is designed to help individuals manage their finances efficiently by tracking income and expenses in a user-friendly interface. With its intuitive design and robust features, users can gain insights into their spending habits, set budgets, and achieve financial goals effectively.

## Features

-   User authentication
-   Social Login ( Facebook, Gmail )
-   Income management
-   Expense management
-   Category management
-   Event management
-   Reporting and analytics
-   Unit testing
-   Responsive design

## Requirements

-   Docker
-   Node JS (NPM)

## Installation

Follow these steps to set up the project locally using Docker.

### Clone the repository

```sh
git clone https://github.com/HtunMyat-GNext/ExpenseTracker.git
```

### Set up environment variables

Copy the example environment file and modify it as needed.

```sh
cp .env.example .env
```

### Build and start the containers

```sh
docker-compose up -d --build
```

### Install dependencies

```sh
docker-compose exec expense_tracker composer install
```

### Generate application key

```sh
docker-compose exec expense_tracker php artisan key:generate
```

### Run database migrations

```sh
docker-compose exec expense_tracker php artisan migrate
```

### Seed the database

```sh
docker-compose exec expense_tracker php artisan db:seed
```

### Install NPM in project directory
```sh
npm install
```

### And then, run 
```sh
npm run dev
```

### Demo User Email and Password

#### Email

```sh
test@example.com
```

#### Password

```sh
password
```

## Usage

Once the installation steps are complete, you can access the application at `http://localhost`.

### Stopping the application

To stop the running containers:

```sh
docker-compose down
```

### Rebuilding the containers

If you make changes to the Dockerfile or `docker-compose.yml`, you may need to rebuild the containers:

```sh
docker-compose up -d --build
```

## Testing

To run the test suite, use the following command:

```sh
docker-compose exec expense_tracker php artisan test
```
