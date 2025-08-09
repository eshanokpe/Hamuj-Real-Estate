$(document).ready(function($){
       $("a[data-action=edit]").on('click',function(e){
        let hrefo = $(this).attr('href')+"/"+ $(this).attr('data-id')+"/update";
        $('#edit-category-form').attr('action', hrefo);
        $('#edit-category-form').prepend('<input type="hidden" name="_method" value="PUT">');
        $('#category-name').val($(this).attr('data-name'));
        $('#category-description').val($(this).attr('data-desc'));
        
    });

    $("a[data-action=delete]").on('click', function(e){
         let hrefo = $(this).attr('href')+"/"+ $(this).attr('data-id')+"/delete";
        $("#delete-category-form").attr('action', hrefo);
    });
    
    $("button[data-close]").on('click', function(e){
        $("#delete-category-form").attr('action', "");
    });
    $("button[data-submit]").on('click', function(e){
        e.preventDefault();
        $("#delete-category-form").submit();
    });   

});