<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Watchlist | eShop</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resources/logo.svg" />

</head>

<body class="bg-dark">
    <div class="container-fluid">
        <div class="row">

            <?php include "header.php";

            if (isset($_SESSION["u"])) {
            ?>



                <div class="col-12">
                    <div class="row">
                        <div class="col-12  rounded">
                            <div class="row">

                                <div class=" col-4"> 
                                    <label class="text-light mt-3  fs-1 fw-bold">Watchlist &hearts;</label>
                                </div>

                                <div class="col-12">
                                    <hr />
                                </div>

          
                                <div class="col-12">
                                    <hr />
                                </div>

                                <?php

                                require "connection.php";
                                $user = $_SESSION["u"]["email"];
                                $watch_rs = Database::search("SELECT*FROM `watchlist` WHERE `user_email`='" . $user . "'");
                                $watch_num = $watch_rs->num_rows;

                                if ($watch_num == 0) {
                                ?>
                                    <!--emaptyView-->
                                    <div class="col-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-12 emptyView"></div>
                                            <div class="col-12 text-center">
                                                <label class="form-label fs-1 fw-bold">You have no item in your Watchlist yet</label>
                                            </div>
                                            <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                                                <a href="home.php" class="btn btn-outline-warning fs-3 fw-bold">Start Shopping</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--emaptyView-->
                                <?php
                                } else {
                                ?>
                                    <div class="col-12  col-lg-11">
                                        <div class="row">
                                            <?php
                                            for ($x = 0; $x < $watch_num; $x++) {
                                                $watch_data = $watch_rs->fetch_assoc();
                                            ?>
                                                <!--have product-->


                                                <div class="card bg-light bg-opacity-25 border-4 border-warning mb-3 mx-0 mx-lg-2 col-12">
                                                    <div class="row g-0">
                                                        <div class="col-md-4 text-center">
                                                            <?php
                                                            $image_rs = Database::search("SELECT*FROM `images` WHERE `product_id`='" . $watch_data["product_id"] . "' ");
                                                            $image_data = $image_rs->fetch_assoc();
                                                            ?>
                                                            <img src="<?php echo ($image_data["code"]); ?>" class="card-img-top img-thumbnail mt-2" style="height: 180px;width: 180px;" />
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="card-body">
                                                                <?php
                                                                $product_rs = Database::search("SELECT*FROM `product` WHERE `id`='" . $watch_data["product_id"] . "' ");
                                                                $product_data = $product_rs->fetch_assoc();
                                                                ?>
                                                                <h5 class="card-title text-light fw-bold"><?php echo $product_data["title"] ?></h5>
                                                                <?php
                                                                $color_rs = Database::search("SELECT*FROM `colour` WHERE `id`='" . $product_data["colour_id"] . "' ");
                                                                $color_data = $color_rs->fetch_assoc();
                                                                ?>
                                                                <span class="fs-5 fw-bold text-black-50">Colour : <span class="text-light"><?php echo $color_data["name"] ?></span></span>
                                                                &nbsp;&nbsp; | &nbsp;&nbsp;
                                                                <?php
                                                                $status_rs = Database::search("SELECT*FROM `condition` WHERE `id`='" . $product_data["condition_id"] . "' ");
                                                                $status_data = $status_rs->fetch_assoc();
                                                                ?>
                                                                <span class="fs-5 fw-bold text-black-50"o>Condition :  <span class="text-light"><?php echo $status_data["name"] ?></span></span><br>
                                                                <span class="fs-5 fw-bold text-black-50">Price : </span>&nbsp;&nbsp;
                                                                <span class="fs-5 fw-bold text-black"><span class="text-light">Rs. <?php echo $product_data["price"] ?>.00</span></span></br>
                                                                <span class="fs-5 fw-bold text-black-50">Quantity : </span>&nbsp;&nbsp;
                                                                <span class="fs-5 fw-bold text-light"><?php echo $product_data["qty"] ?> Items Availale</span></br>
                                                                <?php
                                                                $seller_rs = Database::search("SELECT*FROM `user` WHERE `email`='" . $product_data["user_email"] . "'");
                                                                $seller_data = $seller_rs->fetch_assoc();
                                                                ?>

                                                                <br>
                                                                <br>
                                                                <div class="border-3 border-danger">
                                                                <span class="fs-5 fw-bold text-black-50">Seller : </span>
                                                                <span class="fs-5 fw-bold text-warning"><?php echo $seller_data["fname"]." ".$seller_data["lname"] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mt-5">
                                                            <div class="card-body d-lg-grid">
                                                                <a href="#" class="btn btn-outline-success mb-2">Buy Now</a>
                                                                <a href="#" class="btn btn-outline-warning mb-2">Add to Cart</a>
                                                                <a href="#" class="btn btn-outline-danger mb-2" onclick='removeFromWatchlist(<?php echo $watch_data["id"]; ?>);'>Remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!--have product-->

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>





                            </div>
                        </div>
                    </div>
                </div>

            <?php

            } else {
                echo ("Please Login First");
            }
            ?>

            <?php include "footer.php" ?>

        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>