<?php
ob_start();
require_once("dbconnection.php");
// include 'category.php';
// require_once('category.php');
class Menu extends Database{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addMenu($menu, $category, $price, $status) {
        $query = "SELECT * FROM menu WHERE Menu_Name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $menu);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $query = "UPDATE menu SET Status = 'Active' WHERE Menu_Name = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $menu);
            $stmt->execute();
            return "Menu item already exists.";
        } else {
            $query = "INSERT INTO menu (Menu_Name, C_Id, Price, Status) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("siis", $menu, $category, $price, $status);

            if ($stmt->execute()) {
                return "Menu item added successfully.";
            } else {
                return "Error: " . $stmt->error;
            }
        }
    }

    public function getActiveMenuItems() {
        $query = "SELECT menu.*, category.C_Name FROM menu INNER JOIN category ON menu.C_Id = category.C_Id WHERE menu.Status = 'Active' AND category.C_Status = 'Active'";
        $result = $this->conn->query($query);
        
        $menuItems = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $menuItems[] = $row;
            }
        }
        return $menuItems;
    }

    public function getAllMenuItems() {
        $query = "SELECT menu.*, category.C_Name FROM menu INNER JOIN category ON menu.C_Id = category.C_Id WHERE menu.Status!='Delete' and category.C_Status = 'Active'";
        $result = $this->conn->query($query);
        
        $menuItems = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $menuItems[] = $row;
            }
        }
        return $menuItems;
    }
    public function getActiveCategories() {
        $query = "SELECT C_Id, C_Name FROM category WHERE C_Status = 'Active'";
        $result = $this->conn->query($query);
        
        $categories = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        return $categories;
    }
    public function getMenuById($id) {
        $id = intval($id);
        $query = "SELECT * FROM menu WHERE M_Id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function updateMenu($id, $name, $category, $price, $status) {
        $id = intval($id);
        $query = "UPDATE menu SET Menu_Name = ?, C_Id = ?, Price = ?, Status = ? WHERE M_Id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("siisi", $name, $category, $price, $status, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return $stmt->error;
        }
    }

    public function removeMenuItem($id) {
        $query = "UPDATE menu SET Status = 'Delete' WHERE M_Id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return $stmt->error;
        }
    }
    public function checkMenuNameExists($name, $id) {
        $count=0;
        $query = "SELECT COUNT(*) FROM menu WHERE Menu_Name = ? AND M_Id != ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count;
    }
}
?>