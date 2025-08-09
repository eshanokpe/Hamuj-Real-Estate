$(document).ready(function ($) {
    $('select[id=category_name]').on('change',function () {

        if ($("select[id=category_name]").val() !== '') {
            $("select[id=sector_name]").find("#init").siblings().remove();
            let category = $("select[id=category_name]").val();
            let baseUrl = $("select[id=category_name]").attr('data-url');
            jQuery.ajax({
                url: baseUrl+"/"+category+"/sectors",
                type:'GET',
                cache: false,
                success: function(html){
                    $("select[id=sector_name]").html(html);
                    $("select[id=sector_name]").removeAttr('disabled');
                }
            })
        }
    });
    $('select[id=sector_name]').change(function () {
        if ($("select[id=sector_name]").val() !== '') {
            $("input[id=award_name]").attr('Placeholder', 'e.g. Employer of the Year');
            $("input[id=award_name]").removeAttr('disabled');

            $("textarea[id=award_description]").attr('Placeholder', 'Short description of this award');
            $("textarea[id=award_description]").removeAttr('disabled');

            $("textarea[id=award_criteria]").attr('Placeholder', 'Criteria for winning this award');
            $("textarea[id=award_criteria]").removeAttr('disabled');

        }
    });

    // $("#add-field").click(function () {

    //     let nodes;
    //     let lastChild = $('#create-form-row').children().last();
    //     if ($("select[id=category_name]").val() == '') {
    //         nodes = '<div class="col-12"><div class="mb-3"><label class="control-label form-label">Award Name</label><input class="form-control" placeholder="e.g. Excellence Awards" type="text" name="award_name[]" id="award_name" value required autocomplete="off" disabled/></div></div>';
    //         $(nodes).insertAfter(lastChild);
    //     } else {
    //         nodas = '<div class="col-12"><div class="mb-3">' +
    //             '<label class="control-label form-label">Award Name</label>' +
    //             '<input class="form-control" placeholder="e.g. Excellence Awards" type="text" name="award_name[]" id="award_name" value required autocomplete="off"/>' +
    //             '</div></div>';
    //         $('#create-form-row').append(nodes);
    //     }

    // });

    // $("a[data-action=edit]").on('click',function(e){
    //  let hrefo = $(this).attr('href')+"/"+ $(this).attr('data-id')+"/update";
    //  $('#edit-sector-form').attr('action', hrefo);
    //  $('#edit-sector-form').prepend('<input type="hidden" name="_method" value="PUT">');
    //  $('#sector-name').val($(this).attr('data-name'));



     $("a[data-action=delete]").on('click', function(e){
          let hrefo = $(this).attr('href')+"/"+ $(this).attr('data-id')+"/delete";
         $("#delete-award-form").attr('action', hrefo);
     });

     $("button[data-close]").on('click', function(e){
         $("#delete-award-form").attr('action', "");
     });
     $("button[data-submit]").on('click', function(e){
         e.preventDefault();
         $("#delete-award-form").submit();
     });   


});
