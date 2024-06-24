# CI CD Concepts and Practices

## Concepts

### CI

The acronymous CI means continuos integration and it is the process of integrating modifications onto the codebase in a continuous and automatized way to avoid human errors. When a CI is called, some tests, tags generations, and commit verification should be done. The main CI tools are:

- GitHub actions
- Jenkins
- CircleCI
- GitLab Pipelines/CI


## GitHub actions concepts

GitHub actions is a workflow automatization tool that is based on GitHub's events.

### Status Check

Is a feature on GitHub that grants a Pull Request can't be merged into a repository without pass through a CI process.

### Events
Events are specific activities that trigger workflows. Some common events include:
- **push**: Triggered when code is pushed to a repository.
- **pull_request**: Triggered when a pull request is opened, synchronized, or reopened.
- **schedule**: Triggered at scheduled times using cron syntax.
- **workflow_dispatch**: Triggered manually with the UI or GitHub API.

### Uses
The `uses` keyword specifies the action to be used in a job step. Actions can be from the GitHub Marketplace or defined in your repository.

### Run
The `run` keyword is used to execute commands in a job step. It can run shell commands, scripts, or executables.

### Actions
Actions are custom applications for the GitHub Actions platform that automate tasks within your CI/CD pipeline. You can use existing actions or create your own.

### Custom Actions
Custom actions can be written in JavaScript or as Docker containers. They include metadata files that define their inputs, outputs, and main execution files.

### Filters
Filters allow you to control when a workflow should run based on branch names, tags, or paths.

### Branch Filters
Branch filters control the execution of workflows based on branch patterns.

### Path Filters
Path filters allow workflows to run based on changes to specific files or directories in the repository.



## CI Workflow flow:

![img](https://i.ibb.co/xg9n7h9/Screenshot-2024-06-24-at-07-52-15.png)

## General Tips

- It's possible having more than one workflows for work with GitHub actions.
- You can use already existing actions on GitHub actions available on [GitHub](https://github.com/actions)