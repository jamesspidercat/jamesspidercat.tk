<?php
include('connect.php');

$statement = $link->prepare("UPDATE
`users`
SET
`permissions` = ?
WHERE
`user_id` = ?");
//validate data first! make sure user has permissions to do this update!
//Need to make it confirm login details on every page load
if( $statement) {
    $statement->bind_param("si",$_POST['permission'],$_POST['user_id']);
    $statement->execute();
}else{
    echo 'failed'; 
    die();
}
echo 'success';
?>