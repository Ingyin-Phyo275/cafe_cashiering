<?php
ob_start();
require_once("dbconnection.php");
require_once("categoryclass.php");

// Create an instance of the Database class
$db = new Database("localhost", "root", "", "cafe");

// Create an instance of the Category class
$category = new Category($db);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Call the deleteCategory method
    if ($category->deleteCategory($id)) {
        header('Location: category.php');
        exit; // Ensure no further code runs after header redirection
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: Unable to delete category.</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">Invalid request.</div>';
}

// Close the database connection
$db->close();
?>
