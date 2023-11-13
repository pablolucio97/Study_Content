# Using environment variables on Expo

1 - Run `yarn add react-native-dotenv` to install the react-native-dot env.

2 - Add the DotEnv plugin to your babel.config.js file. Example:

```javascript
// eslint-disable-next-line no-undef
module.exports = function(api) {
  api.cache(true);
  return {
    presets: ['babel-preset-expo'],
    plugins: [
      [
        'module:react-native-dotenv',
        {
          envName: 'APP_ENV',
          moduleName: '@env',
          path: '.env',
        },
      ]
    ],
  };
};
```

3 - Create in your project's root directory a .env file containing your environment variables. Create a .env.example file too, and add the .env file to your .gitignore file.
Obs: All Expo environment variables must contains the "EXPO_PUBLIC" prefix. Example:

```
EXPO_PUBLIC_URL_STAGE=your_url_stage
EXPO_PUBLIC_URL_PROD=your_url_prod
```

4 - Create .env.d.ts file declaration declaring the env module. Example:

```typescript
declare module '@env' {
  export const EXPO_PUBLIC_URL_STAGE: string;
  export const EXPO_PUBLIC_URL_PROD: string;
}
```

5 - Use the variables from `@env` in your project, example:

```typescript
import axios from 'axios';
import { EXPO_PUBLIC_URL_STAGE, EXPO_PUBLIC_URL_PROD } from '@env';

export const api = axios.create({
  baseURL: __DEV__ ? EXPO_PUBLIC_URL_STAGE : EXPO_PUBLIC_URL_PROD,
});

```
Obs: Use the `__DEV__ ` NodeJs global environment to check if the app is running locally or not.

6 - Add the environment variables to your project after signed in your Expo Expo Account. These variables must have same name and value as declared in your project.

7 - Build your project using `eas build`.
Obs: Only build your app after added your environment variables to your Expo project's Account.