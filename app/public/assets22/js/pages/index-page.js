window.onload = function () {
    //Reference the DropDownList.
    var programYear = document.getElementById("award_year");

    //Determine the Current Year.
    var currentYear = (new Date()).getFullYear();

    var endYear = currentYear + 10;

    //Loop and add the Year values to DropDownList.
    for (var i = currentYear; i <= endYear; i++) {
        var option = document.createElement("OPTION");
        option.innerHTML = i;
        option.value = i;
        programYear.appendChild(option);
    }
};


$(document).ready(function($){
    $("body").on('click', 'a[data-action=create]',function(e){

        let hrefo = $('a[data-action=create]').attr('href');
        $('#form-award').attr('action', hrefo);
        $('#modal-title').html('Create Awards Program');
        $('#btn-save').html('Create');
        
    });


    $("a[data-action=edit]").on('click',function(e){
        let hrefo = $(this).attr('href');
        let year = $(this).attr('data-year');
        $('#form-award').attr('action', hrefo);
        $('#form-award').prepend('<input type="hidden" name="_method" value="PUT">');
        $('#modal-title').html('Edit Awards Program');
        $('#award_name').val($(this).attr('data-name'));
        $('#init').replaceWith('<option id=init value='+ year +' selected>'+year+'</option>');
        $('#award_location').val($(this).attr('data-loc'));
        $('#btn-save').html('Update');
        
    });

});