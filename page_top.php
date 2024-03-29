<?php
/*
//page_top.php var setup
$page_title = "thispage | Sam's Books";
$curPage  = "thispage";
$require_login = '0';
$jsPaths = array('js/main.js');
require_once('page_top.php');
*/

//comment out for live version
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


date_default_timezone_set("Pacific/Auckland");
require_once ('connect.php');

function db_bind_array($stmt, &$row)
{
  $md = $stmt->result_metadata();
  $params = array();
  while($field = $md->fetch_field()) {
      $params[] = &$row[$field->name];
  }
  return call_user_func_array(array($stmt, 'bind_result'), $params);
}
include('user_setup.php');
function login($require_login,$permissions){
    if ($require_login > $permissions){
        if ($permissions == 0){
            header("Location: login.php?redirect");
        }else{
            header("Location: index.php?redirect");
        }
        die();
    }
}
login($require_login,$permissions);
?>
<!doctype html>
<html lang="en">
    <head id="head">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="css/normalize.css" rel="stylesheet" type="text/css">
        <link href="bootstrap/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="css/toggle-switch.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="jquery/jquery.dataTables.css">
        <link href="css/styles.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="imgs/book_stack.jpg">
        <title>
        <?php
            print($page_title);
        ?>
        </title>
        <script src="jquery/jquery-3.5.0.js"></script>
        <script src="jquery/jquery.dataTables.js"></script>
        <script src="bootstrap/bootstrap.bundle.js"></script>
        <script src="bootstrap/masonry.pkgd.min.js"></script>
        <?php
            foreach($jsPaths as $i){
                print ("<script src=\"".$i."\"></script>");
            }
            unset($i)
        ?>
    </head>
    <body>
        <header id="header" class="col-12">
        </header>
        <button onclick="topFunction()" id="topButton" title="Go to top"><img src="imgs/Up_Arrow.svg.png" height="80" alt="Back to top"></button>
        <nav class="col-12">
            <a href="index.php"<?php if ($curPage=="Home") echo " class=\"samePage\"";?>>Home</a>
            <a href="table.php"<?php if ($curPage=="Table") echo " class=\"samePage\"";?>>Table</a>
            <a href="wishlist.php"<?php if ($curPage=="Wishlist") echo " class=\"samePage\"";?>>Wishlist</a>
            <a href="sources.php"<?php if ($curPage=="Sources") echo " class=\"samePage\"";?>>Sources</a>
            <a href="blog.php"<?php if ($curPage=="Blog") echo " class=\"samePage\"";?>>Blog</a>
            <a href="contact.php"<?php if ($curPage=="Contact") echo " class=\"samePage\"";?>>Contact</a>
			<?php
			if ($permissions == 0){//if not logged in add these to nav
				print '<a href="login.php"';
				if ($curPage=="login") echo " class=\"samePage\"";
				print '>Login</a>';
			}else{//if logged in add these to nav
				print '<a href="logout.php"';
				if ($curPage=="logout") echo " class=\"samePage\"";
				print '>Logout</a>';
			}
            if ($permissions >= 3){
                print '<a href="admin.php"';
				if ($curPage=="admin") echo " class=\"samePage\"";
				print '>Admin Area</a>';
            }
			?>
        </nav>