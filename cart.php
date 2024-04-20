<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cart | eShop</title>

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
                $email = $_SESSION["u"]["email"];

                $total = 0;
                $subtotal = 0;
                $shipping = 0;

            ?>
          
                <div class="col-12 border mt-3 border-1 border-warning border-3 rounded-4 mb-3">
                    <div class="row">



                        <div class="col-12">
                            <hr />
                        </div>

            
                        <div class="col-12">
                            <hr />
                        </div>

                        <?php

                        $cart_rs = Database::search("SELECT*FROM `cart` WHERE `user_email`='" . $email . "'");
                        $cart_num = $cart_rs->num_rows;

                        if ($cart_num == 0) {
                        ?>

                            <!--emapty View-->
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 emptyCart"></div>
                                    <div class="col-12 text-center mb-2">
                                        <label class="form-label fs-1 fw-bold">
                                            You have no item in your cart yet.
                                        </label>
                                    </div>
                                    <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                                        <a href="home.php" class="btn btn-outline-info fs-3 fw-bold">
                                            Start Shopping
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--emapty View-->

                        <?php
                        } else {
                        ?>

                            <!--Products-->
                            <div class="col-12 col-lg-8">
                                <div class="row ">

                                    <?php

                                    for ($x = 0; $x < $cart_num; $x++) {

                                        $cart_data = $cart_rs->fetch_assoc();

                                        $product_rs = Database::search("SELECT*FROM `product` WHERE `id`='" . $cart_data["product_id"] . "'");
                                        $product_data = $product_rs->fetch_assoc();

                                        $total = $total + ($product_data["price"] * $cart_data["qty"]);
                                        
                                        $shipping =   $shipping  + ($product_data["delivery_fee_other"]);


                                        $address_rs = Database::search("SELECT district.id AS did FROM `user_has_address` INNER JOIN `city` ON
                                        user_has_address.city_id = city.id INNER JOIN `district` ON city.district_id = district.id WHERE 
                                        `user_email`='" . $email . "'");

                                        $address_data = $address_rs->fetch_assoc();

                                        $ship = $product_data["delivery_fee_other"];
                                
                                        $seller_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "'");
                                        $seller_data = $seller_rs->fetch_assoc();
                                        $seller = $seller_data["fname"] . " " . $seller_data["lname"];

                                    ?>



                                        <div class="card bg-light bg-opacity-50 border-warning mb-5 mx-5 col-10">
                                            <div class="row g-0 text-light">
                                                <div class="col-md-12 mt-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <span class="fw-bold text-black-50 fs-5">Seller :</span>&nbsp;
                                                            <span class="fw-bold text-black fs-5"><?php echo $seller; ?></span>&nbsp;
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="col-md-4">

                                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?php $product_data["description"]; ?>" title="Product Details">
                                                       
                                                        <?php
                                                    $image_rs = Database::search("SELECT*FROM `images` WHERE `product_id`='" . $product_data["id"] . "' ");
                                                    $image_data = $image_rs->fetch_assoc();
                                                    ?>
                                                        <img src="<?php echo ($image_data["code"]); ?>" class="border border-warning border-3 card-img-top img-thumbnail mt-2 " style="height: 180px;" />
                                                    </span>

                                                </div>
                                                <div class="col-md-5">
                                                    <div class="card-body">

                                                        <h3 class="card-title"><?php echo $product_data["title"]; ?></h3>

                                                      

                                                        &nbsp; <span class="fw-bold text-black-50">Condition : Band New</span>
                                                        <br>
                                                        <span class="fw-bold text-black-50 fs-5">Price :</span>&nbsp;
                                                        <span class="fw-bold text-black fs-5">Rs.<?php echo $product_data["price"]; ?>.00</span>
                                                        <br>
                                                        <span class="fw-bold text-black-50 fs-5">Quantity :</span>&nbsp;
                                                        <input type="number" class="mt-3 col-3 border border-2 border-secondary fs-4 fw-bold px-3 cardqtytext" min="1" value="1" id="qty" onkeyup='checkValue(<?php echo $product_data["qty"]; ?>);'>

                                                        <br /><br />
                                                        <span class="fw-bold text-black-50 fs-5">Delivery Fee :</span>&nbsp;
                                                        <span class="fw-bold text-black fs-5">Rs.<?php echo $ship; ?>.00</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card-body d-grid">
                                                        <a class="btn btn-outline-success mb-2">Buy Now</a>
                                                        <a class="btn btn-outline-danger mb-2" onclick="deleteFromCart(<?php echo ($cart_data['id']); ?>);">Remove</a>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="col-md-12 mt-3 mb-3">
                                                    <div class="row">
                                                        <div class="col-6 col-md-6">
                                                            <span class="fw-bold fs-5 text-black-50">Requested Total <i class="bi bi-info-circle"></i></span>
                                                        </div>
                                                        <div class="col-6 col-md-6 text-end">
                                                            <span class="fw-bold fs-5 text-black-50">Rs.<?php echo $product_data["price"] * $cart_data['qty'] + $ship ?>.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <!--Products-->


                            <!--Summery-->
                            <div class="col-10 col-lg-3 bg-light  h-75  rounded-3 border-3 m-5 border-warning bg-opacity-50">
                                <div class="row">

                                    <div class="col-12">
                                        <label class="form-label fs-3 fw-bold">Summary</label>
                                    </div>

                                    <div class="col-12">
                                        <hr />
                                    </div>

                                    <div class="col-6 mb-3">
                                        <span class="fs-6 fw-bold">items (<?php echo $cart_num; ?>)</span>
                                    </div>

                                    <div class="col-6 text-end mb-3">
                                        <span class="fs-6 fw-bold">Rs. <?php echo $total; ?>.00</span>
                                    </div>

                                    <div class="col-6">
                                        <span class="fs-6 fw-bold">Shipping</span>
                                    </div>

                                    <div class="col-6 text-end">
                                        <span class="fs-6 fw-bold">Rs. <?php echo $shipping; ?>.00</span>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <hr />
                                    </div>

                                    <div class="col-6 mt-2">
                                        <span class="fs-4 fw-bold">Total</span>
                                    </div>

                                    <div class="col-6 mt-2 text-end">
                                        <span class="fs-4 fw-bold">Rs. <?php echo ($total + $shipping) ?>.00</span>
                                    </div>

                                    <div class="col-12 mt-3 mb-3 d-grid">
                                        <button class="btn btn-primary fs-5 fw-bold">CHECKOUT</button>
                                    </div>

                                </div>
                            </div>

                            <!--Summery-->

                        <?php
                        }
                        ?>

                    </div>
                </div>
            <?php

            } else {
                echo ("Sign in or Register");
            }

            ?>

            <?php include "footer.php"; ?>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
</body>

</html>