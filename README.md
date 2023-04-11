# docker-webapp (creating a webapp, hosting on AWS ECS, and creating a database)
##Creating the Project Files
- On your computer, create a project folder. for the start, we will need two versions, go ahead and create two subfolders V1 and V2
- code in the contents of your project into the respective subfolders.
- Commit to github. 
- The project in my case is a simple login form for my team. the version1(V1) is a simple static form. Version2(V2) is dynamic.
- Add a docker file to both versions.
inside the dockerfile
```yaml
# Use an official PHP runtime as a parent image
FROM php:7.4-apache
# Set the working directory to /var/www/html
WORKDIR /var/www/html
# Copy the contents of the current directory into the container at /var/www/html
COPY . /var/www/html
# Expose port 80
EXPOSE 80
```
- This is how my form is looking;

![login form](https://user-images.githubusercontent.com/68542385/230667621-83c4fd17-45e6-45c2-813f-0c64cfd9631e.PNG)

- Because V1 is a static form, it just contains an HTML, CSS and a dockerfile.
- Version 2 contains the same plus a php file, which give the user a feedback after the form is submitted.
- inside the submit.php
```yaml
<?php
$username = $_POST['username'];
$password = $_POST['password'];
if($username == 'Perfect' && $password == '#2468.') {
    echo "Welcome! This is codeIgnitors' admin";} 
    else{echo "Invalid username or password.";}?>
```

## Building and running the containers
- docker build -t perfectelorm/docker-webapp .
- docker run -p 8080:80 perfectelorm/docker-webapp
- open port 8080 to view your project.
- NB: I chose to run my project in Gitpod (I already have the docker extenxion and configurations done)


