<?php 

include dirname(__FILE__).'/funciones_ofertas_ca.php'; 
include_once(dirname(__FILE__).'/../../../../scripts/generar_pdf_cupon_alfa_online.php');
$base_scripts = "http://www.motorclubexperience.com/admin888/tabs/scripts/";
$base_root_scripts = "http://www.motorclubexperience.com/scripts/";
 
?> 
        <script src="tabs/js/tabpanel_ca.js" type="text/javascript"></script>
        <link type="text/css" rel="stylesheet" href="../../css/tabpane.css" />
        <link href="../../../../css/admin.css" rel="stylesheet" type="text/css">
        <script>
            document.body.style.cursor='default';
        </script>
        <script type="text/javascript">
          function resultadoUploadCA(estado, file) 
          {
            var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';    
            id_('msg_error_im_ca').innerHTML=estado;
            if (estado==0)
             {
             var id_imagen = id_('id_imagen_ca').value;
             var id_oferta = id_('idoferta_ca').value;
             id_('form_alta_imagen_ca').reset();
             r=ajax.load('<?php echo $base_scripts_ca ?>form_lista_imagenes_ca.php?id_imagen='+id_imagen+'&id_oferta='+id_oferta+ale);     
             id_('lista_imagenes_ca').innerHTML=r;
             reset_imagen();
             }
             else id_('msg_error_im_ca').innerHTML=estado;

          }        
        </script>        
        <div id='form_ofe' style='text-align:left;padding:10px; background:#fff;'>
            <fieldset>
    
            <div class="dynamic-tab-pane-control tab-pane" id="tabPane1">
            
            <input type="button" class="boto" name="nueva_oferta_ca" id="nueva_oferta_ca" value ="Nueva Oferta" onclick="nueva_oferta();"><br>  <br>                                
                <div class="tab-row">
                   <!-- <script type="text/javascript">
                                $(document).ready(function() {
                                    id_language = 3;    
                                    languages = new Array();
                                    languages[0] = {
                                        id_lang: 3, 
                                        iso_code: 'es', 
                                        name: 'Espa&amp;ntilde;ol (Spanish)'
                                    };
                                    displayFlags(languages, id_language, 0);
                                });
                    </script> 
                    -->                   
                    <h4 class="tab selected" id='tab1_ca'><a href="#" onclick="CambiarTab(1,2);">1. Oferta.</a> </h4>
                    <h4 class="tab" id='tab2_ca'><a href="#" onclick="CambiarTab(2,2);">2. Imágenes.</a> </h4>
                </div>
                <div id="step1_ca" class="tab-page" style="display: block;">
                    <legend id='titulo_formulario_oferta_ca'></legend>
                    
                    <FORM ACTION="javascript:;" target="frame_oferta_ca" METHOD="POST" id="form_alta_oferta_ca" name="form_alta_oferta_ca">
