<?php
require_once("saleclass.php");
$db = new Database("localhost","root","","cafe");
$salesReport = new SalesReport($db);
$salesData = $salesReport->getSalesOverview();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cafe Cashiering System</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/logo.png" />
    <style>
        .card {
            margin-bottom: 20px;
        }
        .card-header {
            color: #563F36;
            border-bottom: 1px solid #495057;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .card-body {
            background-color: #fff;
        }
        thead {
            background-color: #563F36;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
    <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
            <ul class="navbar-nav navbar-nav-left">
             
            </ul>
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="index.html">Cafe Cashering</a>
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
                      <a class="dropdown-item">
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
              </li>
              <li class="nav-item">
                <a href="saleqty.php" class="nav-link">
                  <i class="mdi mdi-account-card-details menu-icon"></i>
                  <span class="menu-title">Sales</span>
                  <i class="menu-arrow"></i>
                </a>
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
       
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                Sales Overview
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sale Id</th>
                                            <th>Sale Date</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (!empty($salesData)) {
                                                foreach ($salesData as $data) {
                                                    echo "<tr>";
                                                    echo "<td>".$data['id']."</td>";
                                                    echo "<td>".$data['sale_date']."</td>";
                                                    echo "<td>".$data['total']." mmk</td>";
                                                    echo "<td><a href='details1.php?saledate=".$data['sale_date']."' class='btn btn-outline-dark btn-sm text-black'>View</a></td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='4'>No records available</td></tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="js/template.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <!-- End plugin js for this page -->
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/progressbar.js/progressbar.min.js"></script>
    <script src="vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js"></script>
    <script src="vendors/justgage/raphael-2.1.4.min.js"></script>
    <script src="vendors/justgage/justgage.js"></script>
    <script src="js/jquery.cookie.js" type="text/javascript"></script>
    <!-- Custom js for this page-->
    <script src="js/dashboard.js"></script>
    <!-- End custom js for this page-->
</body>
</html>
