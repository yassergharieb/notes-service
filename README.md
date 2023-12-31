# Notes Service

This repository contains the Notes Service, which provides CRUD operations for the notes table. The service is structured based on the repository design pattern and service architecture.

## Installation

Follow the steps below to install and run the Notes Service:

1. Clone the repository:
   ````
   git clone https://github.com/yassergharieb/notes-service.git
   ```

2. Copy the `.env.example` file to `.env`.

3. Build and run the Docker containers:
   ````
   docker-compose build && docker-compose up -d
   ```

4. Install the required dependencies using Composer:
   ````
   composer install
   ```

5. Start the service:
   ````
   php artisan serve
   ```

## Authentication

To access the service's operations, you need to provide a JWT token in the request headers. This token should be obtained from the User service. Without a valid token, you will receive an "unauthenticated" error message.

## Documentation

For detailed information about each endpoint and its usage, refer to the documentation available in this [Postman collection](https://cloudy-crescent-992810.postman.co/workspace/postsapis~184a5ce4-531e-48c2-a3f0-835f88f12071/collection/21307103-925811b9-3379-4fbc-992f-6072d75624fc?action=share&creator=21307103).

Please refer to the documentation for a complete understanding of the service's capabilities and how to interact with it.

