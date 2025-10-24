<script>
//funcion invocada para eliminar un registro de establecimientos.
function borra_establecimiento(id_establecimiento) 
{ 

  id_('id_establecimiento_fbe').value = id_establecimiento;
 
  if (confirm('Esta seguro de que desea borrar este establecimiento?')) {
    id_('frm_borrar_establecimiento').reset();
    $.colorbox({width:"42%", inline:true, href:"#form_borrar_establecimiento",open:true});   
  }
} 

</script>