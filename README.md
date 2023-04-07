# docker-webapp
The form:![login form](https://user-images.githubusercontent.com/68542385/230667621-83c4fd17-45e6-45c2-813f-0c64cfd9631e.PNG)

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
inside the submit.php
```yaml
<?php
$username = $_POST['username'];
$password = $_POST['password'];
if($username == 'admin' && $password == 'password') {
    echo "Welcome! This is codeIgnitors' admin";} 
    else{echo "Invalid username or password.";}?>
```
- docker build -t perfectelorm/docker-webapp .
- docker run -p 8080:80 perfectelorm/docker-webapp
