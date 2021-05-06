<?php
//page_top.php var setup
$page_title = "Logout | Sam's Books";
$curPage  = "logout";
$require_login = '1';
$jsPaths = array('js/main.js','js/no_resubmit.js');
require_once('page_top.php');
?>
<div class="container">
<form name="logout" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <h3>Are you sure you want to logout?</h3>
            <div class="row">
                <button type="submit" name="yes" class="btn btn-success col-1 m-1" value="yes">Yes Please</button>
                <button type="submit" name="maybe" class="btn btn-warning col-1 m-1" value="unsure">I'm Not Sure</button>
                <button type="submit" name="no" class="btn btn-danger col-1 m-1" value="no">No Thanks!</button>
            </div>
    </form>
    
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $random = false;
    if (isset($_POST['maybe'])) {
        if (rand(0, 1)) {
            $random = true;
            $alert_text = "The Gods Have Decided: You have been logged out!";
        }else{
            $alert_text = 'The Gods Have Decided: You will remain logged in!';
        }
    }
    if (isset($_POST['yes']) || $random == true) {
        # Save-button was clicked
        unset( $_SESSION["uid"] );
        unset( $_SESSION["uname"] );
        unset( $_SESSION["uperms"] );
        if (isset($_POST['yes'])) {
            $alert_text = 'Successfuly Logged out!';
        }
    
    }
    elseif (isset($_POST['no'])) {
        $alert_text = 'Okay...';
    }
    print '
    <script>
        alert( "'.$alert_text.'" );
        location = "index.php";
    </script>';


}
include ("page_bottom.php");
?>