<?php
//page_top.php var setup
$page_title = "Logout | Sam's Books";
$curPage  = "logout";
$require_login = '1';
$jsPaths = array('js/main.js','js/no_resubmit.js');
require_once('page_top.php');
?>
<form name="logout" method="post" class="col-12 m-5" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <h3>Are you sure you want to logout?</h3>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary" value="logout">Logout</button>
        </div>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    unset( $_SESSION["uid"] );
    unset( $_SESSION["uname"] );
    unset( $_SESSION["uperms"] );
    print '
<script>
    alert( "Successfuly Logged out!" );
    location = "index.php";
</script>';
}
include ("page_bottom.php");
?>