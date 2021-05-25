<?php
//page_top.php var setup
$page_title = "Admin Area | Sam's Books";
$curPage  = "admin";
$require_login = '3';
$jsPaths = array('js/main.js');
require_once('page_top.php');
?>
<div class="row" data-masonry='{"percentPosition": true }'>
    <section class="col-12 col-sm-6"><!--Add book-->
        <div class="gr_custom_container_1588895837"><a href="add_book.php">Add book to table</a></div> 
    </section>
    <section class="col-12 col-sm-6"><!--Add book to wishlist-->
        <div class="gr_custom_container_1588895837"><a href="add_wishlist.php">Add book to wishlist</a></div> 
    </section>
    <section class="col-12 col-sm-6"><!--Users Page-->
        <div class="gr_custom_container_1588895837"><a href="users.php">Edit users</a></div> 
    </section>
    <section class="col-12 col-sm-6"><!--Create Blog Post-->
        <div class="gr_custom_container_1588895837"><a href="create_post.php">Create blog post</a></div> 
    </section>
</div>
<?php
include ("page_bottom.php");
?>