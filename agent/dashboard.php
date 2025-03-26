<?php

include '../components/connect.php';

if(isset($_COOKIE['agent_id'])){
    $agent_id = $_COOKIE['agent_id'];
 }else{
    $agent_id = '';
    header('location:login.php');
 }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    
    <!-- font-awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
     <link rel="stylesheet" href="agent_style.css">
</head>
<body>
    
 <!-- header section starts  -->
<?php include '../components/agent_header.php'; ?>
<!-- header section ends -->

<!-- dashboard section starts  -->

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

   <div class="box">
      <?php
         $select_profile = $conn->prepare("SELECT * FROM `agents` WHERE id = ? LIMIT 1");
         $select_profile->execute([$agent_id]);
         $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <h3>welcome!</h3>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="update.php" class="btn">update profile</a>
   </div>

   <div class="box">
      <?php
         $select_listings = $conn->prepare("SELECT * FROM `property_1` WHERE agent_id = ? ORDER BY date DESC");
         $select_listings->execute([$agent_id]);
         $total_listings = $select_listings->rowCount();
      ?>
      <h3><?= $total_listings; ?></h3>
      <p>Total listings</p>
      <a href="wahala.php" class="btn">view listings</a>
   </div>

   <div class="box">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `users`");
         $select_users->execute();
         $count_users = $select_users->rowCount();
      ?>
      <h3><?= $count_users; ?></h3>
      <p>total users</p>
      <a href="users.php" class="btn">view users</a>
   </div>

   <div class="box">
      <?php
         $select_admins = $conn->prepare("SELECT * FROM `admins`");
         $select_admins->execute();
         $count_admins = $select_admins->rowCount();
      ?>
      <h3><?= $count_admins; ?></h3>
      <p>total admins</p>
      <a href="admins.php" class="btn">view admins</a>
   </div>

   <div class="box">
      <?php
         $select_requests = $conn->prepare("SELECT * FROM `requests` WHERE receiver = ?");
         $select_requests->execute([$agent_id]);
         $count_requests = $select_requests->rowCount();
      ?>
      <h3><?= $count_requests; ?></h3>
      <p>new requests</p>
      <a href="requests.php" class="btn">view Requests</a>
   </div>

   </div>

</section>


<!-- dashboard section ends -->










<!-- custom js file link  -->
<script src="js/admin_script.js"></script>


</body>
</html>