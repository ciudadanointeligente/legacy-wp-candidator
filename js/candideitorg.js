// In case we forget to take out console statements. IE becomes very unhappy when we forget. Let's not make IE unhappy
if(typeof(console) === 'undefined') {
    var console = {};
    console.log = console.error = console.info = console.debug = console.warn = console.trace = console.dir = console.dirxml = console.group = console.groupEnd = console.time = console.timeEnd = console.assert = console.profile = function() {};
}

jQuery(document).ready(function($) {
    $('.perfiles a').on('click', function(e){
        var CandidatoSlug = $(this).data('candidato-slug');
        $('#candidato-'+CandidatoSlug).attr('style','display:block');
        $('.perfiles').attr('style','display:none');
    })

    $('.volver').on('click', function(e){
        var CandidatoSlug = $(this).data('candidato-slug');
        $('.perfiles').attr('style','display:block');
        $('#candidato-'+CandidatoSlug).attr('style','display:none');
        $('.candidato').attr('style','display:none');
        $('#frente-a-frente').attr('style', 'display:none');
    })

    $('.frente-a-frente').on('click', function(e){

        $('.perfiles').attr('style','display:none');
        $('#frente-a-frente').attr('style', 'display:block');

        if( $(this).data('candidato-slug') ) {
            $('.candidato').attr('style','display:none');
            $('.candidato-a-vs').attr('style','display:none');
            $('.candidato-b-vs').attr('style','display:none');
            $('select[name="candidato-b"]').val(0);

            $('select[name="candidato-a"]').val( $(this).data('candidato-slug') );
            $('#candidato-a-vs-slug-'+$(this).data('candidato-slug')).attr('style','display:block');
        } else {
            $('select[name="candidato-a"]').val(0);
            $('select[name="candidato-b"]').val(0);
            $('.candidato').attr('style','display:none');
            $('.candidato-a-vs').attr('style','display:none');
            $('.candidato-b-vs').attr('style','display:none');
        }
    })

    $('select[name="candidato-a"]').live('change',function(){
        var CandidatoSlug = $(this).val();
        $('.candidato-a-vs').attr('style','display:none');
        $('#candidato-a-vs-slug-'+CandidatoSlug).attr('style','display:block');
    })

    $('select[name="candidato-b"]').live('change',function(){
        var CandidatoSlug = $(this).val();
        $('.candidato-b-vs').attr('style','display:none');
        $('#candidato-b-vs-slug-'+CandidatoSlug).attr('style','display:block');
    })

    if( location.hash.split('/').length >= 3 ) {
        var aData = location.hash.split('/');
        
        $('.perfiles').attr('style','display:none');
        $('#frente-a-frente').attr('style', 'display:block');

        $('select[name="candidato-a"]').val( aData[1] );
        $('#candidato-a-vs-slug-'+aData[1]).attr('style','display:block');

        $('select[name="candidato-b"]').val( aData[2] );
        $('#candidato-b-vs-slug-'+aData[2]).attr('style','display:block');
    }

    if(location.hash == '#perfiles') {
        $('.perfiles').attr('style','display:block');
        $('.candidato').attr('style','display:none');
        $('#frente-a-frente').attr('style', 'display:none');
    }

    if(location.hash == '#frente-a-frente') {
        $('.perfiles').attr('style','display:none');
        $('#frente-a-frente').attr('style', 'display:block');
    }

});