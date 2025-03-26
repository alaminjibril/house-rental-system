<?php
include '../components/connect.php';

if(isset($_COOKIE['agent_id'])){
    $agent_id = $_COOKIE['agent_id'];
} else {
    header('location:login.php');
    exit();
}

if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
 }else{
    $get_id = '';
    // header('location:home.php');
 }
 

$message = "";





if(isset($_POST['submit'])){
    $id = create_unique_id();
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
    $middlename = filter_var($_POST['middlename'], FILTER_SANITIZE_STRING);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $contact = filter_var($_POST['contact'], FILTER_SANITIZE_STRING);
    $property_id = filter_var($_POST['property_id'], FILTER_SANITIZE_STRING);
    $property_name = filter_var($_POST['property_name'], FILTER_SANITIZE_STRING);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
    $date_in = filter_var($_POST['date_in'], FILTER_SANITIZE_STRING);
    $lease_duration = filter_var($_POST['lease_duration'], FILTER_SANITIZE_NUMBER_INT);
    $rent_due_date = filter_var($_POST['rent_due_date'], FILTER_SANITIZE_STRING);
    $payment_status = filter_var($_POST['payment_status'], FILTER_SANITIZE_STRING);
    $lease_start = filter_var($_POST['lease_start'], FILTER_SANITIZE_STRING);
    $lease_end = filter_var($_POST['lease_end'], FILTER_SANITIZE_STRING);
    

    if (!$property_id) {
        $message = "Error: Property ID is missing!";
    } else {
        $insert_tenant = $conn->prepare("INSERT INTO `tenants` (id, firstname, middlename, lastname, email, contact, property_id, property_name, status, date_in, lease_duration, rent_due_date, payment_status, lease_start, lease_end) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $insert_tenant->execute([
            $id, $firstname, $middlename, $lastname, $email, $contact, $property_id, $property_name, $status, 
            $date_in, $lease_duration, $rent_due_date, $payment_status, $lease_start, $lease_end
        ]);

        if ($insert_tenant) {
            $message = "Tenant added successfully!";
        } else {
            $message = "Error adding tenant.";
        }
    }

   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tenant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="agent_style.css">

    <style>
        .form-container form {
            width: 50rem;
            border-radius: .5rem;
            padding: 2rem;
            border: var(--border);
            text-align: center;
            background-color: var(--white);
            box-shadow: var(--box-shadow);
            margin-top: 80%;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            font-size: 1.2rem;
        }
    </style>

</head>
<body>

<?php include '../components/agent_header.php'; ?>

<section class="form-container">
   <form action="" method="post">
      <h3>Add Tenant</h3>
      
      <?php if (!empty($message)) echo "<p style='color:red;'>$message</p>"; ?>

      <input type="text" name="firstname" maxlength="50" placeholder="First Name" class="box" required>
      <input type="text" name="middlename" maxlength="50" placeholder="Middle Name (Optional)" class="box">
      <input type="text" name="lastname" maxlength="50" placeholder="Last Name" class="box" required>
      <input type="email" name="email" maxlength="50" placeholder="Email" class="box" required>
      <input type="text" name="contact" maxlength="15" placeholder="Contact Number" class="box" required>

      <label>Select Property</label>
        <select name="property_id" class="box" required onchange="updatePropertyName(this)">
            <option value="">Select Property</option>
            <?php
            $property_id = null; // Initialize to avoid warnings
            $property_name = '';

            // Fetch the selected property if 'get_id' is provided
            if (!empty($get_id)) {
                $select_properties = $conn->prepare("SELECT id, property_name FROM `property_1` WHERE id = ? LIMIT 1");
                $select_properties->execute([$get_id]);
                if ($select_properties->rowCount() > 0) {
                    $fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC);
                    echo "<option value='{$fetch_property['id']}' data-name='{$fetch_property['property_name']}' selected>{$fetch_property['property_name']}</option>";
                    $property_id = $fetch_property['id'];
                    $property_name = $fetch_property['property_name'];
                }
            }

            // Fetch and display all other properties
            $stmt = $conn->query("SELECT id, property_name FROM property_1");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Skip the property already selected
                if (!isset($fetch_property) || $row['id'] != $property_id) {
                    echo "<option value='{$row['id']}' data-name='{$row['property_name']}'>{$row['property_name']}</option>";
                }
            }
            ?>
        </select>

    <!-- Hidden input to store property_name -->
    <input type="hidden" name="property_name" id="property_name" value="<?= htmlspecialchars($property_name); ?>">

      <label>Status</label>
      <select name="status" class="box">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
      </select>
      
      <label>Date In</label>
      <input type="date" name="date_in" class="box" required>
      
      <label>Lease Duration (Months)</label>
      <input type="number" name="lease_duration" min="1" class="box" required>

      <label>Rent Due Date</label>
      <input type="date" name="rent_due_date" class="box" required>
      
      <label>Payment Status</label>
      <select name="payment_status" class="box">
          <option value="Paid">Paid</option>
          <option value="Unpaid">Unpaid</option>
      </select>

      <label>Lease Start</label>
      <input type="date" name="lease_start" class="box" required>

      <label>Lease End</label>
      <input type="date" name="lease_end" class="box" required>

      <input type="submit" value="Add Tenant" class="btn" name="submit">
   </form>
</section>
<script>
    function updatePropertyName(select) {
        var selectedOption = select.options[select.selectedIndex];
        if (selectedOption) {
            document.getElementById('property_name').value = selectedOption.getAttribute('data-name') || '';
        }
    }

    // Ensure property name is set on page load if a property is pre-selected
    document.addEventListener("DOMContentLoaded", function() {
        var select = document.querySelector("select[name='property_id']");
        updatePropertyName(select);
    });
</script>

<script src="js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>
