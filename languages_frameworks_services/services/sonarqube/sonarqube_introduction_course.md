# SonarQube introduction course

## Concepts

SonarQube is a powerful tool for continuous inspection of code quality that can identify bugs and security vulnerabilities in the codebase.

### Rules
Rules are the set of rules for grant code quality for each language.

### Profiles
Profile is a set of rules defined by the administrator. 

### Quality Profiles
Quality Profiles is the default SonarQube's set of rules defined according to the programming language. You can copy, modify, and use these profiles according to your needs.

### Quality Gates
Are the set of configurable metrics used to measure the quality of your project and define if your project is attending to the project quality requirements. Here you can defined the tests coverage percentage and the percentage of allowed duplicated lines.


## Installing and using SonarQube on your porjects

1. Download the SonarQube Docker's image running the command `docker run -d --name sonarqube -e SONAR_ES_BOOTSTRAP_CHECKS_DISABLE=true -p 9000:9000 sonarqube:latest`.
2. Access the SonarQube at 9000 port, authenticate with `admin` login and password, then define your personal password.
3. Create a new project to be scanned. You must create a new project, generate a token for the project, and copy this token.
4. On your code repository, at the root directory, create a file named sonar-scanner.properties containing your sonar project key/name. Example: 
```properties 
# must be unique in a given SonarQube instance
sonar.projectKey=sonnar-test

# --- optional properties ---

# defaults to project key
#sonar.projectName=My project
# defaults to 'not provided'
#sonar.projectVersion=1.0
 
# Path is relative to the sonar-project.properties file. Defaults to .
#sonar.sources=.
 
# Encoding of the source code. Default is default system encoding
#sonar.sourceEncoding=UTF-8
```

5. Run the command `docker run \
    --platform linux/amd64 \
    --rm \
    -e SONAR_HOST_URL="http://host.docker.internal:9000" \
    -e SONAR_TOKEN="your_project_token" \
    -v "your_project_dir" \
    sonarsource/sonar-scanner-cli`, with your poject directory and token, example : `docker run \
    --platform linux/amd64 \
    --rm \
    -e SONAR_HOST_URL="http://host.docker.internal:9000" \
    -e SONAR_TOKEN="sqp_b0d8cd5e7f6a0313127e9498ef6cfe92909dd3b5" \
    -v "/Volumes/mac-ssd/studies/projects/sonnar-test:/usr/src" \
    sonarsource/sonar-scanner-cli`

6. Wait for the Sonnar analyses and access the results on the generated URL, example: `http://localhost:9000/dashboard?id=sonnar-test&codeScope=overall`

