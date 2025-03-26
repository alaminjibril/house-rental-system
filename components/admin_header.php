<nav class="nav nav-1">
      <section class="flex">
         <a href="dashboard.php" class="logo"><i class="fas fa-house"></i>Admin</a>
         <div id="menu-btn" class="fas fa-bars"></div>

         <ul>
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn"><i class="fas fa-right-from-bracket"></i><span>logout</span></a>
         </ul>
      </section>
   </nav>

<header class="header">

   <div id="close-btn"><i class="fas fa-times"></i></div>

   <a href="dashboard.php" class="logo">AdminPanel.</a>

   <nav class="navbar">
      <a href="dashboard.php"><i class="fas fa-home"></i><span>home</span></a>
      <a href="listings.php"><i class="fas fa-building"></i><span>listings</span></a>
      <a href="users.php"><i class="fas fa-user"></i><span>users</span></a>
      <a href="agents.php"><i class="fas fa-user"></i><span>Agents</span></a>
      <a href="admins.php"><i class="fas fa-user-gear"></i><span>admins</span></a>
      <a href="messages.php"><i class="fas fa-message"></i><span>messages</span></a>
   </nav>

   <a href="update.php" class="btn">update account</a>
   <div class="flex-btn">
      <a href="login.php" class="option-btn">login</a>
      <a href="register.php" class="option-btn">register</a>
   </div>
   <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn"><i class="fas fa-right-from-bracket"></i><span>logout</span></a>

</header>



<script>
    let header = document.querySelector('.header');

document.querySelector('#menu-btn').onclick = () =>{
   header.classList.add('active');
}

document.querySelector('#close-btn').onclick = () =>{
   header.classList.remove('active');
}

window.onscroll = () =>{
   header.classList.remove('active');
}

document.querySelectorAll('input[type="number"]').forEach(inputNumbmer => {
   inputNumbmer.oninput = () =>{
      if(inputNumbmer.value.length > inputNumbmer.maxLength) inputNumbmer.value = inputNumbmer.value.slice(0, inputNumbmer.maxLength);
   }
});
</script>