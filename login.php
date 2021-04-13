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
            <!--<label><input type="checkbox"> Remember me</label>-->
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" value="Login">Submit</button>
        </div>
    </form>
    <form class="col-6">

    </form>
</div>
<?php
$username = $_POST['username'];
$password = $_POST['password'];
print '<p>Attempting to login user '.$username.'...';

$statement = mysqli_prepare( $link, "SELECT user_id, name, pass_hash, pass_salt 
                                     FROM users 
                                     WHERE username=?");

if( $statement ) {
    mysqli_stmt_bind_param( $statement, 's', $username );
    mysqli_stmt_execute( $statement );
    mysqli_stmt_bind_result( $statement, $id ,$name, $hash, $salt );
    if( mysqli_stmt_fetch( $statement ) ) {//check if account exists
        if( hash( 'sha256', $password.$salt ) == $hash) {//password correct?
            $_SESSION["uid"] = $id;
            $_SESSION["uname"] = $name;
            echo $_SESSION['uname'];


            print '<script>
                    alert( "Successful login!" );
                    location = "index.php";
                </script>';        
        }
        else {//incorrect password
            print '<script>
                    alert( "Incorrect password!" );
                    location = "login.php";
                </script>';        
        }

    }
    else {//invalid username
        print '<script>
                    alert( "Username not found!" );
                    location = "login.php";
                </script>';
    }
    mysqli_stmt_close( $statement );
}

?>
include ("page_bottom.php");
?>