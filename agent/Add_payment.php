<?php
include '../components/connect.php';

if(isset($_COOKIE['agent_id'])){
    $agent_id = $_COOKIE['agent_id'];
} else {
    header('location:login.php');
    exit();
}

$message = "";

if(isset($_POST['submit'])){
    $id = create_unique_id();
    $tenant_id = filter_var($_POST['tenant_id'], FILTER_SANITIZE_STRING);
    $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $invoice_number = filter_var($_POST['invoice'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $payment_date = filter_var($_POST['payment_date'], FILTER_SANITIZE_STRING);
    $payment_method = filter_var($_POST['payment_method'], FILTER_SANITIZE_STRING);

    // Fetch tenant name from tenants table
    $stmt = $conn->prepare("SELECT CONCAT(firstname, ' ', lastname) AS tenant_name FROM tenants WHERE id = ?");
    $stmt->execute([$tenant_id]);
    $tenant = $stmt->fetch(PDO::FETCH_ASSOC);
    $tenant_name = $tenant ? $tenant['tenant_name'] : '';

    if (!$tenant_id || !$tenant_name) {
        $message = "Error: Invalid tenant selection!";
    } else {
        $insert_payment = $conn->prepare("INSERT INTO payments (id, tenant_id, tenant_name, amount, invoice_number, payment_date, payment_method) VALUES (?, ?, ?, ?, ?, ?,?)");
        
        $insert_payment->execute([
            $id, $tenant_id, $tenant_name, $amount, $invoice_number, $payment_date, $payment_method
        ]);

        if ($insert_payment) {
            $message = "Payment added successfully!";
        } else {
            $message = "Error adding payment.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment</title>
    <link rel="stylesheet" href="agent_style.css">
</head>
<body>

<?php include '../components/agent_header.php'; ?>

<section class="form-container">
   <form action="" method="post">
      <h3>Add Payment</h3>
      
      <?php if (!empty($message)) echo "<p style='color:red;'>$message</p>"; ?>

      <label>Select Tenant</label>
      <select name="tenant_id" class="box" required>
          <option value="">Select Tenant</option>
          <?php
          $stmt = $conn->query("SELECT id, CONCAT(firstname, ' ', middlename, ' ', lastname) AS tenant_name FROM tenants");
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "<option value='{$row['id']}'>{$row['tenant_name']}</option>";
          }
          ?>
      </select>

      <label>Amount</label>
      <input type="number" name="amount" class="box" required>
      <label>Invoice</label>
      <input type="number" name="invoice" class="box" required>

      <label>Payment Date</label>
      <input type="date" name="payment_date" class="box" required>

      <label>Payment Method</label>
      <select name="payment_method" class="box">
          <option value="Bank Transfer">Bank Transfer</option>
          <option value="Cash">Cash</option>
          <option value="Card">Card</option>
      </select>

      <input type="submit" value="Add Payment" class="btn" name="submit">
   </form>
</section>

<?php include '../components/message.php'; ?>

</body>
</html>
