<?php
include('connect.php');
include('user_setup.php');
$to_delete = json_decode(stripslashes($_POST['to_delete']));
$elements = json_decode(stripslashes($_POST['elements']));
foreach($to_delete as $d){//delete removed post elements
    $statement = $link->prepare("DELETE FROM `post_content` WHERE `content_id` = ?");//delete post content
    if( $statement) {
        $statement->bind_param("i",$d);
        $statement->execute();
        $statement->close();
    }else{
        echo "failed";
        die();
    }
}
//update main post settings
$statement = $link->prepare("UPDATE
`blog_posts`
SET
`author` = ?,
`visibility` = ?,
`unlisted` = ?,
`title` = ?
WHERE
`post_id` = ?");
if( $statement) {
    $statement->bind_param("iiisi",$id,$_POST['visibility'],$_POST['unlisted'],$_POST['title'],$_POST['post_id']);
    $statement->execute();
    $statement->close();
}else{
    echo "failed";
    die();
}
foreach($elements as $element){//save changes to post content
    //'position','text','file_width','file','width','type','align','db_id'
    if ($element[7] != ""){
        //update
        $statement = $link->prepare("UPDATE
            `post_content`
        SET
            `post_order` = ?,
            `width` = ?,
            `type` = ?,
            `text` = ?,
            `file` = ?,
            `file_width` = ?,
            `align` = ?
        WHERE
            `content_id` = ? AND `post_id` = ?");
        if( $statement) {
            $statement->bind_param("iisssisii",$element[0],$element[4],$element[5],
            $element[1],$element[3],$element[2],$element[6],$element[7],$_POST['post_id']);
            $statement->execute();
            $statement->close();
        }else{
            echo "failed";
            die();
        }
    }else{
        //insert
        $statement = $link->prepare("INSERT
        INTO
            `post_content`(
                `post_id`,
                `post_order`,
                `width`,
                `type`,
                `text`,
                `file`,
                `file_width`,
                `align`
            )
        VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        if( $statement) {
            $statement->bind_param("iiisssis",$_POST['post_id'],$element[0],$element[4],$element[5],
            $element[1],$element[3],$element[2],$element[6]);
            $statement->execute();
            $statement->close();
        }else{
            echo "failed";
            die();
        }
    }
}
echo 'success';
?>