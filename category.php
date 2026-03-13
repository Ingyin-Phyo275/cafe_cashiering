<?php

require_once('categoryclass.php');
$db = new Database("localhost", "root", "", "cafe");
$category = new Category($db);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cafe Cashiering System</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/logo.png" />
    <style>
        .card { margin-bottom: 20px; }
        .card-header { color: #563F36; border-bottom: 1px solid #495057; font-weight: bold; font-size: 1.2rem; }
        .card-body { background-color: #fff; }
        thead { background-color: #563F36; color: white; font-weight: bolder; }
        .btnadd { background-color: #563F36; color: white; }
        .btnadd:hover { background-color: greenyellow; color: black; }
        .modal-title { color: #563F36; }
        .modal-body { color: black; }
    </style>
</head>
<body>
<div class="container-scroller">
    <div class="horizontal-menu">
        <!-- Navbar and sidebar code -->
        <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
            <ul class="navbar-nav navbar-nav-left">
             
            </ul>
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="index.html">Cafe Cashiering</a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a>
            </div>
            <ul class="navbar-nav navbar-nav-right">
               
                <li class="nav-item nav-profile dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                    <span class="nav-profile-name">Admin</span>
                    <span class="online-status"></span>
                    <img src="images/faces/face28.png" alt="profile"/>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                      
                    <a class="dropdown-item" href="login.php">
                        <i class="mdi mdi-logout text-primary"></i>
                         Logout
                    </a>
                  </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </div>
      </nav>
      <nav class="bottom-navbar">
        <div class="container">
            <ul class="nav page-navigation">
              <li class="nav-item">
                <a class="nav-link" href="index.php">
                  <i class="mdi mdi-file-document-box menu-icon"></i>
                  <span class="menu-title">Home</span>
                </a>
              </li>
              <li class="nav-item">
                  <a href="category.php" class="nav-link">
                    <i class="mdi mdi-tag-multiple menu-icon"></i>
                    <span class="menu-title">Category</span>
                    <i class="menu-arrow"></i>
                  </a>
                 
              </li>
                <li class="nav-item">
                <a href="menu.php" class="nav-link">
                  <i class="mdi mdi-silverware-fork-knife menu-icon"></i>
                  <span class="menu-title">Menu</span>
                  <i class="menu-arrow"></i>
                </a>
                <li class="nav-item">
                  <a href="saleqty.php" class="nav-link">
                    <i class="mdi mdi-account-card-details menu-icon"></i>
                    <span class="menu-title">Sales</span>
                    <i class="menu-arrow"></i>
                  </a>
		          </li>
              </li>
              <li class="nav-item">
                  <a href="order.php" class="nav-link">
                    <i class="mdi mdi-cart menu-icon"></i>
                    <span class="menu-title">Order</span>
                    <i class="menu-arrow"></i>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="dailysale.php" class="nav-link">
                    <i class="mdi mdi-finance menu-icon"></i>
                    <span class="menu-title">Daily Sales</span>
                    <i class="menu-arrow"></i>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="totalsales.php" class="nav-link">
                    <i class="mdi mdi-cash-multiple menu-icon"></i>
                    <span class="menu-title">Total Sales</span>
                    <i class="menu-arrow"></i>
                  </a>
              </li>
             
            </ul>
        </div>
      </nav>
    </div>
    </div>
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex align-items-center justify-content-md-end">
                            <div class="pe-1 mb-3 mb-xl-0">
                                <button type="button" class="btn btnadd" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    Add Category
                                    <i class="mdi mdi-message-outline btn-icon-append"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Add Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card form-container">
                                                            <div class="card-body">
                                                                <form action="#" method="post">
                                                                    <div class="mb-3">
                                                                        <label for="category" class="form-label">Category Name</label>
                                                                        <input type="text" id="category" name="category" class="form-control" placeholder="Enter Category Name" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="status" class="form-label">Status</label>
                                                                        <select id="status" name="status" class="form-select" required>
                                                                            <option value="Active">Active</option>
                                                                            <option value="Inactive">Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                    <button type="submit" name="submit" class="btn btnadd">Add Category</button>
                                                                </form>
                                                                <?php
                                                                if (!empty($message)) {
                                                                    echo '<div class="modal-footer">';
                                                                    echo '<div class="alert alert-success mt-3">' . $message . '</div>';
                                                                    echo '</div>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Categories
                            </div>
                            <div class="card-body">
                                <div class="form-container">
                                    <?php
                                    // Fetch and display categories
                                    $result = $category->fetchCategories();
                                    $i = 1;

                                    if ($result) {
                                        if ($result->num_rows > 0) {
                                            echo '<table class="table table-striped">';
                                            echo '<thead><tr><th>No</th><th>Category Name</th><th>Edit</th><th>Remove</th></tr></thead>';
                                            echo '<tbody>';

                                            while ($row = $result->fetch_assoc()) {
                                                $id = htmlspecialchars($row['C_Id']);
                                                $name = htmlspecialchars($row['C_Name']);
                                                echo '<tr>';
                                                echo '<td>' . $i . '</td>';
                                                echo '<td>' . $name . '</td>';
                                                echo '<td>';
                                                echo '<a href="editcategory.php?id=' . $id . '" class="btn btn-outline-dark btn-sm">Edit</a></td>';
                                                echo '<td><a href="deletecategory.php?id=' . $id . '" class="btn btn-outline-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this category?\')">Delete</a>';
                                                echo '</td>';
                                                echo '</tr>';
                                                $i++;
                                            }

                                            echo '</tbody></table>';
                                        } else {
                                            echo '<div class="alert alert-info" role="alert">No categories found.</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Error fetching categories.</div>';
                                    }

                                    // Close the database connection
                                    $db->close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="footer-wrap">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">© 2024 Cafe Management System</span>
                    </div>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- base:js -->
<script src="vendors/base/vendor.bundle.base.js"></script>
<script src="js/template.js"></script>
</body>
</html>
