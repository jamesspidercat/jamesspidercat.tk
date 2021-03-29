<?php
$myfile = fopen("last_opened.txt", "r") or die("Unable to open file");
$last_opened = fread($myfile,filesize("last_opened.txt"));
date_default_timezone_set("Pacific/Auckland");
$date = date("m.d");
if ($date != $last_opened){
    fclose($myfile);
    $myfile = fopen("last_opened.txt", "w") or die("Unable to open file");
    fwrite($myfile, $date);
    fclose($myfile);
    $myfile = fopen("book_of_the_day.txt", "w") or die("Unable to open file");
    include("connect.php");
    $count = mysqli_num_rows(mysqli_query($link, 'SELECT * FROM book_of_the_day'));
    while(true){
        $rand = mt_rand(1,intval($count));
        $query = "SELECT * FROM `book_of_the_day` WHERE `id` = '$rand'";
        $result = mysqli_query( $link, $query );
        if(mysqli_num_rows($result) == 1){
            break;
        }
    }
    $record = mysqli_fetch_array($result);
    $txt = '<div class="col-12 col-sm-6"><!--Book of the day -->
                    <div class="gr_custom_container_1588895837">
                        <h2 class="gr_custom_header_1588895837">Book of the Day</h2>
    <div class="gr_custom_each_container_1588895837">
              <div class="gr_custom_book_container_1588895837">
                <a title="'.$record['title'].'" rel="nofollow" href="'.$record['title_link'].'"><img alt="'.$record['title'].'" src="'.$record['cover_link'].'"></a>
              </div>
              <div class="gr_custom_title_1588895837">
                <a rel="nofollow" href="'.$record['title_link'].'">'.$record['title'].'</a>
              </div>
              <div class="gr_custom_author_1588895837">
                by <a rel="nofollow" href="'.$record['author_link'].'">'.$record['author'].'</a>
              </div>
              <div>
                  <p>'.$record['description'].'</p>
              </div>
          </div>
                    </div>
                </div>';
    fwrite($myfile, $txt);
}
fclose($myfile);
?>