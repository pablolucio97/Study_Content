# Implementing OAuth2 authentication flow

## Authentication flow

1 - Register the application on GCP for the application has an AppId and can be recognized when it requests for user data according the authorized app scope during the authentication flow.
2 - User request for authentication.
3 - OAuth2 protocol listen to then request, check for the application id, and deliveries a token for the application after the user has logged in.
4 - OAuth2 returns to the application with the token and access the user data end-point on Google server asking for user data reading.
5 - The application authenticates the user returning its data.