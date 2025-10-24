<?php
if(!isset($_REQUEST['ciudad']))$_REQUEST['ciudad']='';
//$_REQUEST['ciudad']='';
include('config_events.php');
// BUGGY
if($_REQUEST['tipus'] == '_buggy_')
  include 'dies_graella3.php';
else if($_REQUEST['tipus']=='_bferrari_' || $_REQUEST['tipus']=='_blamborghini_')
  include 'dies_graella4.php';
else 
  include 'dies_graella.php';

  include_once 'functions.php';

define('TEMPS',$_REQUEST['data']); // Dia que li arriba
$libres=false;

graella($array_hores);
         
/*
 $hores array(hora,info) 
 $lliure array(hora)  
 */
function graella($hores) {
  global $link,$persones,$libres;
  
    //Incluir la libreria PHPExcel 
    require_once '../../../phpexcel/Classes/PHPExcel.php';
    require_once "../../../phpexcel/Classes/PHPExcel/Writer/Excel2007.php";
    // Crea un nuevo objeto PHPExcel
    $objPHPExcel = new PHPExcel();
     
    // Establecer propiedades
    $objPHPExcel->getProperties()->setCreator("Cattivo");
    $objPHPExcel->getProperties()->setLastModifiedBy("Cattivo");
    $objPHPExcel->getProperties()->setTitle("Listado de clienters por instructor");
    $objPHPExcel->getProperties()->setSubject("Listado de clientes");
    $objPHPExcel->getProperties()->setDescription("Listado de instructores");
    $objPHPExcel->getProperties()->setKeywords("Excel Office 2007 openxml php");
    $objPHPExcel->getProperties()->setCategory("Instructores");
  
  
    $cabecera = array('Hora','nombre Cliente','ferrari','porsche','copiloto','Anulado');
    $anchos_columna = array(10,25,10,10,10,10);
    $i=0;
    $A=65;
    $pc = $A+1; //primera columna con datos.
    $r1=20;
    $t=1;
/*    for($r=0+$r1;$r<$r1+10;$r++)
    {
        $objWorksheet1 = $objPHPExcel->createSheet();
        $objWorksheet1->setTitle('sheet'.($r-$r1));          
        $objPHPExcel->setActiveSheetIndex($r-$r1+1);
        $t=1;
      $g1=0;  
      for($g=0+$g1;$g<$g1+100;$g++)
        for($b=0;$b<1;$b++)
        {
            $color=dechex(($r<<16)|($g<<8)|$b);    
            $objPHPExcel->getActiveSheet()->setCellValue(chr($pc).$t, $color);            
            $objPHPExcel->getActiveSheet()->getStyle(chr($pc).$t)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);    
            $t++;
        }
    // Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
    }
*/

    $objPHPExcel->setActiveSheetIndex(0);

    list($r,$g,$b) = array(255,255,200);
    $color=dechex(($r<<16)|($g<<8)|$b);    
    $color='FFB8CCE4';
    $objPHPExcel->getActiveSheet()->setCellValue(chr($pc).$t, $color);            
    $objPHPExcel->getActiveSheet()->getStyle(chr($pc).$t)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($color);    

    $objPHPExcel->setActiveSheetIndex(0);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
    $nombre_tmp=uniqid();
    $objWriter->save('../../../listados/'.$nombre_tmp.'.xls');
    $content  = file_get_contents('../../../listados/'.$nombre_tmp.'.xls');
    unlink('../../../listados/'.$nombre_tmp.'.xls');

    header("Content-type: application/ms-excel");
    //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=listado_instructor.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    echo($content);
    //exit;   
}
?>
