<?php
include ("connect.php");
$statement = $link->prepare("DELETE FROM `blog_posts` WHERE `post_id` = ?");
if( $statement) {
    $statement->bind_param("i",$_POST['post_id']);
    $statement->execute();
    $statement->close();
}else{
    echo "failed";
    die();
}
$statement = $link->prepare("DELETE FROM `post_content` WHERE `post_id` = ?");
if( $statement) {
    $statement->bind_param("i",$_POST['post_id']);
    $statement->execute();
    $statement->close();
}else{
    echo "failed";
    die();
}
echo "success";
?>