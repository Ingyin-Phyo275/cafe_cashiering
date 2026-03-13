<?php
$con = mysqli_connect("localhost","root","","cafe");
if($con){
     //retrieve category
     $query1 = "select * from category";
     $result1 = mysqli_query($con,$query1);
     $res1 = mysqli_num_rows($result1);
 
     //retrieve menu
     $query2 = "select * from menu";
     $result2 = mysqli_query($con,$query2);
     $res2 = mysqli_num_rows($result2);
 
     //retrieve today sale
     // Set timezone
     date_default_timezone_set('Asia/Yangon');
 
     // Get the start and end of today
     $startOfDay = date("Y-m-d 00:00:00"); // Start of today
     $endOfDay = date("Y-m-d 23:59:59");   // End of today
 
     // Query to get the total sales for today
     $query3 = "SELECT SUM(total) AS totalsum FROM sales WHERE sale_date BETWEEN '$startOfDay' AND '$endOfDay'";
     $result3 = mysqli_query($con, $query3);
 
     if ($result3) {
         $row = mysqli_fetch_assoc($result3);
         $total = $row['totalsum'];
         // If no sales were made, set total to 0
         if ($total === null) {
             $total = 0;
         }
     }
}else{
    echo mysqli_connect_errno();
    exit;
}
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
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
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
        h4{
          color: black;
          font-size: x-large;
        }
        thead{
          background-color: #563F36;
          color: white;
        }
        .btnorder{
          background-color: #563F36;
          color: white;
        }
        td{
          color:black;
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Menu Items</h3>
                        </div>
                        <div class="card-body">
                            <?php
                            // Database connection
                            $conn = mysqli_connect("localhost", "root", "", "cafe");
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            // Fetch categories
                            $query = "SELECT * FROM category where C_Status='Active'";
                            $result = mysqli_query($conn, $query);

                            if ($result) {
                                while ($catRow = mysqli_fetch_assoc($result)) {
                                    $catId = $catRow['C_Id'];
                                    $catName = htmlspecialchars($catRow['C_Name']);
                                    echo "<h4>$catName</h4>";

                                    // Fetch menu items for each category
                                    $menuQuery = "SELECT *, C_Name FROM menu INNER JOIN category ON menu.C_Id = category.C_Id WHERE menu.C_Id = $catId and menu.Status='Active'";
                                    $menuResult = mysqli_query($conn, $menuQuery);

                                    if ($menuResult && mysqli_num_rows($menuResult)>0) {
                                        echo '<ul class="list-group">';
                                        while ($menuRow = mysqli_fetch_assoc($menuResult)) {
                                            $menuId = htmlspecialchars($menuRow['M_Id']);
                                            $menuName = htmlspecialchars($menuRow['Menu_Name']);
                                            $price = htmlspecialchars($menuRow['Price']);
                                            echo '<li class="list-group-item menu-item" onclick="showDetails(' . $menuId . ', \'' . $menuName . '\', ' . $price . ')">';
                                            echo $menuName . ' ' . number_format($price, 2).' mmk';
                                            echo '</li>';
                                        }
                                        echo '</ul>';
                                    } else {
                                        echo '<ul class="list-group">';
                                        echo '<li class="list-group-item">';
                                        echo '<p>No menu items available for this category.</p>';
                                        echo '</li></ul>';
                                    }
                                  }
                            } else {
                                echo '<p>Error fetching categories.</p>';
                            }

                            // Close the connection
                            mysqli_close($conn);
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Order Details</h3>
                        </div>
                        <div class="card-body">
                            <form action="ordersummary.php" method="post" id="order-form">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Menu Item</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="menu-details">
                                        <tr>
                                            <td colspan="4">Select menu items to see the details here.</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="order-summary">
                                    <strong style="color:black;">Total Price:</strong> <span id="total-price" class="total-price">0.00 mmk</span>
                                    <input type="hidden" id="grand_total" name="grand_total" value="0">
                                    <button id="order-btn" type="submit" class="btn btnorder mt-3" style="display: none;">Place Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        let totalPrice = 0;

        function updateTotal() {
            document.getElementById('total-price').innerText = `${totalPrice.toFixed(2)} mmk`;
            document.getElementById('grand_total').value = totalPrice.toFixed(2); // Update hidden input
        }

        function showDetails(menuId, name, price) {
            const detailsTable = document.getElementById('menu-details');
            let row = document.getElementById('row-' + menuId);
            let quantityInput;

            if (!row) {
                row = document.createElement('tr');
                row.id = 'row-' + menuId;
                row.innerHTML = `
                    <td>${name}</td>
                    <td>${price.toFixed(2)} mmk</td>
                    <td><input type="number" class="form-control" name="quantity[${menuId}]" min="1" value="1" onchange="updateRow(${menuId}, ${price})" data-price="${price}" data-old-value="1"></td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${menuId}, ${price})">Remove</button></td>
                `;
                detailsTable.appendChild(row);
                quantityInput = row.querySelector('input');
                totalPrice += price;
            } else {
                quantityInput = row.querySelector('input');
                const oldQuantity = parseInt(quantityInput.value);
                const newQuantity = oldQuantity + 1;
                quantityInput.value = newQuantity;
                totalPrice += price;
            }

            updateTotal();
            document.getElementById('order-btn').style.display = 'block';
        }

        function removeItem(menuId, price) {
            const row = document.getElementById('row-' + menuId);
            if (row) {
                const quantityInput = row.querySelector('input');
                const quantity = parseInt(quantityInput.value);
                totalPrice -= price * quantity;
                row.remove();
                updateTotal();
            }
            if (document.querySelectorAll('#menu-details tr').length === 0) {
                document.getElementById('order-btn').style.display = 'none';
            }
        }

        function updateRow(menuId, price) {
            const row = document.getElementById('row-' + menuId);
            const quantityInput = row.querySelector('input');
            const oldQuantity = parseInt(quantityInput.getAttribute('data-old-value')) || 1;
            const newQuantity = parseInt(quantityInput.value);

            if (newQuantity > oldQuantity) {
                totalPrice += price * (newQuantity - oldQuantity);
            } else {
                totalPrice -= price * (oldQuantity - newQuantity);
            }

            quantityInput.setAttribute('data-old-value', newQuantity);
            updateTotal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTotal(); // Initialize total price on page load
        });
    </script>
					
					
					
					
				</div>
				<!-- content-wrapper ends -->
				<!-- partial:partials/_footer.html -->
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