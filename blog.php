<?php
//page_top.php var setup
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$page_title = "Blog | Sam's Books";
$curPage  = "blog";
$require_login = '0';
$jsPaths = array('js/main.js');
require_once('page_top.php');
?>
<div class="containter">
    <a href="index.php" class="blog_link">
        <div class="row m-5 post-border">
            <div class="col-8 text-white">
                <h1>Deserunt.</h1>
                <p> Published Thursday May 20 2021 12:07:02pm By Sam Bruce </p>
                <hr>
                <p>Velit incididunt reprehenderit ad sint ullamco proident culpa. Cupidatat sint id ea reprehenderit. Deserunt adipisicing dolore proident exercitation in consectetur sit aliqua deserunt veniam proident proident nulla incididunt. Duis ad sint excepteur nostrud occaecat labore eiusmod ullamco quis ullamco est irure nisi nisi. Mollit in sit ex proident enim. Nisi qui voluptate fugiat ipsum magna exercitation in laborum consequat. Fugiat id anim mollit enim quis.</p>
            </div>
            <div class="col-4 p-0">
                <img src="blog/2/moral support.gif" class="img-fluid">
            </div>
        </div>
    </a>
<?php
function db_bind_array($stmt, &$row)
{
  $md = $stmt->result_metadata();
  $params = array();
  while($field = $md->fetch_field()) {
      $params[] = &$row[$field->name];
  }
  return call_user_func_array(array($stmt, 'bind_result'), $params);
}
$statement = $link->prepare("SELECT
users.user_id, users.name, users.username, `post_id`,  `visibility`, `unlisted`, `post_date`, `title`
FROM
`blog_posts`
INNER JOIN `users` ON blog_posts.author = users.user_id
WHERE
    1");
$statement2 = $link->prepare("SELECT
`text`
FROM
`post_content`
WHERE
`post_id` = 1 AND `type` LIKE 'text'
ORDER BY
`post_order`
LIMIT 1");
if( $statement) {
    $statement->execute();
}else{
    die();
}
db_bind_array($statement, $result);
while ($statement->fetch()) {
    if ($result['visibility'] == 'author'){
        if (!($result['user_id'] == $id)){
            continue;
        }
    }else{
        $post_visibility = 0;
        if ($result['visibility'] == 'none') $post_visibility = 0;
        else if ($result['visibility'] == 'user') $post_visibility = 1;
        else if ($result['visibility'] == 'vip') $post_visibility = 2;
        else if ($result['visibility'] == 'mod') $post_visibility = 3;
        else if ($result['visibility'] == 'admin') $post_visibility = 4;
        if ($post_visibility > $permissions){
            continue;
        }
    }
    $post_date = date_create($result['post_date']);
    if( $statement2) {
        //$statement2->bind_param('i', $result['post_id']);
        $statement2->execute();
    }else{
        print '111111111111111';
        die();
    }
    db_bind_array($statement2, $result2);

    print '<a href="blog_post.php?post='.$result['post_id'].'" class="blog_link">
    <div class="row m-5 post-border">
        <div class="col-8 text-white">
            <h1>'.$result['title'].'</h1>
            Published '.date_format($post_date,"l F d Y H:i:sa").'
            <span title="'.$result['username'].'">By '.$result['name'].'</span>
            <hr>
            <p>Velit incididunt reprehenderit ad sint ullamco proident culpa. Cupidatat sint id ea reprehenderit. Deserunt adipisicing dolore proident exercitation in consectetur sit aliqua deserunt veniam proident proident nulla incididunt. Duis ad sint excepteur nostrud occaecat labore eiusmod ullamco quis ullamco est irure nisi nisi. Mollit in sit ex proident enim. Nisi qui voluptate fugiat ipsum magna exercitation in laborum consequat. Fugiat id anim mollit enim quis.</p>
        </div>
        <div class="col-4 p-0">
            <img src="blog/2/moral support.gif" class="img-fluid">
        </div>
    </div>
</a>';
}
?>
</div>
<?php
include ("page_bottom.php");
?>