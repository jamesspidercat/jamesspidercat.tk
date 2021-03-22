<?php
    include("connect.php");
    $query = "SELECT * FROM `wishlist` ORDER BY `book_name`";
    $results = mysqli_query( $link, $query );
?>
<!doctype html>
<html lang="en">
    <head id="head">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="normalize.css" rel="stylesheet" type="text/css">
        <link href="bootstrap-5.0.0-beta2-dist/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="imgs/book_stack.jpg">
        <title>Wishlist | Sam's Books</title>
        <script src="jquery-3.5.0.js"></script>
        <link rel="stylesheet" type="text/css" href="jquery.dataTables.css">
        <script src="jquery.dataTables.js"></script>
        <link href="styles.css" rel="stylesheet" type="text/css">
        <link href="toggle-switch.css" rel="stylesheet">
        <script src="main.js"></script>
        <script>
$(document).ready( function () {//create datatables table
    $('#main').DataTable({
        "lengthChange": false,
        "pageLength": 25,
        language: {
            searchPlaceholder: "Search books",
            search: "",
        },
        "dom": 'lrtip',
        destroy: true,
        "rowId": "id",
        "initComplete": function( settings, json ) {
            document.getElementById("loader").style.display = "none";
            document.getElementById("sectionpaddingthing").style.paddingBottom = "0";
            document.getElementById("main").style.display = "inline";
            document.getElementById("main").classList.add("load");
        }
    });
} );
function showRows() {//Change between showing all rows vs only showing 25
    var table = $('#main').DataTable();
    var checkBox = document.getElementById("showAll");
    // If the checkbox is checked show all the rows
    if (checkBox.checked == true){
        table.page.len(-1).draw();
    } else {// Else only show 25 rows
        table.page.len(25).draw();
    }
}
//Go to top button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {//show back to top button after scroll down
    var topButton = document.getElementById("topButton");
    if (document.body.scrollTop > 120 || document.documentElement.scrollTop > 120) {
        topButton.style.display = "block";
    } else {
        topButton.style.display = "none";
    }
}
function topFunction() {//take you back to the top of the page when you click the back to top button
  window.scrollTo({top: 0, behavior: 'smooth'});
}
// When the user clicks on the button,
//toggle between hiding and showing the dropdown content
function advancedSearchDropDown() {
  document.getElementById("dropDown").classList.toggle("show");
}
//Advanced Search
//
function have_read(y){//filter rows whether or not I have read the book
    var table = $('#main').DataTable();
    if (y == 0){
       table.column(5).search("No", true, false).draw(); 
    }
    else if (y == 1){
        table.column(5).search("Yes", true, false).draw();
    }else{
        table.column(5).search("", true, false).draw();
    }
}
var book_type_search = '';
function advanced_search_book_type(y){//filter rows based on the book type
    var yfinal = y;
    var table = $('#main').DataTable();
    var checkBox = document.getElementById('book_type_'+y);
    yfinal = yfinal.replace("_"," ")
    if (checkBox.checked == true){
        if (book_type_search != ''){
            yfinal = '|'+yfinal;
            yfinal = yfinal.replace("_"," ")
        }
        book_type_search = book_type_search.concat(yfinal);
    }else{
        if (book_type_search.startsWith(yfinal) == true && book_type_search != yfinal){
            yfinal = yfinal+'|';
        }else if(book_type_search != yfinal){
            yfinal = '|'+yfinal;
        }
        book_type_search = book_type_search.replace(yfinal,'');
    }
    table.column(3).search(book_type_search, true, false).draw();
}
        
//Search
function search_table(){
    var search = document.getElementById("search_box").value;
    var table = $('#main').DataTable();
    table.search(search, false, true).draw();
    console.log(search);
}
// reset filters
function reset_filters(){
    var table = $('#main').DataTable();
    const cbs = document.querySelectorAll('input[type="checkbox"]');
    cbs.forEach((cb) => {
        cb.checked = false;
    });
    table.columns([0,1,2,3,4,5,6]).search("",false,true).draw();
    table.search("",false,true).draw();
    showRows();
    document.getElementById("search_box").value = '';
    have_read();
}
//
//
        </script>
    </head>
    <body>
        <header id="header">
        </header>
        <button onclick="topFunction()" id="topButton" title="Go to top"><img src="imgs/Up_Arrow.svg.png" height="80" alt="Back to top"></button>
        <div class="section" id="sectionpaddingthing">
            <nav>
                <a href="index.php">Home</a>
                <a href="table.php">Table</a>
                <a href="wishlist.php" class="samePage">Wishlist</a>
                <a href="sources.php">Sources</a>
                <a href="contact.php">Contact</a>
            </nav>
            <div class="search_box">
            <input type="text" placeholder="Search wishlist..." onkeyup="search_table()" id="search_box">
            </div>
            <div class="dropDown">
                <button type="button" class="dropDownButton" onclick="advancedSearchDropDown()">Advanced Options</button>
                <div id="dropDown" class="dropDownContent">
                    <table class="filterTable">
                        <thead>
                            <tr>
                                <th colspan="2">Filter Table</th>
                            </tr>
                            <tr>
                                <th>Book Type</th>
                                <th>Read</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" onclick="advanced_search_book_type('prose')" id="book_type_prose">Prose</td>
                                <td><input type="radio" onclick="have_read(1)" id="have_read_yes" name="have_read">Yes</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" onclick="advanced_search_book_type('comic')" id="book_type_comic">Comic</td>
                                <td><input type="radio" onclick="have_read(0)" id="have_read_no" name="have_read">No</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" onclick="advanced_search_book_type('audio_drama')" id="book_type_audio_drama">Audio Drama</td>
                                <td><input type="radio" onclick="have_read()" id="have_read_both" name="have_read" checked="checked">Both</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" onclick="advanced_search_book_type('other')" id="book_type_other">Other</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th colspan="2">Settings</th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <label class="switch-light switch-candy">
                                        <input type="checkbox" id="showAll" onclick="showRows()">
                                        <strong class="large-4 columns">Show All</strong>
                                        <span class="large-4 columns float-left">
                                            <span>Off</span>
                                            <span>On</span>
                                            <a></a>
                                        </span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" id="reset_filters" onclick="reset_filters()">Reset Filters</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="loader"></div>
        </div>
        <table id="main">
            <thead>
                <tr><th>Title</th><th>Author</th><th>Series</th><th>Book Type</th><th>Priority</th><th>Have Read</th><th>Notes</th></tr>
            </thead>
            <tbody>
                <?php
                    while( $record = mysqli_fetch_array( $results ) ) {
                        //print book title and author
                        print '<tr><td>'.$record['book_name'].'</td><td>'.$record['author'].'</td>';
                        //print series info
                        if ($record['series_number'] != NULL){
                            print '<td>'.$record['series_name'].' #'.($record['series_number'] + 0).'</td>';
                        }
                        else{
                            print '<td>'.$record['series_name'].'</td>';
                        }
                        //print book type
                        print'<td>'.$record['book_type'].'</td> <td>';
                        //print rating stars
                        for ($x = 0; $x < $record['want']; $x++) {
                            print'★';
                        }
                        for ($x = 0; $x < (5-$record['want']); $x++) {
                            print'☆';
                        }
                        //print have read yes/no
                        print'</td><td>';
                        if ($record['have_read'] == 0){
                            print'No';
                        }
                        else{
                            print'Yes';
                        }
                        //print notes
                        print'</td><td>'.$record['notes'].'</td>';
                    }
                ?>
            </tbody>
        </table>
        <footer>
            <a href="sources.php">© Sam</a>
        </footer>
    </body>
</html>