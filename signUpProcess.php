<?php

require "connection.php";

$fname = $_POST["f"];
$lname = $_POST["l"];
$email = $_POST["e"];
$password = $_POST["p"];
$mobile = $_POST["m"];
$gender = $_POST["g"];

if(empty($fname)){
    echo("Please enter your first name !!!");
}else if(strlen($fname)>50){
    echo("First name must have less than 50 characters");
}else if(empty($lname)){
    echo("Please enter your last name !!!");
}else if(strlen($lname)>50){
    echo("Last name must have less than 50 characters");
}else if(empty($email)){
    echo("Please enter your email !!!");
}else if(strlen($email)>100){
    echo("Last name must have less than 100 characters");
}else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo("Invalid email");
}else if(empty($password)){
    echo("Please enter your password !!!");
}else if(strlen($password) < 5 || strlen($password) >20){
    echo("Password must be between 5-10 characters");
}else if(empty($mobile)){
    echo("Please enter your mobile !!!");
}else if(strlen($mobile) != 10){
    echo("Mobile must have 10 characters");
}else if(!preg_match("/07[0,1,2,3,4,5,6,7,8][0-9]/",$mobile)){
    echo("Invalid Mobile !!!");
}else{
    
    $rs = Database::search("SELECT*FROM `user` WHERE `email`='".$email."' OR `mobile`='".$mobile."'");
    $n = $rs->num_rows;

    if($n>0){
        echo("User with same email or mobile already exist");
    }else{
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user`
        (`fname`,`lname`,`email`,`mobile`,`password`,`gender_id`,`joined_date`,`status`)VALUES
        ('".$fname."','".$lname."','".$email."','".$mobile."','".$password."','".$gender."','".$date."','1')");
    
        echo("success");
    }

}
