<?php
$username = $_POST['username'];
$password = $_POST['password'];
if($username == 'Perfect' && $password == '#2468.') {
    header('Location: table.php');} 
    else{echo "Invalid username or password.";}?>