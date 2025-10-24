<?php 

//Generem un option de plataformas on el valor sera "id_plataforma" i el nom a visualitzar "nombre".
function buscarPlataforma()
  {
	 
	  $sql = 'Select id_plataforma, nombre from plataformas';
	  $result=db::getinstance()->executes($sql);
	  $resultat = "";
	  //Tractament de la consulta.
	  foreach($result as $r)
		{
			$resultat = $resultat.'<option value="'.$r["id_plataforma"].'">'.$r["nombre"].'</option>';
		}
	  return $resultat;
  }

?>