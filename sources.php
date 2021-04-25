<?php
//page_top.php var setup
$page_title = "Sources | Sam's Books";
$curPage  = "Sources";
$require_login = false;
$jsPaths = array('js/main.js');
require_once('page_top.php');
?>
        <div>
            <a class="source" href="http://clipart-library.com/clipart/887865.htm"><img src="imgs/book_stack.jpg" height="100" alt="Title Icon" />Title Icon</a>
            <br>
            <a class="source" href="https://commons.wikimedia.org/wiki/File:Font_Awesome_5_solid_arrow-circle-up.svg"><img src="imgs/Up_Arrow.svg.png" height="100" alt="Back to top button" />Back to top button</a>
            <br>
            <a class="source" href="https://www.filterforge.com/filters/8308.html"><img src="imgs/bookshelf.jpg" height="100" alt="Background Image" />Background Image</a>
            <br>
            <a class="source" href="https://flamingtext.com/"><img src="imgs/Sam's_Books_comic_sans_logo.png" height="100" alt="Logo" />Logo made using https://flamingtext.com/</a>
            <br>
            <a class="source" href="https://flamingtext.com/"><img src="imgs/sams_books_pride.png" height="100" alt="Pride Month Logo" />Logo made using https://flamingtext.com/</a>
            <br>
            <a class="source" href="https://jquery.org/license/"><img src="imgs/1280px-JQuery-Logo.svg.png" height="100" alt="JQuery Logo" />This site uses JQuery</a>
            <br>
            <a class="source" href="https://datatables.net/faqs/index#Licensing"><img src="imgs/datatables.png" height="100" alt=" DataTables Logo" />This site uses DataTables</a>
            <br>
            <label class="switch-light switch-candy">
                <input type="checkbox" id="format_andor" >
                <strong class="large-4 columns"></strong>
                <span class="large-4 columns float-left">
                    <span>This Site uses CSS Toggle Switch</span>
                    <span>by Ionuț Colceriu</span>
                    <a></a>
                </span>
            </label>
            <a class="source" href="https://ghinda.net/css-toggle-switch/">This Site uses CSS Toggle Switch by Ionuț Colceriu</a>
        </div>
<?php
include ("page_bottom.php");
?>