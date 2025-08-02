
## CONTROLING FORMS WITH REACT HOOK FORM AND YUP

React Hook Form helps control forms with validation while the user fills them out.

---

### 1) Install dependencies

```bash
yarn add react-hook-form @hookform/resolvers yup
```

---

### 2) Update the `Input` component to use `forwardRef`

```tsx
// components/Input/index.tsx
import React, { forwardRef } from 'react'
import { TextInput, TextInputProps } from 'react-native'
import { Container } from './styles'

export const Input = forwardRef<TextInput, TextInputProps>((props, ref) => {
  return (
    <Container>
      <TextInput ref={ref} {...props} />
    </Container>
  )
})
```

---

### 3) Create the `InputForm` component with `Controller`

```tsx
// components/Forms/InputForm.tsx
import React from 'react'
import { TextInputProps } from 'react-native'
import { Control, Controller } from 'react-hook-form'
import { Container, Error } from './styles'
import { Input } from '../Input'

interface Props extends TextInputProps {
  control: Control;
  name: string;
  error: string;
}

export function InputForm({ control, error, name, ...rest }: Props) {
  return (
    <Container>
      <Controller
        control={control}
        name={name}
        render={({ field: { onChange, value, ref } }) => (
          <Input
            ref={ref}
            onChangeText={onChange}
            value={value}
            {...rest}
          />
        )}
      />
      {error && <Error>{error}</Error>}
    </Container>
  )
}
```

---

### 4) Define validation schema with Yup

```tsx
import * as Yup from 'yup'

const schema = Yup.object().shape({
  name: Yup.string().required('Name is required'),
  amount: Yup.number()
    .typeError('Amount must be a number')
    .positive('Amount must be positive')
    .required('Amount is required')
})
```

---

### 5) Setup the form component

```tsx
import React, { useState } from 'react'
import {
  Keyboard,
  TouchableWithoutFeedback,
  Alert
} from 'react-native'
import { useForm } from 'react-hook-form'
import { yupResolver } from '@hookform/resolvers/yup'

import { InputForm } from '../../components/Forms/InputForm'
import { Button } from '../../components/Forms/Button'
import {
  Container, Header, Title, Form, Fields
} from './styles'

interface FormDataProps {
  name: string;
  amount: string;
}

export function Register() {
  const { handleSubmit, control, formState: { errors } } = useForm<FormDataProps>({
    resolver: yupResolver(schema)
  })

  const handleRegister = (form: FormDataProps) => {
    Alert.alert('Form Data', JSON.stringify(form, null, 2))
  }

  return (
    <TouchableWithoutFeedback onPress={Keyboard.dismiss}>
      <Container>
        <Header><Title>Register</Title></Header>
        <Form>
          <Fields>
            <InputForm
              placeholder="Name"
              name="name"
              control={control}
              autoCapitalize="sentences"
              autoCorrect={false}
              error={errors.name?.message || ''}
            />
            <InputForm
              placeholder="Amount"
              name="amount"
              keyboardType="numeric"
              control={control}
              error={errors.amount?.message || ''}
            />
          </Fields>
          <Button label="Submit" onPress={handleSubmit(handleRegister)} />
        </Form>
      </Container>
    </TouchableWithoutFeedback>
  )
}
```