<!--                    <FORM ACTION="tabs/scripts/calculo_lineas.php" target="frame_oferta" METHOD="POST" id="form_alta_oferta" name="form_alta_oferta">-->
                    <!--<input type="hidden" name="tabs" id="tabs" value="0" />   
    <!-- envia_formulari_oferta(); -->
                        <table>
                              <tr><td align="left" valign="top">
                               <table >
                                <tr><td colspan="2" class="cabecera" align="left">Datos de la Oferta</td></tr>     
                                <tr>
                                <td><br><span class="label_">Título</span><span style="color:#f00">*</span></td>
                                <td><br><INPUT TYPE="text" NAME="titulo_ca" id="titulo_ca" class="input" style="width:100%;" value=""></td>
                               </tr>
            
                               <tr><td colspan="2" height="10px;"></td></tr>
             
                               <tr>
                                <td><span class="label_">Subtítulo</span><span style="color:#f00"></span></td>
                                <td><INPUT TYPE="text" NAME="subtitulo_ca" id="subtitulo_ca" class="input"  style="width:100%;" value=""></td>
                               </tr>
            
                               <tr><td colspan="2" height="10px;"></td></tr>
            
                               <tr>
                                <td><span class="label_">Id Interno</span><span style="color:#f00" >*</span></td>
                                <td><INPUT TYPE="text" NAME="idinterno_ca" id="idinterno_ca" class="input" value=""></td>
                               </tr>
            
                               <tr><td colspan="2" height="10px;"></td></tr>
            
                               <tr>
                                <td><span class="label_">Destacados</span><span style="color:#f00" ></span></td>
                                <td>
                                <div class="lang_3" style="display:block;float: left;">                        
                                    <textarea type="text"  style="width:600px;height:342px;" wrap="hard" class="rte"  id="destacados_ca" name="destacados_ca"></textarea>
                                </div>
                                <!-- rows="10" cols="80" -->
                                </td>
                               </tr>
            
                               <tr><td colspan="2" height="10px;"></td></tr>
            
                               <tr>
                                <td><span class="label_">Condiciones</span><span style="color:#f00" ></span></td>
                                <td>
                                <div class="lang_3" style="display:block;float: left;">                        
                                    <textarea  wrap="hard" class="rte" rows="10" cols="80" id="condiciones_ca" name="condiciones_ca"></textarea>
                                </div>
                                </td>
                               </tr>
            
                               <tr><td colspan="2" height="10px;"></td></tr>
            
                               <tr>
                                <td><span class="label_">Descripción</span><span style="color:#f00" ></span></td>
                                <td>
                                <div class="lang_3" style="display:block;float: left;">                        
                                    <textarea  wrap="hard" class="rte" rows="10" cols="80" id="descripcion_ca" name="descripcion_ca"></textarea>
                                </div>
                                </td>
                               </tr>
                               <tr><td colspan="2" height="10px;"></td></tr>
<!--                               <tr>
                               <td style="padding-left:110px;height:50px;" colspan="2"><input type="button" style="width:50px;padding:2px;background-color:#787878;border:1px solid #000000;color:#FFFFFF;" onclick="tinyMCE.get('descripcion_cupones').setContent(stripHTML(tinyMCE.get('descripcion').getContent()));" value="Copiar descripción"></td>    
                               </tr>
-->
                               <tr>
                                <td><span class="label_">Descripción <br>Cupones</span><span style="color:#f00" ></span></td>
                                <td>
                                <div class="lang_3" style="display:block;float: left;">                        
                                    <textarea wrap="hard" class="rte" rows="10" cols="80" id="descripcion_cupones_ca" name="descripcion_cupones_ca"></textarea>
                                </div>
                                </td>
                               </tr>
                               <tr><td colspan="2" height="10px;"></td></tr>
                               <tr>
                                <td><span class="label_">Link Video</span></td>
                                <td>
                                <div class="lang_3" style="display:block;float: left;">                        
                                    <input style="width:590px;" type="text" id="link_video_oferta_ca" name="link_video_oferta_ca">
                                </div>
                                </td>
                               </tr>
                               <tr><td colspan="2" height="10px;"></td></tr>
                               <tr>
                                <td><span class="label_">Link Video 2</span></td> 
                                <td>
                                <div class="lang_3" style="display:block;float: left;">                        
                                    <input style="width:590px;" type="text" id="link_video_oferta2_ca" name="link_video_oferta2_ca">
                                </div>
                                </td>
                               </tr>
                               
                               <tr>
                                <td><br><br><span class="label_">Cantidad</span><span style="color:#f00" ></span><br><br></td>
                                <td>
                                <div class="lang_3" style="display:block;float: left;">                        
                                <input style="visibility:hidden;" type="text" id="multiple_cantidad_ca" name="multiple_cantidad_ca" value="1"><br>
                                <span  class="label_">Múltiple de 1: </span><INPUT id="multiple_uno_ca" TYPE="RADIO" checked="checked" NAME="multiple_uno_ca" VALUE="Múltiple de 1" onclick="id_('multiple_cantidad_ca').value=1;id_('multiple_dos_ca').checked=false;"> 
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span  class="label_">Múltiple de 2:</span> <INPUT TYPE="RADIO" id="multiple_dos_ca" NAME="multiple_dos_ca" VALUE="Múltiple de 2" onclick="id_('multiple_cantidad_ca').value=2;id_('multiple_uno_ca').checked=false;">
                                </div>
                                <br><br></td>
                               </tr>

            
