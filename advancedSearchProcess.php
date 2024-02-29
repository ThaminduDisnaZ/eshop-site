<?php

require "connection.php";

$txt = $_POST["t"];
$category = $_POST["c"];
$brand = $_POST["b"];
$model = $_POST["m"];
$condition = $_POST["con"];
$color = $_POST["clr"];
$from = $_POST["f"];
$to = $_POST["to"];
$sort = $_POST["s"];

$query = "SELECT*FROM `product`";
$status = 0;

if ($sort == 0) {

    if (!empty($txt)) {
        $query .= " WHERE `title` LIKE '%" . $txt . "%'";
        $status = 1;
    }

    if ($status == 0 && $category != 0) {
        $query .= " WHERE `category_id`='" . $category . "'";
    } else if ($status != 0 && $category != 0) {
        $query .= " AND `category_id`='" . $category . "'";
    }

    $pid = 0;
    if ($brand != 0 && $model == 0) {

        $brand_rs = Database::search("SELECT*FROM `brand_has_model` WHERE `brand_id`='" . $brand . "'");
        $brand_num = $brand_rs->num_rows;
        for ($x = 0; $x < $brand_num; $x++) {
            $brand_data = $brand_rs->fetch_assoc();
            $pid = $brand_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "'";
            $status = 1;
        }
    }

    if ($brand != 0 && $model != 0) {

        $brand_has_model_rs = Database::search("SELECT*FROM `brand_has_model` WHERE `brand_id`='" . $brand . "'
        AND `model_id`='" . $model . "'");
        $brand_has_model_num = $brand_has_model_rs->num_rows;
        for ($x = 0; $x < $brand_has_model_num; $x++) {
            $brand_has_model_data = $brand_has_model_rs->fetch_assoc();
            $pid = $brand_has_model_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "'";
        }
    }

    if ($status == 0 && $condition != 0) {
        $query .= " WHERE `condition_id`='" . $condition . "'";
        $status = 1;
    } else if ($status != 0 && $condition != 0) {
        $query .= " AND `condition_id`='" . $condition . "'";
    }

    if ($status == 0 && $color != 0) {
        $query .= " WHERE `colour_id`='" . $color . "'";
        $status = 1;
    } else if ($status != 0 && $condition != 0) {
        $query .= " AND `colour_id`='" . $color . "'";
    }

    if (!empty($from) && empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price`>='" . $from . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price`>='" . $from . "'";
        }
    } else if (empty($from) && !empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price`<='" . $to . "'";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price`<='" . $to . "'";
        }
    } else if (!empty($from) && !empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price` BETWEEN '" . $from . "' AND '" . $to . "' ";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` BETWEEN '" . $from . "' AND '" . $to . "' ";
        }
    }
} else if ($sort == 1) {

    if (!empty($txt)) {
        $query .= " WHERE `title` LIKE '%" . $txt . "%' ORDER BY `price` DESC";
        $status = 1;
    }

    if ($status == 0 && $category != 0) {
        $query .= " WHERE `category_id`='" . $category . "' ORDER BY `price` DESC";
    } else if ($status != 0 && $category != 0) {
        $query .= " AND `category_id`='" . $category . "' ORDER BY `price` DESC";
    }

    $pid = 0;
    if ($brand != 0 && $model == 0) {

        $brand_rs = Database::search("SELECT*FROM `brand_has_model` WHERE `brand_id`='" . $brand . "' ORDER BY `price` DESC");
        $brand_num = $brand_rs->num_rows;
        for ($x = 0; $x < $brand_num; $x++) {
            $brand_data = $brand_rs->fetch_assoc();
            $pid = $brand_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "' ORDER BY `price` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "' ORDER BY `price` DESC";
            $status = 1;
        }
    }

    if ($brand != 0 && $model != 0) {

        $brand_has_model_rs = Database::search("SELECT*FROM `brand_has_model` WHERE `brand_id`='" . $brand . "'
        AND `model_id`='" . $model . "' ORDER BY `price` DESC");
        $brand_has_model_num = $brand_has_model_rs->num_rows;
        for ($x = 0; $x < $brand_has_model_num; $x++) {
            $brand_has_model_data = $brand_has_model_rs->fetch_assoc();
            $pid = $brand_has_model_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "' ORDER BY `price` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "' ORDER BY `price` DESC";
        }
    }

    if ($status == 0 && $condition != 0) {
        $query .= " WHERE `condition_id`='" . $condition . "' ORDER BY `price` DESC";
        $status = 1;
    } else if ($status != 0 && $condition != 0) {
        $query .= " AND `condition_id`='" . $condition . "' ORDER BY `price` DESC";
    }

    if ($status == 0 && $color != 0) {
        $query .= " WHERE `colour_id`='" . $color . "' ORDER BY `price` DESC";
        $status = 1;
    } else if ($status != 0 && $condition != 0) {
        $query .= " AND `colour_id`='" . $color . "' ORDER BY `price` DESC";
    }

    if (!empty($from) && empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price`>='" . $from . "' ORDER BY `price` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price`>='" . $from . "' ORDER BY `price` DESC";
        }
    } else if (empty($from) && !empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price`<='" . $to . "' ORDER BY `price` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price`<='" . $to . "' ORDER BY `price` DESC";
        }
    } else if (!empty($from) && !empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price` BETWEEN '" . $from . "' AND '" . $to . "' ORDER BY `price` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` BETWEEN '" . $from . "' AND '" . $to . "' ORDER BY `price` DESC";
        }
    }
} else if ($sort == 2) {
    if (!empty($txt)) {
        $query .= " WHERE `title` LIKE '%" . $txt . "%' ORDER BY `price` ASC";
        $status = 1;
    }

    if ($status == 0 && $category != 0) {
        $query .= " WHERE `category_id`='" . $category . "' ORDER BY `price` ASC";
    } else if ($status != 0 && $category != 0) {
        $query .= " AND `category_id`='" . $category . "' ORDER BY `price` ASC";
    }

    $pid = 0;
    if ($brand != 0 && $model == 0) {

        $brand_rs = Database::search("SELECT*FROM `brand_has_model` WHERE `brand_id`='" . $brand . "' ORDER BY `price` ASC");
        $brand_num = $brand_rs->num_rows;
        for ($x = 0; $x < $brand_num; $x++) {
            $brand_data = $brand_rs->fetch_assoc();
            $pid = $brand_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "' ORDER BY `price` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "' ORDER BY `price` ASC";
            $status = 1;
        }
    }

    if ($brand != 0 && $model != 0) {

        $brand_has_model_rs = Database::search("SELECT*FROM `brand_has_model` WHERE `brand_id`='" . $brand . "'
        AND `model_id`='" . $model . "' ORDER BY `price` ASC");
        $brand_has_model_num = $brand_has_model_rs->num_rows;
        for ($x = 0; $x < $brand_has_model_num; $x++) {
            $brand_has_model_data = $brand_has_model_rs->fetch_assoc();
            $pid = $brand_has_model_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "' ORDER BY `price` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "' ORDER BY `price` ASC";
        }
    }

    if ($status == 0 && $condition != 0) {
        $query .= " WHERE `condition_id`='" . $condition . "' ORDER BY `price` ASC";
        $status = 1;
    } else if ($status != 0 && $condition != 0) {
        $query .= " AND `condition_id`='" . $condition . "' ORDER BY `price` ASC";
    }

    if ($status == 0 && $color != 0) {
        $query .= " WHERE `colour_id`='" . $color . "' ORDER BY `price` ASC";
        $status = 1;
    } else if ($status != 0 && $condition != 0) {
        $query .= " AND `colour_id`='" . $color . "' ORDER BY `price` ASC";
    }

    if (!empty($from) && empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price`>='" . $from . "' ORDER BY `price` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price`>='" . $from . "' ORDER BY `price` ASC";
        }
    } else if (empty($from) && !empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price`<='" . $to . "' ORDER BY `price` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price`<='" . $to . "' ORDER BY `price` ASC";
        }
    } else if (!empty($from) && !empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price` BETWEEN '" . $from . "' AND '" . $to . "' ORDER BY `price` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` BETWEEN '" . $from . "' AND '" . $to . "' ORDER BY `price` ASC";
        }
    }
} else if ($sort == 3) {

    if (!empty($txt)) {
        $query .= " WHERE `title` LIKE '%" . $txt . "%' ORDER BY `qty` DESC";
        $status = 1;
    }

    if ($status == 0 && $category != 0) {
        $query .= " WHERE `category_id`='" . $category . "' ORDER BY `qty` DESC";
    } else if ($status != 0 && $category != 0) {
        $query .= " AND `category_id`='" . $category . "' ORDER BY `qty` DESC";
    }

    $pid = 0;
    if ($brand != 0 && $model == 0) {

        $brand_rs = Database::search("SELECT*FROM `brand_has_model` WHERE `brand_id`='" . $brand . "' ORDER BY `qty` DESC");
        $brand_num = $brand_rs->num_rows;
        for ($x = 0; $x < $brand_num; $x++) {
            $brand_data = $brand_rs->fetch_assoc();
            $pid = $brand_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "' ORDER BY `qty` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "' ORDER BY `qty` DESC";
            $status = 1;
        }
    }

    if ($brand != 0 && $model != 0) {

        $brand_has_model_rs = Database::search("SELECT*FROM `brand_has_model` WHERE `brand_id`='" . $brand . "'
        AND `model_id`='" . $model . "' ORDER BY `qty` DESC");
        $brand_has_model_num = $brand_has_model_rs->num_rows;
        for ($x = 0; $x < $brand_has_model_num; $x++) {
            $brand_has_model_data = $brand_has_model_rs->fetch_assoc();
            $pid = $brand_has_model_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "' ORDER BY `qty` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "' ORDER BY `qty` DESC";
        }
    }

    if ($status == 0 && $condition != 0) {
        $query .= " WHERE `condition_id`='" . $condition . "' ORDER BY `qty` DESC";
        $status = 1;
    } else if ($status != 0 && $condition != 0) {
        $query .= " AND `condition_id`='" . $condition . "' ORDER BY `qty` DESC";
    }

    if ($status == 0 && $color != 0) {
        $query .= " WHERE `colour_id`='" . $color . "' ORDER BY `qty` DESC";
        $status = 1;
    } else if ($status != 0 && $condition != 0) {
        $query .= " AND `colour_id`='" . $color . "' ORDER BY `qty` DESC";
    }

    if (!empty($from) && empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price`>='" . $from . "' ORDER BY `qty` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price`>='" . $from . "' ORDER BY `qty` DESC";
        }
    } else if (empty($from) && !empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price`<='" . $to . "' ORDER BY `qty` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price`<='" . $to . "' ORDER BY `qty` DESC";
        }
    } else if (!empty($from) && !empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price` BETWEEN '" . $from . "' AND '" . $to . "' ORDER BY `qty` DESC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` BETWEEN '" . $from . "' AND '" . $to . "' ORDER BY `qty` DESC";
        }
    }

} else if ($sort == 4) {

    if (!empty($txt)) {
        $query .= " WHERE `title` LIKE '%" . $txt . "%' ORDER BY `qty` ASC";
        $status = 1;
    }

    if ($status == 0 && $category != 0) {
        $query .= " WHERE `category_id`='" . $category . "' ORDER BY `qty` ASC";
    } else if ($status != 0 && $category != 0) {
        $query .= " AND `category_id`='" . $category . "' ORDER BY `qty` ASC";
    }

    $pid = 0;
    if ($brand != 0 && $model == 0) {

        $brand_rs = Database::search("SELECT*FROM `brand_has_model` WHERE `brand_id`='" . $brand . "' ORDER BY `qty` ASC");
        $brand_num = $brand_rs->num_rows;
        for ($x = 0; $x < $brand_num; $x++) {
            $brand_data = $brand_rs->fetch_assoc();
            $pid = $brand_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "' ORDER BY `qty` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "' ORDER BY `qty` ASC";
            $status = 1;
        }
    }

    if ($brand != 0 && $model != 0) {

        $brand_has_model_rs = Database::search("SELECT*FROM `brand_has_model` WHERE `brand_id`='" . $brand . "'
        AND `model_id`='" . $model . "' ORDER BY `qty` ASC");
        $brand_has_model_num = $brand_has_model_rs->num_rows;
        for ($x = 0; $x < $brand_has_model_num; $x++) {
            $brand_has_model_data = $brand_has_model_rs->fetch_assoc();
            $pid = $brand_has_model_data["id"];
        }

        if ($status == 0) {
            $query .= " WHERE `brand_has_model_id`='" . $pid . "' ORDER BY `qty` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `brand_has_model_id`='" . $pid . "' ORDER BY `qty` ASC";
        }
    }

    if ($status == 0 && $condition != 0) {
        $query .= " WHERE `condition_id`='" . $condition . "' ORDER BY `qty` ASC";
        $status = 1;
    } else if ($status != 0 && $condition != 0) {
        $query .= " AND `condition_id`='" . $condition . "' ORDER BY `qty` ASC";
    }

    if ($status == 0 && $color != 0) {
        $query .= " WHERE `colour_id`='" . $color . "' ORDER BY `qty` ASC";
        $status = 1;
    } else if ($status != 0 && $condition != 0) {
        $query .= " AND `colour_id`='" . $color . "' ORDER BY `qty` ASC";
    }

    if (!empty($from) && empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price`>='" . $from . "' ORDER BY `qty` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price`>='" . $from . "' ORDER BY `qty` ASC";
        }
    } else if (empty($from) && !empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price`<='" . $to . "' ORDER BY `qty` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price`<='" . $to . "' ORDER BY `qty` ASC";
        }
    } else if (!empty($from) && !empty($to)) {
        if ($status = 0) {
            $query .= " WHERE `price` BETWEEN '" . $from . "' AND '" . $to . "' ORDER BY `qty` ASC";
            $status = 1;
        } else if ($status != 0) {
            $query .= " AND `price` BETWEEN '" . $from . "' AND '" . $to . "' ORDER BY `qty` ASC";
        }
    }

}

