<?php
    include("connect.php");
    $query = "SELECT * FROM `book_data` ORDER BY `book_name`";
    $results = mysqli_query( $link, $query );
?>
<!doctype html>
<html lang="en">
    <head id="head">
        <meta charset="utf-8">
        <link rel="icon" href="imgs/book_stack.jpg">
        <title>Table | Sam's Books</title>
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
        "columnDefs": [
            {"visible": false, "targets": [8,9,10]}
        ],
        destroy: true,
        "rowId": "id",
        "autoWidth": true,
        "initComplete": function( settings, json ) {//run once table loads
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
//filters rows based off of the options selected in the advanced search options
var format_search = '';
var book_type_search = '';
var owned_in_search = '';

function advanced_search_format(y){
    var yfinal = y;
    var table = $('#main').DataTable();
    var andor = document.getElementById('format_andor');
    if (y == 'refresh' && format_search != ''){
        if (andor.checked == true){//and
            while(format_search.includes("|")){
                format_search = format_search.replace("|",'""');
            }
            format_search = format_search.concat('"');
            format_search = '"' + format_search;
            table.column(5).search(format_search, false, true).draw();
        }else{//or
            while(format_search.includes('""')){
                format_search = format_search.replace('""','|');
            }
            format_search = format_search.replace('"','');
            format_search = format_search.replace('"','');
            table.column(5).search(format_search, true, false).draw();
        }
    }
    else if(y != 'refresh'){
        if (andor.checked == true){//and
            var checkBox = document.getElementById('format_'+y);
            yfinal = '"'+y+'"';
            if (checkBox.checked == true){
                format_search = format_search.concat(yfinal);
            }else{
                format_search = format_search.replace(yfinal,'');
            }
            table.column(5).search(format_search, false, true).draw();
        }else{//or
            var checkBox = document.getElementById('format_'+y);
            if (checkBox.checked == true){
                if (format_search != ''){
                    yfinal = '|'+y;
                }
                format_search = format_search.concat(yfinal);
            }else{
                if (format_search.startsWith(y) == true && format_search != y){
                    yfinal = y+'|';
                }else if(format_search != y){
                    yfinal = '|'+y;
                }
                format_search = format_search.replace(yfinal,'');
            }
            table.column(5).search(format_search, true, false).draw();
        }
    }
}
        
        
function advanced_search_book_type(y){
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
        
        
function advanced_search_owned_in(y){
    var yfinal = y;
    var table = $('#main').DataTable();
    var andor = document.getElementById('owned_in_andor');
    if (y == 'refresh' && owned_in_search != ''){
        if (andor.checked == true){//switch to and searching
            while(owned_in_search.includes("|")){
                owned_in_search = owned_in_search.replace("|",'""');// replace | with "" to change from 'or' search to 'and' search
            }
            owned_in_search = owned_in_search.concat('"');//add ending "
            owned_in_search = '"' + owned_in_search;//add starting "
            table.column(6).search(owned_in_search, false, true).draw();
        }else{//switch to or searching
            while(owned_in_search.includes('""')){
                owned_in_search = owned_in_search.replace('""','|');// replace "" with | to change from 'and' search to 'or' search
            }
            owned_in_search = owned_in_search.replace('"','');//remove starting "
            owned_in_search = owned_in_search.replace('"','');//remove ending "
            table.column(6).search(owned_in_search, true, false).draw();
        }
    }
    else if(y != 'refresh'){
        if (andor.checked == true){//and
            var checkBox = document.getElementById('owned_in_'+y);
            yfinal = '"'+y+'"';
            yfinal = yfinal.replace("_"," ")
            if (checkBox.checked == true){
                owned_in_search = owned_in_search.concat(yfinal);
            }else{
                owned_in_search = owned_in_search.replace(yfinal,'');
            }
            table.column(6).search(owned_in_search, false, true).draw();
        }else{//or
            var checkBox = document.getElementById('owned_in_'+y);
            yfinal = yfinal.replace("_"," ")
            if (checkBox.checked == true){
                if (owned_in_search != ''){
                    yfinal = '|'+yfinal;
                }
                owned_in_search = owned_in_search.concat(yfinal);
            }else{
                if (owned_in_search.startsWith(yfinal) == true && owned_in_search != yfinal){
                    yfinal = yfinal+'|';
                }else if(owned_in_search != yfinal){
                    yfinal = '|'+yfinal;
                }
                owned_in_search = owned_in_search.replace(yfinal,'');
            }
            table.column(6).search(owned_in_search, true, false).draw();
        }
    }
}
//Search
function search_table(){
    var search = document.getElementById("search_box").value;
    var table = $('#main').DataTable();
    table.column(8).search(search, false, true).draw();
    console.log(search);
}
// reset filters
function reset_filters(){
    var table = $('#main').DataTable();
    const cbs = document.querySelectorAll('input[type="checkbox"]');
    cbs.forEach((cb) => {
        cb.checked = false;
    });
    table.columns([0,1,2,3,4,5,6,7,8,9,10]).search("",false,true).draw();//remove search
    showRows();
    document.getElementById("search_box").value = '';//remove text from search box
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
                <a href="table.php" class="samePage">Table</a>
                <a href="wishlist.php">Wishlist</a>
                <a href="sources.php">Sources</a>
                <a href="contact.php">Contact</a>
            </nav>
            <div class="search_box">
            <input type="text" placeholder="Search books..." onkeyup="search_table()" id="search_box">
            </div>
            <div class="dropDown">
                <button type="button" class="dropDownButton" onclick="advancedSearchDropDown()">Advanced Options</button>
                <div id="dropDown" class="dropDownContent">
                    <table class="filterTable">
                        <thead>
                            <tr>
                                <th colspan="3">Filter Table</th>
                            </tr>
                            <tr>
                                <th>Book Type</th>
                                <th>Format</th>
                                <th>Owned in</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" onclick="advanced_search_book_type('prose')" id="book_type_prose">Prose</td>
                                <td><input type="checkbox" onclick="advanced_search_format('physical')" id="format_physical">Physical</td>
                                <td><input type="checkbox" onclick="advanced_search_owned_in('paperback')" id="owned_in_paperback">Paperback</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" onclick="advanced_search_book_type('comic')" id="book_type_comic">Comic</td>
                                <td><input type="checkbox" onclick="advanced_search_format('digital')" id="format_digital">Digital</td>
                                <td><input type="checkbox" onclick="advanced_search_owned_in('hardback')" id="owned_in_hardback">Hardback</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" onclick="advanced_search_book_type('audio_drama')" id="book_type_audio_drama">Audio Drama</td>
                                <td><input type="checkbox" onclick="advanced_search_format('audio')" id="format_audio">Audio</td>
                                <td><input type="checkbox" onclick="advanced_search_owned_in('floppy')" id="owned_in_floppy">Floppy</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" onclick="advanced_search_book_type('other')" id="book_type_other">Other</td>
                                <td></td>
                                <td><input type="checkbox" onclick="advanced_search_owned_in('box_set')" id="owned_in_box_set">Box Set</td>
                            </tr>
                            <tr>
                                <th colspan="2">Settings</th>
                                <td><input type="checkbox" onclick="advanced_search_owned_in('kindle')" id="owned_in_kindle">Kindle</td>
                            </tr>
                            <tr>
                                <td colspan="2" rowspan="3">
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
                                <td><input type="checkbox" onclick="advanced_search_owned_in('comixology')" id="owned_in_comixology">Comixology</td>
                            </tr>
                            <tr>

                                <td><input type="checkbox" onclick="advanced_search_owned_in('big_finish')" id="owned_in_big_finish">Big Finish</td>
                            </tr>
                            <tr>

                                <td><input type="checkbox" onclick="advanced_search_owned_in('humble_bundle')" id="owned_in_humble_bundle">Humble Bundle</td>
                            </tr>
                            <tr>
                                <td colspan="2" rowspan="3">
                                    <label class="switch-light switch-candy">
                                        <input type="checkbox" id="format_andor" onclick="advanced_search_format('refresh')">
                                        <strong class="large-4 columns">Format</strong>
                                        <span class="large-4 columns float-left">
                                            <span>Or</span>
                                            <span>And</span>
                                            <a></a>
                                        </span>
                                    </label>
                                </td>
                                <td><input type="checkbox" onclick="advanced_search_owned_in('fanatical')" id="owned_in_fanatical">Fanatical</td>
                            </tr>
                            <tr>

                                <td><input type="checkbox" onclick="advanced_search_owned_in('audible')" id="owned_in_audible">Audible</td>
                            </tr>
                            <tr>

                                <td><input type="checkbox" onclick="advanced_search_owned_in('unbound')" id="owned_in_unbound">Unbound</td>
                            </tr>
                            <tr>
                                <td colspan="2" rowspan="3">
                                    <label class="switch-light switch-candy">
                                        <input type="checkbox" id="owned_in_andor" onclick="advanced_search_owned_in('refresh')">
                                        <strong class="large-4 columns">Owned in</strong>
                                        <span class="large-4 columns float-left">
                                            <span>Or</span>
                                            <span>And</span>
                                            <a></a>
                                        </span>
                                    </label>
                                </td>
                                <td style="vertical-align: top;"><input type="checkbox" onclick="advanced_search_owned_in('other')" id="owned_in_other">Other</td>
                            </tr>
                            <tr><td></td></tr><tr><td></td></tr>
                            <tr>
                                <td colspan="2" id="reset_filters" onclick="reset_filters()">Reset Filters</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="loader"></div>
        </div>
        <table id="main">
            <thead>
                <tr><th>Title</th><th>Author</th><th>Series</th><th>Book Type</th><th>Collected In</th><th>Format</th><th>Owned In</th><th class="note">Notes</th><th class="hidden">Search</th><th class="hidden">id</th><th class="hidden">collectedid</th></tr>
            </thead>
            <tbody>
                <?php
                    while( $record = mysqli_fetch_array( $results ) ) {
                        $format = $record['format'];
                        $format = str_replace(',',', ',$format);
                        $format = str_replace('_',' ',$format);
                        $owned = $record['owned'];
                        $owned = str_replace(',',', ',$owned);
                        $owned = str_replace('_',' ',$owned);
                        //print book title and author
                        print '<tr><td>'.$record['book_name'].'</td><td>'.$record['author'].'</td>';
                        //print series name and number
                        if ($record['series_number'] != NULL){
                            print '<td>'.$record['series_name'].' #'.($record['series_number'] + 0).'</td>';
                        }else{
                            print '<td>'.$record['series_name'].'</td>';
                        }
                        //print book type
                        print'<td>'.$record['book_type'].'</td>';
                        $collected = $record['collected_in'];
                        $c_a = explode(', ',$collected);//split collected into individual ids
                        $output = NULL;
                        for ($i=0; $i <count($c_a); $i++)//find book name for each id
                        {
                            $wow =  mysqli_query($link, "SELECT * FROM `book_data` WHERE `id` = ".$c_a[$i]."");
                            if ($wow != NULL){
                                if ($output != NULL){
                                    $output .= ",<br>";
                                }
                                $output .= mysqli_fetch_array($wow)['book_name'];
                            }
                        } 
                        print '<td>'.$output.'</td><td>'.$format.'</td><td>'.$owned.'</td><td class="note">'.$record['notes'].'</td>';
                        //hidden cols to get data from
                        print'<td class="hidden">'.$record['book_name'].' '.$record['author'].$record['series_name'].' #'.($record['series_number'] + 0).' '.'</td><td class="hidden">'.$record['id'].'</td><td class="hidden">'.$record['collected_in'].'</td></tr>';
                    }
                ?>
            </tbody>
        </table>
        <footer>
            <a href="sources.php">© Sam</a>
        </footer>
    </body>
</html>