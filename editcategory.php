<?php
// Include the database connection class
require_once("dbconnection.php");
require_once("categoryclass.php");

// Create an instance of the Database class
$db = new Database("localhost", "root", "", "cafe");
$category = new Category($db);
$message = "";
$categoryName = "";

// Check if the 'id' is set in the query string
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $categoryName = $category->getCategoryNameById($id);

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newName = $_POST['name'];
        $message = $category->updateCategory($id, $newName);
        
        // Redirect to category.php after update
        header("Location: category.php");
        exit();
    }
} else {
    $message = '<div class="alert alert-danger" role="alert">Invalid request.</div>';
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Edit Category</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 5rem;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            background-color: #ffffff;
            padding: 2rem;
        }
        .card h1 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #343a40;
        }
        .alert {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .form-control, .btn {
            border-radius: 0.5rem;
        }
        .btn-primary {
            background-color: #563F36;
            border-color: #563F36;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #343a40;
            border-color: #563F36;
        }
        .btn-primary:focus, .btn-primary:active {
            box-shadow: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1 class="mb-4">Edit Category</h1>
            <?php echo $message; ?>
            <form action="" method="post" class="mt-4">
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $categoryName; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</html>
