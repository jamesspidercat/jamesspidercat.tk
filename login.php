<?php
//page_top.php var setup
$page_title = "Login | Sam's Books";
$curPage  = "login";
$jsPaths = array('js/main.js','js/no_resubmit.js');
require_once('page_top.php');
?>
<div class="row" style="margin-left: 10px;">
    <form name="login" method="post" class="col-6" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div class="form-group">
            <label for="username" class="form-label">Username</label>
            <input name="username" class="form-control" type="text">
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input name="password" class="form-control" type="password">
        </div>
        <div class="form-group">
            <label><input type="checkbox"> Remember me</label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" value="Login">Submit</button>
        </div>
    </form>
    <form class="col-6">

    </form>
</div>
<?php
include ("page_bottom.php");
?>