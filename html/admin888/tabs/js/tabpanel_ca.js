// mts 0511202 Función que cambia los estilos de las pestañas al seleccionar una de ellas.
function CambiarTab(tabIndex,nTabs)
{
    var i;
    for (i=1;i<=nTabs;i++)
    {
        if (i==tabIndex)
        {
            id_('tab'+tabIndex+'_ca').className='tab selected';
            id_('step'+tabIndex+'_ca').style.display='block';
        }
        else
        {
            id_('tab'+i+'_ca').className='tab';
            id_('step'+i+'_ca').style.display='none';
        }
    }
}