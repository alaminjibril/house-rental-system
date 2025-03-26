<?php


if (isset($_POST['save'])) {
    session_start(); // Ensure session is started to access user_id

    if ($user_id !== '') {
        $save_id = create_unique_id();
        $listing_id = filter_var($_POST['property_id'], FILTER_SANITIZE_STRING);

        $verify_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? AND user_id = ?");
        $verify_saved->execute([$listing_id, $user_id]);

        if ($verify_saved->rowCount() > 0) {
            // Remove from saved
            $remove_saved = $conn->prepare("DELETE FROM `saved` WHERE property_id = ? AND user_id = ?");
            $remove_saved->execute([$listing_id, $user_id]);
            $success_msg[] = 'Removed from saved';
        } else {
            // Add to saved
            $add_saved = $conn->prepare("INSERT INTO `saved`(id, property_id, user_id) VALUES(?, ?, ?)");
            $add_saved->execute([$save_id, $listing_id, $user_id]);
            $success_msg[] = 'Added to saved';
        }

    } else {
        $warning_msg[] = 'Please log in first!';
    }

    // Redirect to the same page to prevent resubmission
    // header("Location: " . $_SERVER['PHP_SELF']);
    // exit();
}

if (isset($_POST['send'])) {

    if ($user_id !== '') {
        $request_id = create_unique_id();
        $listing_id = filter_var($_POST['property_id'], FILTER_SANITIZE_STRING);

        $select_receiver = $conn->prepare("SELECT agent_id FROM `property_1` WHERE id = ? LIMIT 1");
        $select_receiver->execute([$listing_id]);
        $fetch_receiver = $select_receiver->fetch(PDO::FETCH_ASSOC);
        $receiver = $fetch_receiver['agent_id'];

        $verify_request = $conn->prepare("SELECT * FROM `requests` WHERE property_id = ? AND sender = ? AND receiver = ?");
        $verify_request->execute([$listing_id, $user_id, $receiver]);

        if(($verify_request->rowCount() > 0)){
            $warning_msg[] = 'request sent already!';
         }else{
            $add_request = $conn->prepare("INSERT INTO `requests`(id, property_id, sender, receiver) VALUES(?,?,?,?)");
            $add_request->execute([$request_id, $listing_id, $user_id, $receiver]);
            $success_msg[] = 'request sent successfully!';
         }


    

    } else {
        $warning_msg[] = 'Please log in first!';
    }

    // Redirect to the same page to prevent resubmission
    // header("Location: " . $_SERVER['PHP_SELF']);
    // exit();
}



?>