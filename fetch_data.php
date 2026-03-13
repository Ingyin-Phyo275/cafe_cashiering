<?php
$con = mysqli_connect("localhost", "root", "", "cafe");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$option = $_GET['option'];
$startDate = "";
$endDate = "";
$title = "";

switch ($option) {
    case 'weekly':
        $title = "Weekly Sale Items";
        $startDate = date('Y-m-d', strtotime('monday this week'));
        $endDate = date('Y-m-d', strtotime('sunday this week'));
        break;

    case 'monthly':
        $title = "Monthly Sale Items";
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');
        break;

    case 'yearly':
        $title = "Yearly Sale Items";
        $startDate = date('Y-01-01');
        $endDate = date('Y-12-31');
        break;

    default:
        echo "Invalid option selected.";
        exit;
}

// SQL query to find the top 5 best-selling menu items for the selected period
$sql = "SELECT m.M_Id AS menu_id, m.Menu_Name AS menu_name, c.C_Name AS category, m.price, SUM(si.quantity) AS sale_count
        FROM sale_item si
        JOIN sales s ON si.sale_id = s.s_Id
        JOIN menu m ON si.menu_id = m.M_Id
        JOIN category c ON m.C_Id = c.C_Id
        WHERE s.sale_date BETWEEN '$startDate' AND '$endDate'
        GROUP BY m.M_Id, m.Menu_Name, c.C_Name, m.price
        ORDER BY sale_count DESC";

$result = $con->query($sql);

echo "<div class='card-header'>$title ($startDate to $endDate)</div>";
echo "<div class='card-body'><table border='1' class='table table-striped'>
        <thead> <tr>
            <th>No</th>
            <th>Menu Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Sales Count</th>
        </tr></thead>";

$totalPrice = 0;

if ($result->num_rows > 0) {
    $i=0;
    while ($row = $result->fetch_assoc()) {
        $subtotal = $row['price'] * $row['sale_count'];
        $totalPrice += $subtotal;
        $i++;
        echo "<tr>
                <td>" . $i . "</td>
                <td>" . $row['menu_name'] . "</td>
                <td>" . $row['category'] . "</td>
                <td>" . number_format($row['price']) . " mmk</td>
                <td>" . $row['sale_count'] . "</td>
              </tr>";
    }
    echo "<tr style='color:black;font-weight:bold;'>";
    echo "<td colspan='4'><strong>Total Sales :</strong></td>";
    echo "<td><strong>".number_format($totalPrice,2)." MMK</strong></td>";
    echo "</tr>";
    echo "</table></div>";
} else {
    echo "<div class='card-body'>No data found for the selected period.</div>";
}

mysqli_close($con);
?>
