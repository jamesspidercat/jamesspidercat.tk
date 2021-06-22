<?php
//page_top.php var setup
$page_title = "Create Post | Sam's Books";
$curPage  = "createpost";
$require_login = '3';
$jsPaths = array('js/main.js','js/create_post.js');
require_once('page_top.php');
?>
<?php
//to do: make elements look better, save to DB, load edit from DB, delete post button, post title edit

//text posts have text shown in element box, images are shown in element box (with a maxwidth)
//audio and video and image show file name & text
//add delete post button

//check if .php?edit=[DB_id]
if (isset($_GET["edit"])){
	// if yes get existing elements from database & print js code to create them
	$statement = $link->prepare("SELECT
    `post_id`,
    `author`,
    `visibility`,
    `unlisted`,
    `post_date`,
    `title`
FROM
    `blog_posts`
WHERE
    `post_id` = ?");
	if( $statement ) {
        $statement->bind_param("i", $_GET["edit"]);
        $statement->execute();
		$statement->bind_result($post_id,$author,$visibility,$unlisted,$post_date,$title);
		if ($statement->fetch()){
			//check if user is post author
			if (!($author == $id)){
				login(5,$permissions);
			}
			//create elements
		}else{
			print('<script>
			alert("The Requested Post Does Not Exist");
			location = "blog.php";
			</script>');
		}
        $statement->close();
    }else{
		print('<script>
		alert("An Error Has Occurred");
		location = "blog.php";
		</script>');
		die();
	}
}else{
	$post_title = "Post Title";
	//if no this is new post, create new post in db then take user to ?edit=[new post id]
	$statement = $link->prepare("INSERT INTO `blog_posts`(`author`, `title`) VALUES (?, ?)");
	$statement->bind_param("is",$id,$post_title);
	$statement->execute();
	$statement->close();
	$statement = $link->prepare("SELECT `post_id` FROM blog_posts ORDER BY `post_id` DESC LIMIT 1 ");
	$statement->execute();
	$statement->bind_result($new_post);
	$statement->fetch();
	$statement->close();
	print('<script>
		location = "create_post.php?edit='.$new_post.'";
		</script>');
	die();
}
?>
<div class="container row">
	<section class="col-8" id="post-elements">
	</section>
	<aside class="col-4 seperator text-white">
		<h3>Post Options</h3>
		<button class="btn btn-primary dropdown-toggle post-options" type="button" data-bs-toggle="dropdown">
			Create Element
		</button>
		<ul class="dropdown-menu">
			<li><button class="dropdown-item" type="button" onclick="create_element('text')">Text</button></li>
			<li><button class="dropdown-item" type="button" onclick="create_element('image')">Image</button></li>
			<li><button class="dropdown-item" type="button" onclick="create_element('video')">Video</button></li>
			<li><button class="dropdown-item" type="button" onclick="create_element('audio')">Audio</button></li>
		</ul>
		<br>
		<button class="btn btn-primary post-options" onclick="save()">
			Save
		</button>
		<br>
		<button class="btn btn-primary post-options" onclick="preview()">
			Preview & Save
		</button>
		<br>
		
		<select name="visibility" id="visabilty" class="btn btn-primary post-options">
			<option value="0">All</option>
			<option value="1">User</option>
			<option value="2">Vip</option>
			<option value="3">Mod</option>
			<option value="4">Admin</option>
			<option value="5">Author</option>
		</select>
		<?php
echo "<script>$('#visabilty').val(".$visibility.");</script>";
		?>
		<label for="visibility">Visibility</label>
		<br>
		<label for="unlisted">Unlisted</label>
		<input type="checkbox" id="unlisted" name="unlisted"
		<?php
if ($unlisted == 1){
	echo 'checked';
}
		?>>
		<hr>
		<h3>Element Options</h3>
		<div id="element-options">
			<!-- Selected Element -->
			<div class="form-group">
				<label>Selected Element: </label>
				<small id="selected">None</small>
			</div>
			<!-- text -->
			<div class="form-group">
				<label for="text" class="form-label">Text</label>
				<textarea class="form-control disable" id="text" name="text" disabled></textarea>
			</div>
			<!-- align -->
			<div class="form-group">
				<label for="align" class="form-label">Element Alignment</label>
				<select class="form-select disable" id="align" name="align" disabled>
					<option value="start">Start</option>
					<option value="center">Center</option>
					<option value="end">End</option>
				</select>
			</div>
			<!-- add file -->
			<div class="form-group">
				<form method="post" action="" enctype="multipart/form-data" id="upload_image">
						<label for="file" class="form-label">File</label>
						<p id="file_name"></p>
						<input type="file" id="file" name="file" class="form-control disable" disabled/>
						<input type="button" class="btn btn-primary" value="Upload File" class="form-control disable" id="but_upload" style="margin-top: 3px;" disabled>
				</form>
			</div>
			<!-- file width -->
			<div class="form-group">
				<label for="file_width" class="form-label">Image/Video Width %</label>
				<input type="number" class="form-control disable" id="file_width" name="file_width" disabled minlength="0" maxlength="200">
			</div>
			<br>
			<!-- Move -->
			<div class="form-group">
				<button class="btn btn-primary"onclick="moveChoiceTo(-1)">Move Up</button>
				<button class="btn btn-primary" onclick="moveChoiceTo(1)">Move Down</button>
			</div>
			<!-- delete -->
			<br>
			<div class="form-group">
			<button class="btn btn-danger disable" type="submit" disabled id="delete" onclick="delete_element()">Delete Element</button>
			</div>
		</div>
	</aside>
</div>
<?php
include ("page_bottom.php");
?>