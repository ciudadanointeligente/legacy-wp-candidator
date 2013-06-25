function comparar(){
    jQuery.post(the_ajax_script.ajaxurl, { 'action': 'the_ajax_hook' }, 
        function(response_from_the_action_function) {
            //jQuery("#compare ul").html(response_from_the_action_function);
            console.log(response_from_the_action_function);
        });
}

jQuery(document).ready(function($) {
    $("input:checkbox").on('click', function(){
        var numberOfChecked = $('input:checkbox:checked').length;
        if(numberOfChecked<=2) {
            var candidate_name = $(this).data('candidate-name');
            var candidate_id = $(this).val();
            $(".compare ul").append('<li data-lolo="'+candidate_id+'">'+candidate_name+'<a class="remove-candidate" href="#" data-candidate-id="'+candidate_id+'">x</a></li>');
            
            if(numberOfChecked==2) {
                $(".compare").append('<input type="button" value="Comparar" onClick="comparar()">');
            }
        }
    });

    $(".remove-candidate").live('click', function(event){
        event.preventDefault();
        //console.log( $(this).data('candidate-id') );
        var lolo_id = $(this).data('candidate-id');
        $('li').data('lolo-',lolo_id).remove();
        //$("input:checkbox").val('id','candidato-'+lolo_id).attr('checked', false);
    })
});