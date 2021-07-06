<?php
//page_top.php var setup
$page_title = "Blog | Sam's Books";
$curPage  = "Blog";
$require_login = '0';
$jsPaths = array('js/main.js');
require_once('page_top.php');
?>

<div class="containter">
<?php
$statement = $link->prepare("SELECT
*,
(
SELECT
    post_content.file
FROM
    post_content
WHERE
    post_content.post_id = blog_posts.post_id AND post_content.type = 'image'
ORDER BY
    post_content.post_order ASC
LIMIT 1
) AS image,(
SELECT
    post_content.text
FROM
    post_content
WHERE
    post_content.post_id = blog_posts.post_id AND post_content.type = 'text'
ORDER BY
    post_content.post_order ASC
LIMIT 1
) AS text
FROM
    blog_posts
INNER JOIN `users` ON blog_posts.author = users.user_id
WHERE
    blog_posts.unlisted = 0
ORDER BY
    blog_posts.`post_date`
DESC
");

if( $statement) {
    $statement->execute();
}else{
    die();
}
db_bind_array($statement, $result);
while ($statement->fetch()) {
    if ($result['visibility'] == 5){
        if (!($result['user_id'] == $id)){
            continue;
        }
    }else{
        if ($result['visibility'] > $permissions){
            continue;
        }
    }
    $post_date = date_create($result['post_date']);

    print '<a href="blog_post.php?post='.$result['post_id'].'" class="blog_link">
    <div class="row m-5 post-border">
        <aside class="col-4 p-0 order-last text-end">
            <img src="blog/'.$result['post_id'].'/'.$result['image'].'" class="img-fluid" alt="'.$result['image'].'">
        </aside>
        <div class="col-8 text-white order-first">
            <h1>'.$result['title'].'</h1>
            Published '.date_format($post_date,"l F d Y h:i:sa").'
            <span title="'.$result['username'].'">By '.$result['name'].'</span>
            <hr>
            <p class="truncate" style="max-height: 100px;">'.strip_tags($result['text']).'</p>
        </div>
    </div>
</a>';
}
?>
</div>
<?php
include ("page_bottom.php");
?>