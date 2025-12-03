# Learning and experience's tips history

### 03/01/2025

- At configuring environment variables for Prisma and Docker file, use the variables without quotes to avoid recognition issues.

### 08/01/2025

- At working with transitions with Tailwindcss, for a good experience, pay attention on using transition with default tailwind transforms. Example: `transition eas-out duration-400 hover:scale-125`.

### 10/01/2025

- Use Ngrok with Docker command for generate temporary HTTPS URLs to enable your service communication with third services.

### 29/01/2025

- If you getting fetch errors at running requests on NextJS using Axios, try making these requests using fetch API because all examples on NextJS are using Fetch API.
  
### 04/02/2025

- Use the flag `--allow-unrelated-histories` at the first commit pushing if for some reason there is a mismatch between the current local and remote branches. Example: `git merge master --allow-unrelated-histories`.

### 07/03/2025

- Avoid deep prop drilling because the prop received can be undefined at trying to use it inside some function. It's quite unusual, but it happens.
  
- Always save data that requires formatting as raw data (cep, phone, and so on) and format as necessary on front-end because the database stick more preformat with raw data.

### 11/03/2025
- For a cleaner code, always assign variables to your classes when you need to handle extensive classesNames on React. Example:
```typescript
  const cursorStyle = 'cursor-grabbing';
  const hoverStyle = dropTarget.hoovered ? 'bg-sky-100' : '';
  const baseStyle = 'py-2 px-[6px] xxl:px-3 border-b border-t border-r text-left text-blue-600 text-[.88rem] xxl:text-[.92rem]';
        return (
            <input
                ref={node => drag(drop(node))}
                key={column}
                className={`${baseStyle} ${hoverStyle} ${cursorStyle}`}
            />
        )
```
### 22/03/2025
- Files with contains no named importations probably are importing another files that are exporting something. Example: `import "./infra/models";`, this file content is:
```typescript
import { User } from "./User";

export const models = {
  User,
};
```

### 27/03/2025
- At working with full-stack applications that needs to record data on back-end, always save the date as UTC on back-end and read it on your front-end using moment-timezone to be parsed for your local timezone. The date always need to be stored as UTC.

### 23/04/2025
- If you need to work with composed arrays (arrays inside arrays), you need to map over these arrays twice. Example:
```typescript
  const items = [
    ["Despesa", "DOC125", "2025-05-15", null, 1200, null],
    ["Transferência", "DOC125", "2025-05-15", null, 1200, null]
  ] 

 {items.map((row, rowIndex) => (
      <div
          key={rowIndex}
          className="w-full flex items-center justify-around py-3 border-b-[1px] border-b-gray-200"
      >
          {row.map((cell: any, cellIndex: number) => (
              <div className="mx-auto w-[180px] flex justify-center">
                  <span key={cellIndex} className="text-sm text-gray-900 w-full text-center">
                      {typeof cell === 'number' ?
                          formatBRL(cell) : cell ??
                          "-"}
                  </span>
              </div>
          ))}
      </div>
  ))}
```

### 19/05/2025
- At working with requests on front-end applications, always treat the request try/catch block directly in the screen where you're calling it because it let the error more clear, and gives you the possibility of providing a better UI response for each error.

### 22/05/2025
- At creating React's components, always put fixed constants outside the component to avoid unnecessary rerenders.

### 02/07/2025
- At working with .png files use large and big sizes even for small viewing to avoid losing quality.
- Use the API URL.createObjectURL() passing the blob content to be able to render the image content on web.
- For download files, a server response can be returned as blob to return the blob content, in this case the response type must be explicit as blob. 
- Prefer using return for if statement instead using if else because it improves readability and by reducing nesting.
- Use the hack of changing your logic for true/false for quickly test it.
- Use a callback tied to an event to pass props from children to parent component in React, Example:
```typescript
// Define your Child data type
interface IChild {
  id: string;
  name: string;
}

// Props for ChildComponent
interface ChildProps {
  data: IChild[];
  onDoSomething?: (someId: string) => void;
}

// ChildComponent
export function ChildComponent({ data, onDoSomething }: ChildProps) {
  return (
    <>
      {data.map((d) => (
        <button key={d.id} onClick={() => onDoSomething?.(d.id)}>
          {d.name}
        </button>
      ))}
    </>
  );
}

// ParentComponent
export function ParentComponent() {
  const childrenData: IChild[] = [
    { id: '1', name: 'First' },
    { id: '2', name: 'Second' },
  ];

  const handleDoSomething = (someId: string) => {
    console.log('Child clicked with ID:', someId);
  };

  return (
    <ChildComponent data={childrenData} onDoSomething={handleDoSomething} />
  );
}

``` 

### 11/08/2025
- At working with files downloading, configure the files to be downloaded using the original file's name because it will preserver the file extension and make the file correctly executable. 
- Always apply conditional styling assign it to a variable instead do it directly in the classNam when using Tailwind css, because it get more cleaner and because Tailwind sometimes misses some classes based on variables. The className styles should be completely attached to a prop. Example

