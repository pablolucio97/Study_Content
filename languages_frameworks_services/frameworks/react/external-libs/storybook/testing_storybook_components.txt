# 📚 Using Storybook Interactions, MSW, and Test Runner

## 1️⃣ Install Interaction Addon, Jest, and Testing Library
```bash
npm i @storybook/addon-interactions @storybook/jest @storybook/testing-library @storybook/test-runner -D
```

## 2️⃣ Install MSW and MSW Storybook Addon
```bash
npm i msw msw-storybook-addon -D
```

## 3️⃣ Initialize MSW
For **Vite** and **Next.js** (which have a `public` folder):
```bash
npx msw init public
```
Confirm `public` as the workdir.

## 4️⃣ Configure `.storybook/main.cjs`
Add the interactions addon, enable `interactionsDebugger`, and pass the path of your `public` folder through `staticDirs`:
```javascript
module.exports = {
  stories: [
    "../src/**/*.stories.mdx",
    "../src/**/*.stories.@(js|jsx|ts|tsx)"
  ],
  addons: [
    "@storybook/addon-links",
    "@storybook/addon-essentials",
    "@storybook/addon-interactions",
    "@storybook/addon-a11y",
  ],
  framework: "@storybook/react",
  core: {
    builder: "@storybook/builder-vite"
  },
  features: {
    storyStoreV7: true,
    interactionsDebugger: true
  },
  staticDirs: ["../public"],
  viteFinal: (config, { configType }) => {
    if (configType === "PRODUCTION") {
      config.base = '/ignite-lab-design-system/'
    }
    return config
  }
}
```

## 5️⃣ Configure `.storybook/preview.cjs` with MSW
```javascript
import { themes } from '@storybook/theming';
import { initialize, mswDecorator } from 'msw-storybook-addon';
import '../src/styles/global.css';

// Initialize MSW
initialize({ onUnhandledRequest: 'bypass' });

// Provide MSW addon decorator globally
export const decorators = [mswDecorator];

export const parameters = {
  actions: { argTypesRegex: "^on[A-Z].*" },
  controls: {
    matchers: {
      color: /(background|color)$/i,
      date: /Date$/,
    },
  },
  docs: {
    theme: themes.dark
  }
}
```

## 6️⃣ Writing a Test in a Story
Example: `SignIn.stories.tsx`
```typescript
import { Meta, StoryObj } from '@storybook/react';
import { within, userEvent, waitFor } from '@storybook/testing-library';
import { expect } from '@storybook/jest';
import { SignIn, SignInProps } from './SignIn';
import { rest } from 'msw';

export default {
  title: 'Pages/SignIn',
  component: SignIn,
  args: { title: 'Ignite Lab 2022' },
  parameters: {
    msw: {
      handlers: [
        rest.post('/sessions', (req, res, ctx) => {
          return res(ctx.json({ res }));
        })
      ]
    }
  }
} as Meta<SignInProps>;

export const Default: StoryObj<SignInProps> = {
  play: async ({ canvasElement }) => {
    const canvas = within(canvasElement);
    userEvent.type(canvas.getByPlaceholderText('Digite seu e-mail'), 'pablolucio_@hotmail.com');
    userEvent.type(canvas.getByPlaceholderText('******'), '123456');
    userEvent.click(canvas.getByRole('button'));

    await waitFor(() => {
      return expect(canvas.getByText('Authenticado')).toBeInTheDocument();
    });
  }
};
```

## 7️⃣ Viewing Test Results
Open the **Interactions** tab in your Storybook panel.

## 8️⃣ Run Tests Locally
Add this script to your `package.json`:
```json
"scripts": {
  "test-storybook": "test-storybook --watch"
}
```
Run:
```bash
npm run test-storybook
```

---
## 💡 General Tips
- Use `waitFor` for async expected results.
- Use `within` to search for elements inside the canvas.
- Use `rest` from `msw` to mock API requests.
- Use `parameters` in component variations to handle API requests.
