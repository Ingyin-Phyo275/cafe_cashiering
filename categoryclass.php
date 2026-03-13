<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include the database connection class
require_once("dbconnection.php");

class Category extends Database{
    public $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addCategory($categoryName, $status) {
        $categoryName = $this->db->escapeString($categoryName);
        $status = $this->db->escapeString($status);

        // Check if the category already exists
        $query1 = "SELECT * FROM category WHERE C_Name='$categoryName'";
        $result1 = $this->db->query($query1);

        if ($result1->num_rows > 0) {
            // If the category exists, update its status
            $query4 = "UPDATE category SET C_Status='Active' WHERE C_Name='$categoryName'";
            $result4 = $this->db->query($query4);
            return "Category already exists and was reactivated.";
        } else {
            // Otherwise, insert a new category
            $query = "INSERT INTO category (C_Name, C_Status) VALUES ('$categoryName', '$status')";
            if ($this->db->query($query)) {
                return "Category added successfully.";
            } else {
                return "Failed to add category: " . $this->db->connection->error;
            }
        }
    }
    public function getCategoryById($id) {
        $query = "SELECT * FROM category WHERE C_Id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getCategoryNameById($id) {
        $query = "SELECT C_Name FROM category WHERE C_Id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();  // Use get_result() to get the result set
        if ($result && $row = $result->fetch_assoc()) {  // Fetch the result row
            $categoryName = $row["C_Name"];  // Access the C_Name column
        } else {
            $categoryName = null;  // Handle case where no result is found
        }
        return $categoryName;
    }
    
    public function fetchCategories() {
        $query = "SELECT * FROM category WHERE C_Status='Active'";
        $result = $this->db->query($query);
        return $result;
    }


    public function deleteCategory($id) {
        $query = "UPDATE category SET C_Status='Inactive' WHERE C_Id = ?";
        $stmt = $this->db->connection->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } else {
            return false;
        }
    }

    public function getActiveCategories() {
        $query = "SELECT C_Id, C_Name FROM category WHERE C_Status = 'Active'";
        $result = $this->db->query($query);
        
        $categories = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }
        return $categories;
    }

    // Method to update a category's name
    public function updateCategory($id, $name) {
        $query = "UPDATE category SET C_Name = ? WHERE C_Id = ?";
        $stmt = $this->db->query($query, "si", [$name, $id]);
    
        if ($stmt) {
            return '<div class="alert alert-success" role="alert">Category updated successfully.</div>';
        } else {
            return '<div class="alert alert-danger" role="alert">Failed to update category.</div>';
        }
    }
    
           
}

// Instantiate the Database and Category classes
$db = new Database("localhost", "root", "", "cafe");
$category = new Category($db);

// Add category if form is submitted
$message = "";
if (isset($_POST['submit'])) {
    $categoryName = $_POST['category'];
    $status = $_POST['status'];
    $message = $category->addCategory($categoryName, $status);
}
?>

