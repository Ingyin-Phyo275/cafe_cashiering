<?php
require_once("saleclass1.php");
$db = new mysqli("localhost", "root", "", "cafe");
$salesReport = new SalesReport($db);

// Capture the sale date from the query parameter
$saleDate = isset($_GET['saledate']) ? $_GET['saledate'] : '';

if (empty($saleDate)) {
    echo "No date provided!";
    exit;
}

// Fetch detailed sales data for the selected date
$detailedSalesData = $salesReport->getSalesDetailsForDate($saleDate);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sales Details</title>
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css">
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
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            Sales Details for <?= htmlspecialchars($saleDate) ?>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover mt-4">
                                <thead>
                                    <tr>
                                        <th>Menu Name</th>
                                        <th>Price (MMK)</th>
                                        <th>Sold Quantity</th>
                                        <th>Total Price (MMK)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $totalAmount = 0;
                                        if (!empty($detailedSalesData)) {
                                            foreach ($detailedSalesData as $data) {
                                                $totalAmount += $data['total_price'];
                                                echo "<tr>";
                                                echo "<td>".htmlspecialchars($data['menu_name'])."</td>";
                                                echo "<td>".htmlspecialchars($data['price'])."</td>";
                                                echo "<td>".htmlspecialchars($data['total_quantity'])."</td>";
                                                echo "<td>".htmlspecialchars($data['total_price'])."</td>";
                                                echo "</tr>";
                                            }
                                            // Display the total amount
                                            echo "<tr>";
                                            echo "<td colspan='3'><strong>Total Amount:</strong></td>";
                                            echo "<td><strong>".htmlspecialchars($totalAmount)." MMK</strong></td>";
                                            echo "</tr>";
                                        } else {
                                            echo "<tr><td colspan='4'>No records available for the selected date</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <button onclick="window.print()" class="btn btn-outline-dark mt-3">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendors/base/vendor.bundle.base.js"></script>
    <script src="js/template.js"></script>
</body>
</html>
