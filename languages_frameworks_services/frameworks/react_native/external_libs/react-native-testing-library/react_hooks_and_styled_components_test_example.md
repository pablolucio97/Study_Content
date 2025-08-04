# React Native Testing with Hooks and Styled Components

## React Hooks Test Example

```tsx
import 'jest-fetch-mock';

import { renderHook, act } from '@testing-library/react-hooks'
import { mocked } from 'ts-jest/utils';
import fetchMock from 'jest-fetch-mock';
import { startAsync } from 'expo-auth-session';
import { AuthProvider } from '../contexts/AuthContext'
import { useAuth } from './auth'

jest.mock('expo-auth-session');

fetchMock.enableMocks();

describe('Auth Hooks', () => {
    it('should be able to signIn with Goggle account exisitng', async () => {
        
        const googleMocked = mocked(startAsync as any)

        googleMocked.mockReturnValueOnce({
            type: 'success',
            params: {
                access_token: 'any_token',
            }
        })
        
        fetchMock.mockResponseOnce(JSON.stringify(
            {
                id: 'ksdjf87dsfh',
                email: 'pablo-test@gmail.com',
                name: 'Pablo',
                photo: 'pablo.png'
            }
        ))        

        const { result, waitForNextUpdate } = renderHook(() => useAuth(), {
            wrapper: AuthProvider
        })

        act(async () => await result.current.signInWithGoogle())
        await waitForNextUpdate()

        expect(result.current.userInfo.email).toBe('pablo-test@gmail.com')
    })
})
```

---

## Styled Components Test Example

### 1. Install Dependency

```bash
npm install jest-styled-components --save-dev
```

### 2. Component Structure

**index.tsx**

```tsx
import React from 'react'
import { Container } from './styles'
import { TextInputProps } from 'react-native'

interface Props extends TextInputProps {
    active?: boolean
}

export function Input({
    active = false,
    ...rest
}: Props) {
    return (
        <Container
            active={active}
            {...rest}
        />
    )
}
```

**styles.ts**

```tsx
import styled, { css } from "styled-components/native";
import { TextInput } from "react-native";

interface Props {
  active?: boolean;
}

export const Container = styled(TextInput)<Props>\`
  width: 100%;
  padding: 4px;
  background-color: \${({ theme }) => theme.colors.shape};
  color: \${({ theme }) => theme.colors.text_dark};
  border-radius: 4px;
  margin-bottom: 12px;
  \${({ active }) =>
    active &&
    css\`
      border-color: \${({ theme }) => theme.colors.atention};
      border-width: 2px;
      border-style: solid;
    \`}
\`;
```

### 3. Writing the Test

**Input.test.tsx**

```tsx
import React from 'react';
import { Input } from './'
import { render } from '@testing-library/react-native'
import { ThemeProvider } from 'styled-components/native'
import theme from '../../../global/styles/theme'

const Providers: React.FC = ({ children }) => {
    return (
        <ThemeProvider theme={theme}>
            {children}
        </ThemeProvider>
    )
}

describe('Input component', () => {
    it('should contains borderColor when active', () => {
        const { getByTestId } = render(
            <Input
                testID='input-email'
                placeholder='E-mail'
                keyboardType='email-address'
                autoCorrect={false}
                active
            />,
            {
                wrapper: Providers
            }
        )

        const inputComponent = getByTestId('input-email')
        expect(inputComponent.props.style[0].borderColor)
        .toEqual(theme.colors.atention)
    })
})
```
