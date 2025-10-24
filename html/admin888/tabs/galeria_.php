<?php
?>

<table width="300" border="0">
    <tbody><tr>
        <td align="left"  class="tt">
        <a style="margin-left: 1px; font-size: 14px; text-decoration: none; opacity: 0.9;" class="link_form" href="javascript:slides_('fe')">FERRARI</a> 
	
        </td>
		
		<td align="left" class="tt">
        <a style="margin-left: 1px; font-size: 14px; text-decoration: none; opacity: 0.9;" class="link_form" href="javascript:slides_('po')">PORSCHE</a>

		</td>
        <td align="left"  class="tt">
        <a style="margin-left: 1px; font-size: 14px; text-decoration: none; opacity: 0.9;" class="link_form" href="javascript:slides_('la')">LAMBORGHINI</a>
	
        </td>
        <td align="left"  class="tt">
        <a style="margin-left: 1px; font-size: 14px; text-decoration: none; opacity: 0.9;" class="link_form" href="javascript:slides_('lo')">LOTUS</a>
	
        </td>
    </tr>
</tbody></table>
<br>

<div class="fe" style="display:none;">
  <iframe   name="iframe" frameborder="0" marginwidth="0" marginheight ="0"  src="tabs/upload_clase.php?taula=Ferrari" style="border:0px solid #bbb;width:100%;height:500px" ></iframe>
</div>
<div class="po" style="display:none;">  
  <iframe   name="iframe" frameborder="0" marginwidth="0" marginheight ="0"  src="tabs/upload_clase.php?taula=Porsche" style="border:0px solid #bbb;width:100%;height:500px" ></iframe>
</div>
<div class="la" style="display:none;">
  <iframe   name="iframe" frameborder="0" marginwidth="0" marginheight ="0"  src="tabs/upload_clase.php?taula=Lamborghini" style="border:0px solid #bbb;width:100%;height:500px" ></iframe>
</div>
<div class="lo" style="display:none;">
  <iframe   name="iframe" frameborder="0" marginwidth="0" marginheight ="0"  src="tabs/upload_clase.php?taula=Lotus" style="border:0px solid #bbb;width:100%;height:500px" ></iframe>
</div>
<script>
	function ocultaslides_()
  {
	  $('.fe').slideUp('slow');
	  $('.po').slideUp('slow');
	  $('.la').slideUp('slow');
	  $('.lo').slideUp('slow');
}	  
function slides_(idf)
  {
 switch(idf)
   {
   	case 'fe':
	  $('.fe').slideDown('slow');
	  $('.po').slideUp('slow');
	  $('.la').slideUp('slow');
	  $('.lo').slideUp('slow');
	break;
    case 'po':
	  $('.fe').slideUp('slow');
	  $('.po').slideDown('slow');
	  $('.la').slideUp('slow');
	  $('.lo').slideUp('slow');	  
	break;
	case 'la':
	  $('.fe').slideUp('slow');
	  $('.po').slideUp('slow');
	  $('.la').slideDown('slow');
	  $('.lo').slideUp('slow');	  
	break;
   case 'lo':
	  $('.fe').slideUp('slow');
	  $('.po').slideUp('slow');
	  $('.la').slideUp('slow');
	  $('.lo').slideDown('slow');	  
	break;
   }
  }
setTimeout("slides_('fe')",2500); 

</script>
<style>
	.link_form{
		padding:3px;
		border:1px solid #999;
	}
	
</style>

