# Performing CI with Dockerfile

Creating a CI with Dockerfile is a very useful process to grant your application is working fine on Docker. Your CI must execute the application, run tests and verifications, and generate the build to be used on production.

### Example of CI with Docker

1. Create the Dockerfile containing your application.

```Dockerfile
FROM golang:1.19

WORKDIR /app

RUN go mod init teste

COPY . .

RUN go build -o math

CMD ["./math"]
```

Dockerfile example explanation

**FROM golang:1.19**
This line sets the base image for the Docker container. It uses the official Go (Golang) image version 1.19. This image includes Go language tools and dependencies necessary to build and run Go applications.

**WORKDIR /app**
This line sets the working directory inside the container to `/app`. All subsequent commands will be executed in this directory. If the directory does not exist, it will be created.

**RUN go mod init teste**
This line runs the `go mod init teste` command inside the container. It initializes a new Go module named `teste`. This command creates a `go.mod` file, which is used for dependency management in Go.

**COPY . .**
This line copies all the files and directories from the current directory on the host machine to the working directory (`/app`) in the container. The first `.` refers to the current directory on the host, and the second `.` refers to the current directory in the container.

**RUN go build -o math**
This line runs the `go build -o math` command inside the container. It compiles the Go application and creates an executable named `math`. The `-o math` flag specifies the output filename for the compiled binary.

**CMD ["./math"]**
This line sets the default command to run when the container starts. It executes the `math` binary created in the previous step. The `CMD` instruction uses JSON array syntax to ensure that the command and its arguments are properly parsed.

2. Create your CI file using the actions [Build and Push Docker Images](https://docs.github.com/en/actions/publishing-packages/publishing-docker-images) and [Docker Buildx](https://github.com/marketplace/actions/docker-setup-buildx). Example:


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
        uses: docker/setup-qemu-action@v1 #setups docker to be able to work in different SOs architectures

      - name: Set up Docker Buildx #step name
        uses: docker/setup-buildx-action@v1 #generates  Docker's image build for multiple SOs architectures

      - name: Login to DockerHub #step name
        uses: docker/login-action@v1
        with:
          username: ${{ secrets.DOCKERHUB_USERNAME }} # DockerHub username stored in GitHub Secrets
          password: ${{ secrets.DOCKERHUB_TOKEN }} # Token provided by DockerHub stored in GitHub Secrets

      - name: Build and push #step name
        id: docker_build #this action result will be used
        uses: docker/build-push-action@v2 #builds the Docker file and optionally push it into the Docker Hub
        with:
          push: true
          tags: wesleywillians/fc2.0-ci-go:latest #applies the "latest" tag into the "fc2.0-ci-go" repository on "wesleywillians" account
```

3. After this action be performed on GitHub, you be able to download this same image on your local machine or where you need.