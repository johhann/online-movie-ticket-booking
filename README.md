# Online Movie Ticket Booking API

Online Movie Ticket Booking API is a RESTful API that provides endpoints for managing movie ticket bookings. It allows clients to perform various operations, such as retrieving movies, screening schedules, and booking tickets.

## Features

- User Registration and Authentication: Users can create an account and authenticate themselves to access the booking functionality.

- Movie Listing: The API provides endpoints to retrieve a list of available movies, including their titles, genres, descriptions, and ratings.

- Screening Schedules: Clients can retrieve the schedules for movie screenings, including the screen, date and time, and available seats.

- Booking Tickets: Clients can book tickets for a specific movie screening and select the desired number of seats.

## Technologies Used

- Laravel: A PHP framework used for developing the API.
- MySQL: A relational database management system used for storing application data.

## Installation

1. Clone the repository:

   ```bash
   git clone <repository-url>
2. Install the dependencies:

    ```bash
    composer install
3. Create a new MySQL database for the application.

4. Rename the .env.example file to .env and update the database connection details.

5. Generate an application key:
    ```bash
    php artisan key:generate
6. Run the database migrations:

    ```bash
    php artisan migrate
7. Start the development server:

    ```bash
    php artisan serve
## API Endpoints
### Authentication Endpoints
- POST /api/users: Register a new user account.
- POST /api/login: Log in and retrieve an authentication token.
- GET /api/logout: Log in and retrieve an authentication token.

### User Endpoints

- **GET /api/users**: Retrieve a list of all users.
- **GET /api/users/{id}**: Retrieve a specific user by ID.
- **POST /api/users**: Create a new user.
- **PUT /api/users/{id}**: Update a specific user by ID.
- **DELETE /api/users/{id}**: Delete a specific user by ID.

### Movie Endpoints

- **GET /api/movies**: Retrieve a list of available movies.
- **GET /api/movies/{id}**: Retrieve a specific movie by ID.
- **POST /api/movies**: Create a new movie.
- **PUT /api/movies/{id}**: Update a specific movie by ID.
- **DELETE /api/movies/{id}**: Delete a specific movie by ID.

### Screening Endpoints

- **GET /api/screenings**: Retrieve a list of available screening schedules.
- **GET /api/screenings/{id}**: Retrieve a specific screening schedule by ID.
- **POST /api/screenings**: Create a new screening schedule.
- **PUT /api/screenings/{id}**: Update a specific screening schedule by ID.
- **DELETE /api/screenings/{id}**: Delete a specific screening schedule by ID.

### Booking Endpoints

- **GET /api/bookings**: Retrieve a list of user bookings.
- **GET /api/bookings/{id}**: Retrieve a specific booking by ID.
- **POST /api/bookings**: Book tickets for a specific screening.
- **PUT /api/bookings/{id}**: Update a specific booking by ID.
- **DELETE /api/bookings/{id}**: Delete a specific booking by ID.

Please refer to the API documentation for detailed information on request and response formats for each endpoint.

## Contributing
Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request.

## License
This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
