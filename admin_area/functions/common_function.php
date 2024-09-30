<?php
// Search product functionality
// Search product functionality with brand and category filtering
function search_product() {
    global $con;

    $search_query = "SELECT * FROM products WHERE 1";

    // Handle search data
    if (isset($_GET['search_data_product'])) {
        $search_data_value = mysqli_real_escape_string($con, $_GET['search_data']);
        $search_query .= " AND product_keywords LIKE '%$search_data_value%'";
    }

    // Handle brand filtering
    if (isset($_GET['brand_id'])) {
        $brand_id = mysqli_real_escape_string($con, $_GET['brand_id']);
        $search_query .= " AND brand_id = '$brand_id'";
    }

    // Handle category filtering
    if (isset($_GET['category_id'])) {
        $category_id = mysqli_real_escape_string($con, $_GET['category_id']);
        $search_query .= " AND category_id = '$category_id'";
    }

    $result_query = mysqli_query($con, $search_query);

    if (!$result_query) {
        die("Error fetching products: " . mysqli_error($con));
    }

    $num_of_rows = mysqli_num_rows($result_query);

    if ($num_of_rows == 0) {
        echo "<h2 class='text-center text-danger'>Sorry! No products found matching your search.</h2>";
    } else {
        while ($row = mysqli_fetch_assoc($result_query)) {
            displayProduct($row);
        }
    }
}


// Function to display individual products
function displayProduct($row) {
    $product_id = $row['product_id'];
    $product_title = $row['product_title'];
    $product_description = $row['product_description'];
    $product_image1 = $row['product_image1'];
    $product_price = $row['product_price'];

    echo "<div class='col-md-4 mb-2'>
            <div class='card'>
                <img src='./admin_area/product_images/$product_image1' class='card-img-top product-img' alt='$product_title'>
                <div class='card-body'>
                    <h5 class='card-title'>$product_title</h5>
                    <p class='card-text'>$product_description</p>
                    <p class='card-text'>Price :$product_price</p>
                    
                    <div class='btn-group'>
                        <a href='#' class='btn btn-info'>Add to cart</a>
                        <a href='#' class='btn btn-secondary'>View More</a>
                    </div>
                </div>
            </div>
          </div>";
}

// Get brands function
function getbrands() {
    global $con;

    $select_brands = "SELECT * FROM brands";
    $result_brands = mysqli_query($con, $select_brands);

    if (!$result_brands) {
        echo "<li class='nav-item'><a href='#' class='nav-link text-light'>Error fetching brands: " . mysqli_error($con) . "</a></li>";
        return;
    }

    while ($row = mysqli_fetch_assoc($result_brands)) {
        $brand_id = $row['brand_id'];
        $brand_title = $row['brand_title'];
        echo "<li class='nav-item'>
                <a href='search_product.php?brand_id=$brand_id' class='nav-link text-light'>$brand_title</a>
              </li>";
    }
}

// Get categories function
function getcategories() {
    global $con;

    $select_categories = "SELECT * FROM categories";
    $result_categories = mysqli_query($con, $select_categories);

    if (!$result_categories) {
        echo "<li class='nav-item'><a href='#' class='nav-link text-light'>Error fetching categories: " . mysqli_error($con) . "</a></li>";
        return;
    }

    while ($row = mysqli_fetch_assoc($result_categories)) {
        $category_id = $row['category_id'];
        $category_title = $row['category_title'];
        echo "<li class='nav-item'>
                <a href='search_product.php?category_id=$category_id' class='nav-link text-light'>$category_title</a>
              </li>";
    }
}

?>
