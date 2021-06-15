var elements_count = 0, selected_element = '';
function create_element(type){
	elements_count++;
	var new_element = document.createElement("div");
	document.getElementById("post-elements").appendChild(new_element);
	new_element.setAttribute("data-file-width","100%");
	new_element.setAttribute("data-file","");
	new_element.setAttribute("data-width","3");
	new_element.setAttribute("data-type",type);
	new_element.setAttribute("data-text","");
	new_element.setAttribute("data-align","start");
	new_element.setAttribute("class","post-element");
	new_element.setAttribute("onclick","edit_element(this)");
	new_element.setAttribute("id","element"+elements_count);
	new_element.innerHTML = new_element.id;
}
function save(){

}
function preview(){
	save();
}
function moveChoiceTo(elem_choice, direction) {

    var span = elem_choice.parentNode,
        td = span.parentNode;

    if (direction === -1 && span.previousElementSibling) {
        td.insertBefore(span, span.previousElementSibling);
    } else if (direction === 1 && span.nextElementSibling) {
        td.insertBefore(span, span.nextElementSibling.nextElementSibling)
    }
}
function edit_element(element){
	//save current stuff before loading new element

	//
	selected_element = element.id;
	document.getElementById("selected").innerHTML = selected_element;
	var accept = '', element_options = document.getElementById("element-options");
	document.getElementById('file').removeAttribute("accept");
	var x, i;
	x = document.querySelectorAll(".disable");
	for (i = 0; i < x.length; i++) {
		x[i].setAttribute("disabled","");
		//x[i].removeAttribute("disabled")
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
			document.getElementById("file-width").removeAttribute("disabled");
		case 'audio':
			document.getElementById("file").removeAttribute("disabled");
			document.getElementById('file').setAttribute("accept",accept);
		default:
			document.getElementById("text").removeAttribute("disabled");
			document.getElementById("align").removeAttribute("disabled");
			document.getElementById("save").removeAttribute("disabled");
			document.getElementById("delete").removeAttribute("disabled");
			break;
	}
	//text
	//align
	//add file
	//file width
	//delete
}
function delete_element(){
	var element = document.getElementById(selected_element);
	element.parentNode.removeChild(element);
}