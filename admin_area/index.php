<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" href="../style.css"> -->
    <style>
        .admin_image {
            width: 100px; /* Adjust as needed */
            height: auto; /* Maintain aspect ratio */
            object-fit: contain;
        }
        .logo {
            width: 50px; /* Adjust as needed */
            height: auto; /* Maintain aspect ratio */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="container-fluid p-0 nn">
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="../images/logo.jpg" alt="" class="logo">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link">Welcome Guest</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Manage Details Section -->
        <div class="bg-light">
            <h3 class="text-center p-2">Manage Details</h3>
        </div>

        <!-- Admin Profile Section -->
        <div class="row">
            <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
                <div class="p-3">
                    <a href="#"><img src="../images/pineapple.jpg" alt="" class="admin_image"></a>
                    <p class="text-light text-center">Admin Name</p>
                </div>
                <div class="button text-center">
                    <button class="my-3"><a href="insert_product.php" class="nav-link text-light bg-info my-1">Insert Products</a></button>
                    <button><a href="#" class="nav-link text-light bg-info my-1">View Products</a></button>
                    <button><a href="index.php?insert_category" class="nav-link text-light bg-info my-1">Insert Categories</a></button>
                    <button><a href="#" class="nav-link text-light bg-info my-1">View Categories</a></button>
                    <button><a href="index.php?insert_brand" class="nav-link text-light bg-info my-1">Insert Brands</a></button>
                    <button><a href="#" class="nav-link text-light bg-info my-1">View Brands</a></button>
                    <button><a href="#" class="nav-link text-light bg-info my-1">All Orders</a></button>
                    <button><a href="#" class="nav-link text-light bg-info my-1">All Payments</a></button>
                    <button><a href="#" class="nav-link text-light bg-info my-1">List Users</a></button>
                    <button><a href="#" class="nav-link text-light bg-info my-1">Layout</a></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container my-3">
        <?php
        if(isset($_GET['insert_category'])){
            include('insert_categories.php');
        }
        if(isset($_GET['insert_brand'])){
            include('insert_brands.php');
        }
        ?>
    </div>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6"></script>
</body>
</html>
