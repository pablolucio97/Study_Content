# Deploying services on Heroku

Heroku is a back-end host service used for deploying back-end applications with a free tier limit and so paid plans. You can use free tier limit just adding a credit card and then selecting a plan further.

## Deploying services
1. Create your Heroku account and log in it.
2. Download/install the Heroku CLI.
3. Run the command `heroku login` to authentication into your Heroku account.
4. Create your app on Heroku using Heroku's dashboard.
5. Run the `heroku git:remote -a your-app-on-heroku-name` command to link your current repository to Heroku.
6. Run `git push heroku main` to push your current repository to Heroku and wait for the deployment.
7. Run the command `heroku config:set YOUR_ENVIRONMENT_VARIABLE="your-variable-content"` e.g: `heroku config:set DATABASE_URL="postgresql://admin:admin@books-db:5432/books-db?schema=public"` to configure environment variables. Repeat the process for each environment variable you have in your project.


## Observations
- Heroku only will be free if your application does not need and addon e.g: heroku-postgresql:essential-0.
- Heroku's container runtime environment doesn't support Docker Compose directly, and it handles networking differently compared to local Docker or Docker Compose environments. Use Heroku Postgres (paid, starts from $ 5/month) instead a Docker Postgres image.
- Deploying dockerized applications on Heroku can be complex and provide some charging because it needs some addons if your application is using some image for database. You can use Supabase to create your database and its table, but it can be a complex and manual process.