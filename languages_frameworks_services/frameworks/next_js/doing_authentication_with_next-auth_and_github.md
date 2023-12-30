# DOING AUTHENTICATION WITH NEXT AUTH AND GITHUB

1. **Install the next-auth**: Run `yarn add next-auth` and create a new file named `[...nextauth].tsx` inside of `pages/api/auth`.

---

2. **Set up GitHub OAuth**:
   - Log in to the GitHub site with your account.
   - Go to `Settings > Developer settings > OAuth > New OAuth` and fill in your app information.
   - In the "Authorization callback URL" field, type: `http://localhost:3000/api/auth/callback`.

---

3. **Configure Environment Variables**:
   - Copy your Client ID key.
   - Generate and copy your Secret Key.
   - Paste them in the `.env.local` file.

---

4. **Define the Provider in `[...nextauth].tsx`**:
   - Define your provider, passing the "scope" to define which properties the application will use.
   - Example:
     ```tsx
     import NextAuth from 'next-auth';
     import Providers from 'next-auth/providers'

     export default NextAuth({
         providers: [
             Providers.GitHub({
                 clientId: process.env.CLIENT_ID,
                 clientSecret: process.env.CLIENT_SECRET_KEY,
                 scope: 'read:user'
             })
         ]
     })
     ```

---

5. **Wrap Your Application with the Auth Context**:
   - Example:
     ```tsx
     import { Provider as NextAuthProvider } from 'next-auth/client'
     import { AppProps } from 'next/app'
     import { Header } from '../components/Header'

     function MyApp({ Component, pageProps }: AppProps) {
       return (
         <NextAuthProvider session={pageProps.session}>
           <Header />
           <Component {...pageProps} />
         </NextAuthProvider>
       )
     }

     export default MyApp
     ```

---

6. **Use in Your Application/Component**:
   - Example:
     ```tsx
     import { FaGithub } from 'react-icons/fa'
     import { signIn, signOut, useSession } from 'next-auth/client'

     export function SignInButton() {
       const [session] = useSession()

       return session ? (
         <button
           type="button"
           onClick={() => signOut()}
         >
           <FaGithub color='#04d361' />
           {session.user.name}
         </button>
       ) : (
         <button
           type="button"
           onClick={() => signIn('github')}
         >
           <FaGithub color='#eda417' />
           SignIn with GitHub
         </button>
       )
     }
     ```
