# Implementing OAuth2 Authentication Flow on React Native

## Authentication Flow

1. **Register the Application**: Register the application on Google Cloud Platform (GCP) to obtain an `AppId`. This is essential for the application to be recognized during the authentication process, especially when it requests user data based on the authorized application scope.
2. **User Authentication Request**: The user initiates a request for authentication.
3. **OAuth2 Protocol Handling**: The OAuth2 protocol listens to the request, checks the application ID, and delivers a token to the application after the user logs in.
4. **Token Reception and Data Request**: OAuth2 returns to the application with the token. The application then accesses the user data endpoint on Google's server to request user data.
5. **User Data Retrieval**: The application authenticates the user and returns their data.

## Process

1. **Create a New Application**:
   - Access the Google Cloud Platform dashboard.
   - Create a new application.

2. **Configure Application**:
   - Navigate to `Credentials`, then to `APIs & Services`.
   - Click on `OAuth consent screen`.
   - Select `External`, provide an application name, a support email, and click `Save`.

3. **Set Scopes**:
   - Click on `Add or Remove Scopes`.
   - Select scopes for `User Email` and `User Info`.
   - Click `Save and Continue`.
   - Repeat this process until you reach the final page, then click `Publish App`.

4. **Create Credentials for Android**:
   - In the dashboard, click `Create Credentials`.
   - Select `Android`, provide a name, and specify the package name (it must match the package name in your Android folder).
   - Run the command `./gradlew signingReport` inside the Android folder.
   - Copy the first SHA1 key generated and paste it in the Google Cloud Platform console.
   - Click `Create`, copy the generated ID for Android, and use it as an environment variable.

5. **Create Credentials for iOS**:
   - Repeat the process to create new credentials for iOS, providing the app name and package name (SHA1 key is not required for iOS).
   - Copy and use the generated ID for iOS as an environment variable.
   - On iOS, on info.plist file you must add the string of the URL scheme inside your CFBundleURLSchemes' array. example:

   ```
   <key>CFBundleURLTypes</key>
    <array>
      <dict>
        <key>CFBundleURLSchemes</key>
        <array>
          <string>com.pablosilva.ignitefleet</string>
          <string>com.googleusercontent.apps.120211246285-ldbepihqv2i0b0r7k18a818fv3abnh34</string>
        </array>
      </dict>
    </array>
    ```


6. **Create Credentials for web**:
   - Repeat the process to create new credentials for web, providing the app name and package name, and the authorized URIs ('http://localhost' and 'https://auth.expo.io').
   - Copy and use the generated ID for web as an environment variable.

7. Install and configure the React Native DotEnv, and the create the env @types to assign to the environment variables.

8.  **Create Credentials for web**:
    - Install the React Native Google sign running the command  `npm i @react-native-google-signin/google-signin`, obs: the compatible version for SDK 49 is `10.1.1`. Check the compatible version according to your SDK.

9.  **Calling the Google SignIn**:
    - Import the GoogleSign, configure it, and call the method .signin(). Example:

    ```typescript
    import { IOS_CLIENT_ID, WEB_CLIENT_ID } from "@env";
    import { GoogleSignin } from "@react-native-google-signin/google-signin";
    import { useState } from "react";
    import backgroundImg from "../assets/background.png";
    import { Button } from "../components/Button";
    import { Container, Slogan, Title } from "./styles";

    export function SignIn() {
    const [isAuthenticating, setIsAuthenticating] = useState(false);

    GoogleSignin.configure({
        scopes: ["email", "profile"],
        webClientId: WEB_CLIENT_ID,
        iosClientId: IOS_CLIENT_ID,
    });

    const handleSign = async () => {
        try {
        setIsAuthenticating(true);
        const authInfo = await GoogleSignin.signIn();
        console.log(authInfo)
        } catch (error) {
        console.log("Error at trying to sign in: ", error);
        } finally {
        setIsAuthenticating(false);
        }
    };

    return (
        <Container source={backgroundImg}>
        <Title>Ignite Fleet</Title>
        <Slogan>Gestão de uso de veículos</Slogan>
        <Button
            title="Entrar com Google"
            onPress={handleSign}
            isLoading={isAuthenticating}
        />
        </Container>
    );
    }
```

Project reference: [Ignite Fleet](https://github.com/pablolucio97/ignite-fleet)
