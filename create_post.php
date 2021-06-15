<?php
//page_top.php var setup
$page_title = "Create Post | Sam's Books";
$curPage  = "createpost";
$require_login = '3';
$jsPaths = array('js/main.js','js/create_post.js');
require_once('page_top.php');
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
		
		<select name="visabilty" id="visabilty" class="btn btn-primary post-options">
			<option value="0">All</option>
			<option value="1">User</option>
			<option value="2">Vip</option>
			<option value="3">Mod</option>
			<option value="4">Admin</option>
		</select>
		<label for="visabilty">Visabilty</label>
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
				<label for="file" class="form-label">File</label>
				<input type="file" class="form-control disable" id="file" name="file" disabled>
			</div>
			<!-- file width -->
			<div class="form-group">
				<label for="file-width" class="form-label">Image/Video Width %</label>
				<input type="number" class="form-control disable" id="file-width" name="file-width" disabled minlength="0" maxlength="200">
			</div>
			<!-- Save Changes -->
			<br>
			<div class="form-group">
			<button class="btn btn-primary disable" type="submit" disabled id="save">Save Changes</button>
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