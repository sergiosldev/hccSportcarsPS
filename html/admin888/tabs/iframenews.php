					  	<!-- Newsletter -->
	 <script type="text/javascript" src="<?php echo $_REQUEST['base'] ?>admin888/tabs/js/funcs.js"></script>
     <script type="text/javascript" src="<?php echo $_REQUEST['base'] ?>admin888/tabs/js/ajax_load.js"></script>
					
	<script type="text/javascript" src="<?php echo $_REQUEST['base'] ?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
						
	<FORM ACTION="javascript:;" onsubmit="envia_formulari_news()" METHOD="POST" id="form_news" name="form_news">
   
		<div id="newsletter" style='text-align:left;padding:10px; background:#fff;'>
		<p><strong style="background:#b0b0dd;color:#fff;padding:4px;border:1px solid #000">ENVIAR NEWSLETTER</strong></p>
		<p><strong>Mensage</strong></p>
					
		<p><textarea name="newslettereditor" class="newsEditor" id="newslettereditor"  rows="4" cols="50">
			
		</textarea> 
		<br>
		<input type="hidden" name="imagen_news" id="imagen_news" value="<?php echo str_replace('../','',$_REQUEST['image_newsletter']); ?>"/>
		</p>
		<p><input type="submit" name="env" style="width:150px" value="Enviar newsletter" ></p>
		</div>
		
	</FORM>	
	<script>
	function envia_formulari_news()
    {
		
  	//var dades=obtenirDadesForm_xx('form_news');
	var dades='newslettereditor='+encodeURIComponent(tinyMCE.get('newslettereditor').getContent())+
	'&imagen_news='+document.getElementById('imagen_news').value
	var ale='&gg'+(Math.floor(Math.random()*50000))+'=1'
	var r=ajax.load('/admin888/tabs/scripts/ajax.php?'+dades+ale);
	 alert(r);
	/*
var ok=/OK/;
    if (ok.test(r)) { // recarrega graella
	 
	 }
	else {	
	
	}
*/
	 
  }
	</script>
	
	
		<script type="text/javascript">
					tinyMCE.init({
						mode : "textareas",
						theme : "advanced",
						plugins : "safari,pagebreak,style,layer,table,advimage,advlink,inlinepopups,media,searchreplace,contextmenu,paste,directionality,fullscreen",
						// Theme options
						theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
						theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,,|,forecolor,backcolor",
						theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,|,ltr,rtl,|,fullscreen",
						theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,pagebreak",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						theme_advanced_statusbar_location : "bottom",
						theme_advanced_resizing : false,
						content_css : "<?php echo $_REQUEST['base'] ?>themes/prestashop/css/global2.css",
						document_base_url : "<?php echo $_REQUEST['base'] ?>",
						width: "600",
						height: "auto",
						font_size_style_values : "8pt, 10pt, 12pt, 14pt, 18pt, 24pt, 36pt",
						// Drop lists for link/image/media/template dialogs
						template_external_list_url : "lists/template_list.js",
						external_link_list_url : "lists/link_list.js",
						external_image_list_url : "lists/image_list.js",
						media_external_list_url : "lists/media_list.js",
						elements : "nourlconvert",
						entity_encoding: "numeric",
						convert_urls : false,
						language : "es"
						
					});
		</script>
	
	
	
	