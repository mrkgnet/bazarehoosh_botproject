<?php
////include "header-all-file-bot.php";
//
//
//$telegram = new telegram();
//
//$sql = "SELECT * FROM tbl_user WHERE user_id=" . $user_id;
//$stmt = $telegram->db->prepare($sql);
//$stmt->execute();
//$resUCheckData = $stmt->fetch(PDO::FETCH_ASSOC);
//$rowUser = $stmt->rowCount();
//$uid = $resUCheckData['user_id'];
//if ($rowUser == 0) {
//    $telegram = new telegram();
//    $sql_insert_data = "INSERT INTO tbl_user
//    (user_id, chat_id, first_name , last_name  ,username_telegram , time_stamp , time_persion,step_user )
//values
//       ('" . $user_id . "','" . $chat_id . "','" . $first_name . "','" . $last_name . "','" . $user_name . "','$time_stamp','$time_persion','StartBot')";
//    $stmt = $telegram->db->prepare($sql_insert_data);
//    $stmt->execute();
//
////    $txtStartBotUses = " کاربر " . $resUCheckData['first_name'] . " ربات را استارت کرد ";
////    $telegram->sendMessage(adminChatIDMain, $txtStartBotUses);
////    $telegram->sendMessage(adminChatID2, $txtStartBotUses);
//} else {
//
//    $sql = "UPDATE tbl_user SET time_stamp='$time_stamp',time_persion='$time_persion' WHERE user_id='$user_id'";
//    $stmt = $telegram->db->prepare($sql);
//    $stmt->execute();
//
//}
//?>
<!---->
<!---->
<!---->
