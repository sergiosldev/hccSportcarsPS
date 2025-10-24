<?php
/** mts 01/05/2012. 
 * Funciones para mover información entre la los objetos de la clase (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */
include_once(dirname(__FILE__).'/../../../../config/config.inc.php');
//include_once(dirname(__FILE__).'/../../../../classes/OfertaCA.php');
//include_once(dirname(__FILE__).'/../../../../classes/Distribuidor.php');
//include_once(dirname(__FILE__).'/../../../../classes/CuponOfertaAC.php');
//include_once(dirname(__FILE__).'/../../../../classes/Db.php');

function GetDistribuidores($inOrden,$inDireccion,$inIdOferta=null,$inFiltros=null)
{
   
    switch ($inOrden)
    {
        case '0':
            $orden = "d.id_distribuidor ";
            $direccion = ($inDireccion=='0')?'ASC':'DESC';
        break;
        case '1':
            $direccion = ($inDireccion=='1')?'ASC':'DESC';
            $orden = "d.usuario ";        
        break;
    }   

    $where = '';
    if ($inFiltros!=null && trim($inFiltros)!='')
    {
    $inFiltros = pSQL($inFiltros);
    $where.= ' and (d.nombre like "%'.$inFiltros.'%" 
               or d.nombre_contacto like "%'.$inFiltros.'%"
               or d.apellidos_contacto like "%'.$inFiltros.'%"
               or concat(d.nombre_contacto," ",d.apellidos_contacto) like "%'.$inFiltros.'%"
               or d.email like "%'.$inFiltros.'%"
               or d.direccion like "%'.$inFiltros.'%"
               or d.poblacion like "%'.$inFiltros.'%"
               or d.telefono like "%'.$inFiltros.'%"
               or d.cpostal like "%'.$inFiltros.'%")';
    }           

    
    if (is_numeric($inFiltros) and strlen($inFiltros)<3) 
    {
        //Mostrará los distribuidores con al menos un cupón vendido.
        if (intval($inFiltros)==0)
            $where = ' and (select count(*) from ps_ofertas_cupones_historico_distribuidores c where c.id_distribuidor = d.id_distribuidor) >0';                              
        //Mostrará los distribuidores sin ningún cupón vendido.
        else if (intval($inFiltros)==-1)
            $where = ' and (select count(*) from ps_ofertas_cupones_historico_distribuidores c where c.id_distribuidor = d.id_distribuidor) = 0';                              
        //Mostrará los distribuidores con el número exacto de cupones pasado en el filtro de búsqueda.
        else 
            $where = ' and (select count(*) from ps_ofertas_cupones_historico_distribuidores c where c.id_distribuidor = d.id_distribuidor) = '.intval($inFiltros);                              
    }  
    
    
    
    if (strlen($inFiltros)==13) //cupón    
    {
        $where .= ' or d.id_distribuidor in (select c.id_distribuidor from ps_ofertas_cupones_historico_distribuidores c where c.cupon like "%'.$inFiltros.'%")';
    }        
        
        
            
    if (!empty($inIdOferta))    
    {
        $sql = "SELECT  d.*,c.*  FROM ps_distribuidores d,ps_ofertas_cupones_distribuidores c WHERE c.id_distribuidor = u.id_distribuidor and c.id_oferta = '".intval($inIdOferta)."' ".$where."  ORDER BY ".$orden.$direccion;
         
        $query=Db::getInstance()->ExecuteS($sql);
    }
    else
    {
        $sql = "SELECT  (select count(*) from ps_ofertas_cupones_historico_distribuidores c where c.id_distribuidor = d.id_distribuidor) cupones,d.*  FROM ps_distribuidores d  where true ".$where." ORDER BY ".$orden.$direccion;
        $query=Db::getInstance()->ExecuteS($sql);
    }
	//die($sql);
//return ($sql);
    $usuarioArray = array();
    Foreach ($query as $row)
    //    while ($row = mysql_fetch_assoc($query))
    {
        $Distribuidor = new Distribuidor(intval($row['id_distribuidor']), pSQL($row['email']),pSQL($row['nombre']),pSQL($row['usuario']),
                                         pSQL($row['password']),pSQL($row['telefono']),pSQL($row['fecha_alta']),pSQL($row['fecha_baja']),
                                         pSQL($row['direccion']),pSQL($row['poblacion']),pSQL($row['cpostal']),null,null,pSQL($row['nombre_contacto']),pSQL($row['apellidos_contacto']));
                                         
        //$Distribuidor = new Distribuidor();                                         
                                         
                                         
                                         
                                                 $Distribuidor->sufijo = '_distribuidores';        
        array_push($usuarioArray, $Distribuidor);
    }
    return $usuarioArray;
}




?>


