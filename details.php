<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .container-fluid {
            margin-top: 20px;
        }
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
        }
        .card-header {
            color: black;
            border-bottom: 1px solid #495057;
            font-size: 1.25rem;
        }
        .table {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
            overflow: hidden;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .table thead th {
            background-color: #563F36;
            color: #fff;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
        .table td {
            padding: 1rem;
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
        .btnadd {
            background-color: #563F36;
            color: white;
        }
        .btnadd:hover {
            background-color: greenyellow;
            color: black;
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
            printWindow.document.write('</head><body>');
            printWindow.document.write(voucher.innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Sale Item Details
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sale Id</th>
                            <th>Menu Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once("saleclass1.php");
                        $db = new mysqli("localhost", "root", "", "cafe");
                        $saleid = $_GET['saleid'] ?? '';
                        $report = new SalesReport($db);
                        $data = $report->getOrderItems($saleid);

                        if (!empty($data['items'])) {
                            $orderItems = $data['items'];
                            $grandTotal = $data['total'];
                            foreach ($orderItems as $index => $item) {
                                $totalprice = $item['price'] * $item['quantity'];
                                echo "<tr>";
                                echo "<td>".($index + 1)."</td>";
                                echo "<td>".$item['sale_id']."</td>";
                                echo "<td>".$item['name']."</td>";
                                echo "<td>".$item['quantity']."</td>";
                                echo "<td>".number_format($item['price'], 2)." mmk</td>";
                                echo "<td>".number_format($totalprice, 2)." mmk</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No record available</td></tr>";
                        }
                        ?>
                        <tr>
                            <td colspan="5"><strong>Total Price</strong></td>
                            <td><?php echo number_format($grandTotal, 2)." mmk"; ?></td>
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
                            <th>No</th>
                            <th>Menu Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $index => $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($index + 1); ?></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td>$<?php echo number_format($item['totalPrice'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4"><strong>Total Price</strong></td>
                            <td><?php echo number_format($grandTotal, 2)." mmk"; ?></td>
                        </tr>
                    </tbody>
                </table>
                <button onclick="printVoucher()" class="btn btnadd">Print Voucher</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
