<?php
include('connect.php');
include('user_setup.php');
$statement = $link->prepare("UPDATE
`users`
SET
`permissions` = ?
WHERE
`user_id` = ?");
//validate data first, make sure user has permissions to do this update!
if ($permissions < 4){
    if ($permissions < 3 || $_POST['permission'] == 'mod' || $_POST['permission'] == 'admin'){
    echo 'failed';
    die();
    }
}
if( $statement) {
    $statement->bind_param("si",$_POST['permission'],$_POST['user_id']);
    $statement->execute();
}else{
    echo 'failed'; 
    die();
}
echo 'success';
?>