<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}

include 'components/save_send.php'

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search page</title>

    <!-- font-awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- header section --> 
<?php include 'components/user_header.php' ?>
<!-- header section ends -->

<!-- filter section starts -->

<section class="filter-search">
    <form action="" method="post">
        <div id="close-filter"><i class="fas fa-times"></i></div>
        <h3>filter your search</h3>
         <div class="flex">
            <div class="box">
                <p>property address <span>*</span></p>
                <input type="text" name="address" required maxlength="100" placeholder="enter property address" class="input">
            </div>
            <div class="box">
               <p>property type <span>*</span></p>
               <select name="type" class="input" required>
                  <option value="flat">flat</option>
                  <option value="house">house</option>
                  <option value="shop">shop</option>
               </select>
            </div>
            <div class="box">
               <p>offer type <span>*</span></p>
               <select name="offer" class="input" required>
                  <option value="sale">sale</option>
                  <option value="resale">resale</option>
                  <option value="rent">rent</option>
               </select>
            </div>
            <div class="box">
               <p>how many BHKs <span>*</span></p>
               <select name="bhk" class="input" required>
                    <option value="1">1 BHK</option>
                    <option value="2">2 BHK</option>
                    <option value="3">3 BHK</option>
                    <option value="4">4 BHK</option>
                    <option value="5">5 BHK</option>
                    <option value="6">6 BHK</option>
                    <option value="7">7 BHK</option>
                    <option value="8">8 BHK</option>
                    <option value="9">9 BHK</option>
               </select>
            </div>
            <div class="box">
               <p>minimum budget <span>*</span></p>
               <select name="min" class="input" required>
                  <option value="100000">&#8358; 100,000</option>
                  <option value="200000">&#8358; 200,000</option>
                  <option value="300000">&#8358; 300,000</option>
                  <option value="400000">&#8358; 400,000</option>
                  <option value="500000">&#8358; 500,000</option>
                  <option value="600000">&#8358; 600,000</option>
                  <option value="700000">&#8358; 700,000</option>
                  <option value="800000">&#8358; 800,000</option>
                  <option value="900000">&#8358; 900,000</option>
                  <option value="1000000">&#8358; 1 Million</option>
                  <option value="2000000">&#8358; 2 Million</option>
                  <option value="3000000">&#8358; 3 Million</option>
                  <option value="4000000">&#8358; 4 Million</option>
                  <option value="5000000">&#8358; 5 Million</option>
                  <option value="10000000">&#8358; 10 Million</option>
                  <option value="20000000">&#8358; 20 Million</option>
                  <option value="40000000">&#8358; 40 Million</option>
                  <option value="60000000">&#8358; 60 Million</option>
                  <option value="80000000">&#8358; 80 Million</option>
                  <option value="100000000">&#8358; 100 Million</option>
                  <option value="150000000">&#8358; 150 Million</option>
               </select>
            </div>
            <div class="box">
               <p>maximum budget <span>*</span></p>
               <select name="max" class="input" required>
                <option value="100000">&#8358; 100,000</option>
                  <option value="200000">&#8358; 200,000</option>
                  <option value="300000">&#8358; 300,000</option>
                  <option value="400000">&#8358; 400,000</option>
                  <option value="500000">&#8358; 500,000</option>
                  <option value="600000">&#8358; 600,000</option>
                  <option value="700000">&#8358; 700,000</option>
                  <option value="800000">&#8358; 800,000</option>
                  <option value="900000">&#8358; 900,000</option>
                  <option value="1000000">&#8358; 1 Million</option>
                  <option value="2000000">&#8358; 2 Million</option>
                  <option value="3000000">&#8358; 3 Million</option>
                  <option value="4000000">&#8358; 4 Million</option>
                  <option value="5000000">&#8358; 5 Million</option>
                  <option value="10000000">&#8358; 10 Million</option>
                  <option value="20000000">&#8358; 20 Million</option>
                  <option value="40000000">&#8358; 40 Million</option>
                  <option value="60000000">&#8358; 60 Million</option>
                  <option value="80000000">&#8358; 80 Million</option>
                  <option value="100000000">&#8358; 100 Million</option>
                  <option value="150000000">&#8358; 150 Million</option>
               </select>
            </div>
            <div class="box">
               <p>property status <span>*</span></p>
               <select name="status" class="input" required>
                    <option value="ready to move">ready to move</option>
                    <option value="under construction">under construction</option>
               </select>
            </div>
            <div class="box">
               <p>furnished <span>*</span></p>
               <select name="furnished" class="input" required>
                    <option value="unfurnished">unfurnished</option>
                    <option value="semi-furnished">semi-furnished</option>
                    <option value="furnished">furnished</option>
               </select>
            </div>
        </div>
        <input type="submit" value="filter_search" name="filter_search" class="btn">
    </form>
</section>

<!-- filter section ends -->

<div id="open-filter" class="fas fa-filter"></div>

