<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}

if(isset($_POST['submit'])){

   
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING); 
    
    $verify_users = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
    $verify_users->execute([$email, $pass]);
    $row = $verify_users->fetch(PDO::FETCH_ASSOC);

    if($verify_users->rowCount() > 0){
    setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
    header('location:home.php');
    }else{
    $warning_msg[] = 'incorret email or password!';
    }
 
 }
 



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- font-awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- header section --> 
<?php include 'components/user_header.php' ?>



<!-- login section starts here -->
<?php   ?>
<section class="form-container">
   <form action="" method="post">
      <h3>Welcome back!</h3>
      <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
      <input type="password" name="pass" required maxlength="20" placeholder="enter your password" class="box">
      <p>dont have an account? <a href="register.php">register now</a></p>
      <input type="submit" value="login now" name="submit" class="btn">
   </form>

</section>
<!-- login section ends here -->







<!-- header section ends -->

<!-- footer section start -->
<?php include 'components/footer.php' ?>
<!-- footer section start -->

<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php';  ?>

</body>
</html>