?>

<?php

if ($_POST["page"] != "0") {

    $pageno = $_POST["page"];
} else {

    $pageno = 1;
}

$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

$results_per_page = 10;
$number_of_pages = ceil($product_num / $results_per_page);

$viewed_results_count = ((int)$pageno - 1) * $results_per_page;

$query .= " LIMIT " . $results_per_page . " OFFSET " . $viewed_results_count . "";
$results_rs = Database::search($query);
$results_num = $results_rs->num_rows;

while ($results_data = $results_rs->fetch_assoc()) {
?>

    <div class="card mb-3 mt-3 col-12 col-lg-6">
        <div class="row">

            <div class="col-md-4 mt-4">

                <img src="resources/mobile_images/iphone12.jpg" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">

                    <h5 class="card-title fw-bold"><?php echo $results_data["title"]; ?></h5>
                    <span class="card-text text-primary fw-bold">Rs. <?php echo $results_data["price"]; ?>.00</span>
                    <br />
                    <span class="card-text text-success fw-bold fs"><?php echo $results_data["qty"]; ?> Items Left</span>

                    <div class="row">
                        <div class="col-12">

                            <div class="row g-1">
                                <div class="col-12 col-lg-6 d-grid">
                                    <a href="#" class="btn btn-success fs">Buy Now</a>
                                </div>
                                <div class="col-12 col-lg-6 d-grid">
                                    <a href="#" class="btn btn-danger fs">Add Cart</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

<?php
}

?>



<div class="offset-lg-4 col-12 col-lg-4 mb-3 text-center">

    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-lg justify-content-center">

            <li class="page-item">
                <a class="page-link" <?php if ($pageno <= 1) {
                                            echo "#";
                                        } else {
                                        ?> onclick="advancedSearch('<?php echo ($pageno - 1); ?>')" <?php
                                                                                                } ?>>&laquo;
                </a>
            </li>

            <?php

            for ($page = 1; $page <= $number_of_pages; $page++) {

                if ($page == $pageno) {

            ?>
                    <li class="page-item">
                        <a class="page-link" onclick="advancedSearch('<?php echo ($page); ?>')" class="active">
                            <?php echo $page; ?>
                        </a>
                    </li>
                <?php

                } else {

                ?>
                    <li class="page-item">
                        <a class="page-link" onclick="advancedSearch('<?php echo ($page); ?>')">
                            <?php echo $page; ?>
                        </a>
                    </li>
            <?php

                }
            }

            ?>
            <li class="page-item">
                <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                            echo "#";
                                        } else {
                                        ?> onclick="advancedSearch('<?php echo ($pageno + 1); ?>')" <?php
                                                                                                } ?> aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>

        </ul>
    </nav>

</div>