<?php
require_once("saleclass1.php");

$db = new Database("localhost", "root", "", "cafe");

$saledate = isset($_GET['saledate']) ? $_GET['saledate'] : '';
$saleDetails = new SalesReport($db);
$saleData = $saleDetails->getSaleDetails($saledate);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sale Details</title>
    <!-- base:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/logo.png" />
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
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
        .total-row {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                Sale Details for <?php echo htmlspecialchars($saledate); ?>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Menu Name</th>
                                            <th>Category Name</th>
                                            <th>Price</th>
                                            <th>Sale Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (!empty($saleData['data'])) {
                                                foreach ($saleData['data'] as $row) {
                                                    echo "<tr>";
                                                    echo "<td>".$row['Menu_Name']."</td>";
                                                    echo "<td>".$row['C_Name']."</td>";
                                                    echo "<td>".$row['price']." mmk</td>";
                                                    echo "<td>".$row['salecount']."</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='4'>No records available</td></tr>";
                                            }

                                            echo "<tr class='total-row'>";
                                            echo "<td colspan='3'>Total Price</td>";
                                            echo "<td>".$saleData['totalPrice']." mmk</td>";
                                            echo "</tr>";
                                        ?>
                                    </tbody>
                                </table>
                                <button class="btn btn-outline-dark justify-content-right no-print" onclick="window.print()">Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- base:js -->
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <!-- inject:js -->
    <script src="js/template.js"></script>
</body>
</html>
