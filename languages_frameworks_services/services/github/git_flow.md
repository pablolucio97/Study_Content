# GIT FLOW INTRODUCTION COURSE

Git Flow is a method of working with Git in a team environment. It is recommended for version control, semantic versioning, and collaborative development.

The Git Flow typically includes the following branches: `main`, `develop`, and `stage`. Each new feature starts from the updated `develop` branch. After the feature is developed and approved, it is merged back into `develop`, then merged into `stage` for testing, and finally into `main` for production deployment. Some companies works with `hotfix` branch too, this kind of branch is useful to push urge code without needing updates from `development` branch.

---

## MAIN TYPES OF BRANCHES

- **Develop**: The branch where all new features are created from.
- **Stage / Release**: The branch where merged code from `develop` is tested before moving to `main`.
- **Main**: The production branch containing fully tested and approved code.
- **Hotfix**: The branch used for urgent fixes in production. It's used to not depend on development branch and not be necessary waiting for next update to fix some bug.

---

## WORKING WITH GIT FLOW

1. Git creates the `main` branch by default. Create the `develop` branch:  
   `git checkout -b develop`

2. Create a new feature branch from `develop`:  
   `git checkout -b name-feature`

3. After finishing your feature:  
   `git checkout develop`  
   `git merge name-feature`

4. Create a release branch:  
   `git checkout -b release/1.0.0`

5. Merge `develop` into `release`:  
   `git merge develop`

6. Merge the release into `main`:  
   `git checkout main`  
   `git merge release/1.0.0`

---

## GENERAL TIPS

- Always create feature branches from the **updated** `develop` branch.
- Always run `git pull` on `develop` before starting a new feature branch.
- There is no single correct convention—each project can have its own Git flow based on team policy or owner preference.
- Feature branches **must not** interact directly with the `main` branch—only with `develop`.
- The main benefit of a hotfix branch is to allow urgent fixes to go directly to main (production) without waiting for ongoing development in develop to finish.
