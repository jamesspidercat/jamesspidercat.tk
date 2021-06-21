<?php
include('connect.php');
include('user_setup.php');

$to_delete = json_decode(stripslashes($_POST['to_delete']));

foreach($to_delete as $d){
    //delete all where post_content id = $d
    //delete file from folder when element deleted
}
?>