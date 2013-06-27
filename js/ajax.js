function comparar(){
    jQuery.post(the_ajax_script.ajaxurl, { 'action': 'the_ajax_hook' }, 
        function(response_from_the_action_function) {
            //jQuery("#compare ul").html(response_from_the_action_function);
            console.log(response_from_the_action_function);
        });
}

function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

jQuery(document).ready(function($) {
    $("input[type=checkbox]").on('click', function(){
        $(this).attr('disabled','disabled');
        var numberOfChecked = $('input[type=checkbox]:checked').length;
        if(numberOfChecked<=2) {
            var candidate_name = $(this).data('candidate-name');
            var candidate_id = $(this).val();
            
            $(".compare ul").append('<li data-id="'+candidate_id+'">'+candidate_name+' <a class="remove-candidate" href="#" data-candidate-id="'+candidate_id+'">x</a></li>');
            
            if(numberOfChecked==2) {
                //$(".compare").append('<input type="button" name="comparar" value="Comparar" onClick="comparar()">');
                $('.compare ul li').each( function(){
                    var display_id = $(this).data('id');
                    //console.log(display_id);
                    $('#candidato-antecedentes-'+display_id).attr('style','display:block');
                    $('#candidato-pregresp-'+display_id).attr('style','display:block');
                })
                
            }
        }
    });

    $(".remove-candidate").live('click', function(event){
        event.preventDefault();
        var candidate_id = $(this).data('candidate-id');
        
        $(this).parent().remove();
        $("input[name=candidato-"+candidate_id+"]").attr('checked', false);
        $("input[name=candidato-"+candidate_id+"]").removeAttr('disabled');

        var numberOfChecked = $('input:checkbox:checked').length;
        if(numberOfChecked<2) {
            //$("input[name=comparar]").remove();
            //console.log(display_id);
            $('#candidato-antecedentes-'+candidate_id).attr('style','display:none');
            $('#candidato-pregresp-'+candidate_id).attr('style','display:none');
            
        }
    })
});