<?php
// Database class to manage MySQL connections
require_once("dbconnection.php");
// Cafe class to manage cafe data
class Cafe extends Database{
    private $db;
    private $categoriesCount;
    private $menusCount;
    private $dailySalesTotal;

    public function __construct(Database $db) {
        $this->db = $db;
        $this->categoriesCount = 0;
        $this->menusCount = 0;
        $this->dailySalesTotal = 0;
        $this->retrieveData();
    }

    private function retrieveData() {
        $this->retrieveCategories();
        $this->retrieveMenus();
        $this->retrieveDailySales();
    }

    private function retrieveCategories() {
        $query = "SELECT * FROM category WHERE C_Status='Active'";
        $result = $this->db->query($query);
        $this->categoriesCount = $this->db->numRows($result);
    }

    private function retrieveMenus() {
        $query = "SELECT menu.* FROM menu INNER JOIN category ON menu.C_Id = category.C_Id WHERE menu.Status='Active' AND category.C_Status='Active'";
        $result = $this->db->query($query);
        $this->menusCount = $this->db->numRows($result);
    }
    private function retrieveAllMenus() {
        $query = "SELECT menu.* FROM menu INNER JOIN category ON menu.C_Id = category.C_Id WHERE menu.Status!='Delete' AND category.C_Status='Active'";
        $result = $this->db->query($query);
        $this->menusCount = $this->db->numRows($result);
    }

    private function retrieveDailySales() {
        date_default_timezone_set('Asia/Yangon');
        $startOfDay = date("Y-m-d 00:00:00");
        $endOfDay = date("Y-m-d 23:59:59");
        $query = "SELECT SUM(sale_item.price) AS totalsum FROM sales,sale_item WHERE sales.S_Id = sale_item.sale_id and  sale_date BETWEEN '$startOfDay' AND '$endOfDay'";
        $result = $this->db->query($query);
        if ($result) {
            $row = $this->db->fetchAssoc($result);
            $this->dailySalesTotal = $row['totalsum'] ?? 0;
        }
    }

    public function getCategoriesCount() {
        return $this->categoriesCount;
    }

    public function getMenusCount() {
        return $this->menusCount;
    }

    public function getDailySalesTotal() {
        return $this->dailySalesTotal;
    }
}

// Instantiate the Database and Cafe classes
$db = new Database("localhost", "root", "", "cafe");
$cafe = new Cafe($db);
// Close the database connection
$db->close();
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
                        <li class="nav-item"><a class="nav-link" href="index.php"><i class="mdi mdi-file-document-box menu-icon"></i><span class="menu-title">Home</span></a></li>
                        <li class="nav-item"><a href="category.php" class="nav-link"><i class="mdi mdi-tag-multiple menu-icon"></i><span class="menu-title">Category</span><i class="menu-arrow"></i></a></li>
                        <li class="nav-item"><a href="menu.php" class="nav-link"><i class="mdi mdi-silverware-fork-knife menu-icon"></i><span class="menu-title">Menu</span><i class="menu-arrow"></i></a></li>
                        <li class="nav-item"><a href="saleqty.php" class="nav-link"><i class="mdi mdi-account-card-details menu-icon"></i><span class="menu-title">Sales</span><i class="menu-arrow"></i></a></li>
                        <li class="nav-item"><a href="order.php" class="nav-link"><i class="mdi mdi-cart menu-icon"></i><span class="menu-title">Order</span><i class="menu-arrow"></i></a></li>
                        <li class="nav-item"><a href="dailysale.php" class="nav-link"><i class="mdi mdi-finance menu-icon"></i><span class="menu-title">Daily Sales</span><i class="menu-arrow"></i></a></li>
                        <li class="nav-item"><a href="totalsales.php" class="nav-link"><i class="mdi mdi-cash-multiple menu-icon"></i><span class="menu-title">Total Sales</span><i class="menu-arrow"></i></a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-sm-6 mb-4 mb-xl-0">
                            <div class="d-lg-flex align-items-center">
                                <div>
                                    <h3 class="text-dark font-weight-bold mb-2">Hi, welcome back!</h3>
                                    <h6 class="font-weight-normal mb-2"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 flex-column d-flex stretch-card">
                            <div class="row">
                                <div class="col-lg-4 d-flex grid-margin stretch-card">
                                    <div class="card sale-visit-statistics-border">
                                        <a href="category.php" class="btn btn-outline-secondary">
                                            <div class="card-body">
                                                <h2 class="text-dark mb-2 font-weight-bold"><?php echo $cafe->getCategoriesCount(); ?></h2>
                                                <h4 class="card-title mb-2">Total Category</h4>
                                                <small class="text-muted"><?php echo date("Y-m-d"); ?></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex grid-margin stretch-card">
                                    <div class="card sale-visit-statistics-border">
                                        <a href="menu.php" class="btn btn-outline-secondary">
                                            <div class="card-body">
                                                <h2 class="text-dark mb-2 font-weight-bold"><?php echo $cafe->getMenusCount(); ?></h2>
                                                <h4 class="card-title mb-2">Total Menu</h4>
                                                <small class="text-muted"><?php echo date("Y-m-d"); ?></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 d-flex grid-margin stretch-card">
                                    <div class="card sale-visit-statistics-border">
                                        <a href="dailysale.php" class="btn btn-outline-secondary">
                                            <div class="card-body">
                                                <h2 class="text-dark mb-2 font-weight-bold"><?php echo number_format($cafe->getDailySalesTotal())." mmk"; ?></h2>
                                                <h4 class="card-title mb-2">Daily Sales</h4>
                                                <small class="text-muted"><?php echo date("Y-m-d"); ?></small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="display: flex; flex-wrap: nowrap;">
    <!-- Image Card 1 -->
    <div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/finallatte.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Hot Latte</h5>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/cappuccino.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Cappuccino</h5>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/matcha.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Iced Matcha</h5>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/lemontea.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Lemon Tea</h5>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/mocha.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Iced Mocha</h5>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/espresso.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Iced Espresso</h5>
            </div>
        </div>
    </div>
</div>



 </div>
 
    <div class="row" style="display: flex; flex-wrap: nowrap;">
    <!-- Image Card 1 -->
    <div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/strawberryyogurth.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Strawberry Yogurth</h5>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/cupcake.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Redvelvet Cake</h5>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/cake.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Strawberry Cake</h5>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/berry.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Berry Cake</h5>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/cookie.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Matcha Cookie</h5>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-2 grid-margin stretch-card">
    <div class="card" style="position: relative; border-radius: 15px; overflow: hidden; color: white; height: 200px;">
        <div class="card-body p-0" style="height: 100%; position: relative;">
            <img src="images/smoothie.png" class="img-fluid rounded mx-auto d-block" alt="Hot Latte" style="height: 100%; object-fit: cover;">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border:1px solid #563F36; border-radius: 0 0 15px 15px;">
                <h5 class="m-0" style="color: black;">Smoothie</h5>
            </div>
        </div>
    </div>
</div>


 
 </div>
                </div>
                <footer class="footer"></footer>
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
