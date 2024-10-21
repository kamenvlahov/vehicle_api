# Vehicle Management API

## Overview

This API allows for the management of vehicles, including retrieving a list of vehicles, viewing details of a specific vehicle, creating, updating, and deleting vehicles. The API is designed for use by administrators and utilizes JSON for data interchange.

## Installation

Follow these steps to set up the API on your local machine:

### Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** (version >= 8.0)
- **Composer** (dependency manager for PHP)
- **Symfony CLI** (Symfony command line tool)
- **MySQL** or another database of your choice

### Steps

1. **Clone the repository:**
    ```bash
    git clone https://github.com/your-repo.git
    cd your-repo
    ```

2. **Install dependencies:**
    ```bash
    composer install
    ```

3. **Configure environment variables:**
    - Copy the `.env` file to `.env.local`:
    ```bash
    cp .env .env.local
    ```
    - Update the `.env.local` file with your database credentials and other configuration options:
    ```dotenv
    # Example .env.local configuration
    DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
    JWT_SECRET_KEY=your_jwt_secret_key
    ```

4. **Create the database:**
    ```bash
    php bin/console doctrine:database:create
    ```

5. **Run migrations:**
    ```bash
    php bin/console doctrine:migrations:migrate
    ```

6. **Start the server:**
    ```bash
    symfony serve
    ```

7. **Access the API:**
    - Your API should now be running at `http://localhost:8000/api`.

### Testing

To run the unit tests, use the following command:

```bash
  ./vendor/bin/phpunit
 ```
## API endpoints

## Endpoints

### 1. Get User Profile

- **URL**: `/api/me`
- **Method**: `GET`
- **Authorization**: Bearer Token (JWT)
- **Description**: Retrieve the authenticated user’s profile information.
- **Responses**:
   - **200 OK**: Returns user details.
   - **401 Unauthorized**: If the user is not authenticated.

#### Example Request

```http
GET /api/me HTTP/1.1
Authorization: Bearer your_jwt_token
```
   ### 1. User Login
   - **URL: /login**
   - **Method: POST|OPTIONS**
    
   - **Request Body:
    email: User's email address (string, required)
    password: User's password (string, required)**
   - **Responses:
    200 OK: Returns the JWT token and user roles.
    401 Unauthorized: If the credentials are invalid.
    400 Bad Request: If the request is malformed.
    Example Request**
```
POST /login HTTP/1.1
Content-Type: application/json

{
"email": "user@example.com",
"password": "your_password"
}
```
### 2.  User Registration
- **URL: /register**
- Method: POST|OPTIONS
- Description: Register a new user account.
- Request Body:
  - email: User's email address (string, required)
  - password: User's password (string, required)
  - Responses:
    - 201 Created: User successfully registered with a JWT token.
    - 400 Bad Request: If the request is malformed or validation fails.
- Example Request
```
POST /register HTTP/1.1
Content-Type: application/json

{
    "email": "newuser@example.com",
    "password": "your_password"
}
```
### 3.  Get Followed Vehicles
- **URL: /api/follow/**
- Method: GET
- Description: Retrieve a list of vehicles that the authenticated user is following.
- Responses:
   - 200 OK: Returns a list of followed vehicles.
   - 401 Unauthorized: If the user is not authenticated
- Example Request
```
GET /api/follow/ HTTP/1.1
Authorization: Bearer your_jwt_token
```
### 4.  Follow a Vehicle
- **URL: /api/follow/{vehicleId}**
- Method: POST
- Authorization: Bearer Token (JWT)
- Description: Follow a vehicle by its ID.
- Responses:
  - 200 OK: Vehicle followed successfully.
  - 401 Unauthorized: If the user is not authenticated.
  - 404 Not Found: If the vehicle does not exist.
- Example Request
```
POST /api/follow/1 HTTP/1.1
Authorization: Bearer your_jwt_token
```
### 5.  Get All Vehicles
- **URL: /api/vehicle/**
- Method: GET
- Authorization: Bearer Token (JWT)
- Description: Retrieve a list of vehicles based on query parameters.
- Responses:
   - 200 OK: Returns a list of vehicles.
   - 401 Unauthorized: If the user is not authenticated.
- Example Request
```
GET /api/vehicle/ HTTP/1.1
Authorization: Bearer your_jwt_token
```
### 6.  Get Vehicle by ID
- **URL: /api/vehicle/{id}**
- Method: GET
- Authorization: Bearer Token (JWT)
- Description: Retrieve details of a specific vehicle by its ID.
- Responses:
   - 200 OK: Returns a list of vehicles.
   - 401 Unauthorized: If the user is not authenticated.
   - 404 Not Found: If the vehicle does not exist.
- Example Request
```
GET /api/vehicle/1 HTTP/1.1
Authorization: Bearer your_jwt_token
```
### 7.  Create Vehicle
- **URL: /api/vehicle/**
- Method: POST
- Authorization: Bearer Token (JWT)
- Description: Create a new vehicle.
- Responses:
   - 201 Created: Vehicle created successfully with ID.
   - 401 Unauthorized: If the user is not authenticated.
   - 400 Bad Request: If there is an error in the provided data.
- Example Request
```
POST /api/vehicle/ HTTP/1.1
Authorization: Bearer your_jwt_token
Content-Type: application/json

{
    "type": "motorcycle",
    "engineCapacity": 1.2,
    "color": "Black",
    "id": 2,
    "brand": "Harley Davidson",
    "model": "6801",
    "price": 100000,
    "quantity": 1
}
```