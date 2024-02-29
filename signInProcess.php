<?php

require "connection.php";
session_start();

$email = $_POST["e"];
$password = $_POST["p"];
$rememberme = $_POST["r"];

if(empty($email)){
    echo("Please enter your email !!!");
}else if(strlen($email)>100){
    echo("Email must have less than 100");
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo("Inval id email");
}else if(empty($password)){
    echo("Please enter your password !!!");
}else if(strlen($password) < 5 || strlen($password) >20){
    echo("Password must be between 5-10 characters");
}else{
    
    $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' AND `password`='".$password."'");

    $n = $rs->num_rows;
    
    if($n == 1){

        echo("success");
        $d = $rs->fetch_assoc();
        $_SESSION["u"] = $d;

        if($rememberme == "true"){
            setcookie("email",$email,time()+(60*60*24*365));
            setcookie("password",$password,time()+(60*60*24*365));
        }else{
            setcookie("email","",-1);
            setcookie("password","",-1);
        }

    }else {
        echo("Invaild Username or Password");
    }
}

?>