<?php 
include('config_events.php');
include_once(dirname(__FILE__).'/../../../../config/config.inc.php');


function _positionJS()
{
    
    return '<script type="text/javascript">
            
            function hideLink()
            {
                $(".position-cell").html("<img src=\"'._PS_IMG_.'loader.gif\" alt=\"\" />");

            }
            </script>';
}


?>

<table cellspacing="0" cellpadding="0" class="table">

      <tr>
        <th style="width: 100px;">Imagen</th>
        <th>&nbsp;</th>
        <th>Posición</th>
        <th>Portada</th>
        <th>Acción</th>
      </tr>
      
      <?php
        $id_oferta=$_GET['id_oferta'];
        $im = new ImagenOferta($id_oferta,3);
        $imagenes = $im->getImages(3, $id_oferta);     
        $imagenesTotal = $im->getImagesTotal($id_oferta);
        //echo($id_oferta.'<br>');var_dump($imagenes);die;
      foreach ($imagenes AS $k => $imagen)
        {
        echo _positionJS();
      echo
      '<tr>
        <td style="padding: 4px;"><a href="../../img/o/'.$id_oferta.'-'.$imagen['id_image_oferta'].'.jpg" target="_blank"> 
        <img src="../../img/o/'.$id_oferta.'-'.$imagen['id_image_oferta'].'-small.jpg?ale='.rand(0,50000).'"
        alt="'.htmlentities(stripslashes($imagen['legend']), ENT_COMPAT, 'UTF-8').'" title="'.htmlentities(stripslashes($imagen['legend']), ENT_COMPAT, 'UTF-8').'" /></a></td>
        <td class="center">'.intval($imagen['position']).'</td>
        <td class="position-cell">
        ';
         

        if ($imagen['position'] == 1)
        {
            echo '[ <img src="../../img/admin/up_d.gif" alt="" border="0"> ]';
            if ($imagen['position'] == $imagenesTotal)
                echo '[ <img src="../../img/admin/down_d.gif" alt="" border="0"> ]';
            else
                echo '[ <a  href="javascript:cambiar_posicion(1,1,'.$imagen['id_image_oferta'].');"><img src="../../img/admin/down.gif" alt="" border="0"></a> ]';
        
        }
        elseif ($imagen['position'] == $imagenesTotal) 
            echo '
                [ <a href="javascript:cambiar_posicion('.$imagen['position'].',0,'.$imagen['id_image_oferta'].');"><img src="../../img/admin/up.gif" alt="" border="0"></a> ]
                [ <img src="../..&img/admin/down_d.gif" alt="" border="0"> ]';
        else
            echo '
                [ <a  href="javascript:cambiar_posicion('.$imagen['position'].',0,'.$imagen['id_image_oferta'].');""><img src="../../img/admin/up.gif" alt="" border="0"></a> ]
                [ <a  href="javascript:cambiar_posicion('.$imagen['position'].',1,'.$imagen['id_image_oferta'].');""><img src="../../img/admin/down.gif" alt="" border="0"></a> ]';
        echo '
            </td>
            <td class="center"><a href="javascript:editar_imagen_oferta('.$imagen['id_image_oferta'].','.$id_oferta.',\''.$imagen['legend'].'\','.($imagen['cover'] ?0:1).','.$imagen['position'].');id_(\'guardar_imagen\').click();"><img src="../../img/admin/'.($imagen['cover'] ? 'enabled.gif' : 'forbbiden.gif').'" alt="" /></a></td>
            <td class="center">
                  <a href="javascript:editar_imagen_oferta('.$imagen['id_image_oferta'].','.$id_oferta.',\''.$imagen['legend'].'\','.$imagen['cover'].','.$imagen['position'].');"><img src="../../img/admin/edit.gif" alt="Modificar imagen"/></a>
                  <a href="javascript:borrar_imagen('.$imagen['id_image_oferta'].','.$id_oferta.');"><img src="../../img/admin/delete.gif" alt="Eliminar esta imagen" title="Eliminar esta imagen" /></a>
            </td>
       </tr>';
       
              }
 
?>
    </table> 
    

