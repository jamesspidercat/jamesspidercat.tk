<?php
//page_top.php var setup
$page_title = "thispage | Sam's Books";
$curPage  = "thispage";
$require_login = '0';
$jsPaths = array('js/main.js');
require_once('page_top.php');
?>
<html lang="en" >
    <button onclick="new_box()">new box</button>
<section class="container" id="list-holder">
  
  <div class="list-item">
    <div class="item-content">
      <span class="order">1</span> Alpha
    </div>
  </div>
  
  <div class="list-item">
    <div class="item-content">
      <span class="order">2</span> Bravo
    </div>
  </div>
  
  <div class="list-item">
    <div class="item-content">
      <span class="order">3</span> Charlie
    </div>
  </div>
  
  <div class="list-item">
    <div class="item-content">
      <span class="order">4</span> Delta
    </div>
  </div>
  
</section>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/TweenMax.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/utils/Draggable.min.js'></script>
<script  src="js/create_post.js"></script>
<?php
include ("page_bottom.php");
?>