$(document).ready( function () {//create datatables table
    $('#main').DataTable({
        "lengthChange": false,
        "pageLength": 25,
        language: {
            searchPlaceholder: "Search books",
            search: "",
        },
        "dom": 'lrtip',
        "columnDefs": [
            {"visible": false, "targets": [8,9,10]}
        ],
        destroy: true,
        "rowId": "id",
        "autoWidth": true,
        "initComplete": function( settings, json ) {//run once table loads
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
//filters rows based off of the options selected in the advanced search options
var format_search = '';
var book_type_search = '';
var owned_in_search = '';

function advanced_search_format(y){
    var yfinal = y;
    var table = $('#main').DataTable();
    var andor = document.getElementById('format_andor');
    if (y == 'refresh' && format_search != ''){
        if (andor.checked == true){//and
            while(format_search.includes("|")){
                format_search = format_search.replace("|",'""');
            }
            format_search = format_search.concat('"');
            format_search = '"' + format_search;
            table.column(5).search(format_search, false, true).draw();
        }else{//or
            while(format_search.includes('""')){
                format_search = format_search.replace('""','|');
            }
            format_search = format_search.replace('"','');
            format_search = format_search.replace('"','');
            table.column(5).search(format_search, true, false).draw();
        }
    }
    else if(y != 'refresh'){
        if (andor.checked == true){//and
            var checkBox = document.getElementById('format_'+y);
            yfinal = '"'+y+'"';
            if (checkBox.checked == true){
                format_search = format_search.concat(yfinal);
            }else{
                format_search = format_search.replace(yfinal,'');
            }
            table.column(5).search(format_search, false, true).draw();
        }else{//or
            var checkBox = document.getElementById('format_'+y);
            if (checkBox.checked == true){
                if (format_search != ''){
                    yfinal = '|'+y;
                }
                format_search = format_search.concat(yfinal);
            }else{
                if (format_search.startsWith(y) == true && format_search != y){
                    yfinal = y+'|';
                }else if(format_search != y){
                    yfinal = '|'+y;
                }
                format_search = format_search.replace(yfinal,'');
            }
            table.column(5).search(format_search, true, false).draw();
        }
    }
}
        
        
function advanced_search_book_type(y){
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
        
        
function advanced_search_owned_in(y){
    var yfinal = y;
    var table = $('#main').DataTable();
    var andor = document.getElementById('owned_in_andor');
    if (y == 'refresh' && owned_in_search != ''){
        if (andor.checked == true){//switch to and searching
            while(owned_in_search.includes("|")){
                owned_in_search = owned_in_search.replace("|",'""');// replace | with "" to change from 'or' search to 'and' search
            }
            owned_in_search = owned_in_search.concat('"');//add ending "
            owned_in_search = '"' + owned_in_search;//add starting "
            table.column(6).search(owned_in_search, false, true).draw();
        }else{//switch to or searching
            while(owned_in_search.includes('""')){
                owned_in_search = owned_in_search.replace('""','|');// replace "" with | to change from 'and' search to 'or' search
            }
            owned_in_search = owned_in_search.replace('"','');//remove starting "
            owned_in_search = owned_in_search.replace('"','');//remove ending "
            table.column(6).search(owned_in_search, true, false).draw();
        }
    }
    else if(y != 'refresh'){
        if (andor.checked == true){//and
            var checkBox = document.getElementById('owned_in_'+y);
            yfinal = '"'+y+'"';
            yfinal = yfinal.replace("_"," ")
            if (checkBox.checked == true){
                owned_in_search = owned_in_search.concat(yfinal);
            }else{
                owned_in_search = owned_in_search.replace(yfinal,'');
            }
            table.column(6).search(owned_in_search, false, true).draw();
        }else{//or
            var checkBox = document.getElementById('owned_in_'+y);
            yfinal = yfinal.replace("_"," ")
            if (checkBox.checked == true){
                if (owned_in_search != ''){
                    yfinal = '|'+yfinal;
                }
                owned_in_search = owned_in_search.concat(yfinal);
            }else{
                if (owned_in_search.startsWith(yfinal) == true && owned_in_search != yfinal){
                    yfinal = yfinal+'|';
                }else if(owned_in_search != yfinal){
                    yfinal = '|'+yfinal;
                }
                owned_in_search = owned_in_search.replace(yfinal,'');
            }
            table.column(6).search(owned_in_search, true, false).draw();
        }
    }
}
function advanced_search_show_collected(){
    var table = $('#main').DataTable();
    var checkBox = document.getElementById('show_collected');
    if (checkBox.checked == true){//shows things with info in the collected in col
        table.column(4).search( '',false,true).draw();
    }else{//hides anything where the collected in col is not empty
        table.column(4).search( '^$',true,false).draw();
    }
}
//Search
function search_table(){
    var search = document.getElementById("search_box").value;
    var table = $('#main').DataTable();
    table.column(8).search(search, false, true).draw();
    console.log(search);
}
// reset filters
function reset_filters(){
    var table = $('#main').DataTable();
    const cbs = document.querySelectorAll('input[type="checkbox"]');
    cbs.forEach((cb) => {
        cb.checked = false;
    });
    document.getElementById('show_collected').checked = true;
    table.columns([0,1,2,3,4,5,6,7,8,9,10]).search("",false,true).draw();//remove search
    showRows();
    document.getElementById("search_box").value = '';//remove text from search box
}