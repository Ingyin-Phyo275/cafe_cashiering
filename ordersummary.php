<?php
session_start();
require_once("orderclass.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Order Summary</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #ffffff;
        }
        .card-header {
            color: black;
            font-size: 1.5rem;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            padding: 20px;
        }
        .btnadd {
            background-color: #563F36;
            color:white;
        }
        .btnadd:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .table th, .table td {
            text-align: center;
        }
        .table thead th {
            background-color: #563F36;
            color: #fff;
        }
        .voucher {
            display: none;
        }
        .voucher-content {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        @media print {
            .voucher {
                display: block;
            }
        }
    </style>
    <script>
        function printVoucher() {
            const voucher = document.getElementById('voucher');
            const printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Order Voucher</title>');
            printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">');
            printWindow.document.write('<style>body { font-family: Arial, sans-serif; margin: 20px; }</style>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(voucher.innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus(); // Required for IE
            printWindow.print();
            printWindow.onafterprint = function() {
                window.location.href = 'order.php';
            };
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Order Summary
            </div>
            <div class="card-body">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $selectedQuantities = $_POST['quantity'];
                    
                    $order = new Order(); // Create an instance of Order class

                    // Database connection
                    $conn = new mysqli("localhost", "root", "", "cafe");
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    foreach ($selectedQuantities as $menuId => $quantity) {
                        if ($quantity > 0) {
                            $query = "SELECT Menu_Name, Price FROM menu WHERE M_Id = ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("i", $menuId);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result && $row = $result->fetch_assoc()) {
                                $name = htmlspecialchars($row['Menu_Name']);
                                $price = htmlspecialchars($row['Price']);
                                $order->addItem($menuId, $name, $price, $quantity);
                            }
                        }
                    }

                    $grandTotal = $order->getTotalPrice();
                    $order->saveOrder($conn);

                    mysqli_close($conn);
                } else {
                    echo '<p>No order data received.</p>';
                    exit;
                }
                ?>

                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Menu Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order->getOrderItems() as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                        <td><?php echo number_format($item['price'], 2); ?> mmk</td>
                                        <td><?php echo number_format($item['totalPrice'], 2); ?> mmk</td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="3"><strong>Total Price</strong></td>
                                    <td><?php echo number_format($grandTotal, 2); ?> mmk</td>
                                </tr>
                            </tbody>
                        </table>
                        <button onclick="printVoucher()" class="btn btnadd">Print Voucher</button>
                    </div>

                    <div id="voucher" class="col-md-4 voucher voucher-content">
                        <h2>Order Voucher</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Menu Item</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order->getOrderItems() as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                        <td><?php echo number_format($item['totalPrice'], 2); ?> mmk</td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="2"><strong>Total Price</strong></td>
                                    <td><?php echo number_format($grandTotal, 2); ?> mmk</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
