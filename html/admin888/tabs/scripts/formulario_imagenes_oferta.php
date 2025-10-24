<?php //die(PS7_ADMIN_DIR.'/../config/config.inc.php');
include_once(dirname(__FILE__).'/../../../config/config.inc.php');
include_once('settings.php');
?>

<script type=text/javascript>
function resultadoUpload(estado, file) {
    var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';    
    id_('msg_error_im').innerHTML=estado;
    
    if (estado==0)
     {
     var id_imagen = id_('id_imagen').value;
     var id_oferta = id_('idoferta').value;
     id_('form_alta_imagen').reset();
     r=ajax.load('<?php echo $base_scripts ?>form_lista_imagenes.php?id_imagen='+id_imagen+'&id_oferta='+id_oferta+ale);    
     id_('lista_imagenes').innerHTML=r;
     reset_imagen();
     }
     else id_('msg_error_im').innerHTML=estado;
} 

  function reset_imagen()
  {
   id_('titulo_im').value='';
   id_('imagen_oferta').value='';
   id_('id_imagen').value='';
   id_('portada').checked=false;
   id_('posicion').value='';
   id_('direccion').value='';
   id_('edicion_imagen').value='alta';
   id_('titulo_formulario_imagen').innerHTML='Nueva imagen';
  }
</script>


<legend id='titulo_formulario_imagen'></legend>
<!-- envia_formulario_imagen(id_('id_imagen').value); -->
<!-- target="iframeUpload" -->
<!-- ajax_imagen_oferta_bd.php -->
<FORM  target="iframeUpload" action="tabs/scripts/ajax_imagen_oferta_bd.php<?php echo('?ale='.rand(0,50000));?>" METHOD="POST" id="form_alta_imagen" name="form_alta_imagen" enctype='multipart/form-data'>
<!-- <input type="hidden" name="tabs" id="tabs" value="0" />-->   
<!-- envia_formulari_oferta(); -->
    <table>
          <tr><td align="left" valign="top">
           <table>
            <tr><td colspan="2" class="cabecera" align="left">Datos de la Imagen</td></tr>     

            <tr><td colspan="2" height="10px;"></td></tr>

            <tr>
            <td style="vertical-align:top;"><span class="label_" style="vertical-align: top;">Fichero</span><span style="color:#f00;">*</span></td>
            <td>
                <input class="input" type="file" id="imagen_oferta" name="imagen_oferta" />
                <p>Formato: JPG, GIF, PNG<br /> (Tamaño <?php echo(_MAX_IMAGE_SIZE_ / 1000);?> Kb max)</p>
            </td>    
           </tr>
           <tr style="display:none;">
                <td><br><span class="label_">Título</span><span style="color:#f00">*</span></td>
                <td><br><INPUT TYPE="text" NAME="titulo_im" id="titulo_im" class="input" value="imagen"></td>
           </tr>

           <tr><td colspan="2" height="10px;"></td></tr>

           <tr>
            <td style="vertical-align:top;"><span class="label_">Portada:</span><span style="color:#f00"></span></td>
            <td><input type="checkbox" size="40" name="portada" id="portada" <?php echo('class="checkbox"'.((isset($_POST['cover']) AND intval($_POST['cover'])) ? ' checked="checked"' : '').' value="1"');?> /><label class="t" for="cover_on"> ¿Usar como portada de la oferta?</label>
            <p> Si quiere seleccionar esta imagen como portada de la oferta</p>
            </td>
           </tr>
            <tr>
            <td>
               <INPUT TYPE="hidden" id="edicion_imagen" NAME="edicion_imagen" value="" >
               <INPUT TYPE="hidden" id="id_imagen" NAME="id_imagen" value="" >
               <INPUT TYPE="hidden" id="idoferta_im" NAME="idoferta_im" value="<?php echo($_GET['id_oferta']);?>" >           
               <INPUT TYPE="hidden" id="posicion" NAME="posicion" value="" >           
               <INPUT TYPE="hidden" id="direccion" NAME="direccion" value="" >           

           </td>
           </tr>
           </table>
       </td>
     </tr>
   <tr><td></td></tr>
   <tr><td><div style="font-size:18px;color:red;" id="msg_error_im" ></div></td></tr>
   <tr> 
   <td colspan="2" align="right">
       <INPUT TYPE="button" class="boto" value="Guardar" id="guardar_imagen" onclick="javascript:submit();"> 
       <INPUT TYPE="button" class="boto" value="Limpia" onclick="javascript:reset_imagen();"> </td>
   </tr>             
   <tr><td colspan="2" style="padding-bottom:10px;"><hr style="width:100%;"/></td></tr>
   </table>
   
   <div id="lista_imagenes">
       <?php include dirname(__FILE__).'/form_lista_imagenes.php';?>                         
   </div>   
 <iframe name="iframeUpload" style="display:none;"></iframe>
 </FORM>            
 <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span>



                        
                    
