<div id="listar_ficheros" style="display:none;float:left;width:100%;" >
    <div id='form_ficheros' style='text-align:left;padding:10px; background:#fff;'>
    <fieldset>
    <legend>Listado ficheros cupones </legend>
    <div id="msg_error"></div>  
    <FORM ACTION="javascript:;" onsubmit="" METHOD="POST" id="frm_ficheros" name="frm_ficheros">
          <table >
            <?php
            $path = $_SERVER['DOCUMENT_ROOT'].'/cupones/';
       
            //$path = '/cupones';
            $dir=opendir($path);

            //$dir = '/cupones/';
            while ($file = readdir($dir))
            {
            if ($file != "." && $file != "..")
            {
            echo "<TR><TD  nowrap><a style='color:#000000 !important;' href='../cupones/".$file."'>".$file."</a></TD></TR>";
            }
            }
            closedir($dir);
            ?>
            <!---<tr><td colspan="2" class="cabecera" align="left">Número de cheque</td></tr>
            <tr>
                <td><br><span class="label_">Cheque</span><span style="color:#f00"></span></td>
                <td><br><INPUT TYPE="text" NAME="cupon" id="cupon"></td>
                <td  align="right" style="vertical-align:bottom;"><INPUT id="boton_buscar" name="boton_buscar" TYPE="submit" class="boto" value="Buscar" > </td>
            </tr>
--->

           </table>
           <input type="hidden" id="id_establecimien" name="id_establecimien">
      <!-- <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span> -->
    </FORM> 
    </fieldset>
    </div>
</div>
