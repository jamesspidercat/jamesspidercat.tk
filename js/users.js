$(document).ready( function () {//create datatables table
    $('#main').DataTable({
        "lengthChange": false,
        "pageLength": 25,
        language: {
            searchPlaceholder: "Search users",
            search: "",
        },
        "dom": 'lrtip',
        destroy: true,
        "rowId": "id",
        "autoWidth": true,
        "initComplete": function( settings, json ) {//run once table loads
            //document.getElementById("loader").style.display = "none";
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
//Search
function search_table(){
    var search = document.getElementById("search_box").value;
    var table = $('#main').DataTable();
    table.column(1).search(search, false, true).draw();
    console.log(search);
}