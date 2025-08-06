# Controlling and Validating Forms with React Hook Form and Yup

## 1. Installation

Run the following command to install the required libraries:

```bash
yarn add react-hook-form yup @hookform/resolvers
```

This installs:
- `react-hook-form` to manage form state using uncontrolled components
- `yup` for schema-based form validation
- `@hookform/resolvers` to integrate Yup with React Hook Form

---

## 2. Create the Form Data Type

```ts
type SignInFormData = {
  email: string;
  password: string;
}
```

---

## 3. Create the Validation Schema

```ts
import * as yup from 'yup'
import { yupResolver } from '@hookform/resolvers/yup'

const signFormSchema = yup.object().shape({
  email: yup.string().required('E-mail required').email('E-mail invalid'),
  password: yup.string().required('Password required')
})
```

---

## 4. Configure useForm

```ts
const { register, handleSubmit, formState } = useForm<SignInFormData>({
  resolver: yupResolver(signFormSchema)
})
```

---

## 5. Handle Form Submission

```ts
import { SubmitHandler } from 'react-hook-form'

const handleSignIn: SubmitHandler<SignInFormData> = async (values) => {
  await new Promise(resolve => setTimeout(resolve, 500))
  console.log(values)
}
```

---

## 6. Create Input Component with Error Handling

```tsx
import {
  Input as ChakraInput,
  FormControl,
  FormLabel,
  InputProps as ChakraInputProps,
  FormErrorMessage
} from '@chakra-ui/react'
import { forwardRef, ForwardRefRenderFunction } from 'react'
import { FieldError } from 'react-hook-form'

interface InputProps extends ChakraInputProps {
  label: string
  name: string
  error?: FieldError
}

const InputBase: ForwardRefRenderFunction<HTMLInputElement, InputProps> =
({ error, label, name, ...rest }, ref) => {
  return (
    <FormControl isInvalid={!!error}>
      {!!label && <FormLabel htmlFor={name}>{label}</FormLabel>}
      <ChakraInput name={name} ref={ref} {...rest} />
      {!!error && <FormErrorMessage>{error.message}</FormErrorMessage>}
    </FormControl>
  )
}

export const Input = forwardRef(InputBase)
```

---

## 7. Final Form Page

```tsx
import { Flex, Button, Stack } from '@chakra-ui/react'
import { Input } from '../components/Form/Input'
import { SubmitHandler, useForm } from 'react-hook-form'
import * as yup from 'yup'
import { yupResolver } from '@hookform/resolvers/yup'

type SignInFormData = {
  email: string;
  password: string;
}

const signFormSchema = yup.object().shape({
  email: yup.string().required('E-mail obrigatório').email('E-mail inválido'),
  password: yup.string().required('Password obrigatório')
})

export default function SignIn() {
  const { register, handleSubmit, formState } = useForm<SignInFormData>({
    resolver: yupResolver(signFormSchema)
  })

  const handleSignIn: SubmitHandler<SignInFormData> = async (values) => {
    await new Promise(resolve => setTimeout(resolve, 500))
    console.log(values)
  }

  return (
    <Flex w='100vw' h='100vh' justify='center' align='center'>
      <Flex
        as='form'
        width='100%'
        maxWidth={360}
        bg='gray.800'
        p='4'
        borderRadius={8}
        flexDirection='column'
        onSubmit={handleSubmit(handleSignIn)}
      >
        <Stack spacing={4}>
          <Input
            name='email'
            label='Email'
            type='email'
            error={formState.errors.email}
            {...register('email')}
          />
          <Input
            name='password'
            label='Password'
            type='password'
            error={formState.errors.password}
            {...register('password')}
          />
        </Stack>
        <Button
          mt='6'
          size='lg'
          bg='pink.500'
          type='submit'
          isLoading={formState.isSubmitting}
          _hover={{ cursor: 'pointer' }}
        >
          Entrar
        </Button>
      </Flex>
    </Flex>
  )
}
```