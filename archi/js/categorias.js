

function obtenerDatosCategoria(idCategoria){
    $.ajax({
        type:"POST",
        data:"idCategoria=" + idCategoria,
        url:"../procesos/categorias/obtenerCategoria.php",
        success:function(respuesta){
            respuesta = jQuery.parseJSON(respuesta);

            $('#idCategoria').val(respuesta['idCategoria']);
            $('#categoriaU').val(respuesta['nombreCategoria']);
        }
    });
}
function actualizaCategoria(){
    if($('#categoriaU').val() == ""){
        swal("No hay categoria");
    }else{
        $.ajax({
            type:"POST",
            data:$('#frmActualizaCategoria').serialize(),
            url:"../procesos/categorias/actualizaCategoria.php",
            success:function(respuesta){
                respuesta = respuesta.trim();
                if(respuesta == 1){
                    $('#tablaCategoria').load("categorias/tablaCategoria.php");
                    
                    swal("n_n","Actualizado con Exito","success");
                }else{
                    swal("u_u","No se pudo actualiza","error");
                }
            }
        });
    }
}
function eliminarCategoria(idCategoria){
    idCategoria = parseInt(idCategoria);
    if(idCategoria < 1){
        swal("Agrega una  id de categoria n_n")
        return false;
    }else{
        swal({
            title: "¿Estas seguro de eliminar esta categoria?",
            text: "una vez eliminada no podra recuperarse",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type:"POST",
                    data:"idCategoria=" + idCategoria,
                    url:"../procesos/categorias/eliminarCategoria.php",
                    success:function(respuesta){
                        respuesta = respuesta.trim();
                        if(respuesta == 1){
                            $('#tablaCategoria').load("categorias/tablaCategoria.php");
                            swal("Eliminado con Exito", {
                                icon: "success",
                                });
                        }else{
                            swal("U_U","No se pudo al eliminar","Error");
                        }
                    }
                });
            }
            });
    }
}