<?php

session_start();

if(isset($_SESSION["u"])){

    session_destroy();
    echo("success");
}
?>