# ExpenseTracker

The Expense Tracker application is designed to help individuals manage their finances efficiently by tracking income and expenses in a user-friendly interface. With its intuitive design and robust features, users can gain insights into their spending habits, set budgets, and achieve financial goals effectively.

## Features

-   User authentication
-   Social Login ( Facebook, Gmail )
-   Income management
-   Expense management
-   Set budget and Saving Goals
-   Category management
-   Event management with FullCalendar (Google Calendar)
-   Reporting and analytics
-   Income & Expense download (Excel, PDF)
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
make build
```

### Install dependencies

```sh
make composer install
```

### Generate application key

```sh
make key generate
```

### Run database migrations

```sh
make migrate
```

### Seed the database

```sh
make seed
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
make down
```

### Rebuilding the containers

If you make changes to the Dockerfile or `docker-compose.yml`, you may need to rebuild the containers:

```sh
make build
```

## Testing

To run the test suite, use the following command:

```sh
make test
```
