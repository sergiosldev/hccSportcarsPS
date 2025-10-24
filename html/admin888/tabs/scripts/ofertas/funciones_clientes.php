<?php
/** mts 01/05/2012. 
 * Funciones para mover información entre la los objetos de la clase (modelo)
 *  y la base de datos (las consultas, altas y modificaciones se harán a través de éstas)
 */

include_once(dirname(__FILE__).'/../../../../config/config.inc.php');

function GetNumClientes($inOrden,$inDireccion,$inIdOferta=null,$inFiltros=null,$inRegistroInicio=1,$inNRegistrosPagina=100,$inCompraCliente=0)                                              
{    
    switch ($inOrden)         
    {
        case '0':
            $orden = "u.id_usuario ";
            $direccion = ($inDireccion=='0')?'ASC':'DESC';
        break;
        case '1':
            $direccion = ($inDireccion=='1')?'ASC':'DESC';
            $orden = "u.apellidos ";        
        break;
    }   
    
    $where = '';
    
	if ($inFiltros!=null and trim($inFiltros)!='')
    {
    $inFiltros = pSQL($inFiltros);    
    
    
    $where.= ' and (
			   u.nombre like "%'.$inFiltros.'%" 
               or u.apellidos like "%'.$inFiltros.'%" 
               or concat(u.nombre," ",u.apellidos ) like "%'.$inFiltros.'%"
               or u.email like "%'.$inFiltros.'%"
               or u.direccion like "%'.$inFiltros.'%"
               or u.poblacion like "%'.$inFiltros.'%"
               or u.telefono like "%'.$inFiltros.'%"
               or u.cpostal like "%'.$inFiltros.'%"';  
    }           
	
	if (strlen($inFiltros)==13 or strlen($inFiltros)==17) //cupón o transacción               
    {
        $where .= ' or u.id_usuario in (select c.id_usuario from ps_ofertas_cupones_historico c where c.cupon like "%'.$inFiltros.'%" or c.transaccion_compra like "%'.$inFiltros.'%" or c.codigo_reserva like "%'.$inFiltros.'%")';                  
    }      
	
	if ($where != '') $where.=') ';									
                              
    $limit=' limit '.$inRegistroInicio.','.$inNRegistrosPagina;
	$tabla_cupones='';
	if (is_numeric($inFiltros) and strlen($inFiltros)<3) 
    {
        if (intval($inFiltros)==0)
            $where = ' and (select count(*) from ps_ofertas_cupones_historico c where c.id_usuario = u.id_usuario) >0 ';                                    
        else if (intval($inFiltros)==-1)
            $where = ' and (select count(*) from ps_ofertas_cupones_historico c where c.id_usuario = u.id_usuario) = 0  ';                                    
        else 
            $where = ' and (select count(*) from ps_ofertas_cupones_historico c where c.id_usuario = u.id_usuario) = '.intval($inFiltros);                                    
    }                                 
    
	if (intval($inCompraCliente)==1)
		$where .= ' and exists (select 1 from ps_ofertas_cupones_historico c where c.id_usuario = u.id_usuario) ';                                    
	else if (intval($inCompraCliente)==-1)
		$where .= ' and not exists (select 1 from ps_ofertas_cupones_historico c where c.id_usuario = u.id_usuario)  ';                                    
    
  

	$sql = "SELECT count(1) nregs  FROM ps_usuarios u  WHERE true ".$where;       
	//die($sql);
	
	$query=Db::getInstance()->ExecuteS($sql);
	$total_registros = intval($query[0]['nregs']);

    return $total_registros;
}


		
		
