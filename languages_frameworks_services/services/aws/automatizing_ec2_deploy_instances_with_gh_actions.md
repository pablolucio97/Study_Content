# Automating EC2 Instances Deploy Process with GitHub Actions CI/CD

When GitHub identifies you've committed, it runs an action (GitHub Actions) based on commands you've specified. This avoids the need to access the EC2 instance manually to pull code updates.

---

## Step 1: Generate SSH Key and Authorize Access

On your EC2 Linux instance:

```bash
ssh-keygen -t rsa -b 4096 -C "github-actions" -f ~/.ssh/github_actions
cat ~/.ssh/github_actions.pub
```

Copy the output and run:

```bash
cat >> ~/.ssh/authorized_keys
# paste the copied public key
# then press CTRL+D to save
```

---

## Step 2: Add SSH Private Key to GitHub Secrets

```bash
cat ~/.ssh/github_actions
```

Copy the private key content and add it to your GitHub repository as a secret:

- Navigate to your repository → **Settings** → **Secrets and variables** → **Actions** → **New repository secret**
- Name: `SSH_KEY`, Value: (paste the key)

---

## Step 3: Add Additional Secrets

- `SSH_HOST`: Public IP or DNS of the EC2 instance (found in AWS Console)
- `SSH_USER`: EC2 user (e.g., `ubuntu`, `ec2-user`)
- `SSH_PORT`: Usually `22`

---

## Step 4: Create GitHub Action Workflow

On GitHub, go to **Actions** → **Set up a workflow yourself**, and paste the following:

```yaml
name: CI/CD Deployment

on:
  push:
    branches: [ "main" ]
  workflow_dispatch:

jobs:
  deploy:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout Code
        uses: actions/checkout@v3

      - name: Setup Node.js
        uses: actions/setup-node@v3
        with:
          node-version: 18

      - name: Install Dependencies
        run: npm install

      - name: Build Project
        run: npm run build

      - name: Transfer Files to EC2
        uses: appleboy/scp-action@master
        with:
          host: ${{ secrets.SSH_HOST }}
          username: ${{ secrets.SSH_USER }}
          port: ${{ secrets.SSH_PORT }}
          key: ${{ secrets.SSH_KEY }}
          source: "., !node_modules"
          target: "~/app"

      - name: Update API on EC2
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.SSH_HOST }}
          username: ${{ secrets.SSH_USER }}
          port: ${{ secrets.SSH_PORT }}
          key: ${{ secrets.SSH_KEY }}
          script: |
            cd ~/app
            npm install
            npx typeorm migration:run
            pm2 restart my-app
```

> 📌 **Note**: Make sure `pm2`, `typeorm`, and Node.js are installed on the EC2 instance.

---

## Step 5: Commit and Run

- Click on **Start Commit**
- Provide a commit message
- Click **Commit new file**
- GitHub will trigger the workflow and show logs under the **Actions** tab

---

## References

- https://github.com/appleboy/scp-action
- https://github.com/appleboy/ssh-action

---

## Tips

- GitHub Actions typically watch the `main` or `master` branch
- **Jobs** define the processes run by the workflow
- YAML is space-sensitive—use `-` only with `name` and `uses` (never mix)

