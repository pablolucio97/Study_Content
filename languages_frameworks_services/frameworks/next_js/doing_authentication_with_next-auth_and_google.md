# DOING AUTHENTICATION WITH NEXT-AUTH AND GOOGLE

1. **Install next-auth**: Run `yarn add next-auth` and create a new file named `[...nextauth].tsx` in `pages/api/auth`.

---

2. **Set Up Google OAuth**:
   - Visit [Google Cloud Console - Credentials](https://console.cloud.google.com/apis/credentials).
   - Navigate to `Create Credentials > OAuth Client ID > Configure Consent Screen`.
   - Select user type (external), fill in the required fields, and continue through the steps until you return to the dashboard.
   - Go to `Credentials > Create Credentials > OAuth Client ID`.
   - Select the Application type, provide a name, and create.
   - Copy the generated Client ID and Client Secret keys.
   - Use them in your `.env.local` file with variables `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET`.

---

3. **Configure `[...nextauth].tsx`**:
   - Import NextAuth and Providers, define a configuration object with the provider and settings, and export the NextAuth function.
   - Example:
     ```tsx
     import {NextApiRequest, NextApiResponse} from 'next'
     import NextAuth from 'next-auth'
     import Providers from 'next-auth/providers'

     const options = {
       providers: [
         Providers.Google({
           clientId: process.env.GOOGLE_CLIENT_ID,
           clientSecret: process.env.GOOGLE_CLIENT_SECRET,
           authorizationUrl: 'https://accounts.google.com/o/oauth2/v2/auth?prompt=consent&access_type=offline&response_type=code'
         })
       ],
       session: {
         jwt: true,
         maxAge: 30 * 24 * 60 * 60
       },
       jwt: {
         secret: process.env.JWT_SECRET
       }
     }

     export default (req: NextApiRequest, res: NextApiResponse) => NextAuth(req, res, options);
     ```

---

4. **Inject Provider Context in `_app.tsx`**:
   - Example:
     ```tsx
     import {Provider} from 'next-auth/client'

     export default function MyApp(props: any) {
       const { Component, pageProps } = props;
       return (
         <React.Fragment>
           <Head>
             <title>My page</title>
           </Head>
           <Provider session={pageProps.session}>
             ...
           </Provider>
         </React.Fragment>
       );
     }
     ```

---

5. **Set `NEXTAUTH_URL` in `.env.local`**:
   - `NEXTAUTH_URL=http://localhost:3000`

---

6. **Implement Authentication in a Component**:
   - Import `signIn` and `useSession` from NextAuth.
   - Use `signIn` for login and `useSession` to check if the user is authenticated.
   - Example:
     ```tsx
     import { signIn, useSession } from 'next-auth/client'

     export default function Home() {
       const [session] = useSession()

       return (
         {session ?
           <>
             <h1>Welcome!</h1>
           </>
           :
           <>
             <Button
               variant="outlined"
               color="secondary"
               startIcon={<AccountCircle />}
               onClick={() => signIn('google')}
             >
               Fazer login
             </Button>
           </>
         }
       );
     }
     ```
