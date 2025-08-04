# Working with Tests on React Native with Expo

## Types of Tests and Concepts

- **Unit Tests**: Test only a single function, class, or component independently. If dependent on other features, mocks are used.
- **Test Driven Development (TDD)**: Practice of writing tests before implementing functionality.
- **Integration Tests**: Validate the integration between components or functionalities.
- **End-to-End (E2E) Tests**: Simulate the entire application flow as an end-user would.
- **Interaction Tests**: Simulate user interactions like onPress, onLongPress, gestures, etc.

---

## Configuration Steps

### 1. Install Dependencies

Install the following as devDependencies:

```
jest-expo
jest@26.5.0
jest-styled-components
jest-fetch-mock
ts-jest
@testing-library/jest-native
@testing-library/react-hooks
@testing-library/react-native
react-test-renderer
@types/jest
```

---

### 2. Create `jest.config.js`

```js
module.exports = {
    preset: "jest-expo",
    testPathIgnorePatterns: [
        '/node_modules',
        '/android',
        '/ios'
    ],
    setupFilesAfterEnv: [
        "@testing-library/jest-native/extend-expect",
        "jest-styled-components"
    ],
    setupFiles: ["./setupFile.js"],
    collectCoverage: true,
    collectCoverageFrom: [
        "src/**/*.tsx",
        "!src/**/*.test.tsx"
    ],
    coverageReporters:[
        'lcov'
    ]
}
```

---

### 3. Update `package.json` Scripts

```json
"scripts": {
  "test": "jest",
  "test:w": "yarn test --watchAll"
},
"resolutions": {
  "@jest/create-cache-key-function": "^27.0.1"
}
```

---

### 4. Update `babel.config.js`

```js
module.exports = function(api) {
  api.cache(true);
  return {
    presets: ['babel-preset-expo', '@babel/preset-env'],
    plugins: ['inline-dotenv']
  };
};
```

---

### 5. Folder Structure

Create:

```
src/
  __tests__/
    screens/
      Profile.test.tsx
```

---

### 6. Writing a Sample Test

```tsx
import React from 'react';
import { render } from '@testing-library/react-native';
import { Profile } from '../../screens/Profile';

describe('Profile', () => {
  it('should show correct placeholder', () => {
    const { getByPlaceholderText } = render(<Profile />);
    expect(getByPlaceholderText('Nome').props.placeholder).toBeTruthy();
  });

  it('should match user value', () => {
    const { getByTestId } = render(<Profile />);
    expect(getByTestId('test-name').props.value).toEqual('Pablo');
  });

  it('should render Profile title', () => {
    const { getByTestId } = render(<Profile />);
    expect(getByTestId('test-title').props.children).toContain('Profile');
  });
});
```

---

## General Tips

- You don’t need to launch the app to run tests.
- Avoid dependencies on external contexts; use mocks.
- Use `mockReturnValueOnce` for isolated test data.
- For testing `AsyncStorage` usage:

```js
// setupFile.js
import mockAsyncStorage from '@react-native-async-storage/async-storage/jest/async-storage-mock';
jest.mock('@react-native-async-storage/async-storage', () => mockAsyncStorage);
```
