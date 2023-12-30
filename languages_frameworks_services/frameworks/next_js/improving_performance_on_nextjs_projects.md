# DOING DEPLOY AT VERCEL

1. **Pre-Deployment Checks**:
   - Ensure your code is production-ready and properly committed.

---

2. **Create a New Project on Vercel**:
   - Go to [Vercel's New Project Page](https://vercel.com/new) to start a new project.

---

3. **Set Up Environment Variables and Deploy**:
   - Skip the team step on Vercel.
   - Add your environment variables.
   - Proceed with the deployment.

---

5. **Adjust OAuth for Deployed Application**:
   - For applications using OAuth, update the application's redirect URLs.
   - Go to [GitHub's Developer Settings](https://github.com/settings/developers), click on `OAuth Apps`, and select your application.
   - Change the 'Authorization callback URL' and 'Homepage URL'.
   - Example:
     ```
     Authorization callback URL: https://ignews-pablosilva.vercel.app/api/auth/callback
     Homepage URL: https://ignews-pablosilva.vercel.app/
     ```

---

6. **Configure NextAuth for Vercel**:
   - If using NextAuth, add an environment variable named `NEXTAUTH_URL` with your deployed application's URL.
   - Example: `https://ignews.vercel.app/`
   - Set this in your Vercel environment variables panel.

---

## GENERAL TIPS

- Add all environment variables of your application in the Vercel panel.
- Ensure all services communicating with NextAuth redirect to your new Vercel URL.
- Update your `baseURL` in services/api to the new Vercel URL.
- If using MongoDB, add environment variables for `MongoURI` and `MongoDbName`.
- Allow your Mongo cluster to accept connections from all IPs by setting `0.0.0.0/0` as the default IP.
