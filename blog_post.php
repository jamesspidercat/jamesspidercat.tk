<?php
//page_top.php var setup
$page_title = "Blog Post | Sam's Books";
$curPage  = "blog_post";
$require_login = 0;
$jsPaths = array('js/main.js');
require_once('page_top.php');


if (!isset($_GET['post'])){
    header("Location: blog.php");
	die();
}
$post_id = $_GET['post'];
$statement = $link->prepare("SELECT
users.user_id, users.name, users.username, `visibility`, `post_date`, `last_edit`, `title`
FROM
`blog_posts`
INNER JOIN `users` ON blog_posts.author = users.user_id
WHERE `post_id` = ?");
if( $statement) {
    $statement->bind_param('i', $post_id);
    $statement->execute();
    $statement->bind_result($author_id, $post_author, $post_username, $post_visibility, $post_date, $last_edit, $post_title);
    if($statement->fetch()) {
        $statement->close();
    }else{
        header("Location: blog.php");
        die();
    }
}else{
    die();
}
if ($post_visibility == 'author'){
    if (!($author_id == $id)){
        login(5,$permissions);
    }
}else{
    if ($post_visibility == 'none') $post_visibility = 0;
    else if ($post_visibility == 'user') $post_visibility = 1;
    else if ($post_visibility == 'vip') $post_visibility = 2;
    else if ($post_visibility == 'mod') $post_visibility = 3;
    else if ($post_visibility == 'admin') $post_visibility = 4;
    login($post_visibility,$permissions);
}
print "
<script>
    document.title = '".$post_title." | Sam\'s Books';
</script>";
//
//Create Post
//

$statement = $link->prepare("SELECT
    *
FROM
    `post_content`
WHERE
    `post_id` = ?
ORDER BY
    `post_order`");
if( $statement) {
    $statement->bind_param('i', $post_id);
    $statement->execute();
    print '1';
    $result = $statement->get_result();
    print '2';
}else{
    die();
}
while ($row = $result->fetch_assoc()) {
    break;
}
$statement->close();
//footer
include ("page_bottom.php");
?>