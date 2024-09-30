<?php
include('../includes/connect.php');

if (isset($_POST['insert_cat'])) {
    // Correct the variable name and ensure it matches your form field
    $category_title = $_POST['cat_title']; // Make sure 'cat_title' matches your form field name

    // Fix SQL query syntax: remove single quotes around table and column names
    $select_query = "SELECT * FROM categories WHERE category_title = '$category_title'";
    
    $result_select = mysqli_query($con, $select_query);

    if ($result_select) {
        $number = mysqli_num_rows($result_select);
        if ($number > 0) {
            echo "<script>alert('This Category is present in the database');</script>";
        } else {
            // Use proper table and column names without single quotes
            $insert_query = "INSERT INTO categories (category_title) VALUES ('$category_title')";
            
            $result = mysqli_query($con, $insert_query);
            
            if ($result) {
                echo "<script>alert('Category has been inserted successfully');</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
            }
        }
    } else {
        // Handle query error
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>

<h2 class="text-center">Insert Categories</h2>

<form action ="" method="post" class="mb-2">
<div class="input-group w-90 mb-2">
  <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
  <input type="text" class="form-control"name="cat_title" placeholder="Insert categories" aria-label="Categories" aria-describedby="basic-addon1">
</div>  
<div class="input-group w-10 mb-2 m-auto">
  

  <input type="submit" class="bg-info border-0 p-2 my-3"name="insert_cat" 
  value="Insert Categories">



</div> 
</form>