<?php     
/*    include "../../../js/spellcheck/include.php";   //   "phpspellcheck/include.php" // Full file path to the include.php file in the phpspellcheck Folder
    $mySpell = new SpellCheckButton();
    $mySpell->HiddenButtons="";
    $mySpell->InstallationPath = "../../../js/spellcheck/";   // "/phpspellcheck/" //  Relative URL of phpspellcheck within your site
    $mySpell->Fields = "EDITORS";
    echo $mySpell->SpellImageButton();
*/
?>            
                               <tr><td colspan="2" height="10px;"></td></tr>
            
                               <tr>
                                <td><span class="label_">Precio Valor</span><span style="color:#f00" >*</span></td>
                                <td><INPUT TYPE="text" NAME="precio_valor_ca" id="precio_valor_ca" class="input" value=""></td>
                               </tr>
            
                               <tr><td colspan="2" height="10px;"></td></tr>
            
                               <tr>
                                <td><span class="label_">Descuento (%)</span><span style="color:#f00" >*</span></td>
                                <td><INPUT TYPE="text" NAME="descuento_ca" id="descuento_ca" class="input" value=""></td>
                               </tr>
            
                               <tr><td colspan="2" height="10px;"></td></tr>
            
                               <tr>
                                <td><span class="label_">Ahorro</span><span style="color:#f00" >*</span></td>
                                <td><INPUT TYPE="text" NAME="ahorro_ca" id="ahorro_ca" class="input" value=""></td>
                               </tr>

                               <tr><td colspan="2" height="10px;"></td></tr>
            
                               <tr>
                                <td><span class="label_">Precio Final</span><span style="color:#f00" >*</span></td>
                                <td><INPUT TYPE="text" NAME="precio_final_ca" id="precio_final_ca" class="input" value=""></td>
                               </tr>

                               <tr><td colspan="2" height="10px;"></td></tr>
            
                             <!--  <tr>
                                <td><span class="label_">Precio Oferta</span><span style="color:#f00" ></span></td>
                                <td><INPUT TYPE="text" NAME="precio" id="precio" class="input"></td>
                               </tr>
                             -->
                               <tr><td colspan="2" height="10px;"></td></tr>
            
                               <tr style="display:none;">
                                <td><span class="label_">Fecha Inicio</span><span style="color:#f00" ></span></td>
                                <td><INPUT TYPE="text" disabled NAME="fecha_inicio_ca" id="fecha_inicio_ca" class="input value=""></td>
                               </tr>
            
                               <tr><td colspan="2" height="10px;"></td></tr>
            
                               <tr style="display:none;">
                                <td><span class="label_">Fecha Fin</span><span style="color:#f00" ></span></td>
                                <td><INPUT TYPE="text" NAME="fecha_fin_ca" id="fecha_fin_ca" class="input" value=""></td>
                               </tr>
                                <tr>
                                <td >
                                   <INPUT TYPE="hidden" id="edicio_oferta_ca" NAME="edicio_oferta_ca" value="" >
                                   <INPUT TYPE="hidden" id="idoferta_ca" NAME="idoferta_ca" value="" >
                                   <INPUT TYPE="hidden" id="oferta_activa_ca" NAME="oferta_activa_ca" value="" > 
                                   <!--<INPUT TYPE="hidden" id="cliente_especial_ca" NAME="cliente_especial" value="" >--> 
                               </tr>
                               </table>
                           </td>
                         </tr>
                       <tr><td></td></tr>
                       <tr><td><div style="font-size:18px;color:red;" id="msg_error_ca" ></div></td></tr>
                       <tr>
                           <td>
                               <textarea style="display:none;" wrap="hard" rows="10" cols="80" id="destacados2" name="destacados2"></textarea>
                               <textarea style="display:none;" wrap="hard"  rows="10" cols="80" id="condiciones2" name="condiciones2"></textarea>
                               <textarea style="display:none;" wrap="hard"  rows="10" cols="80" id="descripcion_cupones2" name="descripcion_cupones2"></textarea>
                           </td>
                       </tr>
                       <tr><td><div style="font-size:18px;color:red;" id="msg_error" ></div></td></tr>
                       <tr>
                           <td>
                               <table width="100%">
                                   <tr>
                                       <td aligh="left" style="padding-bottom:10px;"><INPUT id="boton_vista_previa_ca" style="visibility:hidden;" TYPE="button" class="boto" value="Vista Previa Cupón" onclick="ver_vista_previa_cupon_test();" ></td>                            
                                       <td align="right" style="padding-bottom:10px;"> <INPUT id="guardar_oferta_ca" TYPE="submit" class="boto" value="Guardar" onclick="submit_form_oferta();"> <INPUT TYPE="Reset" class="boto" value="Limpia"> </td>
                                   </tr>
                               </table>
                           </td>
                       </tr>             
                       </table>
                         <iframe id="frame_oferta_ca" name="frame_oferta_ca" style="display:none;">  
                         </iframe>
                     </FORM>            
                   <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span>
                   </div> <!-- fin tab 1.info -->

                   <div id="step2_ca" class="tab-page" style="display: none;">
                       <?php include dirname(__FILE__).'/cupones_alfa_online/formulario_imagenes_oferta_ca.php';?> 
                   </div>
           </div><!-- fin tab_panel -->  
            </fieldset>
        <!-- Formulasrio para generar el PDF del cupón vista previa -->
        <form target="_blank" id="form_cupon_pdf" action="" method="POST" >
            <input type="hidden" name = "cupon_pdf" id="cupon_pdf">
        </form>

        </div>


