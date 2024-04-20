<?php
        require "connection.php";
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="bootstrap.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-red navbar-dark">
        <div class="wrapper">

        </div>
        <div class="container-fluid all-show">
            <a class="navbar-brand" href="index.php">TD Tech <i class="fa fa-laptop"></i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto mb-2 mb-lg-0">



                    <?php

if (isset($_SESSION["u"])) {
    $data = $_SESSION["u"];

?>

                    <?php
}
?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#"></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="watchlist.php">Watchlist</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="myProducts.php">My Products</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="cart.php"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn w-100 btn-warning" href="advancedSearch.php">Search.. <span
                                class="fa fa-search"><a></a></span></a>
                    </li>
                    <li class="nav-item">
                        <nav class="navbar bg-body-tertiary">

                            <form class="d-flex" role="search">
                                <div class="btn-group">
                                    <!-- Example split danger button -->



                            </form>

                        </nav>
                    </li>


                </ul>



                <div class="d-flex flex-column sim">

                    <div>

                    </div>





                    <?php



if (isset($_SESSION["u"])) {
    $data = $_SESSION["u"];

?>
                    <?php
   
$email = $_SESSION["u"]["email"];
        $Profile_image_rs = Database::search("SELECT * FROM `profile_image`
        WHERE `user_email`='" . $email . "'");
        $Profile_image_num = $Profile_image_rs->num_rows;
        $Profile_image_data = $Profile_image_rs->fetch_assoc();

        if ($Profile_image_num == 1) {
        ?>
                    <img src="<?php echo ($Profile_image_data["path"]); ?>" width="50px" height="50px"
                        class="rounded-circle" />
                    <?php
        } else {
        ?>

                    <img src="resources/profile_image/new user.svg" width="50px" height="50px" class="rounded-circle" />

                    <?php
        }

        ?>

                </div>



                <div class="dropdown-center dropdown">
                    <button style="border-radius: 5px;" class="dropdown-toggle text-bg-dark text-bg-opacity-10"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="text-lg-start"><b>Welcome </b><?php echo ($data["fname"]); ?></span><br>
                        <span class="text-lg-start"><?php echo ($data["email"]); ?></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li> <a class="dropdown-item" onclick="signout();">Sign Out</a></li>
                        <li><a class="dropdown-item" href="userProfile.php">My Profile</a></li>

                    </ul>
                </div>



            </div>



            <?php

if (empty($image_data["path"])) {


           
                
    } else {
    ?>
            <img src="<?php echo $image_data["path"]; ?>" class="rounded" style="width: 15px;" id="viewImg" />
            <?php
    }
} else {

?>




            <button href="login.php" style="border-radius: 5px;" class=" text-bg-dark text-bg-opacity-10" type="button">
                <a href="login.php"></i> <span class="text-lg-start"><b>Sign In </b>or</span><br></a>
                <span class="text-lg-start"><a href="login.php"></a>Register</span>
            </button>


            <?php
}

?>


        </div>
        </div>
        </div>
    </nav>






    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="bootstrap.js"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>