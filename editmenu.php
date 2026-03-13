<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Edit Menu</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin-top: 5rem;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: #ffffff;
            padding: 2rem;
        }
        .card-header {
            color: black;
            border-bottom: none;
            border-radius: 0.75rem 0.75rem 0 0;
            padding: 1rem;
        }
        .card-header h1 {
            margin: 0;
            font-size: 1.75rem;
        }
        .form-label {
            font-weight: 600;
        }
        .form-control, .form-select, .btn {
            border-radius: 0.5rem;
        }
        .btn-primary {
            background-color: #563F36;
            border-color: #563F36;
        }
        .btn-primary:hover {
            background-color: greenyellow;
            border-color: #004085;
        }
        .alert {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Edit Menu Item</h1>
            </div>
            
            <?php

            // Include the class files
            require_once 'menuclass.php';
            require_once 'categoryclass.php';
            $conn = new Database("localhost","root","","cafe");
            $menuObj = new Menu($conn);
            $cateObj = new Category($conn);

            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);

                // Fetch the menu item details
                $result = $menuObj->getMenuById($id);

                if ($result) {
                    $name = $result['Menu_Name'];
                    $categoryId = $result['C_Id'];
                    $price = $result['Price'];
                    $status = $result['Status'];

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $newName = trim($_POST['name']);
                        $newCategory = $_POST['category'];
                        $newPrice = $_POST['price'];
                        $newStatus = $_POST['status'];

                        if (!empty($newName) && !empty($newPrice)) {
                            // Check if the new name already exists
                            $count = $menuObj->checkMenuNameExists($newName, $id);

                            if ($count > 0) {
                                echo '<div class="alert alert-warning" role="alert">Menu name already exists. Please choose a different name.</div>';
                            } else {
                                // Update the menu item
                                if ($menuObj->updateMenu($id, $newName, $newCategory, $newPrice, $newStatus)) {
                                    echo '<div class="alert alert-success" role="alert">Menu item updated successfully.</div>';
                                    header('Refresh: 0; url=menu.php'); // Redirect after 0 seconds
                                    exit;
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Error updating the menu item.</div>';
                                }
                            }
                        } else {
                            echo '<div class="alert alert-warning" role="alert">Name and Price cannot be empty.</div>';
                        }
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Menu item not found.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Invalid request.</div>';
            }

            // Fetch categories for the dropdown
            $categoriesResult = $cateObj->fetchCategories();
            $categories = [];
            if ($categoriesResult) {
                while ($catRow = $categoriesResult->fetch_assoc()) {
                    $categories[$catRow['C_Id']] = $catRow['C_Name'];
                }
            }
            ?>
            <form action="" method="post" class="mt-4">
                <div class="mb-3">
                    <label for="name" class="form-label">Menu Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" name="category" class="form-select" required>
                        <?php
                        foreach ($categories as $catId => $catName) {
                            $selected = $catId == $categoryId ? 'selected' : '';
                            echo "<option value=\"$catId\" $selected>$catName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="Active" <?php echo $status == 'Active' ? 'selected' : ''; ?>>Active</option>
                        <option value="Inactive" <?php echo $status == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</html>
