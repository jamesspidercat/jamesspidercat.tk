<?php
session_name( 'userinfo' );
session_start();
if( isset($_SESSION['uid'])){
	$id = $_SESSION['uid'];
    $statement = $link->prepare("SELECT
    `username`,
    `permissions`
FROM
    `users`
WHERE
    `user_id` = ?");
    if( $statement) {
        $statement->bind_param("i",$id);
        $statement->execute();
        $statement->bind_result($name,$permissions);
        $statement->fetch();
        if ($permissions == 'user') $permissions = 1;
        else if ($permissions == 'vip') $permissions = 2;
        else if ($permissions == 'mod') $permissions = 3;
        else if ($permissions == 'admin') $permissions = 4;
    }else{
        echo 'Could not connect to database';
        die();
    }
    $statement->free_result();
    $statement->close();
    //permissions in order of power: [0:none,1:user,2:vip,3:mod,4:admin] (none being not signed in)

}
else {
	$permissions = 0;
    $id = null;
    $name = null;
}
?>