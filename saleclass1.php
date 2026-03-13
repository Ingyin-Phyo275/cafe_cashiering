<?php
require_once("dbconnection.php");
class SalesReport extends Database{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDetailedSales($saleDate) {
        $query = "
            SELECT m.menu_name, si.price, si.quantity, (si.price * si.quantity) AS total_price
            FROM sale_item si
            JOIN sales s ON si.sale_id = s.S_Id
            JOIN menu m ON si.menu_id = m.M_Id
            WHERE s.sale_date = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $saleDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $salesData = [];
        while ($row = $result->fetch_assoc()) {
            $salesData[] = $row;
        }
        $stmt->close();
        return $salesData;
    }

    
    public function getSalesOverview($type, $year = null) {
        if ($type == 'yearly') {
            // Get sales data for all months of the selected year
            $query = "SELECT DATE_FORMAT(sale_date, '%Y-%m') AS month, SUM(total) AS total
                      FROM sales
                      WHERE YEAR(sale_date) = ?
                      GROUP BY month";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("s", $year);
        } else {
            // Your existing monthly query logic
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    
    
    
    
    
    
    
    // public function getSalesOverview($type = 'daily', $selectedDate = null) {
    //     $query = "";
    //     switch ($type) {
    //         case 'daily':
    //             $query = "SELECT S_Id, sale_date, total FROM sales WHERE DATE(sale_date) = ?";
    //             break;
    //         case 'monthly':
    //             $query = "SELECT S_Id, sale_date, total FROM sales WHERE MONTH(sale_date) = MONTH(?) AND YEAR(sale_date) = YEAR(?)";
    //             break;
    //         case 'yearly':
    //             $query = "SELECT S_Id, sale_date, total FROM sales WHERE YEAR(sale_date) = YEAR(?)";
    //             break;
    //     }

    //     $stmt = $this->db->prepare($query);
    //     if ($type === 'daily') {
    //         $stmt->bind_param("s", $selectedDate);
    //     } else {
    //         $stmt->bind_param("s", $selectedDate);
    //         if ($type === 'monthly') {
    //             $stmt->bind_param("ss", $selectedDate, $selectedDate);
    //         }
    //     }

    //     $stmt->execute();
    //     $result = $stmt->get_result();

    //     $salesData = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $salesData[] = $row;
    //     }

    //     $stmt->close();
    //     return $salesData;
    // }
    public function getSaleDetails($saledate) {
        $saledate = $this->db->escapeString($saledate); // Use the connection object here
        $query = "SELECT m.Menu_Name, c.C_Name, s.price, SUM(s.quantity) AS salecount
                  FROM sale_item s
                  JOIN menu m ON s.menu_id = m.M_Id
                  JOIN category c ON m.C_Id = c.C_Id
                  JOIN sales sa ON s.sale_id = sa.s_Id
                  WHERE DATE(sa.sale_date) = '$saledate'
                  GROUP BY m.Menu_Name, c.C_Name, m.price";
        
        $result = $this->db->query($query);
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

      //retrieve dailysale table
      public function getTodaySales() {
        $today = date('Y-m-d');
        $query = "
            SELECT s.S_Id, s.Sale_Date, SUM(si.price) AS total_amount
            FROM sales s
            JOIN sale_item si ON s.S_Id = si.sale_id
            WHERE DATE(s.Sale_Date) = ?
            GROUP BY s.S_Id, s.Sale_Date
            ORDER BY s.Sale_Date DESC
        ";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die('Prepare failed: ' . $this->db->error);
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
            SELECT SUM(si.price) AS total_day_amount
            FROM sales s
            JOIN sale_item si ON s.S_Id = si.sale_id
            WHERE DATE(s.Sale_Date) = ?
        ";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die('Prepare failed: ' . $this->db->error);
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

      public function getSalesByDate($date) {
        $stmt = $this->db->prepare("SELECT * FROM sales WHERE Sale_Date = ?");
        $stmt->bind_param("s", $date);
        $stmt->execute();
        return $stmt->get_result();
    }
    //retrieve for details.php  print voucher section
    public function getOrderItems($saleid) {
        $query = "SELECT *, Menu_Name,sale_item.price FROM sale_item
                  JOIN menu ON menu.M_Id = sale_item.menu_id
                  WHERE sale_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $saleid);
        $stmt->execute();
        $result = $stmt->get_result();

        $orderItems = [];
        $grandTotal = 0;
        $i = 1;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $totalprice = $row['price'];
                $orderItems[] = [
                    'sale_id' => $row['sale_id'],
                    'name' => $row['Menu_Name'],
                    'quantity' => $row['quantity'],
                    'price' => $row['Price'],
                    'totalPrice' => $totalprice
                ];
                $grandTotal += $totalprice;
                $i++;
            }
        }

        return ['items' => $orderItems, 'total' => $grandTotal];
    }
 // Define the getSalesDetailsForDate method
//  public function getSalesDetailsForDate($selectedDate) {
//     // Assuming you have a menu table and you need to join with sales_details
//     $query = "SELECT m.menu_name, 
//                      sd.price, 
//                      SUM(sd.quantity) AS total_quantity, 
//                      SUM(sd.price * sd.quantity) AS total_price 
//               FROM sale_item sd
//               JOIN menu m ON sd.menu_id = m.M_Id
//               JOIN sales s ON sd.sale_id = s.S_Id
//               WHERE DATE(s.sale_date) BETWEEN ? AND ?
//               GROUP BY m.menu_name, sd.price";
              
//     $startDate = $selectedDate . '-01'; // First day of the month
//     $endDate = date('Y-m-t', strtotime($startDate)); // Last day of the month

//     $stmt = $this->db->prepare($query);
//     $stmt->bind_param("ss", $startDate, $endDate);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     return $result->fetch_all(MYSQLI_ASSOC);
// }

public function getSalesDetailsForDate($saleDate) {
    // Modify the query to use the correct date format and column names
    $query = "SELECT m.menu_name,m.price, SUM(sd.quantity) AS total_quantity, ( SUM(sd.price)) AS total_price
              FROM sale_item sd
              JOIN menu m ON sd.menu_id = m.M_Id
              JOIN sales s ON sd.sale_id = s.S_Id
              WHERE DATE_FORMAT(s.sale_date, '%Y-%m') = ?
              GROUP BY m.menu_name order by total_quantity DESC";

    $stmt = $this->db->prepare($query);
    $stmt->bind_param("s", $saleDate); 
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}




}
?>
