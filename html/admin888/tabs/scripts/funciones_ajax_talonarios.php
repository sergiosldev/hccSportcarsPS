<? php
/** mts 05052012. Funciones javascript que realizan las llamadas ajax necesarias para la actualización
 *  de los datos.
 */
?>

<script>

//Esta función se encarga de almacenar los datos de un talonario 
function guardar(id_establecimiento,id_talonario,numero,min_rango,max_rango)
  {
    if (numero=='') {alert('Debe introducir el número de talonario');return;}
    if (min_rango=='') {alert('Debe introducir el primer número de cupón');return;}
    if (max_rango=='') {alert('Debe introducir el último número de cupón');return;}
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'; 
    dades='id_establecimiento='+id_establecimiento;
    dades+='&id_talonario='+id_talonario;
    dades+='&numero='+numero;
    dades+='&min_rango='+min_rango;
    dades+='&max_rango='+max_rango;

    r=ajax.load('<?php echo $base_scripts ?>ajax_talonario.php?'+dades+aleatorio); 

    var ok=/OK/;

    //alert(r);
   if (ok.test(r)) {  
      get_lista_talonarios(id_establecimiento);
     }
     else if (r.indexOf('SOLAPADOS')!=-1) alert('El rango de cupones introducido se solapa con algunos ya registrados. Por favor, introduzca un rango nuevo.');
    else {  
     id_('msg_error').innerHTML=r;
    }
  }
  

function borra_talonario(id_establecimiento,id_talonario) 
{ 
  id_('id_establecimiento_fbt').value = id_establecimiento;
  id_('id_talonario_fbt').value = id_talonario;
  if (confirm('Esta seguro de que desea borrar este talonario?')) {
    id_('frm_borrar_talonario').reset();
    $.colorbox({width:"42%", inline:true, href:"#form_borrar_talonario",open:true});   
  }
} 
  
//Función encargada de borrar el talonario
function envia_formulario_talonario(id_establecimiento,id_talonario,password)
  {

    if (password=='') {alert('Debe introducir la contraseña');return;}      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    //var dades=obtenirDadesForm('frm_busqueda');
    dades = 'password='+id_('password').value; //el código alfa será único.
    dades+= '&id_establecimiento='+id_establecimiento;
    dades+= '&id_talonario='+id_talonario;
    dades+= '&operacion=delete';

    r=ajax.load('<?php echo $base_scripts ?>ajax_talonario.php?'+dades+aleatorio); 

    if (r.indexOf('error_password')!=-1) {alert('Contraseña incorrecta. Inténtelo de nuevo.'); id_('frm_borrar_talonario').reset();}
    else $.colorbox.close();   
    
    get_lista_talonarios(id_establecimiento);
 
 }
  


function envia_formulario_cupon()
  {
    if (id_('cupon').value=='') {alert('Debe introducir el número de cupón');return;}
    if (id_('cupon').value.length<6) {alert('El número de cupón debe tener 6 dígitos');return;}
          
      
    var aleatorio='&gg'+(Math.floor(Math.random()*50000))+'=1'
    //var dades=obtenirDadesForm('frm_busqueda');
    dades = 'numero_cupon='+id_('cupon').value; //el código alfa será único.
    dades+= '&id_establecimiento=0';
    dades+= '&id_talonario=0';
    dades+= '&numero_talonario=0';

    

    r=ajax.load('<?php echo $base_scripts ?>cupones.php?'+dades+aleatorio);  
    if (r.indexOf('error')!=-1) r = " <div style='font-weight:bold;color:red;font-size:18px;'>No existen cupones para este talonario</div>";    

    id_('lista_cupones').innerHTML = r;  
    $.colorbox({width:"52%", inline:true, href:"#lista_cupones",open:true}); 
 
 }
  
  
function lpad(originalstr, length, strToPad) {
    while (originalstr.length < length)
        originalstr = strToPad + originalstr;
    return originalstr;
}  
  
function validar_min_rango(min_rango,n)
{   
    var rango=29;
    if (!isNaN(min_rango.value))
    {
    var tmp = parseInt(min_rango.value)+rango;
    if (min_rango.value.length>6) {alert('El número de cupón no puede tener más de 6 dígitos');id_('min_rango'+n).value="";}
    else{
        var tmp = tmp.toString();
        id_('max_rango'+n).value = lpad(tmp,6,'0'); 
        id_('min_rango'+n).value = lpad(id_('min_rango'+n).value,6,'0');
        }
    }
}  


</script>  