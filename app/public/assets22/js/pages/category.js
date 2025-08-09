$(document).ready(function($){
       $("a[data-action=edit]").on('click',function(e){
        let hrefo = $(this).attr('href')+"/"+ $(this).attr('data-id')+"/update";
        $('#edit-sector-form').attr('action', hrefo);
        $('#edit-sector-form').prepend('<input type="hidden" name="_method" value="PUT">');
        $('#sector-name').val($(this).attr('data-name'));
        
    });

    $("a[data-action=delete]").on('click', function(e){
         let hrefo = $(this).attr('href')+"/"+ $(this).attr('data-id')+"/delete";
        $("#delete-sector-form").attr('action', hrefo);
    });

    $("button[data-close]").on('click', function(e){
        $("#delete-sector-form").attr('action', "");
    });
    $("button[data-submit]").on('click', function(e){
        e.preventDefault();
        $("#delete-sector-form").submit();
    });   
   

});
