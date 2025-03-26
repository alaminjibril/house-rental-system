<?php

include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
    $admin_id = $_COOKIE['admin_id'];
}else{
    $admin_id = '';
}

if(isset($_POST['submit'])){

    $id = create_unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING); 
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);   
 
    $select_agents = $conn->prepare("SELECT * FROM `agents` WHERE email = ?");
    $select_agents->execute([$email]);
 
    if($select_agents->rowCount() > 0){
       $warning_msg[] = 'email already taken!';
    }else{
       if($pass != $c_pass){
          $warning_msg[] = 'Password not matched!';
       }else{
          $insert_agent = $conn->prepare("INSERT INTO `agents`(id, name, number, email, password) VALUES(?,?,?,?,?)");
          $insert_agent->execute([$id, $name, $number, $email, $c_pass]);
          
          if($insert_agent){
             $verify_agents = $conn->prepare("SELECT * FROM `agents` WHERE email = ? AND password = ? LIMIT 1");
             $verify_agents->execute([$email, $c_pass]);
             $row = $verify_agents->fetch(PDO::FETCH_ASSOC);
          
             if($verify_agents->rowCount() > 0){
                $success_msg[] = 'Agent registered successfully!';
             }else{
                $error_msg[] = 'something went wrong!';
             }
          }
 
       }
    }
 
 }
 



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register agent</title>

    <!-- font-awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<!-- header section --> 
<?php include '../components/admin_header.php' ?>
<!-- header section ends -->

<!-- register section starts here -->
<?php   ?>
<section class="form-container">
   <form action="" method="post">
      <h3>Register Agent!</h3>
      <input type="tel" name="name" required maxlength="50" placeholder="enter name" class="box">
      <input type="email" name="email" required maxlength="50" placeholder="enter email" class="box">
      <input type="number" name="number" required min="0" max="99999999999" maxlength="11" placeholder="enter number" class="box">
      <input type="password" name="pass" required maxlength="20" placeholder="enter password" class="box">
      <input type="password" name="c_pass" required maxlength="20" placeholder="confirm password" class="box">
      <input type="submit" value="register now" name="submit" class="btn">
   </form>

</section>
<!-- register section ends here -->









<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include '../components/message.php';  ?>

</body>
</html>