<?php
session_start(); // Start session to access session variables
require '../database/connect.php';

$conn = getDBConnection();
if (!$conn) {
    die("Database connection failed");
}

$warning_msg = [];
$success_msg = [];

// Fetch shop IDs and categories
$shop_query = oci_parse($conn, "SELECT shop_id, shop_category FROM shops");
oci_execute($shop_query);
$shops = [];
while ($row = oci_fetch_assoc($shop_query)) {
    $shops[] = [
        'shop_id' => $row['SHOP_ID'],
        'category' => $row['SHOP_CATEGORY']
    ];
}

if (isset($_POST['add'])) {
    if (!isset($_SESSION['user_id'])) {
        $warning_msg[] = 'User is not logged in.';
    } else {
        $product_name = filter_var($_POST['product_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $stock = filter_var($_POST['stock'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $min_order = filter_var($_POST['min_order'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $max_order = filter_var($_POST['max_order'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $product_status = filter_var($_POST['product_status'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $shop_id = $_POST['shop_id'];
        $product_category_name = '';
        foreach ($shops as $shop) {
            if ($shop['shop_id'] == $shop_id) {
                $product_category_name = $shop['category'];
                break;
            }
        }

        $user_id = $_SESSION['user_id']; // Get user_id from session

        $image = $_FILES['product_image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = uniqid('product_') . '.' . $ext;
        $image_tmp_name = $_FILES['product_image']['tmp_name'];
        $image_size = $_FILES['product_image']['size'];
        $image_folder = 'uploaded_files/' . $rename;

        if ($image_size > 2000000) {
            $warning_msg[] = 'Image size is too large!';
        } else {
            $sql = "INSERT INTO product (
                        product_name, description, price, stock, min_order, max_order,
                        product_image, add_date, product_status,
                        shop_id, user_id, product_category_name
                    ) VALUES (
                        :product_name, :description, :price, :stock, :min_order, :max_order,
                        :product_image, TO_DATE(:add_date, 'YYYY-MM-DD'), :product_status,
                        :shop_id, :user_id, :product_category_name
                    )";

            $stmt = oci_parse($conn, $sql);
            $add_date = date('Y-m-d');

            oci_bind_by_name($stmt, ':product_name', $product_name);
            oci_bind_by_name($stmt, ':description', $description);
            oci_bind_by_name($stmt, ':price', $price);
            oci_bind_by_name($stmt, ':stock', $stock);
            oci_bind_by_name($stmt, ':min_order', $min_order);
            oci_bind_by_name($stmt, ':max_order', $max_order);
            oci_bind_by_name($stmt, ':product_image', $rename);
            oci_bind_by_name($stmt, ':add_date', $add_date);
            oci_bind_by_name($stmt, ':product_status', $product_status);
            oci_bind_by_name($stmt, ':shop_id', $shop_id);
            oci_bind_by_name($stmt, ':user_id', $user_id);
            oci_bind_by_name($stmt, ':product_category_name', $product_category_name);

            $result = oci_execute($stmt);
            if ($result) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'Product added!';
            } else {
                $e = oci_error($stmt);
                $warning_msg[] = 'Database error: ' . $e['message'];
            }
            oci_free_statement($stmt);
        }
    }
}
?>

<!-- HTML Part -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <style>
        /* Main Form Container */
        .form-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Form Header */
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .form-header h3 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        /* Form Grid Layout */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        /* Form Group Styling */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group label span {
            color: #e74c3c;
        }

        /* Input Fields */
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: #f9f9f9;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            background-color: #fff;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* File Input Customization */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            font-size: 100px;
            opacity: 0;
            right: 0;
            top: 0;
            cursor: pointer;
        }

        .file-input-label {
            display: block;
            padding: 12px;
            background: #f9f9f9;
            border: 1px dashed #ddd;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-input-label:hover {
            border-color: #3498db;
            background: #f0f7fd;
        }

        /* Submit Button */
        .submit-btn {
            grid-column: span 2;
            background-color: rgb(254, 148, 74);
            color: white;
            border: none;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 15px;
            text-decoration: none;
            text-align: center;
        }

        .submit-btn:hover {
            background-color: grey;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .submit-btn {
                grid-column: span 1;
            }
        }

        /* Status Messages */
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .success-msg {
            background-color: #d4edda;
            color: #155724;
        }

        .warning-msg {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="form-header">
            <h3>Product Information</h3>
            <p>Add new product to your inventory</p>
        </div>

        <?php if (!empty($warning_msg)): ?>
            <div class="message warning-msg">
                <?php echo $warning_msg[0]; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_msg)): ?>
            <div class="message success-msg">
                <?php echo $success_msg[0]; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <!-- Left Column -->
                <div>
                    <div class="form-group">
                        <label>Product Name <span>*</span></label>
                        <input type="text" name="product_name" class="form-control" required maxlength="50">
                    </div>

                    <div class="form-group">
                        <label>Description <span>*</span></label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Price <span>*</span></label>
                        <input type="number" name="price" class="form-control" required min="0" step="0.01">
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <div class="form-group">
                        <label>Stock Quantity <span>*</span></label>
                        <input type="number" name="stock" class="form-control" required min="0">
                    </div>

                    <div class="form-group">
                        <label>Minimum Order <span>*</span></label>
                        <input type="number" name="min_order" class="form-control" required min="1">
                    </div>

                    <div class="form-group">
                        <label>Maximum Order <span>*</span></label>
                        <input type="number" name="max_order" class="form-control" required min="1">
                    </div>

                    <div class="form-group">
                        <label>Product Status <span>*</span></label>
                        <select name="product_status" class="form-control" required>
                            <option value="In Stock">In Stock</option>
                            <option value="Out of Stock">Out of Stock</option>
                        </select>
                    </div>

                    <!-- REMOVED: User ID dropdown -->

                    <div class="form-group">
                        <label>Shop <span>*</span></label>
                        <select name="shop_id" id="shopSelect" class="form-control" required onchange="updateCategory()">
                            <option value="">Select Shop</option>
                            <?php foreach ($shops as $shop): ?>
                                <option value="<?= htmlspecialchars($shop['shop_id']) ?>" data-category="<?= htmlspecialchars($shop['category']) ?>">
                                    <?= htmlspecialchars($shop['shop_id']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Product Image <span>*</span></label>
                        <div class="file-input-wrapper">
                            <label class="file-input-label">
                                <i class="fas fa-cloud-upload-alt"></i> Choose an image file
                                <input type="file" name="product_image" required accept="image/*">
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="submit-btn" name="add">Add Product</button>
                <a href="../../FrontEnd/trader_dashboard.php" class="submit-btn">Go to Dashboard</a>
            </div>
        </form>
    </div>

    <script>
        function updateCategory() {
            var shopSelect = document.getElementById("shopSelect");
            var selectedOption = shopSelect.options[shopSelect.selectedIndex];
            var category = selectedOption.getAttribute("data-category");
            document.getElementById("categoryInput").value = category || '';
        }
    </script>
</body>

</html>