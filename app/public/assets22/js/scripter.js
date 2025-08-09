$(document).ready(function(){
    $('button[id="#Submit"]').click(function(e){
        e.preventDefault();
        let button_id = $(this).attr('data-id');
       let ab = $("form[id="+button_id+"2]").find("input[name="+button_id+"]").is(":checked");

       if (ab == true){
           let baseUrl = $("form[id="+button_id+"2]").attr('action');
           let award = $("form[id="+button_id+"2]").find("input[name="+button_id+"]:checked").attr('name');
           let nominee = $("form[id="+button_id+"2]").find("input[name="+button_id+"]:checked").val();
// console.log(baseUrl, ' ', award, nominee);
            try{
                fetch(baseUrl+"/"+award+"/vote/"+nominee, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then((response) => {
                    return response.json();
                }).then((data)=>{
                    console.log(data);
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": false,
                        "preventDuplicates": true,
                        "preventOpenDuplicates": true,
                        "positionClass": "toast-top-center",
                        "showMethod": "slideDown"
                    };
                    if(data == 'warning'){
                        toastr.warning('You already have a vote under this Award');
               
                    }
                    if(data == 'danger'){
                        toastr.warning('Sorry, It appears you have manipulated your device details');
                
                    }
                    if (data == 'success'){
                        toastr.success('Your vote have been added successfully under this Award');
                    }
                }).catch(error => {
                    console.log('Error:', error);
                })
            }catch (error) {
                console.log('Error:', error);
            }
    
        $("form[id="+button_id+"2]").find("input[name="+button_id+"]").attr('checked', false);
        $("form[id="+button_id+"2]").find('div[class=pay-item]').removeAttr('style');

       }else{
           alert('make a selection before clicking the vote button');
       }
    });

    $('div[class=pay-item]').click(function(){
       let is_checked= $(this).find('input[type=radio]').is(':checked');

       if (is_checked == true){
           $(this).css({"border": "1px solid #D4AF37","padding":"5px", "border-radius":"5px"})
       }

        $(this).siblings('div[class=pay-item]').removeAttr('style');
       });


       $('button[id="#SubmitNominee"]').click(function(e){
        e.preventDefault();
        let button_id = $(this).attr('data-id');
       let ab = $("form[id="+button_id+"2]").find("input[name="+button_id+"]").val();

       if (ab != ''){
           let baseUrl = $("form[id="+button_id+"2]").attr('action');
           let award = $("form[id="+button_id+"2]").find("input[name="+button_id+"]").attr('name');
           let nominee = $("form[id="+button_id+"2]").find("input[name="+button_id+"]").val();

           jQuery.ajax({
               url: baseUrl+"/"+award+"/vote/other/"+nominee,
               type:'GET',
               cache: false,
               success: function(data){
                   console.log(data);
                   
                   toastr.options = {
                    "closeButton": true,
                    "progressBar": false,
                    "preventDuplicates": true,
                    "preventOpenDuplicates": true,
                    "positionClass": "toast-top-center",
                    "showMethod": "slideDown"
                    };
                    if(data == 'warning'){
                        toastr.warning('You already have a vote under this Award');

                    }
                    if(data == 'danger'){
                        toastr.warning('Sorry, It appears you have manipulated your device details');

                    }
                    if (data == 'success'){
                        toastr.success('Your vote have been added successfully under this Award');
                    }
               }
           })
        $("form[id="+button_id+"2]").find("input[name="+button_id+"]").val('');
        // $("form[id="+button_id+"2]").find('div[class=pay-item]').removeAttr('style');

       }else{
           alert('make an entry before clicking the vote button');
       }
    });

})