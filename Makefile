# Build the Docker images and up
build:
	docker-compose up --build

# Start the Docker containers
up:
	docker-compose up

# Stop the Docker containers
down:
	docker-compose down

# Restart the Docker containers
restart: down up

# Run Composer Install commands
composer install:
	docker exec -it expense_tracker composer install

# Run Composer Update commands
composer update:
	docker exec -it expense_tracker composer update

# Run database migrations
migrate:
	docker exec -it expense_tracker php artisan migrate

# Seed the database
seed:
	docker exec -it expense_tracker php artisan db:seed

# Fresh and Seed
fresh seed:
	docker exec -it expense_tracker php artisan migrate:fresh --seed

# Generate key
key generate:
	docker exec -it expense_tracker php artisan key:generate

# Run test code
test:
	docker exec -it expense_tracker php artisan test