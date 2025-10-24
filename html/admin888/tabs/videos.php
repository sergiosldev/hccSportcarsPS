<?php	
	include_once(dirname(__FILE__).'/../../config/config.inc.php');	
	//die(dirname(__FILE__).'/../../config/config.inc.php');
	session_start();    



	$datos_video = new Video();
	
	$base_scripts='/admin888/tabs/scripts/';

	$videos=$datos_video->getVideos();

	?>
	 
	
     <script type="text/javascript" src="tabs/js/ajax_load.js"></script>
     <script type="text/javascript" src="tabs/js/ajax_load_post.js"></script>
		
	Link:<input id="link_video" type="text"\>&nbsp;&nbsp;Título:<input id="titulo" type="text"\><input type="button" value="Agregar" onclick="agregar_video($('#link_video').val(),$('#titulo').val());"\>
	<p></p>
	<div id="lista_videos">                                                          
	<?php                             

		$htmlvideos=$datos_video->htmlVideos($videos);
		echo($htmlvideos);
	?>                                                                
	</div>          
	
<script type="text/javascript">
	function cambiar_posicion_video(posicion,direccion,id_video)   
	  {
		var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1';                                                            
		var dades='';
		dades += '&posicion='+posicion;
		dades += '&direccion='+direccion;
		dades += '&id_video='+id_video;
		var r=ajax.load('<?php echo($base_scripts);?>modificar_videos.php?reposicionar=1'+dades+aleatorio);
		$('#lista_videos').html(r);
	  }  

	function agregar_video(link_video,titulo)   
	  {
	    var dades='&link_video='+link_video;
		dades=dades+'&titulo='+titulo;
		var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1';      
			
		var r=ajax.load('<?php echo($base_scripts);?>modificar_videos.php?nuevo=1'+dades+aleatorio);
		$('#lista_videos').html(r);
	  }  
	  
	function borrar_video(id_video)   
	  {
		var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1';                                                            
		var dades='&id_video='+id_video;
		var r=ajax.load('<?php echo($base_scripts);?>modificar_videos.php?borrar=1&id_video='+id_video+aleatorio);
		$('#lista_videos').html(r);
	  }  
	  
</script>	