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

### CI Example:

```yaml
name: ci-golang-workflow #my CI name
on: 
  pull_request:
    branches:
      - develop
jobs:
  check-application: #my Job name
    runs-on: ubuntu-latest #required for running the Job and its steps
    steps:
      - uses: actions/checkout@v2 #uses image available on github.com/actions/checkout@v2
      - uses: actions/setup-go@v2 #uses image available on github.com/actions/setup-go@v2
        with:
          go-version: 1.15
      - run: go test #uns the Go tests. This command is a feature of the Go programming language that compiles and runs any tests within the current package. It looks for files ending in `_test.go` and executes any test functions defined in those files.
      - run: go run math.go #runs the math.go file
      - name: Set up QEMU #step name
        uses: docker/setup-qemu-action@v1

      - name: Set up Docker Buildx #step name
        uses: docker/setup-buildx-action@v1

      - name: Login to DockerHub #step name
        uses: docker/login-action@v1 
        with:
          username: ${{ secrets.DOCKERHUB_USERNAME }} # DockerHub username stored in GitHub Secrets
          password: ${{ secrets.DOCKERHUB_TOKEN }} # DockerHub token stored in GitHub Secrets

      - name: Build and push #step name
        id: docker_build
        uses: docker/build-push-action@v2
        with:
          push: false
          tags: wesleywillians/fc2.0-ci-go:latest #applies the "latest" tag into the "fc2.0-ci-go" repository on "wesleywillians" account
```

## Protecting branches using Status Check on GitHub

After you have defined your CI instructions, you could go on GitHub, click on your branch that you want to protect, and click on the check "Require status checks to pass before merging", and then select the action you have created. In this case the protected branch will be the develop branch because the yaml configuration:

```yaml
on: 
  pull_request:
    branches:
      - develop
```

## General Tips

- It's possible having more than one workflows for work with GitHub actions.
- You can use already existing actions on GitHub actions available on [GitHub](https://github.com/actions)
- You can optionally specify IDs for your steps for helping identifying it.
- Generally the CI on the Develop/Stage is different from the CI on the Production branch. You must create a CI for `develop` with tests instructions, and a CI containing deploy instructions for the `main` branch.