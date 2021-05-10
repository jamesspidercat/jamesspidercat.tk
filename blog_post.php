<?php
//page_top.php var setup
$page_title = "Blog Post | Sam's Books"; //update with post title later
$curPage  = "blog_post";
$require_login = 0; //get post visabillity later BEFORE loading post
$jsPaths = array('js/main.js');
require_once('page_top.php');
//
//Create Post
//
if (!isset($_GET['post'])){
    header("Location: blog.php");
	die();
}
$post_id = $_GET['post'];
print '<script>console.log("'.$post_id.'")</script>';
$statement = $link->prepare("SELECT
users.name, users.username, `visibility`, `post_date`, `last_edit`, `title`
FROM
`blog_posts`
INNER JOIN `users` ON blog_posts.author = users.user_id
WHERE `post_id` = ?");
if( $statement) {
    $statement->bind_param('i', $post_id );
    $statement->execute();
    $statement->bind_result($post_author, $post_username, $post_visibility, $post_date, $last_edit, $post_title);
    print '<script>console.log("'.$post_author.'")</script>';
    print $post_title;
}



//footer
include ("page_bottom.php");
?>