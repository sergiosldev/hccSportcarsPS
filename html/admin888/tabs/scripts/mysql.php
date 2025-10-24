<?php



/*
Exemples


$db->query($sql); 
if($db->row_count()){
	$t = new Table(1, 'width="100%" cellspacing="1" cellpadding="2" border="0"','heading;even;odd');
	$t->data("&nbsp;".$string['Listado_Pedidos'],'class="titols"  height=30 ');
	
	while($r=$db->row()){
		$uri=$ruta_common."registrarse/facturapedidos.php?item=".$r->ID_pedido."&action=update";
		$t->data('','height=20 ');
		TextLink($uri, fecha_convert($r->Data_compra)." - <strong>".$r->Num_pedido."</strong> - ".$string_estat[$r->Estat] ." - ".$string['importe_total'].':'.$r->Total_t_t);
	}
	
	$t->done();



$db= new _mysql();


*/



class _mysql  {
	//inicalizamos las vars
	var $output_html = TRUE;
	/*si deseamos controlar los accesos en cada conexi�n, lo incluimos en trailer
	del metodo init y elimanos las init vars*/
	var $host;
	var $conexion;
	var $usuario;
	var $password;
	var $str_aux_bd;
	var $debug=FALSE;
	var $resultados=array();
	var $last_query='';
	function __construct ($host,$user,$password,$bd,$debug=FALSE, $persistente = FALSE) {
		 
		$this->host=$host;//
		$this->usuario=$user;//
		$this->password=$password;// 
		$this->debug=$debug;
       
		$this->str_aux_bd=$bd;
		$function = ($persistente) ? 'mysql_pconnect' : 'mysql_connect';
		
		if (!$this->conexion = $function($this->host, $this->usuario, $this->password)) return FALSE;
		if (!mysql_select_db($this->str_aux_bd, $this->conexion)) {
			trigger_error(mysql_error($this->conexion), E_USER_WARNING);
			return FALSE;
		}

		return TRUE;
	}
	function mysqlclose (){
		mysql_close($this->conexion);
	}
    function get_last_query (){
		return  $this->last_query;
	}
	function query($query, $key = 0, $debug = FALSE) {
		
		//echo $query;
		$this->last_query = $query;
		if ($this->debug){
			 echo ($this->output_html) ? "Consulta: <span style='white-space: pre; background: #000070; color: #ffffff; font: 0.8em sans-serif'>".htmlspecialchars($query)."</span><br/>\n" : "$query\n";
		    return true;
			}
		else if (!$this->resultados[$key] = mysql_query($query, $this->conexion)) {
			
			trigger_error(mysql_error($this->conexion), E_USER_WARNING);
			return FALSE;
		}
	
		return TRUE;
	}
	function begin() {
		return $this->query('BEGIN', uniqid(0));
	}

	function rollback() {
		return $this->query('ROLLBACK', uniqid(0));
	}

	function commit() {
		return $this->query('COMMIT', uniqid(0));
	}

	function cell($query) {
		$key = uniqid(0);

		$this->query($query, $key);
		if ($this->row_count()) return mysql_result($this->resultados[$key], 0);
	}

	function row($key = 0) {// access var object fotmat cadena $r->{'cadena'} 
		return mysql_fetch_object($this->resultados[$key]);
	}
    function fetch_row($key = 0) {
		return mysql_fetch_row($this->resultados[$key]);
	}
	function all_rows($query) {
		$key = uniqid(0);
		
		$this->query($query, $key);
		while ($row = $this->row($key)) $rows[] = $row;

		return $rows;
	}

	function row_count() {
		$command = strtoupper(substr($this->last_query, 0, 6));
		return ($command == 'INSERT' || $command == 'UPDATE' || $command == 'DELETE') ? mysql_affected_rows($this->conexion) : mysql_num_rows(max($this->resultados));
	}

	function quote($string) {
		return (get_magic_quotes_gpc()) ? $string : addslashes($string);
	}

	function limit($rows, $offset = 0) {
		return "LIMIT $offset, $rows";
	}

	function last_id($table, $serial_column = 'id') {
		return ($contents = mysql_insert_id($this->conexion)) ? $contents : FALSE;
	}

	function serial() {
		return 'INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY';
	}

	function seconds($column) {
		return "UNIX_TIMESTAMP($column)";
	}
	function insert($P_valor,$P_tabla){
		while(list($k,$v)=each($P_valor)){
			$columnas[]=$k;
			$valor[]="'".addslashes(mysql_real_escape_string($v))."'"; // afegit addslashes
		}
		$columnas=implode(' , ',$columnas);
		$valor=implode(' , ',$valor);
		$sql="INSERT INTO ".$P_tabla."
				( ".$columnas." ) VALUES 
				( ".$valor." );";
				
		
		return $this->query($sql);
	}
	function del($P_table,$P_where){
		$sql="DELETE FROM ".$P_table."  ".$this->crear_where($P_where).";";
		if(!$this->query($sql))return false;
		$this->optimizar($P_table);
		return true;
	}
	function crear_where($P_where){
	
		if($P_where!="" ){
			$this->str_aux_bd=" WHERE ";
			//mysql_real_escape_string($unescaped_string);
				while(list($camp,$val)=each($P_where)){
					$condicio[]=$camp."='".mysql_real_escape_string($val)."'";
				}
			$this->str_aux_bd.=implode(' AND ',$condicio);
		}else{
			 $this->str_aux_bd="";
		}
	
		return	$this->str_aux_bd;
	}
	
	function update($P_valor,$P_tabla,$P_where){
		while(list($k,$v)=each($P_valor)){
			$columnas_valor[]=$k."='".addslashes($v)."'"; // afegit addslashes
		}
		$columnas_valor=implode(' , ',$columnas_valor);
		
		$sql="UPDATE ".$P_tabla." SET ".$columnas_valor." ".$this->crear_where($P_where).";";
		return $this->query($sql);
		
	}
	
	function reparar($P_table){
		$sql="REPAIR TABLE ".$P_table.";";
		return $this->query($sql);
	}
	function optimizar($P_table){
		$sql="OPTIMIZE  TABLE ".$P_table.";";
		return $this->query($sql);
	}
}



?>