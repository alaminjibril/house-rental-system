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
    <title>saved listings</title>

    <!-- font-awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- header section --> 
<?php include 'components/user_header.php' ?>
<!-- header section ends -->


<!-- listings section starts -->

<section class="listings">

   <h1 class="heading">saved listings</h1>

   <div class="box-container">
      <?php

         $select_saved_property = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
         $select_saved_property->execute([$user_id]);
         if($select_saved_property->rowCount() > 0){
         while($fetch_saved = $select_saved_property->fetch(PDO::FETCH_ASSOC)){
         $select_listing = $conn->prepare("SELECT * FROM `property_1` WHERE id = ? ORDER BY date DESC");
         $select_listing->execute([$fetch_saved['property_id']]);
         if($select_listing->rowCount() > 0){
            while($fetch_listing = $select_listing->fetch(PDO::FETCH_ASSOC)){
               
            $select_user = $conn->prepare("SELECT * FROM `agents` WHERE id = ?");
            $select_user->execute([$fetch_listing['agent_id']]);
            $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

            if(!empty($fetch_listing['image_02'])){
               $image_coutn_02 = 1;
            }else{
               $image_coutn_02 = 0;
            }
            if(!empty($fetch_listing['image_03'])){
               $image_coutn_03 = 1;
            }else{
               $image_coutn_03 = 0;
            }
            if(!empty($fetch_listing['image_04'])){
               $image_coutn_04 = 1;
            }else{
               $image_coutn_04 = 0;
            }
            if(!empty($fetch_listing['image_05'])){
               $image_coutn_05 = 1;
            }else{
               $image_coutn_05 = 0;
            }

            $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);

            $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
            $select_saved->execute([$fetch_listing['id'], $user_id]);

      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="property_id" value="<?= $fetch_listing['id']; ?>">
            <?php
               if($select_saved->rowCount() > 0){
            ?>
            <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>remove from saved</span></button>
            <?php
               }else{ 
            ?>
            <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
            <?php
               }
            ?>
            <div class="thumb">
               <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
               <img src="uploaded_files/<?= $fetch_listing['image_01']; ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $fetch_listing['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price"><i class="fas fa-naira-sign"></i><span><?= $fetch_listing['price']; ?></span></div>
            <h3 class="name"><?= $fetch_listing['property_name']; ?></h3>
            <p class="address"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_listing['address']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-house"></i><span><?= $fetch_listing['type']; ?></span></p>
               <p><i class="fas fa-tag"></i><span><?= $fetch_listing['offer']; ?></span></p>
               <p><i class="fas fa-bed"></i><span><?= $fetch_listing['bhk']; ?> BHK</span></p>
               <p><i class="fas fa-trowel"></i><span><?= $fetch_listing['status']; ?></span></p>
               <p><i class="fas fa-couch"></i><span><?= $fetch_listing['furnished']; ?></span></p>
               <p><i class="fas fa-maximize"></i><span><?= $fetch_listing['carpet']; ?>sqft</span></p>
            </div>
            <div class="flex-btn">
               <a href="view_property.php?get_id=<?= $fetch_listing['id']; ?>" class="btn">view property</a>
               <input type="submit" value="send enquiry" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
                }
            }else{
                echo '<p class="empty">no properties added yet! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">add new</a></p>';
            }
            }   
        }else{
            echo '<p class="empty">no properties saved yet! <a href="listings.php" style="margin-top:1.5rem;" class="btn">discover more</a></p>';
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

<?php include 'components/message.php';  ?>

</body>
</html>