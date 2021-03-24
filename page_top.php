<?php
/*
//page_top.php var setup
$page_title = "thispage | Sam's Books";
$curPage  = "thispage";
$jsPaths = array('js/main.js');
require_once('page_top.php');
*/
?>

<!doctype html>
<html lang="en">
    <head id="head">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="css/normalize.css" rel="stylesheet" type="text/css">
        <link href="bootstrap/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="css/toggle-switch.css" rel="stylesheet" type="text/css">
        <link href="css/styles.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="imgs/book_stack.jpg">
        <title>
        <?php
            print($page_title);
        ?>
        </title>
        <script src="jquery/jquery-3.5.0.js"></script>
        <link rel="stylesheet" type="text/css" href="jquery/jquery.dataTables.css">
        <script src="jquery/jquery.dataTables.js"></script>
        <script src="bootstrap/bootstrap.bundle.js"></script>
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
            <a href="contact.php"<?php if ($curPage=="Contact") echo " class=\"samePage\"";?>>Contact</a>
        </nav>