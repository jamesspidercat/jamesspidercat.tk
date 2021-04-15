<?php
//page_top.php var setup
$page_title = "Login | Sam's Books";
$curPage  = "login";
$jsPaths = array('js/main.js','js/no_resubmit.js');
require_once('page_top.php');
?>
<div class="row" style="margin-left: 10px; padding: 10px;">
    <!--move style in form to css only for md+ pages-->
    <form name="login" method="post" class="col-12 col-md-6" action="<?php echo $_SERVER['PHP_SELF'];?>" validate style="border-right: 1px solid white;">
        <h3>Login</h3>
        <div class="form-group">
            <label for="username" class="form-label">Username</label>
            <input name="username" class="form-control" type="text" minlength="3" maxlength="30" required>
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input name="password" class="form-control" type="password" minlength="3" maxlength="30" required>
        </div>
        <!--<div class="form-group">
            <label><input type="checkbox"> Remember me</label>
        </div>-->
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" value="Login">Login</button>
        </div>
        <p id="login_attempt"></p>
    </form>

    <form class="col-12 col-md-6" style="border-left: 1px solid white;">
        <h3>Sign Up</h3>
        <div class="form-group">
        <label for="name" class="form-label">Name</label> 
        <input type="text" class="form-control" name="name" maxlength="50" required minlength="2">
        </div>
        <div class="form-group">
        <label for="username" class="form-label">Username</label> 
        <input type="text" class="form-control" name="username" maxlength="30" required minlength="3">
        </div>
        <div class="form-group">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" maxlength="30" required minlength="3">
        <small class="form-text text-white">Make sure to remember this! There is currently no way to recover your password</small>
        </div>
        <br>

        <button type="submit" class="btn btn-primary" value="register">Register</button>
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $username = htmlspecialchars( $username );
    print   '<script>
            document.getElementById("login_attempt").innerHTML+="Attempting to login user <strong>'.$username.'</strong>...<br>";
            </script>';
    $statement = mysqli_prepare( $link, "SELECT * 
    FROM users
    WHERE username=?");
    if( $statement) {
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
                        document.getElementById("login_attempt").innerHTML+="Success! You are now logged in<br>";
                        location = "index.php";
                        </script>';        
            }
            else {//incorrect password
                print   '<script>
                        document.getElementById("login_attempt").innerHTML+="Incorrect password<br>";
                        </script>';        
            }

        }
        else {//invalid username
            print   '<script>
                    document.getElementById("login_attempt").innerHTML+="Invalid username<br>";
                    </script>';
        }
        mysqli_stmt_close( $statement );
    }else{
    print '<script>document.getElementById("login_attempt").innerHTML+="Attempting to login user <strong>'.$username.'</strong>...<br>"; </script>';

    }
}
include ("page_bottom.php");
?>