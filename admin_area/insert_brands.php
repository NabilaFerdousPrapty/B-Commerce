<?php
include('../includes/connect.php'); // Adjusted path

// Check if the form was submitted
if (isset($_POST['insert_brand'])) {
    // Get the brand title from the form and escape it to prevent SQL injection
    $brand_title = mysqli_real_escape_string($con, $_POST['brand_title']);

    // Check if the brand title is not empty
    if (empty($brand_title)) {
        echo "<script>alert('Brand title cannot be empty');</script>";
        exit();
    }

    // Check if the brand already exists in the database
    $select_query = "SELECT * FROM brands WHERE brand_title = '$brand_title'";
    $result_select = mysqli_query($con, $select_query);

    if ($result_select) {
        $number = mysqli_num_rows($result_select);

        if ($number > 0) {
            echo "<script>alert('This brand is already present in the database');</script>";
        } else {
            // Insert the new brand into the database
            $insert_query = "INSERT INTO brands (brand_title) VALUES ('$brand_title')";
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

<!-- Form Section with Improved Bootstrap Styling -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-info text-white text-center">
                    <h2 class="fw-bold">Insert Brand</h2>
                </div>
                <div class="card-body p-4">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="brand_title" class="form-label fw-semibold">Brand Title</label>
                            <div class="input-group">
                                <span class="input-group-text bg-info text-white" id="basic-addon1">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input type="text" class="form-control" name="brand_title"
                                    placeholder="Enter brand name" aria-label="Brand Title"
                                    aria-describedby="basic-addon1" required>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" name="insert_brand" class="btn btn-info btn-lg text-white">
                                <i class="fas fa-plus me-2"></i> Insert Brand
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>