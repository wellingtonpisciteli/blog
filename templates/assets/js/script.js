$(document).ready(function(){
    $("#busca").keyup(function(){
        var busca=$(this).val();
        if(busca.length>0){
            $('#buscaResultado').css('display', 'flex');
            $.ajax({
                url: $('form').attr('data-url-busca'),
                method: 'POST',
                data: {
                    busca: busca
                },
                success: function(data){
                    if(data){
                        $('#buscaResultado').html(data);
                    }
                }
            });
        }else{
            $('#buscaResultado').css('display', 'none');
        }
    });
});