function GetClientes($inOrden,$inDireccion,$inIdOferta=null,$inFiltros=null,$inRegistroInicio=1,$inNRegistrosPagina=100,$inCompraCliente=0)
{
    
    switch ($inOrden)
    {
        case '0':
            $orden = "u.id_usuario ";
            $direccion = ($inDireccion=='0')?'ASC':'DESC';
        break;
        case '1':
            $direccion = ($inDireccion=='1')?'ASC':'DESC';
            $orden = "u.apellidos ";        
        break;
    }   
    
    $where = '';
    
	if ($inFiltros!=null and trim($inFiltros)!='')
    {
    $inFiltros = pSQL($inFiltros);    
    
    
    $where.= ' and (
			   u.nombre like "%'.$inFiltros.'%" 
               or u.apellidos like "%'.$inFiltros.'%" 
               or concat(u.nombre," ",u.apellidos ) like "%'.$inFiltros.'%"
               or u.email like "%'.$inFiltros.'%"
               or u.direccion like "%'.$inFiltros.'%"
               or u.poblacion like "%'.$inFiltros.'%"
               or u.telefono like "%'.$inFiltros.'%"
               or u.cpostal like "%'.$inFiltros.'%" ';  
			   
    }           
	
	
    if (strlen(trim($inFiltros))==13 or strlen(trim($inFiltros))==17) //cupón o transacción 
    {
        $where.= ' or u.id_usuario in (select c.id_usuario from ps_ofertas_cupones_historico c where c.cupon like "%'.$inFiltros.'%" or c.transaccion_compra like "%'.$inFiltros.'%" or c.codigo_reserva like "%'.$inFiltros.'%")';  
    }        
	
    if ($where != '') $where.=') ';									
    
	$limit=' limit '.($inRegistroInicio-1).','.$inNRegistrosPagina;
	if (is_numeric($inFiltros) and strlen($inFiltros)<3) 
    {
        
        if (intval($inFiltros)==0)
            $where = ' and (select count(*) from ps_ofertas_cupones_historico c where c.id_usuario = u.id_usuario) >0 ';                                    
        else if (intval($inFiltros)==-1)
            $where = ' and (select count(*) from ps_ofertas_cupones_historico c where c.id_usuario = u.id_usuario) = 0  ';                                    
        else 
            $where = ' and (select count(*) from ps_ofertas_cupones_historico c where c.id_usuario = u.id_usuario) = '.intval($inFiltros);                                
    }                                 


	if (intval($inCompraCliente)==1)
		$where .= ' and exists (select 1 from ps_ofertas_cupones_historico c where c.id_usuario = u.id_usuario) ';                                    
	else if (intval($inCompraCliente)==-1)
		$where .= ' and not exists (select 1 from ps_ofertas_cupones_historico c where c.id_usuario = u.id_usuario)  ';                                    
    
    
    
    if (!empty($inIdOferta))    
    {
		$sql = "SELECT  u.*,c.*  FROM ps_usuarios u,ps_ofertas_cupones c WHERE c.id_usuario = u.id_usuario and c.id_oferta = '".pSQL($inIdOferta)."'".$where." ORDER BY ".$orden.$direccion;                                                
        $query=Db::getInstance()->ExecuteS($sql);
    }
    else
    {
		
		$sql = "SELECT  (select count(*) from ps_ofertas_cupones_historico c where c.id_usuario = u.id_usuario) cupones,u.*  FROM ps_usuarios u WHERE true ".$where." ORDER BY ".$orden.$direccion.$limit;                                                                      
        $query=Db::getInstance()->ExecuteS($sql);
    }
	

    $usuarioArray = array();
    foreach ($query as $row)
    {
                
        $Usuario = new Usuario(pSQL($row['id_usuario']), pSQL($row['email']),pSQL($row['password']),pSQL($row['nombre']),pSQL($row['apellidos']),pSQL($row['fecha_nacimiento']), 
                     pSQL($row['sexo']), pSQL($row['telefono']),pSQL($row['activo']),pSQL($row['fecha_alta']),pSQL($row['fecha_baja']),pSQL($row['direccion']),pSQL($row['poblacion']),
                     pSQL($row['cpostal']),pSQL($row['ultimo_pago']),pSQL($row['pagados']),pSQL($row['fechaPagoForm']),pSQL($row['ultima_transaccion']));
        $Usuario->eliminado = $row['eliminado'];
		$Usuario->registro_reserva=$row['registro_reserva'];
		$Usuario->empresa=$row['empresa'];
		$Usuario->nif=$row['nif'];
        array_push($usuarioArray, $Usuario);
    }
    return $usuarioArray;
}



?>


