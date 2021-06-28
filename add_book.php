<?php
//page_top.php var setup
$page_title = "Add Book | Sam's Books";
$curPage  = "addbook";
$require_login = '3';
$jsPaths = array('js/main.js','js/no_resubmit.js');
require_once('page_top.php');
?>
<script>
$(function(){
    var requiredCheckboxes = $('.formats :checkbox[required]');
    requiredCheckboxes.change(function(){
        if(requiredCheckboxes.is(':checked')) {
            requiredCheckboxes.removeAttr('required');
        } else {
            requiredCheckboxes.attr('required', 'required');
        }
    });
});
$(function(){
    var requiredCheckboxes = $('.ownedin :checkbox[required]');
    requiredCheckboxes.change(function(){
        if(requiredCheckboxes.is(':checked')) {
            requiredCheckboxes.removeAttr('required');
        } else {
            requiredCheckboxes.attr('required', 'required');
        }
    });
});
function setThreeNumberDecimal(event) {
    number = document.getElementById("series_number").value;
    number = parseFloat(number).toFixed(3);
    document.getElementById("series_number").value = number;
}
</script>
<div class="row" style="margin-left: 10px; margin-right: 10px;">
    <form name="add_book" class="col-12" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" validate>
        <h3>Add book</h3>
        <div class="form-group">
            <label for="book_name" class="form-label">Title*</label> 
            <input id="book_name" type="text" class="form-control" name="book_name" maxlength="255" required>
        </div>
        <div class="form-group">
            <label for="author" class="form-label">Author*</label> 
            <input id="author" type="text" class="form-control" name="author" maxlength="255" required>
        </div>
        <div class="form-group">
            <label for="series_number" class="form-label">Series Number</label>
            <input id="series_number" type="number" class="form-control" placeholder="0.000" name="series_number" max='9999999.999' min='-9999999.999' step="0.001"onchange="
            setThreeNumberDecimal()">
        </div>
        <div class="form-group">
            <label for="series_name" class="form-label">Series Name</label>
            <input id="series_name" type="text" class="form-control" name="series_name" maxlength="255">
        </div>
        <div class="form-group">
            <label for="book_type" class="form-label">Book Type*</label>
            <select class="form-select" id="book_type" name="book_type" required>
                <option selected disabled value="">Choose...</option>
                <option value="Prose">Prose</option>
                <option value="Comic">Comic</option>
                <option value="Audio Drama">Audio Drama</option>
                <option value="Other">Other</option>
			</select>
        </div>
        <div class="form-group">
            <label for="collected_in" class="form-label">Collected In</label>
            <input id="collected_in" type="text" class="form-control" name="collected_in" maxlength="255">
            <small class="form-text text-white">Enter id's of books this book is collected in, in a comma seperated list (i.e. 123,456,789)</small>
        </div>
        <div class="form-group formats">
            <label class="form-label">Format Owned In*</label>
            <br>
            <input type="checkbox" id="physical" name="physical" value="physical" required>
            <label for="physical" class="form-label">Physical</label>
            <input type="checkbox" id="digital" name="digital" value="digital" required>
            <label for="digital" class="form-label">Digital</label>
            <input type="checkbox" id="audio" name="audio" value="audio" required>
            <label for="audio" class="form-label">Audio</label>
        </div>
        <div class="form-group ownedin">
            <label class="form-label">Location Owned*</label>
            <br>
            <?php
            $ownedlist = ['Paperback','Hardback','Floppy','Box_Set','Kindle','Comixology','Big_Finish','Humble_Bundle','Fanatical','Audible','Unbound','Other'];
            foreach($ownedlist as $i){
                print '<input type="checkbox" id="'.$i.'" name="'.$i.'" value="'.$i.'"required>
                <label for="'.$i.'" class="form-label" styles>'.str_replace('_',' ',$i).' </label>';
            }
            unset($i);
            ?>
        </div>
        <div class="form-group">
            <label for="notes" class="form-label">Notes</label>
            <input id="notes" type="text" class="form-control" name="notes" maxlength="65000">
        </div>
        <br>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary" value="submit">Add</button>
        </div>
        <p id="post_attempt"></p>
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $statement = $link->prepare("INSERT
    INTO
        `book_data`(
            `book_name`,
            `author`,
            `series_number`,
            `series_name`,
            `book_type`,
            `collected_in`,
            `format`,
            `owned`,
            `notes`
        )
    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    //prepare posted data
    function drop_empty($var){
        return ($var === '') ? NULL : $var;
    }
    $post = array_map('drop_empty', $_POST);
            $book_name = $post['book_name'];
            $author = $post['author'];
            $series_number = $post['series_number'];
            $series_name = $post['series_name'];
            $book_type = $post['book_type'];
            $collected_in = $post['collected_in'];
            $format = '';
            $formatlist = ['physical','digital','audio'];
            foreach ($formatlist as $i){
                if (isset($post[$i])){
                    if ($format == ''){
                        $format = $i;
                    }else{
                        $format .= ',';
                        $format .= $i;
                    }
                }
            }
            unset($i);
            $owned = '';
            foreach ($ownedlist as $i){
                if (isset($post[$i])){
                    if ($owned == ''){
                        $owned = $i;
                    }else{
                        $owned .= ',';
                        $owned .= $i;
                    }
                }
            }
            unset($i);
            $notes = $post['notes'];
    //
    if( $statement ) {
        $statement->bind_param("ssdssssss", $book_name,$author,$series_number,$series_name,
        $book_type,$collected_in,$format,$owned,$notes);
        $statement->execute();
        $statement->close();
        print   '<script>
        document.getElementById("post_attempt").innerHTML+="Book successfully added!<br>";
        </script>';
    }else{
        print   '<script>
    document.getElementById("post_attempt").innerHTML+="An unknown error has occurred, please try again<br>";
    </script>';
    }
}

include ("page_bottom.php");
?>