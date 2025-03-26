<?php

include '../components/connect.php';

if(isset($_COOKIE['agent_id'])){
    $agent_id = $_COOKIE['agent_id'];
} else {
    $agent_id = '';
    header('location:login.php');
    exit();
}

// Fetch payments
$query = "SELECT payments.*, tenants.firstname, tenants.lastname, tenants.property_name FROM payments 
          JOIN tenants ON payments.tenant_id = tenants.id";
$stmt = $conn->prepare($query);
$stmt->execute();
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['delete'])){
    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = $conn->prepare("SELECT * FROM `payments` WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if($verify_delete->rowCount() > 0){
        $delete_payment = $conn->prepare("DELETE FROM `payments` WHERE id = ?");
        $delete_payment->execute([$delete_id]);
        $success_msg[] = 'Payment deleted!';
    } else {
        $warning_msg[] = 'Payment not found!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>

    <!-- FontAwesome and DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="agent_style.css">
    <style>
    .container {
        height: 100vh;
        align-items: center;
        justify-content: center;
        margin: 3rem;
    }       
    .flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: var(--border);
        padding: .5rem;
        margin-bottom: 1rem;
    }
    .flex h2 {
        color: var(--main-color);
        margin-right: .7rem;
    }
    .btn1 {
        padding: 5px 10px;
        margin: 2px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        display: inline-block;
    }
    .btn-info { background-color: #17a2b8; color: white; }
    .btn-danger { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    
<?php include '../components/agent_header.php'; ?>

<div class="container">
    <div class="flex">
        <h2>Payments</h2>
        <ul>
            <li><a href="Add_payment.php" class="btn1 btn-info">New Payment</a></li>
        </ul>
    </div>
    <table id="paymentsTable" class="display">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Tenant</th>
                <th>property Rented</th>
                <th>Invoice</th>
                <th>Amount</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($payments as $i => $payment): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($payment['payment_date']); ?></td>
                <td><?= htmlspecialchars($payment['firstname'] . ' ' . $payment['lastname']); ?></td>
                <td><?= htmlspecialchars($payment['property_name']); ?></td>
                <td><?= htmlspecialchars($payment['invoice_number']); ?></td>
                <td><?= number_format($payment['amount'], 2); ?></td>
                <td class="text-center">
                    <a href="view_payment.php?id=<?= $payment['id']; ?>" class="btn1 btn-info">View</a>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?= $payment['id']; ?>">
                        <input type="submit" value="Delete" onclick="return confirm('Delete this payment?');" name="delete" class="btn1 btn-danger">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#paymentsTable').DataTable();
    });
</script>

<?php include '../components/message.php'; ?>

</body>
</html>
