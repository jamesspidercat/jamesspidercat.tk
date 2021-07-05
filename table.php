<?php
//page_top.php var setup
$page_title = "Table | Sam's Books";
$curPage  = "Table";
$require_login = '0';
$jsPaths = array('js/main.js','js/table.js');
require_once('page_top.php');

$query = "SELECT * FROM `book_data` ORDER BY `book_name`";
$results = mysqli_query( $link, $query );
?>
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
<?php
include ("page_bottom.php");
?>