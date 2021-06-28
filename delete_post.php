<?php
include ("connect.php");
$statement = $link->prepare("DELETE FROM `blog_posts` WHERE `post_id` = ?");//delete post
if( $statement) {
    $statement->bind_param("i",$_POST['post_id']);
    $statement->execute();
    $statement->close();
}else{
    echo "failed";
    die();
}
$statement = $link->prepare("DELETE FROM `post_content` WHERE `post_id` = ?");//delete post contents
if( $statement) {
    $statement->bind_param("i",$_POST['post_id']);
    $statement->execute();
    $statement->close();
}else{
    echo "failed";
    die();
}
//delete files from post
$dirname = 'blog/'.$_POST['post_id'];
array_map('unlink', glob("$dirname/*.*"));
rmdir($dirname);
echo "success";
?>