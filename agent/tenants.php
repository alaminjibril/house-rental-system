<?php

include '../components/connect.php';

if(isset($_COOKIE['agent_id'])){
    $agent_id = $_COOKIE['agent_id'];
} else {
    $agent_id = '';
    header('location:login.php');
    exit();
}


if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
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

// Fetch tenants
$query = "SELECT * FROM `tenants`";
if (!empty($get_id)) {
    $query .= " WHERE property_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$get_id]);
} else {
    $stmt = $conn->prepare($query);
    $stmt->execute();
}
$tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- FontAwesome and DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <!-- Custom CSS -->
    <link rel="stylesheet" href="agent_style.css">
    <style>
    
.container{
    height: 100vh;
   align-items: center;
   justify-content: center;
   margin: 3rem;
}       
.flex{
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: var(--border);
    padding: .5rem;
    margin-bottom: 1rem

}
 
.flex .h2{
    font-size: 2.2rem;
    color: var(--black); 
}
 
.flex h2{
    color: var(--main-color);
    margin-right: .7rem;
}

.flex ul{
    list-style: none;
}
 
.flex ul li{
    float: left;
    position: relative;
}
 
.flex ul li a{
    display: inline-block;
    font-size: 1.8rem;
    color: var(--black);
    background-color: var(--white);
}

.flex ul li a:hover{
    background-color: var(--main-color);
    color: var(--white);
}
 
.flex ul li a i{
    margin-left: 1rem;
}
 
.flex ul li ul{
    position: absolute;
    width: 17rem;
    left: 0;
}

.flex ul li ul li{
    width: 100%;
 }
 
.flex ul li ul li a{
    display: none;
 }
 
.nav .flex ul li:hover ul li a{
    display: block;
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
.btn-warning { background-color: #ffc107; color: black; }
.btn-danger { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    
<?php include '../components/agent_header.php'; ?>

<div class="container">

    <div class="flex">
        <h2>List of Tenants</h2>
        <ul>
        <li><a href="add_tenant.php" class="btn btn-primary">New Tenant</a></li>
        </ul>
    </div>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Property Rented</th>
                <th>Date In</th>
                <th>Lease Duration</th>
                <th>Payment Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tenants as $i => $tenant): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($tenant['firstname']); ?></td>
                <td><?= htmlspecialchars($tenant['lastname']); ?></td>
                <td><?= htmlspecialchars($tenant['email']); ?></td>
                <td><?= htmlspecialchars($tenant['property_name']); ?></td>
                <td><?= htmlspecialchars($tenant['date_in']); ?></td>
                <td><?= htmlspecialchars($tenant['lease_duration']); ?></td>
                <td><?= htmlspecialchars($tenant['payment_status']); ?></td>
                <td class="text-center">
                    <a href="View_tenant.php?id=<?= $tenant['id']; ?>" class="btn1 btn-info">View</a>
                    <a href="edit_tenant.php?id=<?= $tenant['id']; ?>" class="btn1 btn-warning">Edit</a>
                    <form action="" method="POST">
                        <input type="hidden" name="delete_id" value="<?= $tenant['id']; ?>">
                        <input type="submit" value="delete" onclick="return confirm('delete this tenant?');" name="delete" class="btn1 btn-danger">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>



<!-- Custom JS -->
<script src="js/admin_script.js"></script>
<script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

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
