<?php
//page_top.php var setup
$page_title = "Add To Wishlist | Sam's Books";
$curPage  = "addwishlist";
$require_login = '3';
$jsPaths = array('js/main.js','js/no_resubmit.js');
require_once('page_top.php');
?>
<script>
function setThreeNumberDecimal(event) {
    number = document.getElementById("series_number").value;
    number = parseFloat(number).toFixed(3);
    document.getElementById("series_number").value = number;
}
</script>
<div class="row" style="margin-left: 10px; margin-right: 10px;">
    <form name="add_book" class="col-12" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <h3>Add book to wishlist</h3>
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
            <input id="series_number" type="number" class="form-control" placeholder="0.000" name="series_number" max='9999999.999' min='-9999999.999' step="0.001" onchange="
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
            <label for="want" class="form-label">Want (1-5)*</label>
            <input id="want" type="number" class="form-control" name="want" min="1" max="5" required>
        </div>
        <div class="form-group">
            <label for="have_read" class="form-label">Have Read Before*</label>
            <select class="form-select" id="have_read" name="have_read" required>
                <option value="" disabled>Choose...</option>
                <option value="1">True</option>
                <option value="0" selected>False</option>
			</select>
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
        `wishlist`(
            `book_name`,
            `author`,
            `series_number`,
            `series_name`,
            `book_type`,
            `want`,
            `have_read`,
            `notes`
        )
    VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
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
            $want = $post['want'];
            $have_read = $post['have_read'];
            $notes = $post['notes'];
    //
    if( $statement ) {
        $statement->bind_param("ssdssiis", $book_name,$author,$series_number,$series_name,
        $book_type,$want,$have_read,$notes);
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