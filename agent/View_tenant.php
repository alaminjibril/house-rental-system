<?php

include '../components/connect.php';

if(isset($_COOKIE['agent_id'])){
    $agent_id = $_COOKIE['agent_id'];
} else {
    $agent_id = '';
    header('location:login.php');
    exit();
}

// Check if tenant ID is provided
if (isset($_GET['id'])) {
    $tenant_id = $_GET['id'];

    // Fetch tenant details
    $query = $conn->prepare("SELECT * FROM `tenants` WHERE id = ?");
    $query->execute([$tenant_id]);
    $tenant = $query->fetch(PDO::FETCH_ASSOC);

    if (!$tenant) {
        echo "<script>alert('Tenant not found!'); window.location='tenants.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request!'); window.location='tenants.php';</script>";
    exit();
}

if(isset($_POST['delete'])){

    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
 
    $verify_delete = $conn->prepare("SELECT * FROM `tenants` WHERE id = ?");
    $verify_delete->execute([$delete_id]);
 
    if($verify_delete->rowCount() > 0){
       $delete_user = $conn->prepare("DELETE FROM `tenants` WHERE id = ?");
       $delete_user->execute([$delete_id]);
       $success_msg[] = 'user deleted!';
    }else{
       $warning_msg[] = 'User deleted already!';
    }
 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- FontAwesome and DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="agent_style.css">
    <style>
        .container {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .tenant-name {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 10px;
        }

        .tenant-info {
            list-style: none;
            padding: 0;
        }

        .tenant-info li {
            padding: 10px;
            font-size: 1.2rem;
            color: #444;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
        }

        .status-paid {
            color: green;
            font-weight: bold;
        }

        .status-pending {
            color: red;
            font-weight: bold;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2rem;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    
<?php include '../components/agent_header.php'; ?>

<div class="container">
    <h2 class="tenant-name"><?= htmlspecialchars($tenant['firstname']) . " " . htmlspecialchars($tenant['lastname']); ?></h2>

    <ul class="tenant-info">
        <li><strong>Email:</strong> <span><?= htmlspecialchars($tenant['email']); ?></span></li>
        <li><strong>Phone:</strong> <span><?= htmlspecialchars($tenant['contact']); ?></span></li>
        <li><strong>Move-in Date:</strong> <span><?= htmlspecialchars($tenant['date_in']); ?></span></li>
        <li><strong>Lease Duration:</strong> <span><?= htmlspecialchars($tenant['lease_duration']); ?> months</span></li>
        <li><strong>Payment Status:</strong> 
            <span class="<?= $tenant['payment_status'] === 'Paid' ? 'status-paid' : 'status-pending'; ?>">
                <?= htmlspecialchars($tenant['payment_status']); ?>
            </span>
        </li>
    </ul>

    <a href="tenants.php" class="btn-back"><i class="fa fa-arrow-left"></i> Back to Tenants</a>
</div>
   

<script>
// $(document).ready(function(){
//     $('#tenantTable').DataTable({ 
//         "searching": true,
//         "ordering": true,
//         "info": true
//     });
// });
</script>

<?php include '../components/message.php'; ?>

</body>
</html>