<?php
if(isset($_POST['h_search'])){

    $h_address = $_POST['h_address'];
    $h_address = filter_var($h_address, FILTER_SANITIZE_STRING);
    $h_type = $_POST['h_type'];
    $h_type = filter_var($h_type, FILTER_SANITIZE_STRING);
    $h_offer = $_POST['h_offer'];
    $h_offer = filter_var($h_offer, FILTER_SANITIZE_STRING);
    $h_min = $_POST['h_min'];
    $h_min = filter_var($h_min, FILTER_SANITIZE_STRING);
    $h_max = $_POST['h_max'];
    $h_max = filter_var($h_max, FILTER_SANITIZE_STRING);
 
    $select_properties = $conn->prepare("SELECT * FROM `property_1` WHERE address LIKE '%{$h_address}%' AND type LIKE '%{$h_type}%' AND offer LIKE '%{$h_offer}%' AND price BETWEEN $h_min AND $h_max ORDER BY date DESC");
    $select_properties->execute();


}elseif(isset($_POST['filter_search'])){
    $address = $_POST['address'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $type = $_POST['type'];
    $type = filter_var($type, FILTER_SANITIZE_STRING);
    $offer = $_POST['offer'];
    $offer = filter_var($offer, FILTER_SANITIZE_STRING);
    $bhk = $_POST['bhk'];
    $bhk = filter_var($bhk, FILTER_SANITIZE_STRING);
    $min = $_POST['min'];
    $min = filter_var($min, FILTER_SANITIZE_STRING);
    $max = $_POST['max'];
    $max = filter_var($max, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);
    $furnished = $_POST['furnished'];
    $furnished = filter_var($furnished, FILTER_SANITIZE_STRING);
 
    $select_properties = $conn->prepare("SELECT * FROM `property_1` WHERE address LIKE '%{$address}%' AND type LIKE '%{$type}%' AND offer LIKE '%{$offer}%' AND bhk LIKE '%{$bhk}%' AND status LIKE '%{$status}%' AND furnished LIKE '%{$furnished}%' AND price BETWEEN $min AND $max ORDER BY date DESC");
    $select_properties->execute();

}else{
    $select_properties = $conn->prepare("SELECT * FROM `property_1` ORDER BY date DESC LIMIT 6");
    $select_properties->execute();
}

?>

<!-- listings section starts -->

<section class="listings">

   <?php 
      if(isset($_POST['h_search']) or isset($_POST['filter_search'])){
         echo '<h1 class="heading">search results</h1>';
      }else{
         echo '<h1 class="heading">latest listings</h1>';
      }
   ?>

   <div class="box-container">
      <?php
         $total_images = 0;
         if($select_properties->rowCount() > 0){
            while($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)){
            $select_user = $conn->prepare("SELECT * FROM `agents` WHERE id = ?");
            $select_user->execute([$fetch_property['agent_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

            if(!empty($fetch_property['image_02'])){
               $image_coutn_02 = 1;
            }else{
               $image_coutn_02 = 0;
            }
            if(!empty($fetch_property['image_03'])){
               $image_coutn_03 = 1;
            }else{
               $image_coutn_03 = 0;
            }
            if(!empty($fetch_property['image_04'])){
               $image_coutn_04 = 1;
            }else{
               $image_coutn_04 = 0;
            }
            if(!empty($fetch_property['image_05'])){
               $image_coutn_05 = 1;
            }else{
               $image_coutn_05 = 0;
            }

            $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);

            $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
            $select_saved->execute([$fetch_property['id'], $user_id]);

      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
            <?php
               if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
            <?php
               }
            ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
               <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $fetch_property['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price"><i class="fas fa-naira-sign"></i><span><?= $fetch_property['price']; ?></span></div>
            <h3 class="name"><?= $fetch_property['property_name']; ?></h3>
            <p class="address"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_property['address']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= $fetch_property['type']; ?></span></p>
               <p><i class="fas fa-tag"></i><span><?= $fetch_property['offer']; ?></span></p>
               <p><i class="fas fa-bed"></i><span><?= $fetch_property['bhk']; ?> BHK</span></p>
               <p><i class="fas fa-trowel"></i><span><?= $fetch_property['status']; ?></span></p>
               <p><i class="fas fa-couch"></i><span><?= $fetch_property['furnished']; ?></span></p>
               <p><i class="fas fa-maximize"></i><span><?= $fetch_property['carpet']; ?>sqft</span></p>
            </div>
            <div class="flex-btn">
               <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">view property</a>
               <input type="submit" value="send enquiry" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">no results found!</p>';
      }
      ?>
      
   </div>

</section>

<!-- listings section starts -->


<!-- footer section start -->
<?php include 'components/footer.php' ?>
<!-- footer section start -->

<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script>

    let filter = document.querySelector('.filter-search');

    document.querySelector('#open-filter').onclick = () =>{
    filter.classList.add('active');
    }

    document.querySelector('#close-filter').onclick = () =>{
        filter.classList.remove('active');
    }
</script>
<?php include 'components/message.php';  ?>

</body>
</html>