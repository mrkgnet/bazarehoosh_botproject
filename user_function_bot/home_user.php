<?php
    include ("../config.php");
    include ("../telegram.php");
    include ("../index.php");
    $telegram = new telegram();
    $telegram->sendMessage(user_id , 'eiiew')


?>
