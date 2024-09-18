# Doing deploys on Firebase Hosting using Vite.

1. Create the project on Firebase Console.
2. After creating the project, add a web application for this project on Firebase Console.
3. Run `npm run build` to generate your Vite project build over the "dist" folder.
4. On your terminal, run `firebase login` to authenticate into your Firebase account.
5. On your terminal, run `firebase init`, select "Hosting", then follow the prompts:
   - Choose the Firebase project you created for this app.
   - Specify `dist` as your public directory.
   - Configure as a single-page application: answer "yes".
   - Overwrite `index.html`: answer "no" if Vite has already created it.
6. After configuring Firebase, deploy your project by running `firebase deploy`.
7. Once deployed, Firebase will provide you with a URL to access your hosted application.

## Additional Tips

- **Environment Variables**: Make sure to configure your `.env.production` file with the correct `VITE_API_BASEURL` or any other environment variables your application needs. When Vite builds your project, Vite will automatically include these variables in the build. 
- **Continuous Integration**: Set up GitHub Actions or other CI/CD tools to automate your builds and deployments directly from your repository to Firebase Hosting.
- **Custom Domain**: If you want to use a custom domain instead of the default `web.app` or `firebaseapp.com` domain, Firebase Console provides an easy way to configure custom domains including SSL certificate provisioning.
- **Security Rules**: Firebase Hosting allows you to specify headers and other security configurations in the `firebase.json` file, enhancing your app’s security posture.
- **Cache Control**: Use Firebase's `firebase.json` to set caching headers for your assets to optimize load times and reduce bandwidth usage.

