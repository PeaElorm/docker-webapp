<?php
$username = $_POST['username'];
$password = $_POST['password'];
if($username == 'perfect' && $password == '#2468.') {
    echo "Welcome Perfect!";} 
    else{echo "Invalid username or password.";}?>