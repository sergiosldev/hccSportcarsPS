 <?php

include dirname(__FILE__).'/config_events_new.php';
include dirname(__FILE__).'/funciones_establecimiento.php'; 
include dirname(__FILE__).'/funciones_establecimiento_vista.php';             

$establecimientos = GetEstablecimientos();


//Vista de establecimientos: (deberá psarse a un tpl)
?>
<div id="establecimientos" style="margin-left:24px;">  
    <p class="cabecera" style="font-style:italic;font-size:18px;"><br>Establecimientos<br></p>
    <br>
    <?php
   
    cabecera_establecimientos();
    
    foreach($establecimientos as $e)
      {
    ?>
     <table width="1036px;">
       <tr>
           <td width="80px" class="borderg"><?php echo(implode('/',array_reverse(explode('-',substr($e->fechaAlta,0,10)))));?></td> 
	   
           <td width="150px" class="borderg"><?php echo($e->nombre);?>  </td>
           <td width="120px" class="borderg"><?php echo($e->nombreContacto);?><br><?php echo($e->apellidosContacto);?></td>
           <!-- style="color:#22f;font-weight:bold" -->
           <td width="120px" class="borderg" ><?php echo($e->poblacion);?></td>
           <td  width="80px" class="borderg " align="left" > <?php echo($e->provincia);?></td>
           <td  width="70px" class="borderg " align="left" > <?php echo($e->telefono);?></td>
           <td  width="70px" class="borderg " align="left" > <?php echo($e->email);?></td>
    
           <td align="right" valign="center">
                <a id="activa" href="javascript:borra_establecimiento('<?php echo($e->id);?>')">
                    <img src="<?php echo(URL_ROOT);?>img/esborra.gif"  alt="" />
                </a> 
                <a id="activa" href="javascript:edita('<?php echo($e->id);?>')">
                    <img src="<?php echo(URL_ROOT);?>img/edit.gif"  alt="" />
                </a>
      
       <?php /*
       $marcat=1;
       if($marcat=='1') { ?>
               <a class="_marcat" style=" background: none repeat scroll 0% 0% #f00; border: 0px solid #000; padding: 1px;color:white;" href="javascript:activar_talonarios(<?php echo($e->id);?>);">&nbsp;Activar Talonario&nbsp;</a>
       <?php
       } else {?>
               <a class="_marcat" style=" background: none repeat scroll 0% 0% #0f0; border: 0px solid #000; padding: 1px;color:white;" href="javascriptactivar_talonarios(<?php echo($e->id);?>">&nbsp;Activar Talonario&nbsp;</a>
       <?php } */?>       

       <input class="boton" type="button" onclick="javascript:activar_talonarios(<?php echo($e->id);?>);" value='Mostrar Talonario'>

           </td>
       </tr>
     </table> 
    <?php
    } 
    ?>
</div> <!-- fin div establecimientos -->    
<style>
   .boton {
    background: none repeat scroll 0 0 #888888;
    color: #FFFFFF;
    font-style: italic;
</style>
 

