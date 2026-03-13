<?php
//require_once 'dbconnection.php';
require_once 'menuclass.php';
$db = new Database("localhost", "root", "", "cafe");
$menu = new Menu($db);
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    

    $result = $menu->removeMenuItem($id);

    if ($result === true) {
        header('Location: menu.php');
        exit;
    } else {
        echo 'Error: ' . $result;
    }
} else {
    echo 'Invalid request.';
}
?>
