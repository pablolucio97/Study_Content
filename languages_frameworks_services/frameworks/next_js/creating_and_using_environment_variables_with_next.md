# Creating and Using Environment Variables with Next.js

## Types of Environment Variable Files

- `.env`: Used to store variables with data that can be shared in the application. Not included in `.gitignore`.
- `.env.local`: Stores private variables for all environments and should not be uploaded to GitHub.
- `.env.local.development`: Only available in the development environment.
- `.env.local.test`: Only available in the test environment.
- `.env.local.production`: Only available in the production environment.

## Using Environment Variables on the Server

1. **Create .env.local File:**
   - Create a `.env.local` file in the root project folder.

2. **Define Variables:**
   - Create your variables. Use the prefix `NEXT_PUBLIC` for variables that Next.js can read. Example:
     ```
     PASSWORD='ItIsMyPassWord123'
     ```

3. **Restart the Server:**
   - Restart your server application to load the new variables.

4. **Use in Server-Side Code:**
   - Example usage:
     ```javascript
     export const getServerSideProps: GetServerSideProps = async (context) => {
       console.log(process.env.PASSWORD);
       return {
         props: {}
       };
     }
     ```

## Using Environment Variables in the Browser

1. **Create .env.local File:**
   - Create a `.env.local` file in the root project folder.

2. **Define Variables:**
   - Create your variables with the `NEXT_PUBLIC_` prefix for Next.js to read them. Example:
     ```
     NEXT_PUBLIC_PASSWORD='ItIsMyPassWord123'
     ```

3. **Restart the Server:**
   - Restart your server application to load the new variables.

4. **Use in Components:**
   - Example usage in a component:
     ```javascript
     export default function Any() {
       return (
         <p>Your password is {process.env.NEXT_PUBLIC_PASSWORD}</p>
       );
     }
     ```

## General Tips

- Always save your environment variable files on your local machine or a secure storage, as you will need them if you clone the repository again.