```typescript
  import React from "react";

interface ButtonProps {
  variant?: "primary" | "secondary";
  size?: "sm" | "md" | "lg";
}

export const Button: React.FC<ButtonProps> = ({ variant = "primary", size = "md", children }) => {
  // ✅ Define styles in a variable so Tailwind can detect all classes at build time
  const baseStyles = "font-semibold rounded focus:outline-none focus:ring";
  
  const variantStyles =
    variant === "primary"
      ? "bg-blue-500 text-white hover:bg-blue-600"
      : "bg-gray-200 text-gray-800 hover:bg-gray-300";
  
  const sizeStyles =
    size === "sm"
      ? "px-3 py-1 text-sm"
      : size === "lg"
      ? "px-6 py-3 text-lg"
      : "px-4 py-2 text-base";

  const buttonClasses = `${baseStyles} ${variantStyles} ${sizeStyles}`;

  return <button className={buttonClasses}>{children}</button>;
};
```

### 26/08/2025
- At documenting components with StoryBook, creates your React component as a function and comment every single property to have a better StoryBook compatibility. Example:
```typescript
// component file index.tsx
import { ClipboardIcon } from "@phosphor-icons/react";
import type { ButtonHTMLAttributes } from "react";
import { sizes } from "../../../theme/theme";

export type ClipboardButtonVariant = "filled" | "outlined";

export interface ClipboardButtonProps
  extends ButtonHTMLAttributes<HTMLButtonElement> {
  /** Text that will be copied to the clipboard. */
  textToCopy: string;
  /** Button label text. */
  label?: string;
  /** Visual style variant. */
  variant?: ClipboardButtonVariant;
  /** Icon size in px. */
  iconSize?: number;
  /** Called after the text is copied. */
  onCopy?: () => void;
}

function ClipboardButton({
  textToCopy,
  label = "Copy text",
  onCopy,
  iconSize = sizes.medium,
  variant = "outlined",
  ...props
}: ClipboardButtonProps) {
  return (
    <button
      className={`flex items-center justify-center w-fit px-4 py-3 rounded-md gap-2 ${
        variant === "filled"
          ? "bg-primary-500 text-white hover:bg-primary-600"
          : variant === "outlined"
          ? "border border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white"
          : ""
      }`}
      onClick={() => {
        navigator.clipboard.writeText(textToCopy);
        if (onCopy) {
          onCopy();
        }
      }}
      {...props}
    >
      <ClipboardIcon size={iconSize} />
      {label}
    </button>
  );
}

export default ClipboardButton;
```

```typescript
//storybook file index.tsx 
import type { Meta, StoryObj } from "@storybook/react-vite";
import ClipboardButton from ".";

const meta = {
  title: "Example/ClipboardButton",
  component: ClipboardButton,
  tags: ["autodocs"],
} satisfies Meta<typeof ClipboardButton>;

export default meta;

type Story = StoryObj<typeof ClipboardButton>;

export const Default: Story = {
  args: {
    textToCopy: "Hello World",
    label: "Copy text",
    variant: "outlined",
    iconSize: 24,
    onCopy: () => alert("Text copied to clipboard!"),
  },
  argTypes: {
    variant: {
      options: ['filled', 'outlined'],
      control: { type: 'radio' },
      type: { name: 'string', },
    },
  },
  parameters: {
    layout: "centered",
  },
};
```

### 28/10/2025
- At configuring interceptors on Axios, always log the server response details in production safely avoiding to expose sensitive server data. Example:

```typescript
api.interceptors.response.use(
  (response: AxiosResponse<IApiSuccessResponse<any>>) => {
    if (import.meta.env.DEV) {
      console.log("[RESPONSE SUCCESS] - ", response.data);
    }
    return response;
  },
  (error: AxiosError<IApiErrorResponse>) => {
    if (error.response?.status === 429) {
      showAlertError(
        "Houve um erro ao tentar realizar sua solicitação. Por favor tente novamente dentro de 1 minuto."
      );
    }
    if (error.response) {
      if (import.meta.env.DEV) {
        console.log("[RESPONSE ERROR] - ", error.response.data);
        return Promise.reject(error.response.data);
      }
      const safeError = {
        STATUS: error.response?.status ?? 500,
        MESSAGE: "Ocorreu um erro ao processar sua solicitação.",
        DATA: null,
      };
      return Promise.reject(safeError);
    }
    if (error.request) {
      if (import.meta.env.DEV) {
        console.log("[REQUEST ERROR] - ", error.request.data);
        return Promise.reject(error.request.data);
      }
    }
  }
);
```

### 02/12/2025
- Always there are problems at pulling from team remote branches, try deleting your local branch and recreating it based on the updated remote origin branch running the commands `git branch -D myLocalBranch` and `git checkout -b myLocalBranch origin/remoteBranch`. Ex: `git branch -D develop` and `git checkout -b develop origin/develop`.
- Create views to replace repeated complex queries, example:

```sql
# Before (it was being called every time)
SELECT o.id, o.total, c.name AS customer_name
FROM orders o
JOIN customers c ON c.id = o.customer_id
WHERE o.status = 'PAID' AND c.is_active = true;
```
```sql
#After(with view it's created just once)
CREATE VIEW paid_orders_with_customer AS
SELECT o.id, o.total, c.name AS customer_name
FROM orders o
JOIN customers c ON c.id = o.customer_id
WHERE o.status = 'PAID' AND c.is_active = true;
#And call it:
SELECT * FROM paid_orders_with_customer;
```

### 03/12/2025
- At working with back-end application that has no authentication system yet, you can use cookies api according the query-builder/ORM you're using to manage routes and restrict user requests based on session-id for example. 

