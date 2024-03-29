var elements_count = 0, selected_element = "", to_delete = [];

function create_element(type,values){
	element_values = [];
	if (values === undefined)
	{
		//file_width, file, width, text, align, db_id
		element_values = ["100","","3","","start",""];
	}else{
		element_values = values;
	}
	elements_count++;
	var new_element = document.createElement("div");
	document.getElementById("post-elements").appendChild(new_element);
	new_element.setAttribute("data-file_width",element_values[0]);
	new_element.setAttribute("data-file",element_values[1]);
	new_element.setAttribute("data-width",element_values[2]);
	new_element.setAttribute("data-type",type);
	new_element.setAttribute("data-text",element_values[3]);
	new_element.setAttribute("data-align",element_values[4]);
	new_element.setAttribute("class","post-element");
	new_element.className += ' text-white';
	new_element.setAttribute("onclick","edit_element(this)");
	new_element.setAttribute("id","element"+elements_count);
	new_element.setAttribute("data-db_id",element_values[5]);
	new_element.innerHTML = new_element.id+' Type: '+new_element.dataset.type+'<br>Text: '+new_element.dataset.text;
	if (new_element.dataset.file != ""){
		new_element.innerHTML += '<br>File: '+new_element.dataset.file;
	}
}


function save(){
	save_element();
	to_delete = JSON.stringify(to_delete);
	visibility = document.getElementById('visibility').value;
	title = document.getElementById('title').value;
	if (document.getElementById('unlisted').checked){
		unlisted = 1;
	}else unlisted = 0;
	var url_string = window.location.href;
	var url = new URL(url_string);
	var id = url.searchParams.get("edit");
	elements = [];
	var all_elements = document.getElementsByClassName("post-element");
	console.log(all_elements);
	for (var i = 0; i < all_elements.length; i++){
		element = all_elements[i];
		parent = element.parentNode;
		var index = Array.prototype.indexOf.call(parent.children, element);//get location of child
		//'position','text','file_width','file','width','type','align','db_id'
		temp_array = [index,
			element.dataset.text,
			element.dataset.file_width,
			element.dataset.file,
			element.dataset.width,
			element.dataset.type,
			element.dataset.align,
			element.dataset.db_id
		]
		elements[i] = temp_array;
	}
	elements = JSON.stringify(elements);
	$.post("save_post.php", {
		//all vars sent here to php
		to_delete : to_delete,
		visibility : visibility,
		unlisted : unlisted,
		elements : elements,
		title : title,
		post_id : id
	},function(data){
		if (data == 'success'){
			if(!alert("Successfully saved post")){window.location.reload();}
		}else{
			alert("Failed to save changes"+data)
		}
	});
}


function preview(){
	//save first
	save();
	//then open preview in new tab
	var url_string = window.location.href;
	var url = new URL(url_string);
	var id = url.searchParams.get("edit");
	window.open('blog_post.php?post='+id, '_blank').focus();
}
function moveChoiceTo(direction) {
    var span = document.getElementById(selected_element),
        td = span.parentNode;

    if (direction === -1 && span.previousElementSibling) {
        td.insertBefore(span, span.previousElementSibling);
    } else if (direction === 1 && span.nextElementSibling) {
        td.insertBefore(span, span.nextElementSibling.nextElementSibling)
    }
}
function edit_element(element){
	//save current stuff before loading new element
	save_element();
	selected_element = element.id;
	//re disable everything
	document.getElementById("file_width").setAttribute("disabled","true");
	document.getElementById("file").setAttribute("disabled","true");
	document.getElementById("but_upload").setAttribute("disabled","true");
	document.getElementById("text").setAttribute("disabled","true");
	document.getElementById("align").setAttribute("disabled","true");
	document.getElementById("delete").setAttribute("disabled","true");
	document.getElementById("move_up").setAttribute("disabled","true");
	document.getElementById("move_down").setAttribute("disabled","true");
	//get data from selected element and put in input boxes
	document.getElementById("file_width").value = element.dataset.file_width;
	document.getElementById("file_name").innerHTML = element.dataset.file;
	document.getElementById("file").value = '';
	document.getElementById("text").value = element.dataset.text;
	document.getElementById("align").value = element.dataset.align;
	//
	document.getElementById("selected").innerHTML = selected_element;
	var accept = '';
	document.getElementById('file').removeAttribute("accept");
	var x, i;
	x = document.querySelectorAll(".disable");
	for (i = 0; i < x.length; i++) {
		x[i].setAttribute("disabled","");
	}
	switch (element.dataset.type){
		case 'image':
			accept = ".jpeg, .jpg, .gif, .png, .webp";
			break;
		case 'video':
			accept = ".mp4, .webm";
			break;
		case 'audio':
			accept = ".mp3, .wav";
			break;
		default:
			break;
	}
	switch (element.dataset.type){
		case 'image':
		case 'video':
			document.getElementById("file_width").removeAttribute("disabled");
		case 'audio':
			document.getElementById("file").removeAttribute("disabled");
			document.getElementById("but_upload").removeAttribute("disabled");
			document.getElementById('file').setAttribute("accept",accept);
		default:
			document.getElementById("text").removeAttribute("disabled");
			document.getElementById("align").removeAttribute("disabled");
			document.getElementById("delete").removeAttribute("disabled");
			document.getElementById("move_up").removeAttribute("disabled");
			document.getElementById("move_down").removeAttribute("disabled");
			break;
	}
}
function delete_element(){
	var element = document.getElementById(selected_element);
	//tell to remove from DB on next save
	if ('db_id' in element.dataset){
		to_delete.push(element.dataset.db_id);
	}
	element.parentNode.removeChild(element);
	selected_element = "";
}
function save_element(){
	//save element locally
	if (selected_element != ""){
		element = document.getElementById(selected_element);
		element.dataset.file_width = document.getElementById("file_width").value;
		element.dataset.file = document.getElementById("file_name").innerHTML;
		element.dataset.text = document.getElementById("text").value;
		element.dataset.align = document.getElementById("align").value;
		//show content in element
		element.innerHTML = element.id+' Type: '+element.dataset.type+'<br>Text: '+element.dataset.text;
	if (element.dataset.file != ""){
		element.innerHTML += '<br>File: '+element.dataset.file;
	}
	}
}
function delete_post(){
	if (confirm("Are you sure you want to delete this post?")){
		var url_string = window.location.href;
		var url = new URL(url_string);
		var id = url.searchParams.get("edit");
		$.post("delete_post.php", {
			post_id : id
		},function(data){
			if (data == 'success'){
				if(!alert("Successfully deleted post")){window.location = 'blog.php';}
			}else{
				if(!alert("Failed to delete post")){window.location.reload();}
			}
		});
	}
}


$(document).ready(function(){
    $("#but_upload").click(function(){

        var fd = new FormData();
        var files = $('#file')[0].files;
        
        // Check file selected or not
        if(files.length > 0 ){
           fd.append('file',files[0]);
			var element = document.getElementById(selected_element);
			var url_string = window.location.href;
			var url = new URL(url_string);
			var id = url.searchParams.get("edit");
			$.ajax({
				url: 'upload_image.php?id='+id+'&type='+element.dataset.type,
				type: 'post',
				data: fd,
				contentType: false,
				processData: false,
				success: function(response){
					if(response != 0){
						//success
						document.getElementById('file_name').innerHTML = response;
					}else{
						alert('file not uploaded');
						var element = document.getElementById(selected_element);
						element.dataset.file = '';
					}
				},
			});
		}else{
        	alert("Please select a file.");
			var element = document.getElementById(selected_element);
			element.dataset.file = '';
        }
    });
});