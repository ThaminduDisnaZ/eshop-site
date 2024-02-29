<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Profile | eShop</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resources/logo.svg" />

</head>

<body class="">

    <div class="container-fluid">
        <div class="row">
            <?php include "header.php" ?>

            <?php

            if (isset($_SESSION["u"])) {
                $email = $_SESSION["u"]["email"];

                // $details_rs = Database::search("SELECT*FROM `user` INNER JOIN `profile_image` ON 
                // user.email = profile_image.user_email INNER JOIN `user_has_address` ON
                // user.email = user_has_address.user_email INNER JOIN `city` ON
                // user_has_address.city_id=city.id INNER JOIN `district` ON
                // city.district_id=district.id INNER JOIN `province` ON 
                // district.province_id=province.id INNER JOIN `gender` ON 
                // gender.id=user.gender_id WHERE `email`='" . $email . "'");

                $details_rs = Database::search("SELECT*FROM `user` INNER JOIN `gender` ON 
                gender.id=user.gender_id WHERE `email`='" . $email . "'");

                $image_rs = Database::search("SELECT*FROM `profile_image` WHERE `user_email`='" . $email . "'");

                $address_rs = Database::search("SELECT*FROM `user_has_address` INNER JOIN `city` ON
                user_has_address.city_id=city.id INNER JOIN `district` ON
                city.district_id=district.id INNER JOIN `province` ON 
                district.province_id=province.id WHERE `user_email`='" . $email . "'");

                $data = $details_rs->fetch_assoc();
                $image_data = $image_rs->fetch_assoc();
                $address_data = $address_rs->fetch_assoc();


            ?>

                <div class="col-12  ">
                    <div class="row">

                        <div class="col-12 rounded mt-4 mb-4 ">
                            <div class="row g-2">

                                <div class="col-md-3 borde border-end">
                                    <div class="d-flex flex-column align-items-center m-4 border text-center p-3 py-5 ">

                                        <?php

                                        if (empty($image_data["path"])) {
                                        ?>
                                            <img src="resources/profile_image/new user1.svg" class="rounded mt-5" style="width: 150px;" id="viewImg" />
                                        <?php
                                        } else {
                                        ?>
                                            <img src="<?php echo $image_data["path"]; ?>" class="rounded mt-5" style="width: 150px;" id="viewImg" />
                                        <?php
                                        }
                                        ?>


                                        <span class="fw-bold"><?php echo ($data["fname"]); ?> <?php echo ($data["lname"]); ?></span>
                                        <span class="fw-bold text-black-50"><?php echo ($data["email"]); ?></span>

                                        <input type="file" class="d-none" id="profileimg" accept="image/*" />
                                        <label for="profileimg" class="btn btn-primary mt-5" onclick="changeImage();">Update Profile Image</label>
                                    </div>
                                </div>

                                <div class="col-md-5 m-3 border-dark pbg rounded-4 border">
                                    <div class="p-3 py-5 ">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="fw-bold">Profile Settings</h4>
                                        </div>

                                        <div class="row mt-4 ">

                                            <div class="col-6">
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="fname" value="<?php echo $data["fname"]; ?>" />
                                            </div>

                                            <div class="col-6">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="lname" value="<?php echo $data["lname"]; ?>" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Mobile Number</label>
                                                <input type="text" class="form-control" id="mobile" value="<?php echo $data["mobile"]; ?>" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" readonly aria-label="Receipent's username" value="<?php echo $data["password"]; ?>" />
                                                    <span class="input-group-text bg-primary" id="basic-addon2">
                                                        <i class="bi bi-eye-slash-fill"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" value="<?php echo $data["email"]; ?>" disabled />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Registered Date</label>
                                                <input type="text" class="form-control" value="<?php echo $data["joined_date"]; ?>" disabled />
                                            </div>
                                            <?php

                                            if (!empty($address_data["line1"])) {

                                            ?>

                                                <div class="col-12">
                                                    <label class="form-label">Address Line 01</label>
                                                    <input type="text" class="form-control" id="line1" value="<?php echo $address_data["line1"]; ?>" />
                                                </div>

                                            <?php
                                            } else {


                                            ?>
                                                <div class="col-12">
                                                    <label class="form-label">Address Line 01</label>
                                                    <input type="text" class="form-control" id="line1" />
                                                </div>


                                            <?php
                                            }
                                            if (!empty($address_data["line2"])) {

                                            ?>

                                                <div class="col-12">
                                                    <label class="form-label">Address Line 02</label>
                                                    <input type="text" class="form-control" id="line2" value="<?php echo $address_data["line2"]; ?>" />
                                                </div>

                                            <?php
                                            } else {


                                            ?>
                                                <div class="col-12">
                                                    <label class="form-label">Address Line 02</label>
                                                    <input type="text" class="form-control" id="line2" />
                                                </div>


                                            <?php
                                            }
                                            $province_rs = Database::search("SELECT*FROM `province`");
                                            $district_rs = Database::search("SELECT*FROM `district`");


                                            ?>



                                            <div class="col-12">
                                                <label class="form-label">Province</label>
                                                <select class="form-select" id="province">
                                                    <option value="0">Select Province</option>
                                                    <?php

                                                    $province_num = $province_rs->num_rows;
                                                    for ($x = 0; $x < $province_num; $x++) {

                                                        $province_data = $province_rs->fetch_assoc();
                                                    ?>

                                                        <option value="<?php echo ($province_data["id"]); ?>" <?php if (!empty($address_data["province_id"])) {

                                                                                                                    if ($province_data["id"] == $address_data["province_id"]) {
                                                                                                                ?>selected<?php
                                                                                                                        }
                                                                                                                    } ?>><?php echo ($province_data["name"]); ?></option>

                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">District</label>
                                                <select class="form-select" id="district">
                                                    <option value="0">Select District</option>

                                                    <?php

                                                    $district_num = $district_rs->num_rows;
                                                    for ($x = 0; $x < $district_num; $x++) {

                                                        $district_data = $district_rs->fetch_assoc();
                                                    ?>

                                                        <option value="<?php echo ($district_data["id"]); ?>" <?php if (!empty($address_data["district_id"])) {
                                                                                                                    if ($district_data["id"] == $address_data["district_id"]) {
                                                                                                                ?>selected<?php
                                                                                                                    }
                                                                                                                } ?>><?php echo ($district_data["name"]); ?></option>

                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">City</label>
                                                <select class="form-select" id="city">
                                                    <option value="0">Select City</option>
                                                    <?php
                                                    $city_rs = Database::search("SELECT * FROM `city`");
                                                    $city_num = $city_rs->num_rows;
                                                    for ($x = 0; $x < $city_num; $x++) {
                                                        
                                                        $city_data = $city_rs->fetch_assoc();
                                                    ?>

                                                        <option value="<?php echo ($city_data["id"]); ?>" <?php if (!empty($address_data["city_id"])) {
                                                                                                            if ($city_data["id"] == $address_data["city_id"]) {
                                                                                                        ?>selected<?php
                                                                                                            }
                                                                                                        } ?>><?php echo ($city_data["name"]); ?></option>

                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </div>

                                            <?php

                                            if (!empty($address_data["postal_code"])) {
                                            ?>

                                                <div class="col-12">
                                                    <label class="form-label">Postal-Code</label>
                                                    <input type="text" class="form-control" id="pcode" value="<?php echo ($address_data["postal_code"]) ?>" />
                                                </div>

                                            <?php
                                            } else {
                                            ?>
                                                <div class="col-12">
                                                    <label class="form-label">Postal-Code</label>
                                                    <input type="text" class="form-control" id="pcode" />
                                                </div>
                                            <?php
                                            }

                                            ?>



                                            <div class="col-12">
                                                <label class="form-label">Gender</label>
                                                <input type="text" class="form-control" disabled readonly value="<?php echo $data["gender_name"] ?>" />
                                            </div>

                                            <div class="col-12 d-grid mt-3">
                                                <button class="btn btn-primary col-12" onclick="updateProfile();">Update My Profile</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 text-center">
                                    
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            <?php

            } else {
                header("Location:http://localhost/eshop/home.php");
            }


            ?>



            <?php include "footer.php" ?>
        </div>
    </div>


    <script src="script.js"></script>
</body>

</html>