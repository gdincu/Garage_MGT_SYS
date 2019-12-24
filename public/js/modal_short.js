window.addEventListener('keydown', function(event) {

  switch(event.keyCode) {
  
  case 67: //C
  if(document.getElementById("clienti") !== null) document.getElementById("clienti").click()
  else document.getElementById("cauta").click();
  break;
  
  case 82:
  document.getElementById("reparatii").click();
  break;

  case 65: //A
  if(document.getElementById("rapoarte") !== null) document.getElementById("rapoarte").click();
  document.getElementById("adauga").click();
  break;

  case 77: //M
  $("#portfolioModal1").modal('show');
  document.getElementById("modifica").click();  
  break;
  
   case 83: //S
  document.getElementById("sterge").click();  
  break;

  case 80: //P
  document.getElementById("piese").click();
  break;

  case 70: //F
  $("#portfolioModal2").modal('show');
  break;

  case 32: //Spacebar
  document.getElementsByClassName("navbar-brand js-scroll-trigger")[0].click();
  break;

  case 73: //I
  document.getElementById("masini_1").click();
  break;

  case 84: //T
  document.getElementById("masini_2").click();
  break;

  case 90: //Z
  document.getElementById("factura_1").click();
  break;

  case 79: //O
  document.getElementById("factura_2").click();
  break;

}

}, false);