// mts 0511202 Función que cambia los estilos de las pestañas al seleccionar una de ellas.
function CambiarTab(name,tabIndex,nTabs)
{
    var i;
    var clase;
    if (name=='opcion') clase = 'tab sub';
    else clase = 'tab';
    
	
	var scr = window.pageYOffset;
	for (i=1;i<=nTabs;i++)
    {
        if (i==tabIndex)
        {
		
			id_('tab'+name+tabIndex).className=clase+' selected';
            id_('step'+name+tabIndex).style.display='block';
			
        }
        else
        {
			id_('tab'+name+i).className=clase;
            id_('step'+name+i).style.display='none';
		
        }
    }
	window.pageYOffset = scr;
		
}