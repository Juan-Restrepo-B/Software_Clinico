$(function(){

    // Lista de docente
    $.post( '../../frontend/funciones/monto.php' ).done( function(respuesta)
    {
        $( '#mont' ).html( respuesta );
    });
    
    
    // Lista de Ciudades
    $( '#mont' ).change( function()
    {
        var el_continente = $(this).val();

    });

})