<script>
    function submit_form_oferta()
    {
        document.body.style.cursor='wait';
        id_('guardar_oferta_ca').style.cursor='wait';
        guardar_datos_oferta_ca(0,0,0);
        document.body.style.cursor='default';
        id_('guardar_oferta_ca').style.cursor='default';

    }
    function guardar_datos_oferta_ca(nlineas_destacados,nlineas_condiciones,nlineas_descripcioncupones)     
    {   
        id_('fecha_inicio_ca').value='<?php echo(strftime( "%d/%m/%Y %H:%M:%S", time() ));?>';
        envia_formulari_oferta_ca(id_('idoferta_ca').value,nlineas_destacados,nlineas_condiciones,nlineas_descripcioncupones);  
    }

    function strip_tags(cadena)
    {
        var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
        dades = 'cadena='+encodeURIComponent(cadena);
        
        //alert(dades);
        r=ajax_post.load('<?php echo $base_scripts ?>stripHTML.php',dades+ale); 
        //alert(r);
        return (r);
    }

    function strip_tags_all(cadena)
    {
        var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
        dades = 'cadena='+encodeURIComponent(cadena);
        
        //alert(dades);
        r=ajax_post.load('<?php echo $base_scripts ?>stripHTML.php',dades+'&all=1'+ale); 
        return (r);
    }

    function ver_vista_previa_cupon_test()
    {
        var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
        //id_('form_cupon_pdf').action='../../../../scripts/generar_pdf_cupon_ca.php?id_oferta='+id_('idoferta_ca').value+'&vista_previa=1'+ale;

        id_('form_cupon_pdf').action='../generar_vista_previa_cupon_alfa_test.php?id_oferta='+id_('idoferta_ca').value+'&id_distribuidor='+ale;

        id_('form_cupon_pdf').submit();
    }
</script>

<style>
    table#descripcion_cupones_tbl tr p
    {
    font-family:TimesNewRoman;    
    }
    table#descripcion_cupones_tbl tr.mceFirst,table#descripcion_cupones_tbl tr.mceLast
    {
    font-family:inherit;    
    }
 
</style>

