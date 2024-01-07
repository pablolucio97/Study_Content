# Defining Application Requirements and Business Rules

## Concepts

### Functional Requirements (RF)
These are the core functionalities that the application must provide. Examples:
- Should be possible to list all cars.
- Should be possible to register a new user.

### Non-Functional Requirements (RNF)
These are the technical specifications and technologies used to implement the functional requirements. Example:
- Must use Multer for user avatar uploads.

### Business Rules (RN)
These are the logical business rules that serve as conditions for the requirements. Examples:
- The user must be logged in to list cars.
- Should not be possible to register a new user with the same email or CPF.

## Example: Car Rental Application Requirements and Business Rules

### Car Registration
**RF**
- It should be possible to register a new car.

**RN**
- It should not be possible to register a car with an existing license plate.
- The car must be registered, by default, with availability.
- The user responsible for the registration must be an administrator.

### Car Listing
**RF**
- It should be possible to list all available cars.
- It should be possible to list all available cars by category name, brand name, or car name.

**RN**
- The user does not need to be logged into the system.

### Specification Registration on the Car
**RF**
- It must be possible to register a specification for a car.

**RN**
- It should not be possible to register a specification for an unregistered car.
- It should not be possible to register an existing specification for the same car.
- The user responsible for the registration must be an administrator.

### Car Image Registration
**RF**
- It must be possible to register the image of the car.

**RNF**
- Use Multer for uploading files.

**RN**
- The user must be able to register more than one image for the same car.
- The user responsible for the registration must be an administrator.

### Car Rental
**RF**
- It must be possible to register a rental.

**RN**
- The rental must have a minimum duration of 24 hours.
- It should not be possible to register a new rental if there is an existing open rental for the same car.
- The user must be logged into the application.
- When making a rental, the car's status must be changed to unavailable.

### Car Return
**RF**
- It must be possible to return a car.

**RN**
- If the car is returned in less than 2 hours, it must be charged as a full day.
- When returning, the car must be available for another rental.
- The user must be logged into the application.
- If the return is later than expected, additional days must be charged.
- Any fines must be added to the total rental cost.

### User Rental Listing
**RF**
- It must be possible to list all rentals for a user.

**RN**
- The user must be logged into the application.

### Recover Password
**RF**
- The user must be able to recover a password by providing an email.
- The user should be able to enter a new password.

**RN**
- The user needs to enter a new password.
- The link sent for recovery must expire in 3 hours.
