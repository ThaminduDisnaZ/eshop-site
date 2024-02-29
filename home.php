

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home | eShop</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="card.css" />
    <link rel="icon" href="resources/tdtech.png" />
    <link rel="stylesheet" href="font-awesome\css\font-awesome.min.css">

</head>

<body class=" bg-dark">

    <div class="container-fluid">
        <div class="row">
            <?php include "header.php";   ?>

            <hr />

            <div class="col-12  justify-content-center">

                <div class="row  mb-3">

                    <div class="offset-4 offset-lg-1 col-4 col-lg-1" style="height: 60px;">
<div></div>
                    
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="input-group mt-3 mb-3">
                            <input type="text" class="form-control" aria-label="Text input with dropdown button" id="basic_search_txt">
                            <select class="form-select" id="basic_search_select">
                                <option value="0">All Catagaries</option>

                                <?php

                             

                                $category_rs = Database::search("SELECT * FROM `category`");

                                $category_num = $category_rs->num_rows;

                                for ($x = 0; $x < $category_num; $x++) {
                                    $category_data = $category_rs->fetch_assoc();
                                ?>

                                    <option value="<?php echo $category_data["id"]; ?>"><?php echo $category_data["name"]; ?></option>

                                <?php

                                }
                                ?>
                            </select>
                        </div>
                        
                    </div >
                  

                    <div class="col-12 col-lg-2 d-grid">
                        <button class="btn btn-primary mt-3 mb-3" onclick="basicSearch(0);">Search</button>
                    </div>

                    <div class="col-12 col-lg-2 mt-2 mt-lg-4 text-center text-lg-start">
                        <a href="advancedSearch.php" class="link-secondary text-decoration-none fw-bold">Advanced</a>
                    </div>
                   
                </div>

                <hr />

              




                        <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="resources\slider images\asus1.jpg" class="d-block w-100">
                                </div>
                                <div class="carousel-item">
                                    <img src="resources\slider images\samsung1.jpg" class="d-block w-100">
                                </div>
                                <div class="carousel-item">
                                    <img src="resources\slider images\keyboard1.jpg" class="d-block w-100">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>


                        <?php
                        $c_rs = Database::search("SELECT * FROM `category`");
                        $c_num = $category_rs->num_rows;

                        for ($y = 0; $y < $c_num; $y++) {
                            $cdata = $c_rs->fetch_assoc();
                        ?>







                            <!--catagory name-->
                            <div class="col-12 mt-3 mb-3">
                                <a href="#" class="text-decoration-none link-light fs-3 fw-bold"><?php echo $cdata["name"] ?></a>&nbsp;&nbsp;
                                <a href="#" class="text-decoration-none link-light fs-6">See All &nbsp;&rarr;</a>
                            </div>
                            <!--catagory name-->


                            <!--products-->
                            <div class="col-12 mb-3">
                                <div class="row border border-warning border-5 rounded-4">
                                    <div class="col-12">
                                        <div class="row justify-content-center gap-2">

                                            <?php

                                            $product_rs = Database::search("SELECT*FROM `product` WHERE `category_id` = '" . $cdata["id"] . "'
                                             AND `status_id` = '1' ORDER BY `datetime_added` DESC LIMIT 4 OFFSET 0 ");

                                            $product_num = $product_rs->num_rows;

                                            for ($z = 0; $z < $product_num; $z++) {
                                                $product_data = $product_rs->fetch_assoc();

                                            ?>
                                                <div class=" card bg-secondary bg-opacity-75 col-6 col-lg-2 mt-2 mb-2 border border-warning border-opacity-50 rounded-4" style="width: 18rem;">
                                                    <?php
                                                    $image_rs = Database::search("SELECT*FROM `images` WHERE `product_id`='" . $product_data["id"] . "' ");
                                                    $image_data = $image_rs->fetch_assoc();
                                                    ?>
                                                    <img src="<?php echo ($image_data["code"]); ?>" class="border border-warning border-3 card-img-top img-thumbnail mt-2 " style="height: 180px;" />
                                                    <div class="card-body ms-0 m-0 text-center">
                                                        <h5 class="text-light"><?php echo $product_data["title"]; ?></h5>


                                                        <?php

                                                        if ($product_data["qty"] > 0) {
                                                        ?>

                                                            <span class="card-text text-warning fw-bold">In Stock</span><br />
                                                            <span class="s fw-bold"><?php echo $product_data["qty"]; ?> Items Available</span><br /><br />
                                                            <div class="border-3 border border-warning mb-4 rounded-3 ">
                                                                <span class="text-light fs-4">Rs.<?php echo $product_data["price"]; ?>.00</span><br />
                                                            </div>
                                                            <a class="col-12 btn btn-success" href="<?php echo "singleProductView.php?id=" . $product_data["id"]; ?>">Buy Now</a>

                                                            <div class="row">

                                                                <button class="col-6 btn btn-danger mt-2" onclick="addToCart(<?php echo $product_data['id']; ?>);"><span class="fa fa-shopping-cart"></span></button>

                                                            <?php
                                                        } else {
                                                            ?>

                                                                <span class="card-text text-warning fw-bold">Out of Stock</span><br />
                                                                <div class="border-3 border border-warning mb-4 rounded-3 ">
                                                                    <span class="text-light fs-4">Rs.<?php echo $product_data["price"]; ?>.00</span><br />
                                                                </div>
                                                                <span class="card-text text-success fw-bold">0 Items Available</span><br /><br />
                                                                <button class="col-12 btn btn-success disabled">Buy Now</button>
                                                                <button class="col-12 btn btn-danger mt-2 disabled">Add to cart</button>

                                                            <?php
                                                        }




                                                            ?>



                                                            <?php

                                                            if (isset($_SESSION["u"])) {
                                                                $data = $_SESSION["u"];



                                                                $watchlist_rs = Database::search("SELECT*FROM `watchlist` WHERE `product_id`='" . $product_data["id"] . "' AND
                                                        `user_email`='" .

                                                                    $_SESSION["u"]["email"] . "'");
                                                                $watchlist_num = $watchlist_rs->num_rows;

                                                                if ($watchlist_num == 1) {
                                                            ?>
                                                                    <button class="col-6 mt-2 btn btn-primary" onclick="addtoWatchlist(<?php echo $product_data['id']; ?>);">
                                                                        <i class=" text-danger fs-5" id="heart<?php echo $product_data['id']; ?>"><span class="fa fa-heart"></span></i>
                                                                    </button>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <button class="col-6 mt-2 btn btn-warning" onclick="addtoWatchlist(<?php echo $product_data['id']; ?>);">
                                                                        <i class=" text-dark fs-5" id="heart<?php echo $product_data['id']; ?>"><span class="fa fa-heart"></span></i>
                                                                    </button>
                                                                <?php
                                                                }
                                                            } else {



                                                                ?>
                                                                <button class="col-6 border mt-2 btn btn-dark" onclick="loginfirst(<?php echo $product_data['id']; ?>);">
                                                                    <i class="bi bi-heart-fill text-reset fs-5" id="heart<?php echo $product_data['id']; ?>"></i>
                                                                </button>
                                                            <?php
                                                            }

                                                            ?>




                                                            <?php









                                                            ?>

                                                            </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>



                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--products-->

                        <?php
                        }
                        ?>


                    </div>
                </div>

            </div>

            <?php include "footer.php"; ?>
        </div>
    </div>


    <script src="script.js"></script>
</body>

</html>