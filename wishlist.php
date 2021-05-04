<?php
//page_top.php var setup
$page_title = "Wishlist | Sam's Books";
$curPage  = "Wishlist";
$require_login = '0';
$jsPaths = array('js/main.js','js/wishlist.js');
require_once('page_top.php');

$query = "SELECT * FROM `wishlist` ORDER BY `book_name`";
$results = mysqli_query( $link, $query );
?>
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
<?php
include ("page_bottom.php");
?>