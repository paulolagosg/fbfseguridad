  // $(document).ready(function() {
  //     jQuery('table.display').DataTable({
  //       bFilter : true,
  //       ordering    : true,
  //       info        : true,
  //       autoWidth   : false,
  //       language: {
  //         url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
  //       }
  //     });
  //     jQuery('#fecha_inicio').datepicker({
  //       locale: 'es-es',
  //       uiLibrary: 'bootstrap4',
  //       format:'dd/mm/yyyy'
  //     });
  //     jQuery('#fecha_termino').datepicker({
  //       locale: 'es-es',
  //       uiLibrary: 'bootstrap4',
  //       format:'dd/mm/yyyy'
  //     });
  // } );

var mybutton = document.getElementById("btnSubir");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

function getDatosCliente(nCliente){
  var rutCliente="";
  var ejecutivo = "";
  var fono = "";
  var direccion = "";
  var correo = "";
  switch(nCliente){
    case 1:
    case "1":
      rutCliente = "88.888.888-8";
      ejecutivo="Fernando Larrain";
      fono = "+56987662345";
      correo ="fflarrain@abcdin.cl";
      direccion = "Manuel Montt 0321";
      break;
    case 2:
    case "2":
      rutCliente = "99.999.999-9";
      ejecutivo="Felipe Izquiero";
      fono = "+56987667887";
      correo ="fizquierdo@bancochile.cl";
      direccion = "Arturo Prat 0123";
      break;
    default:
      rutCliente = "Seleccione cliente";
      ejecutivo="Seleccione cliente";
      fono = "Seleccione cliente";
      correo ="Seleccione cliente";
      direccion = "Seleccione cliente";
      break;
  }

  jQuery('#txtRUT').html(rutCliente);
  jQuery('#txtEjecutivo').html(ejecutivo);
  jQuery('#txtFono').html(fono);
  jQuery('#txtCorreo').html(correo);
  jQuery('#txtDireccion').html(direccion);
}

function calculaDias(fInicio,fTermino){
  var aFecha1 = fInicio.split('/');
  var aFecha2 = fTermino.split('/');
  var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
  var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
  var dif = fFecha2 - fFecha1;
  var dias = Math.floor(dif / (1000 * 60 * 60 * 24)) + 1;
  
  jQuery('#nDias').html(dias); ;

}

function calculaTotal(nValor){
  var dias = parseInt(jQuery('#nDias').html());
  if(dias <= 0){
    alert('Debe seleccionar las fecha de inicio y termino');
  }
  else{
    var sinIva = nValor*dias;
    var conIva = nValor*dias + (nValor*dias*0.19);
    jQuery("#totalSinIVA").html(sinIva);
    jQuery("#totalConIVA").html(conIva);

  }

}

function mostrarFactura(nValor){
  switch(nValor){
    case "4":
    case "5":
    case "6":
      jQuery('#divFactura').show();
      break;
    default:
      jQuery('#divFactura').hide();

  }
}