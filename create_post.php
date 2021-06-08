<?php
//page_top.php var setup
$page_title = "Create Post | Sam's Books";
$curPage  = "createpost";
$require_login = '3';
$jsPaths = array('js/main.js','js/create_post.js');
require_once('page_top.php');
?>
<div class="container row">
	<section class="col-8">
		asdfghj
	</section>
	<aside class="col-4 seperator">

			<button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">Create Element</button>
			<ul class="dropdown-menu">
				<li><button class="dropdown-item" type="button" onclick="create_element('text')">Text</button></li>
				<li><button class="dropdown-item" type="button" onclick="create_element('image')">Image</button></li>
				<li><button class="dropdown-item" type="button" onclick="create_element('video')">Video</button></li>
				<li><button class="dropdown-item" type="button" onclick="create_element('audio')">Audio</button></li>
			</ul>
			<br>
			<button class="btn btn-primary" onclick="save()">
				Save
			</button>
			<br>
			<button class="btn btn-primary" onclick="preview()">
				Preview & Save
			</button>
			<br>
			<label for="visabilty">Visabilty:</label>
			<select name="visabilty" id="visabilty" class="btn btn-primary">
				<option value="0">All</option>
				<option value="1">User</option>
				<option value="2">Vip</option>
				<option value="3">Mod</option>
				<option value="4">Admin</option>
			</select>
	</aside>
</div>
<?php
include ("page_bottom.php");
?>