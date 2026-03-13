<?php
require_once("dbconnection.php");

class SalesReport {
   
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
       
    }

    //retrieve dailysale table
    public function getTodaySales() {
        $today = date('Y-m-d');
        $query = "
            SELECT s.S_Id, s.Sale_Date, SUM(si.quantity * si.price) AS total_amount
            FROM sales s
            JOIN sale_item si ON s.S_Id = si.sale_id
            WHERE DATE(s.Sale_Date) = ?
            GROUP BY s.S_Id, s.Sale_Date
            ORDER BY s.Sale_Date DESC
        ";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }

        $stmt->bind_param("s", $today);
        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        if (!$result) {
            die('Get result failed: ' . $stmt->error);
        }

        return $result;
    }

    //retireve total amount in dailysale.php
    public function getTotalSalesAmount() {
        $today = date('Y-m-d');
        $query = "
            SELECT SUM(si.quantity * si.price) AS total_day_amount
            FROM sales s
            JOIN sale_item si ON s.S_Id = si.sale_id
            WHERE DATE(s.Sale_Date) = ?
        ";

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die('Prepare failed: ' . $this->conn->error);
        }

        $stmt->bind_param("s", $today);
        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        if (!$result) {
            die('Get result failed: ' . $stmt->error);
        }

        $row = $result->fetch_assoc();
        return $row['total_day_amount'] ?? '0.00';
    }

    //retrieve for details.php  print voucher section
    public function getOrderItems($saleid) {
        $query = "SELECT *, Menu_Name FROM sale_item
                  JOIN menu ON menu.M_Id = sale_item.menu_id
                  WHERE sale_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $saleid);
        $stmt->execute();
        $result = $stmt->get_result();

        $orderItems = [];
        $grandTotal = 0;
        $i = 1;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalprice = $row['price'] * $row['quantity'];
                $orderItems[] = [
                    'sale_id' => $row['sale_id'],
                    'name' => $row['Menu_Name'],
                    'quantity' => $row['quantity'],
                    'price' => $row['price'],
                    'totalPrice' => $totalprice
                ];
                $grandTotal += $totalprice;
                $i++;
            }
        }

        return ['items' => $orderItems, 'total' => $grandTotal];
    }

    //retireve totalsales table
    public function getSalesOverview() {
        $query = "SELECT DATE(sale_date) AS sale_date, SUM(total) AS total FROM sales GROUP BY DATE(sale_date) ORDER BY DATE(sale_date) DESC";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $salesData = [];
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                $salesData[] = [
                    'id' => $i,
                    'sale_date' => $row['sale_date'],
                    'total' => $row['total']
                ];
                $i++;
            }
            return $salesData;
        } else {
            return [];
        }
    }

    
    public function getSaleDetails($saledate) {
        $saledate = $this->conn->escapeString($saledate); // Use the connection object here
        $query = "SELECT m.Menu_Name, c.C_Name, s.price, SUM(s.quantity) AS salecount
                  FROM sale_item s
                  JOIN menu m ON s.menu_id = m.M_Id
                  JOIN category c ON m.C_Id = c.C_Id
                  JOIN sales sa ON s.sale_id = sa.s_Id
                  WHERE DATE(sa.sale_date) = '$saledate'
                  GROUP BY m.Menu_Name, c.C_Name, m.price";
        
        $result = $this->conn->query($query);
        $data = [];
        $totalPrice = 0;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $itemTotal = $row['price'] * $row['salecount'];
                $totalPrice += $itemTotal;

                $data[] = [
                    'Menu_Name' => $row['Menu_Name'],
                    'C_Name' => $row['C_Name'],
                    'price' => $row['price'],
                    'salecount' => $row['salecount'],
                    'itemTotal' => $itemTotal
                ];
            }
        }

        return ['data' => $data, 'totalPrice' => $totalPrice];
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?>
