

    <div id="alta" style="display:none;float:left;width:100%;"  >
        <div id='form_est' style='text-align:left;padding:10px; background:#fff;'>
            <fieldset>
            <legend id='titulo_formulario'></legend>
            <div id="msg_error"></div>  
            <FORM ACTION="javascript:;" onsubmit="envia_formulari_estab()" METHOD="POST" id="form_alta_estab" name="form_alta_estab">
            <table><tr><td align="left" valign="top">
                  <table >
                    <tr><td colspan="2" class="cabecera" align="left">Datos del Establecimiento</td></tr>     
                   <tr>
                    <td><br><span class="label_">Nombre</span><span style="color:#f00"></span></td>
                    <td><br><INPUT TYPE="text" NAME="nombre" id="nombre" class="input"></td>
                   </tr>
                   <tr>
                    <td><span class="label_">Nombre Contacto</span><span style="color:#f00"></span></td>
                    <td><INPUT TYPE="text" NAME="nombre_contacto" id="nombre_contacto" class="input"></td>
                   </tr>
                   <tr>
                    <td><span class="label_">Apellidos Contacto</span><span style="color:#f00"></span></td>
                    <td><INPUT TYPE="text" NAME="apellidos_contacto" id="apellidos_contacto" class="input"></td>
                   </tr>
                   <tr>
                    <td><span class="label_">Dirección</span><span style="color:#f00"></span></td>
                    <td><INPUT TYPE="text" NAME="direccion" id="direccion" class="input"></td>
                   </tr>
                   <tr>
                    <td><span class="label_">Email</span><span style="color:#f00" ></span></td>
                    <td><INPUT TYPE="text" NAME="email" id="email" class="input"></td>
                    </tr>
                    <tr>
                    <td valign="top"><span class="label_">Teléfono</span><span style="color:#f00"></span></td>
                    <td >
                       <INPUT TYPE="text" NAME="telefono" id="telefono"  class="input">
                       <INPUT TYPE="hidden" id="edicio_estab" NAME="edicio_estab" value="false" >
                       <INPUT TYPE="hidden" id="id_establecimiento" NAME="id_establecimiento" >
                       <INPUT TYPE="hidden" id="ciudad" NAME="ciudad" value='' >
                   </td>
                   <tr>
                    <td><span class="label_">NIF</span><span style="color:#f00"></span></td>
                    <td><INPUT TYPE="text" NAME="nif" id="nif"  class="input"></td>
                   </tr>
        
                   </tr>
                   </table>
               </td>
               <td align="left" valign="top">
                   
                   <table style="display:inline">
                   <tr><td colspan="2" align="left" class="cabecera" ></td></tr>
                   <tr>
                    <td><br><span class="label_">Usuario</span></td>
                    <td><br><INPUT TYPE="text" NAME="usuario" id="usuario" class="input"></td>
                   </tr>
                   <tr>
                    <td><span class="label_">Constraseña</span></td>
                    <td><INPUT TYPE="text" NAME="password" id="password" class="input"></td>
                   </tr>
                   <tr>
                    <td><span class="label_">Población</span></td>
                    <td><INPUT TYPE="text" NAME="poblacion" id="poblacion" class="input"></td>
                   </tr>
                   <tr>
                    <td><span class="label_">C.P.</span></td>
                    <td><INPUT TYPE="text" NAME="cpostal" id="cpostal" class="input"></td>
                   </tr>
                    <tr>
                    <td><span class="label_">Provincia</span></td>
                    <td>
                        
                        <select class="input" name='provincia' id='provincia' style='width:164px;'>
                            <option value = '0'></option>
                            <?php
                                $sql = " select * from provincias ";
                                $result = mysql_query($sql);  
                                while($r=mysql_fetch_assoc($result))
                                {
                                    echo ("<option value = '".$r['id']."'>".$r['nombre']."</option>");
                                }     
                            ?>
                        
                        </select>
                    </td>
                   </tr>
                   <tr><td><br><br></td></tr>
                   <tr id="botones_establecimiento"> 
                   <td colspan="2" align="right"><INPUT TYPE="submit" class="boto" value="Guardar" > <INPUT TYPE="Reset" class="boto" value="Limpia"> </td>
                   </tr>
                   </table>
               </td>
             </tr>
            </table>
          
               <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span>
            </FORM> 
            </fieldset>
        </div>
    </div>



