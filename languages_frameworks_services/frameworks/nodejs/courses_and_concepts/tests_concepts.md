# TYPES OF TESTS

## Unit Tests

Unit tests are a fundamental part of Test-Driven Development (TDD), where the application is developed based on tests. These tests focus on single functionalities of the application using mock or fake data. They are designed to ensure that individual components of the application function as expected.

## Integration Tests

Integration tests assess the entire application flow:

- **On Request**: Test the routes, then the controller, and finally the repository.
- **On Response**: Test the repository, then the controller, and finally the response.

These tests are crucial for verifying that different parts of the application work together seamlessly.

## End-to-End (E2E) Tests

End-to-end tests are primarily used in front-end development to simulate real user interactions with the application. They test the application from start to finish, ensuring that the entire flow works as expected from the user's perspective.

## Test Pyramid

The Test Pyramid is a concept that suggests an ideal distribution of different types of tests in a software application:

- **Base of the Pyramid**: A large number of unit tests, as they are quick to run and help catch bugs at an early stage.
- **Middle Layer**: A moderate number of integration tests, which are essential for ensuring that different parts of the application work well together.
- **Top of the Pyramid**: A few end-to-end tests, which are slower to run but crucial for verifying the overall user experience.

This pyramid structure helps in isolating test contexts and ensuring efficient performance of the test suite.
