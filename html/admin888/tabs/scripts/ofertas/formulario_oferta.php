<?php   
include_once (dirname(__FILE__).'/../../../../config/config.inc.php');
include_once dirname(__FILE__).'/funciones_ofertas.php'; 

$base_uri = _BASE_URL_;
$base_scripts = _BASE_URL_."admin888/tabs/scripts/ofertas/";
$base_root_scripts = _BASE_URL_."scripts/";
?> 
        <script src="tabs/js/tabpanel.js" type="text/javascript"></script>
        <link type="text/css" rel="stylesheet" href="../../css/tabpane.css" />
        <link href="../../css/admin.css" rel="stylesheet" type="text/css">   
        <script>
            //document.body.style.cursor='default';
        </script>
        <div id='form_ofe' style='text-align:left;padding:10px; background:#fff;'>
            <fieldset>
    
            <div class="dynamic-tab-pane-control tab-pane" id="tabPane1">  
            
            <input type="button" class="boto" name="nueva_oferta" id="nueva_oferta" value ="Nueva Oferta" onclick="nueva_oferta();"><br>  <br>                                
                <div class="tab-row">
                    <h4 class="tab selected" id='tab1'><a href="#" onclick="CambiarTab('',1,2);return(false);">1. Oferta.</a> </h4>
                    <h4 class="tab" id='tab2'><a href="#" onclick="CambiarTab('',2,2);return(false);">2. Imágenes.</a> </h4>
                   <!-- <h4 class="tab" id='tab3'><a href="#" onclick="CambiarTab(3,3);">2. Videos.</a> </h4>-->
                </div>
                <div id="step1" class="tab-page" style="display: block;">
                    <legend id='titulo_formulario_oferta'></legend>

                    <FORM ACTION="javascript:guardar_datos_oferta();" target="frame_oferta" METHOD="POST" id="form_alta_oferta" name="form_alta_oferta">
                        <table>
							  <tr>
								<td align="right" style="padding-bottom:10px;"> <br><INPUT id="guardar_oferta" TYPE="submit" class="boto" value="Guardar" onclick="submit_form_oferta(1);">  </td>
							  </tr>	
		                       <tr><td><div style="font-size:18px;color:red;" id="msg_errorh" ></div></td></tr>
		                       <tr><td></td></tr>

                              <tr>
                              	<td align="left" valign="top">
							     <!--<input type="button" id="opcion_nueva" name="opcion_nueva" value="+" style="float:left;margin-left: 4px;width: 20px;height: 20px;" onclick="add_tab_opcion(this);">-->
								 <div id="lista_opciones">
									 <div class="tab-row">           
										<h4 class="tab selected" id='tabopcion1'><a class="cabecera" align="left" href="#" onclick="CambiarTab('opcion',1,1);">Datos de la oferta</a> </h4>				                	
									 </div> 
                                 </div>
                           		</td>
                         	  </tr>
                       <tr><td></td></tr>
                       <tr><td><div style="font-size:18px;color:red;" id="msg_error" ></div></td></tr>
                       <tr>
                           <td>
                               <textarea style="display:none;" rows="10" cols="80" id="destacados2" name="destacados2"></textarea>
                               <textarea style="display:none;"  rows="10" cols="80" id="condiciones2" name="condiciones2"></textarea>
                               <textarea style="display:none;"  rows="10" cols="80" id="descripcion_cupones2" name="descripcion_cupones2"></textarea>
                           </td>
                       </tr>
                       <tr><td><div style="font-size:18px;color:red;" id="msg_error" ></div></td></tr>
                       <tr>
                           <td>
                               <table width="100%">
                                   <tr>
                                       <td aligh="left" style="padding-bottom:10px;"><INPUT id="boton_vista_oferta" style="visibility:hidden;" TYPE="button" class="boto" value="Vista Previa Oferta" onclick="ver_vista_previa_oferta();" ></td>                            
                                       <td align="right" style="padding-bottom:10px;"> <INPUT id="guardar_oferta" TYPE="submit" class="boto" value="Guardar" onclick="submit_form_oferta(2);"> <INPUT TYPE="Reset" class="boto" value="Limpia"> </td>
                                   </tr>
                               </table>
                           </td>
                       </tr>             
                       </table>
                         <iframe id="frame_oferta" name="frame_oferta" style="display:none;">  
                         </iframe>
                     </FORM>            
                   <span class="label_">Campos obligatorios</span><span style="color:#f00">*</span>
                   </div> <!-- fin tab 1.info -->

                   <div id="step2" class="tab-page" style="display: none;">
                       <?php include_once dirname(__FILE__).'/formulario_imagenes_oferta.php';?> 
                   </div>
                  <!-- <div id="step3" class="tab-page" style="display: none;">
                       <?php //include dirname(__FILE__).'/formulario_videos_oferta.php';?> 
                   </div>-->
           </div><!-- fin tab_panel -->  
            </fieldset>
        <!-- Formulasrio para generar el PDF del cupón vista previa -->
        <form target="_blank" id="form_cupon_pdf" action="" method="POST" >
            <input type="hidden" name = "cupon_pdf" id="cupon_pdf">
        </form>

        </div>

