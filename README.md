# docker-webapp (creating a webapp, Deploying the Docker Conainer with AWS ECS and Fargate, and creating a database)
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

## Pushing Version2 to AWS
- Note: As indicated in the title, we will use AWS ECS, ECR and Fargate. With ECS, we will create a task to deploy our docker image to a container. ECR is the versioned storage for Docker images on AWS. ECR pulls the images from ECR then deploys. Fargate manages the cluster of compute instances, no need for you to manage the unlying infrustructure.
- This guide already assumes you have an IAM user.

### Editing ECS access policy
- Login to your AWS IAM account.
- search for IAM. on the left nav bar, select users.
- select the IAM user and click on add permissions.
- next, click on attach policy directly.
-  Search for AmazonECS_FUllAccess and add it.
- You should see something like this after edit permissions is complete;
![full access](https://user-images.githubusercontent.com/68542385/231045547-fe18a3c1-04ec-4145-98bb-7dc4de9e217c.PNG)

### Deploying the docker container to ECS;
- In your AWS console, search for ECR and select.
- click on Create Repository.
- Under general setting, select public and name your project and then create repositoy.
![repo](https://user-images.githubusercontent.com/68542385/231046975-ab475da1-ddc1-412c-913c-c8b987837846.png)

### Tag the image
- For ECR to know the repo being pushed, we must tag the image with the URI generated when the repo was created.
```yaml
docker tag <image name URI>
docker tag <image name URI>
```

### Making your AWS Account accessible to your Docker CLI
- Input the following into your docker terminal
```yaml
curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
unzip awscliv2.zip
sudo ./aws/install
```
- run aws --version
- now, run aws configure and input your AWS when prompted.

### Create Fargate Cluster.
- Search for ecs in the console
- CLick on create cluster
- Fill in the details and create
![Cluster created](https://user-images.githubusercontent.com/68542385/231052739-148dd8de-a21b-4534-abe8-fa2331cb60ee.PNG)
- CLick on tasks definitions on the side nav snd then click on Creatr new task definition.
- Name the task and select your task memory and cpu. mine was 0.5GB and 0.25vCPU, respectively.
- fill in the rest of the details. you need the ARN for the image URL.
- click add
![task def](https://user-images.githubusercontent.com/68542385/231055402-f362b613-851a-4591-9005-46ee86597b4c.PNG)
- go to the task definition page. select run task in the actions dropdown
- select fargate, at least one vpc and subnet
- click on run task.
- check to be sure task is running
![running](https://user-images.githubusercontent.com/68542385/231055593-dc4e70b4-270e-4167-be50-6a6595d64d92.PNG)
- click on it and open the public ip in another tab. This should show your project.
- Delete the cluster to avoid charges
![delete cluster](https://user-images.githubusercontent.com/68542385/231057175-9924f486-6061-405d-a9c9-7209ea2e032c.PNG)
![stopped](https://user-images.githubusercontent.com/68542385/231057177-25d5f1ea-8e09-4f49-aebe-946fd61f0bd6.PNG)


- Create an Amazon ECS cluster
- Upload/ Push your Image to AWS ECR (like docker hub).
- Create a public repo
- Open the repo
- Click on “view push commands” to see how to push to ECR. *Give your repo the same name to simplify things. E.g., docker-web-app. You will need AWS CLI installed
- Run AWS configure in your terminal: You will need an IAM user (access keys & secret keys
- Go ahead with the commands from AWS. You might need to add an ECR policy for users to run the first command.
 - Set up an Amazon ECS task definition with Fargate launch type and specify the Docker image you just created as the container image for the task definition. (Get the Uri from the repo)
- Launch a new Fargate task using the task definition you just created.  
- (Wait for 5-10 min until everything is running) Access the web app by going to the Fargate task's public IP address.

## Adding a manual DynamoDB table.
purpose: A guestbook table that will allow us record data of all visitors of our webabbp


