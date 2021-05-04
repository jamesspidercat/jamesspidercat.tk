<?php
//page_top.php var setup
$page_title = "Login | Sam's Books";
$curPage  = "login";
$require_login = '0';
$jsPaths = array('js/main.js','js/no_resubmit.js');
require_once('page_top.php');

if (isset($_GET['redirect'])){
	print '<script>alert( "Please login to access that page" );</script>';
}
?>
<div class="row" style="margin-left: 10px; padding: 10px;">
    <form name="login" method="post" class="col-12 col-md-6" action="<?php echo $_SERVER['PHP_SELF'];?>" validate>
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
            <button type="submit" name="submit" class="btn btn-primary" value="login">Login</button>
        </div>
        <p id="login_attempt"></p>
    </form>

    <form name="register" class="col-12 col-md-6 seperator" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" validate>
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
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary" value="register">Register</button>
        </div>
        <p id="signup_attempt"></p>
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    unset( $_SESSION["uid"] );
    unset( $_SESSION["uname"] );
    unset( $_SESSION["uperms"] );
    if ($_POST['submit'] == 'register'){//if user is registering
        $username = $_POST['username'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $name = strip_tags( $name );
        $username = strip_tags( $username);
        print   '<script>
                document.getElementById("signup_attempt").innerHTML+="Creating Account...<br>";
                </script>';
                $statement = $link->prepare("SELECT user_id
                FROM users
                WHERE username LIKE ?");
        if( $statement) {//check if username in use already
            $statement->bind_param('s', $username );
            $statement->execute();
            $statement->bind_result($id ,$name, $hash, $salt);
            if( $statement->fetch()) {
                print   '<script>
                document.getElementById("signup_attempt").innerHTML+="That username is already in use, please choose a unique username<br>";
                </script>';
                $statement->close();
            }else{
                $statement->close();
                $salt = md5( microtime(true)*100000 );
                $hash = hash( 'sha256', $password.$salt );
                $statement = $link->prepare("INSERT INTO users 
                                                    (name, username, pass_hash, pass_salt) 
                                                    VALUES (?, ?, ?, ?)" );
                if( $statement ) {
                    $statement->bind_param("ssss", $name, 
                                                                $username, 
                                                                $hash, 
                                                                $salt );
                    $statement->execute();
                    $statement->close();
                    print   '<script>
                    document.getElementById("signup_attempt").innerHTML+="Account successfully created! Please login<br>";
                    </script>';
                }else{
                    print   '<script>
                document.getElementById("signup_attempt").innerHTML+="An unknown error has occurred, please try again<br>";
                </script>';
                }
            }
        }
    }else{//if user is logging in
        $username = $_POST['username'];
        $password = $_POST['password'];
        $username = strip_tags( $username );
        print   '<script>
                document.getElementById("login_attempt").innerHTML+="Attempting to login user <strong>'.$username.'</strong>...<br>";
                </script>';
                $statement = $link->prepare("SELECT user_id, username, pass_hash, pass_salt, permissions
                FROM users
                WHERE username LIKE ?");
        if( $statement) {
            $statement->bind_param('s', $username );
            $statement->execute();
            $statement->bind_result($id ,$name, $hash, $salt, $perms);
            if( $statement->fetch()) {//check if account exists
                if( hash( 'sha256', $password.$salt ) == $hash) {//password correct?
                    $_SESSION["uid"] = $id;
                    $_SESSION["uname"] = $name;
					if ($perms == 'user') $_SESSION['uperms'] = 1;
					else if ($perms == 'vip') $_SESSION['uperms'] = 2;
					else if ($perms == 'mod') $_SESSION['uperms'] = 3;
					else if ($perms == 'admin') $_SESSION['uperms'] = 4;



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
            $statement->close();
        }else{
        print '<script>document.getElementById("login_attempt").innerHTML+="Attempting to login user <strong>'.$username.'</strong>...<br>"; </script>';

        }
    }
}
include ("page_bottom.php");
?>