<script>     
    function submit_form_oferta(boton)
    {
        //guardar_datos_oferta(0,0,0);                          
		
        ret=guardar_datos_oferta(boton);               

        if (ret==-1)
        {
            return;
        }                
        
        /*document.body.style.cursor='wait';           
        id_('guardar_oferta').style.cursor='wait';               
        
        document.body.style.cursor='default';
        id_('guardar_oferta').style.cursor='default';
*/
	    var tab_sel =  1;
	
		for (i=1;i<=id_('nopciones').value;i++)
		{

			if (id_('tabopcion'+i).className.indexOf('selected')!=-1)
				tab_sel = i;
			
		}
		
		 edita_oferta(id_('idoferta').value,'',4);
		 CambiarTab('opcion',tab_sel,id_('nopciones').value);

    }
    //function guardar_datos_oferta(nlineas_destacados,nlineas_condiciones,nlineas_descripcioncupones)
    function guardar_datos_oferta(boton)     
    {
		var num_opciones;
        if (id_('nopciones')!=null) num_opciones =id_('nopciones').value;
        else num_opciones = 0;  
                   
        id_('fecha_inicio').value='<?php echo(strftime( "%d/%m/%Y %H:%M:%S", time() ));?>';
        var ret=envia_formulari_oferta(id_('idoferta').value,num_opciones,boton);
        
		return ret;
    }

    function unloadTinyMCE()
    {
	    if(typeof(tinyMCE) !== 'undefined')
	    {
	    tinymce.each(tinyMCE.editors, function(e) {
	    if(typeof(e) !== 'undefined')
	    {
	    tinymce.remove(e);
	    }
	    });
	    }
    }
    function strip_tags(cadena)
    {
        var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
        dades = 'cadena='+encodeURIComponent(cadena);
        
        r=ajax_post.load('<?php echo $base_scripts ?>stripHTML.php',dades+ale); 

        return (r);
    }

    function strip_tags_all(cadena)
    {
        var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
        dades = 'cadena='+encodeURIComponent(cadena);
        
        r=ajax_post.load('<?php echo $base_scripts ?>stripHTML.php',dades+'&all=1'+ale); 
        return (r);
    }

    function ver_vista_previa_cupon(id_opcion)
    {
        var ale='&gg'+(Math.floor(Math.random()*50000))+'=1';
        id_('form_cupon_pdf').action='../scripts/generar_pdf_cupon.php?id_oferta='+id_('idoferta').value+'&id_opcion_oferta='+id_opcion+'&vista_previa=1'+ale;
        id_('form_cupon_pdf').submit();
    }

    function ver_vista_previa_oferta()
    {
		//id_('form_cupon_pdf').target='_blank';
        id_('form_cupon_pdf').action='<?php echo($base_uri);?>/detalle-oferta/'+id_('idoferta').value+'-1-oferta.html';
        id_('form_cupon_pdf').submit();
    }

	function del_tab_opcion(id_opcion,elem)
	{
		var numopciones;
		if (id_('nopciones') != null) numopciones = id_('nopciones').value;
		else numopciones = 0;
	
		
	   var tab_sel =  1;
	
		for (i=1;i<=id_('nopciones').value;i++)
		{

			if (id_('tabopcion'+i).className.indexOf('selected')!=-1)
				tab_sel = i;
			
		}
	
		<?php
			$texto = utf8_encode('La opci�n va a ser eliminada. �Est� seguro?');
		?>
        document.body.style.cursor='wait';
		if(confirm('<?php echo($texto);?>'))
		{
		edita_oferta(id_('idoferta').value,0,2,id_opcion);
		}
		CambiarTab('opcion',parseInt(tab_sel)-1,parseInt(numopciones)-1);
		document.body.style.cursor='default';
		  
	}	
	
     
	function add_tab_opcion(elem)
	{
		var numopciones=1;
        document.body.style.cursor='wait';
        elem.style.cursor='wait';
		

	 		
		if (id_('nopciones') != null) numopciones = id_('nopciones').value;
		

		var tab_sel = parseInt(numopciones)+1;
		
		if (id_('idoferta').value=='')
		{ 
			alert('<?php echo(utf8_encode('No puede a�adir una opci�n porque los datos de la oferta no se han guardado'));?>');
		}
		else if (numopciones>0)
		{
			if (numopciones>1)
			{	
				if (id_('idopcion'+numopciones).value=='')
				{
				alert('<?php echo(utf8_encode('No puede a�adir una opci�n si existe todav�a alguna con los datos sin guardar'));?>');			
				}
				else 
				{
					edita_oferta(id_('idoferta').value,0,1);
				}
			}	
			else
				{	
				edita_oferta(id_('idoferta').value,0,1);
				}
			
		 //else nueva_opcion_oferta(id_('idoferta').value);

		}
		else 
		{
		
		//nueva_opcion_oferta(id_('idoferta').value);
		edita_oferta(id_('idoferta').value,0,1);
		
		}
		//alert('tabsel '+tab_sel);
		CambiarTab('opcion',tab_sel,id_('nopciones').value);
        document.body.style.cursor='default';
        elem.style.cursor='default';
		
		
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

