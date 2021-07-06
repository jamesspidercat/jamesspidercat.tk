<?php
//page_top.php var setup
$page_title = "Users | Sam's Books";
$curPage  = "users";
$require_login = '3';
$jsPaths = array('js/main.js','js/users.js');
require_once('page_top.php');
?>
<p id="feedback"></p>
<div class="search_box">
    <input type="text" placeholder="Search usernames..." onkeyup="search_table()" id="search_box">
</div>
<table id="main">
    <thead>
        <tr>
            <th>User Id</th><th>Username</th><th>Name</th><th>User Permissions</th>
        </tr>
    </thead>
    <tbody>
<?php
$statement = $link->prepare("SELECT
`user_id`,
`username`,
`name`,
`permissions`
FROM
`users`");
if( $statement) {
    $statement->execute();
}else{
    die();
}
db_bind_array($statement, $result);
while ($statement->fetch()) {
    print "<tr>
        <td>".$result['user_id']."</td>
        <td>".$result['username']."</td>
        <td>".$result['name']."</td>
        <td>
            <select id='user_".$result['user_id']."' onchange='update_user(".$result['user_id'].")'";
    if (($result['permissions'] == 'mod' || $result['permissions'] == 'admin') && $permissions < 4){
        print "disabled ";
    }
    print ">
                <option ";
    if ($result['permissions'] == 'user'){
        print "selected='selected' ";
    }
    print "value='user'>User</option>
                <option ";
    if ($result['permissions'] == 'vip'){
        print "selected='selected' ";
    }
    print "value='vip'>Vip</option>
                <option ";
    if ($result['permissions'] == 'mod'){
        print "selected='selected' ";
    }
    if ($permissions < 4){
        print 'disabled ';
    }
    print  "value='mod'>Mod</option>
                <option ";
    if ($result['permissions'] == 'admin'){
        print "selected='selected' ";
    }
    if ($permissions < 4){
        print 'disabled ';
    }
    print "value='admin'>Admin</option>
            </select>
        </td>
    </tr>";
}
?>
    </tbody>
</table>
<?php
include ("page_bottom.php");
?>