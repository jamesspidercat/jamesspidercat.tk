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
}else{
    die();
}
db_bind_array($statement, $result);
$row_col = 0;
$post_date = date_create($post_date);
$last_edit = date_create($last_edit);
print '

<div class="container" style="color: white;">
    <div class="row">
    <h1>
       '.$post_title.' 
    </h1>
    <p>
        <span title="Last Edited: '.date_format($last_edit,"l F d Y H:i:s a").'">Published '.date_format($post_date,"l F d Y H:i:s a").'</span>
        <span title="'.$post_username.'">By '.$post_author.'</span>
    </p>
    </div>
<div class="row">';//open first row
while ($statement->fetch()) {//THIS IS WHERE COOL STUFF GETS PRINTED!!!
    $row_col += $result['width'];
    if ($row_col > 3){
        $row_col = $result['width'];
        print '</div><div class="row">';//close row, open next row
    }
    print '<div class="col-12 col-md-'.($result['width']*4).' text-'.$result['align'].'">';//open col
    switch ($result['type']){
        case "text":
            print $result['text'];
            break;
        case "image":
            print '<figure class="figure">
            <img class="figure-img img-fluid" src="blog/'.$post_id.'/'.$result['file'].'" width="'.$result['file_width'].'%">
            <figcaption class="figure-caption text-white">'.$result['text'].'</figcaption>
        </figure>';
            break;
        case "video":
            print '<figure class="figure">
                <video class="figure-img  img-fluid" src="blog/'.$post_id.'/'.$result['file'].'" width="'.$result['file_width'].'%" controls></video>
                <figcaption class="figure-caption text-white">'.$result['text'].'</figcaption>
            </figure>';
            break;
        case "audio":
            print '<figure class="figure">
            <audio class="figure-img" src="blog/'.$post_id.'/'.$result['file'].'" controls></audio>
            <figcaption class="figure-caption text-white">'.$result['text'].'</figcaption>
        </figure>';
            break;
        default:
            print '&nbsp;';
            break;

    }
    print '</div>';//close col
}
print '</div></div>';//close final row, close container
$statement->close();
//footer
include ("page_bottom.php");
?>