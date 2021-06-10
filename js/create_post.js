function create_element(type){
	var new_element = document.createElement("div");
	document.getElementById("post-elements").appendChild(new_element);
	if (type != 'text' && type != 'blank'){
		new_element.setAttribute("data-file-width","100%")
		new_element.setAttribute("data-file","")
	}
	new_element.setAttribute("data-width","3");
	new_element.setAttribute("data-type",type);
	new_element.setAttribute("data-text","");
	new_element.setAttribute("data-align","start");
	new_element.setAttribute("class","post-element");
	new_element.setAttribute("onclick","edit_element(this)")
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
	console.log(element);
	var element_options = document.getElementById("element-options");
	switch (element.dataset.type){
		case 'image':
			accept = ".jpeg, .jpg, .gif, .png, .webp"
			break;
		case 'video':
			accept = ".mp4, .webm"
			break;
		case 'audio':
			accept = ".mp3, .wav"
			break;
		case 'text':
			//text
			//align
		case 'blank':
			//delete
			break;
	}
	if (element == //audio/video/image){
		//add file
		var new_element = document.createElement("input");
		element_options.appendChild(new_element);
		new_element.setAttribute("type","file");
		new_element.setAttribute("accept",accept);
	}
	//file width
}