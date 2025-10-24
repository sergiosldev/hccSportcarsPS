<script src="tabs/js/tabpanel.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="../../css/tabpane.css" />

<fieldset>
            <div class="dynamic-tab-pane-control tab-pane" id="tabPane1">
            
            <input type="button" class="boto" name="nueva_oferta" id="nueva_oferta" value ="Nueva Oferta" onclick="nueva_oferta();"><br>  <br>                                
                <div class="tab-row">
                    <h4 class="tab selected" id='tab1'><a href="#" onclick="CambiarTab(1,2);">1. Carga Manual.</a> </h4>
                    <h4 class="tab" id='tab2'><a href="#" onclick="CambiarTab(2,2);">2. Carga Autom&aacute;tica.</a> </h4>
                </div>
                <div id="step1" class="tab-page" style="display: block;">
						<?php include dirname(__FILE__).'/formulario_videos_oferta.php';?> 
				</div>		
                <div id="step2" class="tab-page" style="display: block;">
						<?php include dirname(__FILE__).'/formulario_carga_localizadores.php';?> 
				</div>		

</fieldset>