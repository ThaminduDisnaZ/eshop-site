<?php

session_start();
require "connection.php";

if(isset($_SESSION["u"])){
    if(isset($_GET["id"])){

        $email = $_SESSION["u"]["email"];
        $pid = $_GET["id"];

        $watchlist_rs = Database::search("SELECT*FROM `watchlist` WHERE `product_id`='" . $pid . "' AND
        `user_email`='" .$email . "'");
        $watchlist_num = $watchlist_rs->num_rows;

        if($watchlist_num == 1){

            $watchlist_data = $watchlist_rs->fetch_assoc();
            $list_id = $watchlist_data["id"];

            Database::iud("DELETE FROM `watchlist` WHERE `id`='".$list_id."'");
            echo("removed");

        }else{

            Database::iud("INSERT INTO `watchlist`(`product_id`,`user_email`) VALUES ('".$pid."','".$email."')");
            echo("added");

        }

    }else{
        echo("Something went wrong");
    }

}else{
    echo("Please Login First");
}
