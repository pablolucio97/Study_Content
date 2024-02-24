# GIT AND GITHUB COURSE

## GIT

Git is a version control system that binds GitHub with your local environment code. Git is used to create local repositories, which can be created using the command `git`.

## GITHUB

GitHub is the social network of code where developers can create and update their own codes and those of others.

## USING MARKDOWN LANGUAGE

### TEXT STYLES

*italic* or __italic__

**bold** or __bold__

_*mixed italic bold*_

~~strached~~

`marked text`

# New title level 1
## New title level 2
### New title level 3

### LIST STYLES

***

1. First item
2. Second item
   1. First subitem

* First circle list item
* Second circle list item
   * First circle subitem

- [ ] Task item.
- [x] Task item realized.

[text](active link)
![text](inactive link)

### TABLE

| Num | Name | Note |
| --- | ---- | ---- |
| 1   | Paul | 9.5  |
| 2   | John | 8.7  |

### EMOJI

:emoji_name:

all emojis: [github.com/ikatyang/emoji-cheat-sheet](https://github.com/ikatyang/emoji-cheat-sheet)

emojis in any input text: [emojipedia.org](https://emojipedia.org)

### MARK PEOPLES

@peoplename
> reply people

## VISUAL STUDIO CODE FILE STATUS

- M: Modified - The file has been modified.
- U: Untracked - The file hasn't been pushed to GitHub yet.

## GIT HUB PROCESS

### CREATING AND COMMITTING A PROJECT WITH GITHUB FOR DESKTOP

1. Click on "new repository", give it a name and a description, always mark the option "Initialize this repository with a README", select the 'MIT license' and click on "Create repository" (CTRL+Enter).
2. Click on "Publish repository" (CTRL+P) to send your local repository to your GitHub.
3. Click on "Open in Visual Studio Code" to open your local repository folder in Visual Studio Code. Working in your project with GitHub for Desktop open, you can see in the "Changes" tab all changes and differences in your project.
4. To save your changes from the local repository to your remote repository (GitHub), type a description for your changes, click on "Commit to master" then click on "Push origin".

### CLONING A REPOSITORY

1. Navigate to the desired repository on github.com, click on 'Clone or download' and then click on 'Open with Desktop'.
2. In GitHub Desktop, choose a folder to clone the repository and click on Clone.
3. If it's a React/React Native project, add the `node_modules` folder to the project and install the project dependencies to work correctly.

### CREATING LOCAL REPOSITORY AND ADDING FILES

1. `git init repository_name`: create a new local repository.
2. `touch file_name`: create a new file.
3. `git add *` or `git add file_name.extension`: add files to the current repository.
4. `git status`: show all changes of the local files.
5. `git commit -m "message"`: moves the changed local files to the current local repository and registers this commit tagged by the message.

### RESTORING A DELETED FILE TO THE PROJECT

1. `git log`: see all commits.
2. `git checkout hash_of_commit --name_of_file`: return with the desired file to the commit.

Note: Use `git checkout --filename` to restore deleted files still not committed.

### TRACKING CHANGES IN THE LOCAL REPOSITORY

1. `git log --oneline`: show the hash of all branches or use `git log --graph`: show a graphic of the commits. The current branch is identified with the Head.
2. `git checkout hash_code`: track and return to the branch version (commit moment).
3. `git checkout file_name`: discard the current changes and return to the previous version of the files.
4. `git checkout master`: undo and return to the last modified branch.

### CREATING NEW BRANCHES AND MERGING TO THE MASTER

1. `git checkout -b branch_name`: creates a new branch (from now, all commits will automatically be done in this branch).
2. `git checkout master`: return to the master branch (from now, all commits will automatically be done in the master branch).
3. `git merge name_of_new_merge`: merge the master branch with an existing branch (the master branch needs to be the current to merge two branches).
4. `git add .` to add changes merging to the master and `git push -u origin master` to sync changes on master in GitHub.
5. `git branch -D branch_name`: deletes the branch created, do it if you will not use this branch anymore.

### LINKING LOCAL REPOSITORY WITH REMOTE REPOSITORY

1. On github.com, create a new repository.
2. `git remote`: verify if there are remote repositories available.
3. `git remote add origin link_of_repository`: links the local repository with the remote repository (if this repository is already used, skip to the next step).
4. `git pull --rebase origin master`: is used to resolve conflict between the local and remote repositories.
5. `git push -u origin master`: send all file changes to the remote repository.

### CONTRIBUTING TO REAL TEAM PROJECTS

1. On the develop branch, run `git pull` to get all remote updates.
2. Create your feature branch.
3. Work on your code and commit it.
4. Run `git log` to check if the latest commits on develop on the remote repository match (are the same) your local commits, excluding your last branch commits. If they are different, run `git pull origin develop --rebase`.
5. Adjust the conflicts using the VsCode conflict resolution tool (if there are any).
6. Stage the altered files by clicking on the "plus icon", commit, and push over the feature branch.

Note: In case the rebase process creates a new branch, remove the staged files from the stage and create a new branch over it. Example: `feat/myFeatureRebased` pushing and committing over this branch, otherwise continue the process normally.

Always update the development branch and create your branch from this branch either by running `git pull origin development` on your branch or hitting a pull on this branch and doing a rebase afterward on your branch from development.

If a Pull request has already been merged and you need to update the code, create a new branch for this code with the updated development branch to not lose any commit.

Note: If you open a pull request and another yet opened pull request is merged before yours and you rebase your current branch based on the branch where the previous pull request was merged, your pull request will contain your files and all the other pull request files.

You don't need to commit before pushing if you haven't any changes.

Run `git pull` at a specific branch to update that specific branch.

### EDITING YOUR LAST COMMIT

1. `git commit --amend -m 'your_message'`
2. Edit your text and type the command `:wq` to exit.

### REMOVING ALL UNTRACKED NEW FILES

1. `git clean -fxd`

### RESOLVING CONFLICTS OF GIT PUSH CAUSED BY FILE DIFFERENCES

1. `git fetch`: download the repository content.
2. `git remote`: get the name of the remote repository.
3. `git checkout remote_repository_name`: open the remote repository folder in the local machine.
4. `git checkout master`: changes to master branch of the repository.
5. `git pull`: synchronize all changes of the remote repository to the local repository (will show the files with changes conflict).
6. On Visual Studio Code, open the files with appointed conflicts and change the option to resolve the conflict (Accept current changes or Accept incoming changes or Accept both changes) and save the file.
7. `git status`.
8. `git add`.
9. `git commit`.

### SYNCHRONIZING CHANGES OF REMOTE REPOSITORY TO LOCAL REPOSITORY

1. `git remote`: verify if there are remote repositories available.
2. `git add remote origin link_of_repository`: links the local repository with the remote repository.
3. On github.com, make your changes.
4. `git pull`: synchronize all changes of the remote repository to the local repository.

### CONTRIBUTING TO ANOTHER PROJECTS (FORK AND PULL REQUEST)

1. On github.com, navigate to the desired repository and click on Fork.
2. On GitHub, go to the new forked repo and clone it to your local machine.
3. Create a new branch to do your changes and switch to it.
4. Edit the desired files and commit them.
5. Do the push with your new branch using the command `git push --set-upstream origin name_of_your_branch`. The changes will appear in your GitHub forked repo.
6. To do a new pull request, in the new branch for the forked repo, click on New Pull Request and then on Create Pull request (the owner of the repository will receive a notification and define if they accept your pull request).

### ADDING A GITHUB PAGE TO YOUR REPOSITORY

1. In your repository, go to settings.
2. In the Github Pages section (bottom of the page), select the master branch and wait (the link of your GitHub page will be generated).

### SYNCHRONIZING CHANGES FROM GITHUB TO LOCAL MACHINE

1. Make the desired changes in the GitHub panel editor.
2. Run `git pull` on your local machine. Your local machine files will be updated.

## ANOTHER FUNCTIONALITIES

`git commit -am 'your commit message'`: add and commit your changes in a single line code.

`git reset`: Avoid the last changes to be committed.

`git reset --hard Head`: remove the current branch to don't be committed.

`git reset --hard hash_code`: undo the last commit of the current branch.

`git log --graph --oneline`: show a graphic of the commits.

`git branch`: show the current branch of the project.

`git diff`: show the file changes before to commit

`git config --global user.name "[name]"`: Set the name that you desire binded at your transitions of commit.

`git config --global user.email "[email_address]"`: Set the email that you desire binded at your transitions of commit.

`git config --global color.ui auto`: Set the color.

### CREATING REPOSITORY

`git init [name_of_project]`: Creates a new local repository with a specific name.

`git clone [URL]`: Download the repository through the URL.

### DOING CHANGES

`git status`: List all new or shifted files to be committed.

`git add [name_of_file]`: Add new files to your project.

`git diff --staged`: Shows the difference between selected files and your latest versions.

`git reset [name_of_file]`: Unselect the file, but maintain your content.

`git commit -m "[message]"`: Create a message explaining a new file add or changes.

### DOING CHANGES IN GROUP

`git branch`: List all local branches in the current repository.

`git branch [name_of_branch]`: Creates a new branch.

`git checkout [name_of_branch]`: Switch to a specific branch and refresh the work directory.

`git merge [branch]`: Combines the history of the specific and current branch.

`git branch -d [name_of_branch]`: Deletes the specific branch.

### HANDLING FILES

`git rm [name_of_file]`: Removes the file from the directory and selects them to remove.

`git rm --cached [name_of_file]`: Constraints the file to not be committed after added.

`git stash`: Stores temporarily all files tracked modified.

`git stash pop`: Restore the recent files in stash.

### ACCESSING THE HISTORY

`git log`: List the history of version to the current branch.

`git log --follow [name_of_file]`: List the history of versions to a file, including changes of name.

`git diff [first_branch] [second_branch]`: Shows the difference between the content of two branches.

`git show [commit]`: Return changes of metadata and content to the specified commit.

`git reset [commit]`: Undo all commits after '[commit]', preserving local changes.

`git reset --hard [commit]`: Unrely all history and changes to the specified commit.

### SYNCHRONIZING CHANGES

`git fetch [marker]`: Download all history of a repository marker.

`git merge [marker]/[branch]`: Combines the marker of branch in the local branch.

`git push [alias] [branch]`: Send all commits of the local branch to GitHub.

`git pull`: Download the history of your remote GitHub repo and incorporates the changes for your local machine project.

### APPLYING SAME COMMIT FROM DIFFERENT REPOSITORIES AT SAME MACHINE

1. On repository A, run the command `git format-patch -1 your_commit_hash --stdout > commit.patch` to create the commit patch that will be used by repository B.
2. On repository B, run the command `git apply path_to_commit_patch`. Example: `git apply /Volumes/mac-ssd/business/ps-course-track/commit.patch`
3. On repository B, commit and push the new commit to GitHub normally.
4. On repository A, delete the `commit.patch` file that will not be used anymore.

## GENERAL TIPS

Each commit should do only one thing. Names your commits in the present (not past) specifying what it does.

Do atomic commits to make it easier to fix possible conflicts when merging branches in the future.

Conflicts generally occur when we're cloning a repo, changing the content in our local machine in a new branch, and pushing it again to GitHub. We should fix it before pushing.

Create a new branch for features, bug fixes, and releases when working on professional projects. Example of a branch: `feature/theme-dark`.

Use `git commit -am 'your commit message'` to add and commit your changes in a single line of code.

The branches of the project vary according to the branches that are created on each machine, so always create new branches when working with local repositories already on GitHub.

GitHub can or cannot create a new rebase branch when rebasing branches. If it's created, create a new branch over this branch, for example: `feat/myFeatRebasecommit`, and push over this rebasing branch.
