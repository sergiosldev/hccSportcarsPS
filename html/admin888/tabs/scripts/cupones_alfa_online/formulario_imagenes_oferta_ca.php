<?php 
include_once(dirname(__FILE__).'/../../../../config/config.inc.php');
include_once(dirname(__FILE__).'/../settings.php');
?>


<legend id='titulo_formulario_imagen_ca'></legend>
<!-- envia_formulario_imagen(id_('id_imagen').value); -->
<!-- target="iframeUpload" -->
<!-- ajax_imagen_oferta_bd.php -->
<FORM  target="iframeUploadCA" action="tabs/scripts/cupones_alfa_online/ajax_imagen_oferta_bd_ca.php<?php echo('?ale='.rand(0,50000));?>" METHOD="POST" id="form_alta_imagen_ca" name="form_alta_imagen_ca" enctype='multipart/form-data'>
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
                <input class="input" type="file" id="imagen_oferta_ca" name="imagen_oferta_ca" />
                <p>Formato: JPG, GIF, PNG<br /> (Tamaño <?php echo(_MAX_IMAGE_SIZE_ / 1000);?> Kb max)</p>
            </td>    
           </tr>
           <tr style="display:none;">
                <td><br><span class="label_">Título</span><span style="color:#f00">*</span></td>
                <td><br><INPUT TYPE="text" NAME="titulo_im_ca" id="titulo_im_ca" class="input" value="imagen"></td>
           </tr>

           <tr><td colspan="2" height="10px;"></td></tr>

           <tr>
            <td style="vertical-align:top;"><span class="label_">Portada:</span><span style="color:#f00"></span></td>
            <td><input type="checkbox" size="40" name="portada_ca" id="portada_ca" <?php echo('class="checkbox"'.((isset($_POST['cover']) AND intval($_POST['cover'])) ? ' checked="checked"' : '').' value="1"');?> /><label class="t" for="cover_on"> ¿Usar como portada de la oferta?</label>
            <p> Si quiere seleccionar esta imagen como portada de la oferta</p>
            </td>
           </tr>
            <tr>
            <td>
               <INPUT TYPE="hidden" id="portada_valor_ca" NAME="portada_valor_ca" value="<?php echo($_POST['cover']);?>" >
               <INPUT TYPE="hidden" id="edicion_imagen_ca" NAME="edicion_imagen_ca" value="" >
               <INPUT TYPE="hidden" id="id_imagen_ca" NAME="id_imagen_ca" value="" >
               <INPUT TYPE="hidden" id="idoferta_im_ca" NAME="idoferta_im_ca" value="<?php echo($_GET['id_oferta']);?>" >           
               <INPUT TYPE="hidden" id="posicion_ca" NAME="posicion_ca" value="" >           
               <INPUT TYPE="hidden" id="direccion_ca" NAME="direccion_ca" value="" >           
           </td>
           </tr>
           </table>
       </td>
     </tr>
   <tr><td></td></tr>
   <tr><td><div style="font-size:18px;color:red;" id="msg_error_im_ca" ></div></td></tr>
   <tr> 
   <td colspan="2" align="right">
       <INPUT TYPE="button" class="boto" value="Guardar" id="guardar_imagen_ca" onclick="javascript:submit();"> 
       <INPUT TYPE="button" class="boto" value="Limpia" onclick="javascript:reset_imagen();"> </td>
   </tr>             
   <tr><td colspan="2" style="padding-bottom:10px;"><hr style="width:100%;"/></td></tr>
   </table>
   
   <div id="lista_imagenes_ca">
       <?php include_once (dirname(__FILE__).'/form_lista_imagenes_ca.php');?>                         
   </div>   
 <iframe name="iframeUploadCA" style="display:none;"></iframe>
 </FORM>            
 <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span>



                        
                    
