<?php
session_start();

// Check if the user is logged in and is a trader
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'trader') {
    header("Location: login.php");
    exit();
}

// Include the OCI connection
include "../backend/database/connect.php";
$conn = getDBConnection();

$user_id = $_SESSION['user_id'];

try {
    // Get trader info
    $query = "SELECT * FROM users WHERE user_id = :user_id AND role = 'trader'";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':user_id', $user_id);
    oci_execute($stmt);
    $userData = oci_fetch_assoc($stmt);
    oci_free_statement($stmt);

    if (!$userData) {
        throw new Exception("Trader data not found");
    }

    // Get recent orders (last 5)
    $ordersQuery = "SELECT * FROM (
                        SELECT o.*, u.full_name AS customer_name, u.email AS customer_email 
                        FROM orders o
                        JOIN users u ON o.user_id = u.user_id
                        ORDER BY o.order_date DESC
                    ) WHERE ROWNUM <= 5";
    $ordersStmt = oci_parse($conn, $ordersQuery);
    oci_execute($ordersStmt);

    $recentOrders = [];
    while ($row = oci_fetch_assoc($ordersStmt)) {
        $recentOrders[] = $row;
    }
    oci_free_statement($ordersStmt);

    // Get order statistics
    $statsQuery = "SELECT 
        COUNT(*) AS total_orders,
        SUM(total_amount) AS total_sales,
        SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed_orders,
        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending_orders
        FROM orders";
    $statsStmt = oci_parse($conn, $statsQuery);
    oci_execute($statsStmt);
    $orderStats = oci_fetch_assoc($statsStmt);
    oci_free_statement($statsStmt);

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Handle order status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['order_id'])) {
    try {
        $order_id = (int) $_POST['order_id'];
        $newStatus = '';
        switch ($_POST['action']) {
            case 'process':
                $newStatus = 'processing';
                break;
            case 'complete':
                $newStatus = 'completed';
                break;
            case 'cancel':
                $newStatus = 'cancelled';
                break;
        }

        $updateQuery = "UPDATE orders SET status = :status WHERE order_id = :order_id";
        $updateStmt = oci_parse($conn, $updateQuery);
        oci_bind_by_name($updateStmt, ':status', $newStatus);
        oci_bind_by_name($updateStmt, ':order_id', $order_id);
        oci_execute($updateStmt);
        oci_free_statement($updateStmt);

        header("Location: trader_dashboard.php");
        exit();
    } catch (Exception $e) {
        die("Update failed: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trader Dashboard - Cleckhudders Market</title>
    <link rel="stylesheet" href="trader_dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Cleckhudders Market</h1>
        <h2>Trader Dashboard</h2>
        
        <div class="welcome-message">
            <h3>Welcome back, <?php echo htmlspecialchars($userData['FULL_NAME']); ?>!</h3>
            <p>Ready to manage your shop and keep things running smoothly.</p>
            <a href="../BackEnd/admin/add_product.php" class="edit-btn" style="margin-top: 20px;">Add Product</a>
        </div>
        
        <div class="trader-info">
            <h3>Your Account Information</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($userData['FULL_NAME']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userData['EMAIL']); ?></p>
            <p><strong>Member Since:</strong> <?php echo date('F j, Y', strtotime($userData['CREATED_DATE'])); ?></p>
            <a href="User_Profile.php" class="edit-btn">View Profile</a>
        </div>
        
        <div class="metrics">
            <div class="metric-card">
                <h3>Total Orders</h3>
                <div class="metric-value"><?php echo $orderStats['total_orders'] ?? 0; ?></div>
            </div>
            
            <div class="metric-card">
                <h3>Total Sales</h3>
                <div class="metric-value">$<?php echo number_format($orderStats['total_sales'] ?? 0, 2); ?></div>
            </div>
            
            <div class="metric-card">
                <h3>Completed Orders</h3>
                <div class="metric-value"><?php echo $orderStats['completed_orders'] ?? 0; ?></div>
            </div>
            
            <div class="metric-card">
                <h3>Pending Orders</h3>
                <div class="metric-value"><?php echo $orderStats['pending_orders'] ?? 0; ?></div>
            </div>
        </div>
        
        <h2>Recent Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($recentOrders)): ?>
                    <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo date('m/d/Y', strtotime($order['order_date'])); ?></td>
                            <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                            <td class="status-<?php echo htmlspecialchars($order['status']); ?>">
                                <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                            </td>
                            <td>
                                <?php if ($order['status'] == 'pending'): ?>
                                    <form class="action-form" method="POST">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                        <input type="hidden" name="action" value="process">
                                        <button type="submit" class="btn btn-process">Process</button>
                                    </form>
                                <?php elseif ($order['status'] == 'processing'): ?>
                                    <form class="action-form" method="POST">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                        <input type="hidden" name="action" value="complete">
                                        <button type="submit" class="btn btn-complete">Complete</button>
                                    </form>
                                <?php endif; ?>
                                <?php if ($order['status'] != 'completed' && $order['status'] != 'cancelled'): ?>
                                    <form class="action-form" method="POST">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                        <input type="hidden" name="action" value="cancel">
                                        <button type="submit" class="btn btn-cancel">Cancel</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No recent orders found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="logout.php" class="edit-btn" style="margin-top: 20px;">Logout</a>
    </div>
</body>
</html>