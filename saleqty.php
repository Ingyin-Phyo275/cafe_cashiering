<?php
$con = mysqli_connect("localhost", "root", "", "cafe");

if (!$con) {
    echo "Connection failed: " . mysqli_connect_error();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cafe Cashiering System</title>
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css">
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
            font-weight: bolder;
        }
        .btnadd {
            background-color: #563F36;
            color: white;
        }
        .btnadd:hover {
            background-color: greenyellow;
            color: black;
        }
        .modal-title {
            color: #563F36;
        }
        .modal-body {
            color: black;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
        <div class="horizontal-menu">
            <nav class="navbar top-navbar col-lg-12 col-12 p-0">
                <div class="container-fluid">
                    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                        <ul class="navbar-nav navbar-nav-left"></ul>
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
                        <div class="col-sm-12">
                            <div class="d-flex align-items-center justify-content-md-end">
                                <div class="pe-1 mb-3 mb-xl-0">
                                    <select class="form-select" aria-label="Default select example" id="seloption">
                                        <option selected>Select Time Period</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <!-- <option value="yearly">Yearly</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <footer class="footer">
                    <div class="footer-wrap">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com </a>2021</span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Only the best <a href="https://www.bootstrapdash.com/" target="_blank"> Bootstrap dashboard </a> templates</span>
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
    <script>
        document.getElementById("seloption").addEventListener("change", function () {
            var selectedOption = this.value;
            fetchSaleData(selectedOption);
        });

        window.onload = function () {
            fetchSaleData("weekly"); // Load weekly data by default
        };

        function fetchSaleData(option) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_data.php?option=" + option, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.querySelector(".form-container").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <script src="js/template.js"></script>
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/progressbar.js/progressbar.min.js"></script>
    <script src="vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js"></script>
    <script src="vendors/justgage/raphael-2.1.4.min.js"></script>
    <script src="vendors/justgage/justgage.js"></script>
    <script src="js/jquery.cookie.js" type="text/javascript"></script>
    <script src="js/dashboard.js"></script>
  </body>
</html>
