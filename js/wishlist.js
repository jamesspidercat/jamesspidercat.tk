$(document).ready( function () {//create datatables table
    $('#main').DataTable({
        "lengthChange": false,
        "pageLength": 25,
        language: {
            searchPlaceholder: "Search books",
            search: "",
        },
        "dom": 'lrtip',
        destroy: true,
        "rowId": "id",
        "initComplete": function( settings, json ) {
            document.getElementById("loader").style.display = "none";
            document.getElementById("main").style.display = "inline";
            document.getElementById("main").classList.add("load");
        }
    });
} );
function showRows() {//Change between showing all rows vs only showing 25
    var table = $('#main').DataTable();
    var checkBox = document.getElementById("showAll");
    // If the checkbox is checked show all the rows
    if (checkBox.checked == true){
        table.page.len(-1).draw();
    } else {// Else only show 25 rows
        table.page.len(25).draw();
    }
}
// When the user clicks on the button,
//toggle between hiding and showing the dropdown content
function advancedSearchDropDown() {
  document.getElementById("dropDown").classList.toggle("show");
}
//Advanced Search
//
function have_read(y){//filter rows whether or not I have read the book
    var table = $('#main').DataTable();
    if (y == 0){
       table.column(5).search("No", true, false).draw(); 
    }
    else if (y == 1){
        table.column(5).search("Yes", true, false).draw();
    }else{
        table.column(5).search("", true, false).draw();
    }
}
var book_type_search = '';
function advanced_search_book_type(y){//filter rows based on the book type
    var yfinal = y;
    var table = $('#main').DataTable();
    var checkBox = document.getElementById('book_type_'+y);
    yfinal = yfinal.replace("_"," ")
    if (checkBox.checked == true){
        if (book_type_search != ''){
            yfinal = '|'+yfinal;
            yfinal = yfinal.replace("_"," ")
        }
        book_type_search = book_type_search.concat(yfinal);
    }else{
        if (book_type_search.startsWith(yfinal) == true && book_type_search != yfinal){
            yfinal = yfinal+'|';
        }else if(book_type_search != yfinal){
            yfinal = '|'+yfinal;
        }
        book_type_search = book_type_search.replace(yfinal,'');
    }
    table.column(3).search(book_type_search, true, false).draw();
}
        
//Search
function search_table(){
    var search = document.getElementById("search_box").value;
    var table = $('#main').DataTable();
    table.search(search, false, true).draw();
    console.log(search);
}
// reset filters
function reset_filters(){
    var table = $('#main').DataTable();
    const cbs = document.querySelectorAll('input[type="checkbox"]');
    cbs.forEach((cb) => {
        cb.checked = false;
    });
    table.columns([0,1,2,3,4,5,6]).search("",false,true).draw();
    table.search("",false,true).draw();
    showRows();
    document.getElementById("search_box").value = '';
    have_read();
}