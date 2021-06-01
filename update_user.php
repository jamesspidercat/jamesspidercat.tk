<?php
require_once('connect.php');

$statement = $link->prepare("UPDATE
`users`
SET
`permissions` = ?
WHERE
`user_id` = ?");
//validate data first! make sure user has permissions to do this update!
if( $statement) {
    $statement->bind_param("si",$_POST['permission'],$_POST['user_id']);
    $statement->execute();
}else{
    echo $_POST['permission'];  
    die();
}
echo $_POST['permission'];
?>