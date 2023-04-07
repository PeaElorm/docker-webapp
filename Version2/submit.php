<?php
$username = $_POST['username'];
$password = $_POST['password'];
if($username == 'Perfect' && $password == '#2468.') {
    echo "Welcome CodeIgnitor Perfect!";} 
    else{echo "Invalid username or password.";}?>