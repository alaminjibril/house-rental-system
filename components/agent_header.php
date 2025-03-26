<nav class="nav nav-1">
      <section class="flex">
         <a href="dashboard.php" class="logo"><i class="fas fa-house"></i>Agent</a>
         <div id="menu-btn" class="fas fa-bars"></div>

         <ul>
         <a href="../components/agent_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn"><i class="fas fa-right-from-bracket"></i><span>logout</span></a>
         </ul>
      </section>
   </nav>

<header class="header">

   <div id="close-btn"><i class="fas fa-times"></i></div>

   <a href="dashboard.php" class="logo">AgentPanel.</a>

   <nav class="navbar">
      <a href="dashboard.php"><i class="fas fa-home"></i><span>home</span></a>
      <a href="wahala.php"><i class="fas fa-building"></i><span>My listings</span></a>
      <a href="post_property.php"><i class="fas fa-paper-plane"></i><span>Post property</span></a>
      <a href="tenants.php"><i class="fas fa-user"></i><span>Tenants</span></a>
      <a href="payments.php"><i class="fas fa-user"></i><span>Payments</span></a>
      <a href="requests.php"><i class="fas fa-message"></i><span>Requests</span></a>
      <a href="reports.php"><i class="fa fa-file" aria-hidden="true"></i><span>Reports</span></a>
   </nav>

   <a href="update.php" class="btn">update account</a>
   <div class="flex-btn">
      <a href="login.php" class="option-btn">login</a>
   </div>
   <a href="../components/agent_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn"><i class="fas fa-right-from-bracket"></i><span>logout</span></a>

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