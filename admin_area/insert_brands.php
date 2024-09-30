<?php
include('./includes/connect.php');

// Check if the form was submitted
if (isset($_POST['insert_brand'])) {
    // Get the brand title from the form and escape it to prevent SQL injection
    $brand_title = mysqli_real_escape_string($con, $_POST['brand_title']);

    // Debugging: Print received data
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    // Check if the brand title is not empty
    if (empty($brand_title)) {
        echo "<script>alert('Brand title cannot be empty');</script>";
        exit();
    }

    // Check if the brand already exists in the database
    $select_query = "SELECT * FROM brands WHERE brand_title = '$brand_title'";
    echo "Select Query: " . $select_query . "<br>"; // Debugging: Print the select query
    $result_select = mysqli_query($con, $select_query);

    if ($result_select) {
        $number = mysqli_num_rows($result_select);
        echo "Number of rows found: " . $number . "<br>"; // Debugging: Print number of rows found

        if ($number > 0) {
            echo "<script>alert('This brand is already present in the database');</script>";
        } else {
            // Insert the new brand into the database
            $insert_query = "INSERT INTO brands (brand_title) VALUES ('$brand_title')";
            echo "Insert Query: " . $insert_query . "<br>"; // Debugging: Print the insert query
            $result = mysqli_query($con, $insert_query);

            if ($result) {
                echo "<script>alert('Brand has been inserted successfully');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
                error_log("Insert Error: " . mysqli_error($con)); // Log error for further investigation
            }
        }
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        error_log("Select Error: " . mysqli_error($con)); // Log error for further investigation
    }
}
?>

<h2 class="text-center">Insert Brands</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="brand_title" placeholder="Insert Brands" aria-label="brands" aria-describedby="basic-addon1">
    </div>  
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_brand" value="Insert Brands">
    </div> 
</form>
