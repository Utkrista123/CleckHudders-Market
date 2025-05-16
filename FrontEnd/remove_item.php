<?php
require '../BackEnd/database/connect.php';

$conn = getDBConnection();

if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    $sql = "DELETE FROM product_cart WHERE product_id = :product_id";
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ":product_id", $product_id);

    if (oci_execute($stid)) {
        echo "success";
    } else {
        $e = oci_error($stid);
        echo "Error: " . $e['message'];
    }

    oci_free_statement($stid);
} else {
    echo "Invalid product ID.";
}
?>
