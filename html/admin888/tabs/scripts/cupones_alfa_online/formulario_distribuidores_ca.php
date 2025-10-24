

    <div id="alta_distribuidor_oferta_ca" style="display:none;float:left;width:100%;"  >
        <div id='form_distribuidor_ca' style='text-align:left;padding:10px; background:#fff;'>
            <fieldset>
            <legend id='titulo_formulario_ca'></legend>
            <FORM ACTION="javascript:;" onsubmit="envia_formulario_distribuidor(id_('id_oferta_distribuidor_ca').value)" METHOD="POST" id="form_alta_distribuidor_ca" name="form_alta_distribuidor_ca">
            <table>
                <tr> 
                    <td align="left" valign="top">
                        <table>
                            <tr><td colspan="2" class="cabecera" align="left">Datos del Distribuidor</td></tr>     
                            <tr>
                                <td><br><span class="label_">Empresa</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="nombre_ca" id="nombre_ca" class="input"></td>
                            </tr>
                            <tr>
                                <td><br><span class="label_">Usuario</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="usuario_ca" id="usuario_ca" class="input"></td>
                            </tr>
                           <tr>
                                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="password_ca" id="password_ca" class="input"></td>
                           </tr>
                           <tr>
                                <td><br><span class="label_">Email</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="email_oferta_ca" id="email_oferta_ca" class="input"></td>
                           </tr>
                            <tr>
                                <td><br><span class="label_">Persona Contacto</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="nombre_contacto_ca" id="nombre_contacto_ca" class="input"></td>
                            </tr>
                            <tr style="display:none;">
                                <td><br><span class="label_">Apellidos Contacto</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="apellidos_contacto_ca" id="apellidos_contacto_ca" class="input"></td>
                            </tr>
                           <tr>
                                <td><br><span class="label_">Teléfono</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="telefono_ca" id="telefono_ca" class="input"></td>
                           </tr>
                           <tr>
                                <td><br><span class="label_">Dirección</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="direcciond_ca" id="direcciond_ca" class="input"></td>
                           </tr>
                           <tr>
                                <td><br><span class="label_">Código postal</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="cpostal_ca" id="cpostal_ca" class="input"></td>
                           </tr>
                           <tr>
                                <td><br><span class="label_">Ciudad</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="ciudad_ca" id="ciudad_ca" class="input"></td>
                           </tr>
                           <tr>
                                <td><br><span class="label_">Nif</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="nif_ca" id="nif_ca" class="input"></td>
                           </tr>
                           <tr>
                               <td>
                                <INPUT TYPE="hidden" id="edicio_distribuidor_ca" NAME="edicio_distribuidor_ca" value="false" >
                                <INPUT TYPE="hidden" id="id_distribuidor_ca" NAME="id_distribuidor_ca" >
                                <INPUT TYPE="hidden" id="id_oferta_distribuidor_ca" NAME="id_oferta_distribuidor_ca" value="0">
                                <INPUT TYPE="hidden" id="desde_cupones_ca" NAME="desde_cupones_ca" value="0">   
                               </td>
                           </tr>
                           <tr>
                               <td colspan="2">            
                                   <div id="msg_error_distribuidores" style="color:#f00;font-size:18px"></div>  
                               </td>
                           </tr>
                        </table>
                    </td>
                </tr>    
                <tr>
                    <td><br><br></td>
                </tr>
               <tr id="botones_usuario"> 
               <td colspan="2" align="right"><INPUT TYPE="submit" class="boto" value="Guardar" > <INPUT TYPE="Reset" class="boto" value="Limpia"> </td>
               </tr>
            </table>
          
               <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span>
            </FORM> 
            </fieldset>
        </div>
    </div>



