<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <style>
    .admin_image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
    }

    .logo {
        width: 40px;
        height: auto;
    }

    .button a {
        font-size: 0.9rem;
        padding: 10px;
        margin: 5px 0;
        display: block;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-info py-3">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <a href="#"><img src="../images/logo.jpg" alt="Logo" class="logo"></a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white">Welcome, Admin</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Manage Details Section -->
        <div class="bg-light py-2">
            <h3 class="text-center p-3">Manage Details</h3>
        </div>

        <!-- Admin Profile Section -->
        <div class="row">
            <div class="col-md-12 bg-secondary p-4 d-flex flex-column align-items-center text-center text-white">
                <img src="../images/pineapple.jpg" alt="Admin" class="admin_image mb-2">
                <h4>Admin Name</h4>
                <div class="button m-4 d-flex gap-4 w-300">
                    <a href="insert_product.php" class="btn btn-info text-white mb-2">Insert Products</a>
                    <a href="../product.php" class="btn btn-info text-white mb-2">View Products</a>
                    <a href="insert_categories.php" class="btn btn-info text-white mb-2">Insert Categories</a>
                    <a href="#" class="btn btn-info text-white mb-2">View Categories</a>
                    <a href="insert_brands.php" class="btn btn-info text-white mb-2">Insert Brands</a>
                    <a href="#" class="btn btn-info text-white mb-2">View Brands</a>
                    <a href="#" class="btn btn-info text-white mb-2">All Orders</a>
                    <a href="#" class="btn btn-info text-white mb-2">All Payments</a>
                    <a href="#" class="btn btn-info text-white mb-2">List Users</a>
                    <a href="#" class="btn btn-warning text-dark mb-2">Layout</a>
                </div>
            </div>

            <!-- Content Section -->

        </div>
    </div>

    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6"></script>
</body>

</html>