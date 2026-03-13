<?php
require_once("saleclass1.php");
$db = new mysqli("localhost","root","","cafe");
$salesReport = new SalesReport($db);
$todaySales = $salesReport->getTodaySales();
$totalAmount = number_format($salesReport->getTotalSalesAmount(), 2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cafe Cashering System</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
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
        h4 {
            font-weight: bolder;
            color: black;
        }
        #ltotal {
           font-weight: bolder;
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
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="container mt-1">
                            <div class="card">
                                <div class="card-header">
                                    Daily Sales Report
                                </div>
                                <div class="card-body">
                                    <?php
                                    if ($todaySales->num_rows > 0) {
                                        echo '<table class="table table-striped">';
                                        echo '<thead>';
                                        echo '<tr>';
                                        echo '<th scope="col">No</th>';
                                        echo '<th scope="col">Sale Date</th>';
                                        echo '<th scope="col">Total Amount</th>';
                                        echo '<th scope="col">Action</th>';
                                        echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                          $i=0;
                                        while ($row = $todaySales->fetch_assoc()) {
                                            $i++;
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($i) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['Sale_Date']) . '</td>';
                                            echo '<td>' . number_format($row['total_amount'], 2) . ' mmk</td>';
                                            echo "<td><a href='details.php?saleid=".$row['S_Id']."' class='btn btn-outline-dark btn-sm'>View</a></td>";
                                            echo '</tr>';
                                        }
                                        echo "<tr id='ltotal'>";
                                            echo "<td colspan='3'><strong>Total Sales :</strong></td>";
                                            echo "<td><strong>".$totalAmount." MMK</strong></td>";
                                            echo "</tr>";
                                        echo '</tbody>';
                                        echo '</table>';
                                    } else {
                                        echo '<p>No sales data available for today.</p>';
                                    }

                                    // echo '<div class="mt-4" id="total">';
                                    // echo '<h4>Total Sales Amount: ' . $totalAmount . ' mmk</h4>';
                                    // echo '</div>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer and other parts here -->
    </div>
    <!-- base:js -->
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <!-- inject:js -->
    <script src="js/template.js"></script>
</body>
</html>
