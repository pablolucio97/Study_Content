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

