
# 📚 Using Storybook to Document React Components

Storybook is a tool for developing UI components in isolation. It makes building stunning UIs organized and efficient.

---

## 1️⃣ Install Storybook

Run the following command to set up Storybook in your project:

```bash
npx storybook init
```

Additionally, install **ts-loader** to avoid TypeScript conflicts:

```bash
yarn add ts-loader -D
```

---

## 2️⃣ Configure Styled Components Support

To use **Styled Components** in Storybook, add `@react-theming/storybook-addon` inside the `addons` array in your `.storybook/main.js`.

**Example:**

```javascript
module.exports = {
  stories: [
    "../src/**/*.stories.mdx",
    "../src/**/*.stories.@(js|jsx|ts|tsx)",
  ],
  addons: [
    "@storybook/addon-links",
    "@storybook/addon-essentials",
    "@storybook/addon-interactions",
    "@react-theming/storybook-addon"
  ],
  framework: "@storybook/react",
  core: {
    builder: "@storybook/builder-webpack5"
  }
}
```

---

## 3️⃣ Add Theme Provider and Global Styles

In `.storybook/preview.js`, wrap all components with your **ThemeProvider** and **GlobalStyle**.

**Example:**

```javascript
import { ThemeProvider } from "styled-components";
import { GlobalStyle } from '../src/styles/global-style';
import { theme } from '../src/themes/theme';

export const parameters = {
  actions: { argTypesRegex: "^on[A-Z].*" },
  controls: {
    matchers: {
      color: /(background|color)$/i,
      date: /Date$/,
    },
  },
};

export const decorators = [
  (Story) => (
    <ThemeProvider theme={theme}>
      <Story />
      <GlobalStyle />
    </ThemeProvider>
  )
];
```

---

## 4️⃣ Running Storybook

Start Storybook locally:

```bash
yarn storybook
```

Your browser will open a panel containing your documented components and their stories.

---

## 5️⃣ Creating a Component Story

Inside your component folder, create a `.stories.tsx` file:

**Example:**

```tsx
import React from 'react';
import { Text } from './';
import { ComponentMeta, ComponentStory } from '@storybook/react';

export default {
    title: 'Text',
    component: Text
} as ComponentMeta<typeof Text>;

export const Primary: ComponentStory<typeof Text> = () => (
    <Text content='Example' />
);

export const Secondary: ComponentStory<typeof Text> = () => {
    const theme = useTheme();
    return <Text content='Example' style={{ color: theme.colors.primary }} />;
};
```

---

## 📦 Documenting a Set of Components

**Example:**

```tsx
import { ComponentMeta, ComponentStory } from '@storybook/react';
import { ReactNode } from 'react';
import { Text as TextComponent } from './Text';
import { Title as TitleComponent } from './Title';

interface ContainerProps {
    children: ReactNode;
}

const Container = ({ children }: ContainerProps) => <>{children}</>;

export const Text: ComponentStory<typeof TextComponent> = () => (
    <TextComponent content='This is the Text component' />
);

export const Title: ComponentStory<typeof TitleComponent> = () => (
    <TitleComponent content='This is the TitleComponent component' />
);

Text.argTypes = {
    content: {
        name: 'content',
        description: 'Text to be displayed',
        type: { name: 'string', required: true },
        table: {
            type: { summary: 'string' },
            defaultValue: { summary: '' },
        },
    },
    style: {
        name: 'style',
        description: 'CSS Styles',
        table: {
            type: { summary: 'CSS Properties' },
        },
    },
};

Title.argTypes = {
    content: {
        name: 'content',
        description: 'Text to be displayed',
        type: { name: 'string', required: true },
        table: {
            type: { summary: 'string' },
            defaultValue: { summary: '' },
        },
    },
    style: {
        name: 'style',
        description: 'CSS Styles',
        table: {
            type: { summary: 'CSS Properties' },
        },
    },
};

export default {
    title: 'Typography',
    component: Container,
} as ComponentMeta<typeof Container>;
```

---

✅ **Tips**  
- Use `argTypes` to document props clearly in Storybook’s controls panel.  
- Group related components into a single story file for better organization.  
- Always wrap your stories with providers like `ThemeProvider` if your components depend on them.