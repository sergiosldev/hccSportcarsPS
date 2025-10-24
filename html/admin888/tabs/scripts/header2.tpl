<!doctype html>    
<html lang="es">
<head>           
    <meta charset="utf-8">     
    <meta http-equiv="x-ua-compatible" content="ie=edge">   
    <title>{$meta_title|escape:'htmlall':'UTF-8'}</title>
	{if isset($meta_description) AND $meta_description}                                                                          
	<meta name="description" content="{$meta_description|escape:html:'UTF-8'}" />     
	{/if}  
	{if isset($meta_keywords) AND $meta_keywords}
	<meta name="keywords" content="{$meta_keywords|escape:html:'UTF-8'}" />
	{/if}
	<meta name="robots" content="{if isset($nobots)}no{/if}index,follow" />       
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /> 
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" href="includes/css/main.css">-->
	{*literal}             
		<script type="text/javascript">
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-54117399-1', 'auto'); 
		  ga('send', 'pageview');
		  
		</script>    
	{/literal*}	 
	<link rel="icon" type="image/vnd.microsoft.icon" href="{$img_ps_dir}favicon.ico" />     
	<link rel="shortcut icon" type="image/x-icon" href="{$img_ps_dir}favicon.ico" />    
	   
	{foreach from=$css_files key=css_uri item=media}   
			<link href="{$css_uri}" rel="stylesheet" type="text/css" media="{$media}" />                             
	{/foreach}    
	
                     
	<script type="text/javascript" src="{$js_dir}js/tools.js"></script>
	<script type="text/javascript">
		var baseDir = '{$content_dir}';
		var static_token = '{$static_token}';
		var token = '{$token}';
		var priceDisplayPrecision = {$priceDisplayPrecision*$currency->decimals};
		var roundMode = {$roundMode};
	</script>
	
 	<script type="text/javascript" src="{$content_dir}js/ajax_load.js"></script>                                                                                                           
	<script type="text/javascript" src="{$content_dir}js/politica_cookies.js"></script>                                                     
	<script type="text/javascript" src="{$content_dir}js/jquery/jquery-1.2.6.pack.js"></script>
	<script type="text/javascript" src="{$content_dir}js/jquery/jquery.easing.1.3.js"></script>
	{if isset($js_files)}
		{foreach from=$js_files item=js_uri}
		<script type="text/javascript" src="{$js_uri}"></script>
		{/foreach}
	{/if}
</head>
	
<body {if $page_name}id="{$page_name|escape:'htmlall':'UTF-8'}"{/if}> 
	{*<div id="fb-root"></div>
	{literal}
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&appId=1483927391879943&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	{/literal*}
	 
	<div class="mobilenav">
		<div class="nav-toggle">
			<span></span>
		</div>
		<div class="nav-items">
				<a href="{$base_dir}#vehiculos">Vehículos</a>       
				<a href="{$base_dir}#servicios">Servicios</a>  
				<a href="{$base_dir}category.php?id_category=2">Ofertas</a>
				<a href="{$base_dir}videos.php">Vídeos</a>    
				<a href="{$base_dir}locs.php">Localización</a>
				<a href="{$base_dir}contact-form.php">Contacto</a>
				<a class="destacado" href="{$base_dir}registro_compra.php?id_oferta=0&compra=0&reservar=1"><img alt="Reservas" src="{$images_dir}calendario.png"> Reservas</a>		</div>
	</div>
    			  
	{include file=$tpl_dir./cabecera.tpl products=$products categoryc=$category page_name=$page_name formulario_consulta=$formulario_consulta assign="imagen_cabecera"}                    
	{assign var="imagen_cabecera" value=$imagen_cabecera|trim}
         
	{if ($product and $category->id_parent!=$id_cat_experiencias) or $page_name=='index' or $formulario_consulta==1} 
	<header class="height75 background parallax"   	
	{else}
	<header class="height50 background parallax"  
	{/if}
			style="background-image:url('{$images_dir}cabeceras/{$imagen_cabecera}')"
			data-img-width="1200" data-img-height="800" data-diff="400">
	{literal}			
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			<script>window.jQuery || document.write('<script src="{/literal}{$scripts_dir}{literal}jquery-1.11.3.min.js"><\/script>')</script>

			<script src="{/literal}{$js_dir}{literal}scripts/parallax.js"></script>
	{/literal}			
			
		<div class="wrapper">
			<div class="logo">
				<a href="{$URL_ROOT}">
					<img src="{$images_dir}logo_{$nombre_emp|replace:' ':''|strtolower|cat:".png" alt="{$nombre_emp}">
				</a>
			</div>
			<nav>
				<a href="{$base_dir}#vehiculos">Vehículos</a>       
				<a href="{$base_dir}#servicios">Servicios</a>  
				<a href="{$base_dir}category.php?id_category=2">Ofertas</a>
				<a href="{$base_dir}videos.php">Vídeos</a>    
				<a href="{$base_dir}locs.php">Localización</a>
				<a href="{$base_dir}contact-form.php">Contacto</a>
				<a class="destacado" href="{$base_dir}registro_compra.php?id_oferta=0&compra=0&reservar=1"><img alt="Reservas" src="{$images_dir}calendario.png"> Reservas</a>
			</nav>
			<div class="award">
				<img src="{$images_dir}nuevaweb.png" width="177" height="49" alt="Estrenamos nueva Web">
				<img src="{$images_dir}award.png" width="180" height="42" alt="Finalistas 2015 E-Commerce Awards España">
				<span class="socialmedia">
					<a href="https://www.youtube.com/channel/UC7g_VTeqrlH64MHJyDFosFQ/videos" target="_blank"><img src="{$images_dir}youtube.png" width="26" height="26" alt="Youtube"></a>
					<a href="https://es-es.facebook.com/motorclubexperience" target="_blank"><img src="{$images_dir}facebook.png" width="26" height="26" alt="Facebook"></a>
				</span>
			</div>
			
			     
			{if $product and $category->id_parent!=$id_cat_experiencias}			
        		<div class="titulo vehiculo">
            		{$product->name}
        		</div>
        		
        	{elseif $inicio==1 and $page_name=='index'}        	
        		<div class="centrado">
            		<div class="titulo">
                		No se trata de velocidad,<br>sinó de <strong>auténticas aceleraciones</strong>
            		</div>
        		</div>
        	{elseif $formulario_consulta==1}
        		<div class="centrado">
            		<div class="titulo">
                		Consultas
            		</div>
        		</div>
        	{/if}
			
		</div>
		<div class="topBar"></div>
	</header>
	
	
