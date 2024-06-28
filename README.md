# Class Marking Panel API

This is an API for class marking panels to manage their tasks, including managing students, managing tests, adding marks, and generating mark reports. This project was built for my pure mathematics sir, Gihan Chamindu's marking panel.

## Features

- **Authentication**: User login and registration.
- **Student Management**: Add, update, delete, and view students.
- **Invitation Management**: Send and manage invitations for users to join panels.
- **Panel Management**: Create and manage panels, add users to panels, and remove users from panels.
- **Center Management**: Create and manage centers where tests can be conducted.
- **Test Management**: Create and manage tests, add marks, and generate mark reports.

## Endpoints

### Public Routes

- `POST /login`: User login.
- `POST /register`: User registration.
- `GET /test`: Test endpoint.

### Protected Routes (Authenticated)

#### Authentication

- `POST /logout`: User logout.

#### Students

- `GET /students`: List all students. *(requires user level `a` or `m`)*
- `POST /students`: Add a new student. *(requires user level `a` or `m`)*
- `GET /students/{student}`: View a specific student.
- `PATCH /students/{student}`: Update a specific student. *(requires user level `a` or `m`)*
- `DELETE /students/{student}`: Delete a specific student. *(requires user level `a` or `m`)*

#### Invitations

- `GET /invitations`: List all invitations.
- `POST /invitations`: Send a new invitation. *(requires user level `a` or `m`)*
- `GET /invitations/{invitation}`: View a specific invitation.
- `DELETE /invitations/{invitation}`: Delete a specific invitation. *(requires user level `a` or `m`)*

#### Panels

- `GET /panels`: List all panels.
- `POST /panels`: Create a new panel. *(requires user level `a` or `m`)*
- `GET /panels/{panel}`: View a specific panel. *(requires user access to the panel)*
- `PATCH /panels/{panel}`: Update a specific panel. *(requires user level `a` or `m` and user access to the panel)*
- `DELETE /panels/{panel}`: Delete a specific panel. *(requires user level `a` or `m` and user access to the panel)*
- `GET /panels/{panel}/users`: List all users in a panel.
- `POST /panels/{panel}/users`: Add a user to a panel. *(requires user level `a`, `m`, or `l` and user access to the panel)*
- `DELETE /panels/{panel}/users/{user}`: Remove a user from a panel. *(requires user level `a`, `m`, or `l` and user access to the panel)*

#### Centers

- `GET /centers`: List all centers.
- `POST /centers`: Create a new center. *(requires user level `a` or `m`)*
- `GET /centers/{center}`: View a specific center. *(requires user access to the center)*
- `PATCH /centers/{center}`: Update a specific center. *(requires user level `a` or `m` and user access to the center)*
- `DELETE /centers/{center}`: Delete a specific center. *(requires user level `a` or `m` and user access to the center)*

#### Tests

- `GET /centers/{center}/tests`: List all tests in a center. *(requires user access to the center)*
- `POST /centers/{center}/tests`: Create a new test. *(requires user level `a`, `m`, or `l` and user access to the center)*
- `GET /centers/{center}/tests/{test}`: View a specific test. *(requires user access to the test and the center)*
- `DELETE /centers/{center}/tests/{test}`: Delete a specific test. *(requires user level `a`, `m`, or `l` and user access to the test and the center)*
- `GET /centers/{center}/tests/{test}/report`: Download the public marks report for a test.
- `GET /centers/{center}/tests/{test}/marks`: List all marks for a test. *(requires user level `a`, `m`, or `l` and user access to the test and the center)*
- `GET /centers/{center}/tests/{test}/marks/my`: View the marks for the current user.
- `POST /centers/{center}/tests/{test}/marks`: Add marks to a test.
- `GET /centers/{center}/tests/{test}/marks/of/{student}`: View a specific student's marks for a test.
- `DELETE /centers/{center}/tests/{test}/marks/of/{student}`: Delete a specific student's marks for a test.

## Middleware

- **auth:sanctum**: Ensures the user is authenticated.
- **checkUserLevel**: Ensures the user has the appropriate level (`a` for admin, `m` for manager, `l` for leader).
- **checkUserAccessTo**: Ensures the user has access to the specified resource (e.g., panel, center).
- **checkHasRelation**: Ensures the specified relationship exists between resources (e.g., test and center).

## Installation

1. Clone the repository.
2. Run `composer install`.
3. Set up your `.env` file.
4. Run `php artisan migrate` to set up the database.
5. Run `php artisan serve` to start the development server.

## Contributing

Feel free to submit issues and pull requests. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](LICENSE)
