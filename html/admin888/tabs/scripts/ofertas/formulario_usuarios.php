

    <div id="alta_usuario_oferta" style="display:none;float:left;width:100%;"  >
        <div id='form_usu' style='text-align:left;padding:10px; background:#fff;'>
            <fieldset>
            <legend id='titulo_formulario'></legend>
            <div id="msg_error"></div>  
            <FORM ACTION="javascript:;" onsubmit="envia_formulario_usuario()" METHOD="POST" id="form_alta_usuario" name="form_alta_usuario">
            <table>
                <tr>
                    <td align="left" valign="top">
                        <table>
                            <tr><td colspan="2" class="cabecera" align="left">Datos del Usuario</td></tr>     
                            <tr>
                                <td><br><span class="label_">Nombre</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="nombre" id="nombre" class="input"></td>
                            </tr>
                           <tr>
                                <td><br><span class="label_">Apellidos</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="apellidos" id="apellidos" class="input"></td>
                           </tr>
                           <tr>
                                <td><br><br><span class="label_"></span><span style="color:#f00"></span></td>
                                <td>Hombre:<INPUT TYPE="radio" NAME="sexo" id="sexoh" value="Hombre" style="margin-right:40px;" checked>
                                Mujer:<INPUT TYPE="radio" NAME="sexo" id="sexom" value="Mujer" style="width:10px">
                                </td>
                           </tr>
                           <tr>
                                <td><span class="label_">Email</span><span style="color:#f00"></span></td>
                                <td><INPUT TYPE="text" NAME="email_oferta" id="email_oferta" class="input"></td>
                           </tr>
                           <tr>
                                <td><br><span class="label_">Contraseña</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="password" id="password" class="input"></td>
                           </tr>
                           <tr>
                                <td><br><span class="label_">F. nacimiento</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="fecha_nacimiento" id="fecha_nacimiento" class="input"></td>
                           </tr>
                           <tr>
                                <td><br><span class="label_">Teléfono</span><span style="color:#f00"></span></td>
                                <td><br><INPUT TYPE="text" NAME="telefono" id="telefono" class="input"></td>
                           </tr>
                           <tr>
                                <td><span class="label_">Dirección</span><span style="color:#f00"></span></td>
                                <td><INPUT TYPE="text" NAME="direccion" id="direccion" class="input"></td>
                           </tr>
                           <tr>
                                <td><span class="label_">Código postal</span><span style="color:#f00"></span></td>
                                <td><INPUT TYPE="text" NAME="cpostal" id="cpostal" class="input"></td>
                           </tr>
                           <tr>
                                <td><span class="label_">Ciudad</span><span style="color:#f00"></span></td>
                                <td><INPUT TYPE="text" NAME="ciudad" id="ciudad" class="input"></td>
                           </tr>
                           <tr>
                               <td>
                                <INPUT TYPE="hidden" id="edicio_usu" NAME="edicio_usu" value="false" >
                                <INPUT TYPE="hidden" id="id_usuario" NAME="id_usuario" >
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



