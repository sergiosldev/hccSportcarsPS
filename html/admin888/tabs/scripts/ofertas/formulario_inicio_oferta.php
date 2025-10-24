<?php 
	
    include_once(dirname(__FILE__).'/../../../../config/config.inc.php');

    //echo($_POST['texto_inicio']);
    $sql=' SELECT texto FROM ps_inicio ';
    
    $inicio=Db::getInstance()->ExecuteS($sql);
    
    $inicio = $inicio[0];    
    
?> 
<!--        <link href="../../css/admin.css" rel="stylesheet" type="text/css">-->
        <div id='form_inicio' style='display:none;text-align:left;padding:10px; background:#fff;'>
            <fieldset>
                    <legend id='titulo_formulario_inicio'></legend>
                    <FORM ACTION="javascript:envia_formulari_inicio(0);" METHOD="POST" id="form_inicio" name="form_inicio">
                        <table>
                            <tr>
                              <td align="left" valign="top">
                              <table>
                                  <tr><td colspan="2" class="cabecera" align="left"><h2>Texto de la pantalla de inicio</h2></td></tr>     
                                  <tr><td colspan="2" height="10px;"></td></tr>
                                  <tr>
                                    <td><span class="label_">Inicio</span><span style="color:#f00" ></span></td>
                                    <td>
                                    <div class="lang_3" style="display:block;float: left;">                        
                                        <textarea rows="20" cols="80" wrap="hard"  id="texto_inicio" name="texto_inicio"><?php echo($inicio['texto']);?></textarea>
                                    <!-- style="width:600px;height:342px;" -->
                                    </div>
                                    </td>
                                  </tr>
                              </table>
                              </td>
                            </tr>
                            <tr><td></td></tr>
                            <tr><td><div style="font-size:18px;color:red;" id="msg_error_inicio" ></div></td></tr>
                            <tr> 
                                <td colspan="2" align="right"><INPUT id="guardar_inicio" TYPE="submit" class="boto" value="Guardar"> 
                                 <!--<INPUT TYPE="Reset" class="boto" value="Limpia"> --></td>
                            </tr>             
                       </table>
                     </FORM>            
            </fieldset>
        </div>

