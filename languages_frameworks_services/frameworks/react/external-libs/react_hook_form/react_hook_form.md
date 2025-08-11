# Adding Form Validations with React Hook Form and Zod Resolver

## 1) Install Dependencies

Run the following command to install React Hook Form, the resolvers, and Zod for validations:

```bash
yarn add react-hook-form @hookform/resolver zod
```

---

## 2) Create Your Validation Schema

Import `* as zod` and the `zodResolver`, and create a new type to type your resolver according to your object validation type.

```typescript
import { zodResolver } from "@hookform/resolvers/zod"
import * as zod from "zod"

const newCycleFormValidationScheme = zod.object({
    task: zod.string().min(1, "Informe a tarefa"),
    minutesAmount: zod.number().min(5).max(60)
})

type FormData = zod.infer<typeof newCycleFormValidationScheme>
```

---

## 3) Initialize the Form

Import the `useForm` from `react-hook-form` and destructure `register`, `watch`, `handleSubmit`, and `reset` from `useForm`. Pass an object as an argument to `useForm` containing your resolver with the validation type and an object with the default values.

```typescript
const { register, watch, handleSubmit, reset } = useForm<FormData>({
    resolver: zodResolver(newCycleFormValidationScheme),
    defaultValues: {
        task: "",
        minutesAmount: 0
    }
})
```

---

## 4) Control Form Behavior

Create variables to watch each input of your application and control the submit button based on these variables' rules.

```typescript
const task = watch("task")
const minutesCounter = watch("minutesAmount")
const isDisabledBtn = !task || !minutesCounter

<StartCountdownButton disabled={isDisabledBtn} type="submit">
    Começar
</StartCountdownButton>
```

---

## 5) Register Inputs

Pass for each input of your form the `register` function with all possible returns of this function (through the spread operator) passing the name of the field that this input controls as an argument. You can also pass an object of configuration as a second parameter.

```tsx
<TaskInput
    type="text"
    id='task'
    placeholder='Inicie uma tarefa'
    list="task-suggestions"
    {...register("task")}
/>

<MinutesAmountInput
    type="number"
    id='minutesAmount'
    placeholder='00'
    min={0}
    max={60}
    step={5}
    {...register("minutesAmount", { valueAsNumber: true })}
/>
```

---

## 6) Handle Form Submission

Write the function that will be called in your form and call this function inside the `handleSubmit` function from the `useForm` hook.

```tsx
function handleCreateNewCycle(data: FormData) {
    console.log(data)
    reset()
}

<form action="" onSubmit={handleSubmit(handleCreateNewCycle)}>
    <InputsContainer>
        <label htmlFor="task">Vou trabalhar em</label>
        <TaskInput
            type="text"
            id='task'
            placeholder='Inicie uma tarefa'
            list="task-suggestions"
            {...register("task")}
        />
        <MinutesAmountInput
            type="number"
            id='minutesAmount'
            placeholder='00'
            min={0}
            max={60}
            step={5}
            {...register("minutesAmount", { valueAsNumber: true })}
        />
    </InputsContainer>
    <StartCountdownButton disabled={isDisabledBtn} type="submit">
        <Play size={24} />
        Começar
    </StartCountdownButton>
</form>
```

---
