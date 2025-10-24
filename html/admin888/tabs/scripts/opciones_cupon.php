<div>

<fieldset>
    <legend>Opciones Cupón</legend>
    <!--Validar Cupones: <INPUT TYPE="RADIO" NAME="ciudad_c" VALUE="" checked="checked" onclick="vista('cupones')"> -->
    Establecimientos: <INPUT TYPE="RADIO" id="lista" NAME="establecimientos" VALUE="lista" onclick="vista('establecimientos')"> 
    Dar de alta un establecimiento: <INPUT id="editar" TYPE="RADIO" NAME="editar" VALUE="editar" onclick="vista('alta_estab')">
</fieldset>
		     	  
</div>


<script>
id_('lista').checked=true;
function vista(nombre)
{
    switch (nombre)
    {
        /*case 'cupones':
            ocultar_lista_estab();
            ocultar_form_estab();
        break;*/
        case 'establecimientos':
            get_lista_establecimientos();
            mostrar_lista_estab();            
            ocultar_form_estab();
            id_('lista').checked=true;
            id_('editar').checked=false;
            id_('id_alta_estab').value = 'false';
        break;
        case 'alta_estab':
            ocultar_lista_estab();
            mostrar_form_estab();
            id_('lista').checked=false;
            id_('editar').checked=true;
            id_('id_alta_estab').value = 'true';
        break;
        default:
            ocultar_form_estab();
            id_('id_alta_estab').value = 'false';
        break;        
    }
}


</script>