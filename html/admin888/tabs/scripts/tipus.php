<div>

<fieldset>
  <legend>Herramientas</legend>
  <!--<a target="_blank" href="https://ssl.ols.es/extranet/mysql/?username=motorclubexperie&amp;password=7e1d54b4"> base datos motorclubexperie</a> -->
</fieldset>
<fieldset>
  <a id="ciudad_barcelona" name="ciudad_c" class="boton_menu menu_activo" href="javascript:canvia_ciudad('')">Barcelona</a> 
  
  <a id="ciudad_madrid" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('madrid')">Madrid</a> 
  <a id="ciudad_valencia" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('valencia')">Valencia</a> 
  <a id="ciudad_vitoria" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('vitoria')">Vitoria</a> 
  <a id="ciudad_andalucia" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('andalucia')">Andaluc&iacute;a</a>
  <div style="display:none;"> 
  <a id="ciudad_cantabria" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('cantabria')">Cantabria</a> 
  <a id="ciudad_circuitovendrell" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('circuitovendrell')">Circ. El vendrell</a> 
  <a id="ciudad_circuitomoradebre" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('circuitomoradebre')">Circ. Mora d'Ebre</a> 
  <a id="ciudad_circuitosegovia" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('circuitosegovia')">Circ. Segovia</a> 
  <a id="ciudad_circuitozaragoza" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('circuitozaragoza')">Circ. Zaragoza</a> 
  <a id="ciudad_circuitoandalucia" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('circuitoandalucia')">Circ. Andalucía</a> 
  <a id="ciudad_circuitovalencia" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('circuitovalencia')">Circ. Valencia</a> 
  </div>
  <!--<a id="ciudad_rutas_turisticas" name="ciudad_c" class="boton_menu" href="javascript:canvia_ciudad('rutas_turisticas')">Rutas Tur&iacute;sticas</a>  -->
 <!-- Madrid: <INPUT TYPE="RADIO" NAME="ciudad_c" VALUE="madrid" onclick="canvia_ciudad('madrid')"> 
  Valencia: <INPUT TYPE="RADIO" NAME="ciudad_c" VALUE="valencia" onclick="canvia_ciudad('valencia')">
  Andalucía: <INPUT TYPE="RADIO" NAME="ciudad_c" VALUE="valencia" onclick="canvia_ciudad('andalucia')">
-->
  </fieldset>
<fieldset id="grupo_tipo_eventos">
  <legend>Tipo eventos</legend>	
	<a id="ferrari"  style="margin-right:10px;" class="boton_menu_tipo menu_activo boton_mediano" href="javascript:canvia_tipus('ferrari')">Ferrari 20km</a>
	<a id="_bferrari_" style="margin-right:10px;width:80px;"  class="boton_menu_tipo boton_mediano" href="javascript:canvia_tipus('_bferrari_')">Ferrari 7km</a>
	<a id="lamborghini" style="display:none;margin-right:10px;"  class="boton_menu_tipo boton_grande"  href="javascript:canvia_tipus('lamborghini')">Lamborghini 20km</a>
	<a id="_blamborghini_" style="display:none;margin-right:10;width:116px;"  class="boton_menu_tipo boton_grande"  href="javascript:canvia_tipus('_blamborghini_')">Lamborghini 7km</a>
	<a id="_porsche_"  style="margin-right:10px;"  class="boton_menu_tipo boton_mediano"  href="javascript:canvia_tipus('_porsche_')">Porsche 20km</a>
	<a id="_bporsche_" style="margin-right:10px;"  class="boton_menu_tipo boton_mediano"  href="javascript:canvia_tipus('_bporsche_')">Porsche 7km</a>
	<a id="_corvette_"  style="margin-right:10px;width:99px;"  class="boton_menu_tipo boton_mediano"  href="javascript:canvia_tipus('_corvette_')">Corvette 20km</a>
	<a id="_bcorvette_" style="margin-right:10px;"  class="boton_menu_tipo boton_mediano"  href="javascript:canvia_tipus('_bcorvette_')">Corvette 7km</a>
	<a id="formula" style="display:none;margin-right:10px;"  class="boton_menu_tipo boton_mediano"  href="javascript:canvia_tipus('formula')">Fórmula</a>
    <a id="_buggy_"  style="display:none;display:none;margin-right:10px;"  class="boton_menu_tipo boton_small"  href="javascript:canvia_tipus('_buggy_')">BUGGY</a> 
</fieldset>		     	  
<fieldset id="grupo_tipo_eventos_turisticos"  style="display:none;">
  <legend>Tipo eventos</legend>	
	<a id="ferrari_ruta_turistica1"   class="boton_menu_tipo menu_activo boton_grande2" href="javascript:canvia_tipus('ferrari_ruta_turistica1')">Ferrari BCN (Paseo)</a>
	<a id="ferrari_ruta_turistica2"   class="boton_menu_tipo boton_grande2" href="javascript:canvia_tipus('ferrari_ruta_turistica2')">Ferrari BCN (S.Familia)</a>
	<a id="ferrari_ruta_turistica3"   class="boton_menu_tipo boton_grande2"  href="javascript:canvia_tipus('ferrari_ruta_turistica3')">Ferrari Sitges</a>
	<a id="ferrari_ruta_turistica4"   class="boton_menu_tipo boton_grande2"  href="javascript:canvia_tipus('ferrari_ruta_turistica4')">Ferrari Montserrat</a>
	<a id="lamborghini_ruta_turistica1"   class="boton_menu_tipo boton_grande2" href="javascript:canvia_tipus('lamborghini_ruta_turistica1')">Lamborghini BCN (Paseo)</a>
	<a id="lamborghini_ruta_turistica2"   class="boton_menu_tipo boton_grande2" href="javascript:canvia_tipus('lamborghini_ruta_turistica2')">Lamborghini BCN (S.Familia)</a>
	<a id="lamborghini_ruta_turistica3"   class="boton_menu_tipo boton_grande2"  href="javascript:canvia_tipus('lamborghini_ruta_turistica3')">Lamborghini Sitges</a>
	<a id="lamborghini_ruta_turistica4"   class="boton_menu_tipo boton_grande2"  href="javascript:canvia_tipus('lamborghini_ruta_turistica4')">Lamborghini Montserrat</a>
</fieldset>
</div>