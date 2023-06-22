/* $("#tabelaStolova tr").hover(function(){
  $(this).addClass('bg-success');
  },function(){
  $(this).removeClass('bg-success');
}); */

$('.ok').on('click', function(e){
   alert($("#table tr.selected td:first").html());
});
/* $('element').datepicker({
  minDate : 0
}); */

$("#btn-izmeni").click(function () {

  request = $.ajax({
    url: "handler/get.php",
    type: "post",
    data: { rezID: checked.val() },
    dataType: "json",
  });

  request.done(function (response, textStatus, jqXHR) {
    console.log("Popunjena");
    $("#nazivv").val(response[0]["nazivTima"]);
    console.log(response[0]["nazivTima"]);

    $("#drzavaa").val(response[0]["drzava"].trim());
    console.log(response[0]["drzava"].trim());
    $("#godinaa").val(response[0]["godinaOsnivanja"].trim());
    console.log(response[0]["godinaOsnivanja"].trim());
    $("#brojj").val(response[0]["brojTitula"].trim());
    console.log(response[0]["brojTitula"].trim());
    $("#idd").val(checked.val());

    console.log(response);
  });

  request.fail(function (jqXHR, textStatus, errorThrown) {
    console.error("The following error occurred: " + textStatus, errorThrown);
  });
});
function prikaziRezervacije() {
  var x = document.getElementById("tabelaRezervacija");
  if(x.style.display=== "none"){
    $("#tabelaRezervacija").show()
  } else{
    $("#tabelaRezervacija").hide()
  }
  
  var y = document.getElementById("prikazi")
  if (y.innerHTML =="ПРИКАЖИ РЕЗЕРВАЦИЈЕ") {
    y.innerHTML  = "САКРИЈ РЕЗЕРВАЦИЈЕ";
  }else {
    y.innerHTML  = "ПРИКАЖИ РЕЗЕРВАЦИЈЕ";
 }
}

function obrisiSto(){
  event.preventDefault();
  console.log("Brisanje je pokrenuto");
  /* const id = document.querySelector('#stolovii').value;
  
  request = $.ajax({
  url:'handler/delete.php',
  type:'post',
  data: {stoID: id}
  }); */
  const id1 = document.getElementById("stolovii");
  const text = id1.options[id1.selectedIndex].text; 
  request = $.ajax({
    url:'handler/delete.php',
    type:'post',
    data: {naziv: text}
    }); 

  request.done(function (response, textStatus, jqXHR) {
    if (response.trim() === "radi") {
      console.log("Sto je obrisan");
      location.reload(true);
    } else {
      console.log("Sto nije obrisan" + response);
      location.reload(true);
    }
  });
}

function obrisiRez(rezID){
    const id1 = rezID;
    console.log("Brisanje je pokrenuto");
    request = $.ajax({
    url:'handler/delete.php',
    type:'post',
    data: {rezID: id1}
    });
     
    request.done(function (response, textStatus, jqXHR) {
      if (response.trim() === "radi") {
        console.log("Rezervacija je obrisana");
        // alert("Rezervacija je obrisana");
        location.reload(true);
      } else {
        console.log("Rezervacija nije obrisana " + response);
        // alert("Rezervacija nije obrisana");
        location.reload(true);
      }
    });
}

function reply_stoID(clicked_id)
  {
    document.getElementById("stoNaziv").value = clicked_id;
    return clicked_id;
  }
  
function reply_stoNaziv(clicked_id)
  {
    document.getElementById("stoNaziv1").value = clicked_id;
    return clicked_id;
  }
function reply_rezID(clicked_id){
    document.getElementById("rezID").value = clicked_id;
    return clicked_id;
}

$("#zakazi").submit(function () {
    $("staticBackdrop").modal("toggle");
    return false;
  });

$('#dodajRez').submit(function(){
    event.preventDefault();
    console.log("Dodavanje je pokrenuto");
    const $form = $(this);
    const $inputs = $form.find('input, text, button, hidden');
    const serijalizacija = $form.serialize();
    console.log(serijalizacija);

    request = $.ajax({
        url:'handler/add.php',
        type:'post',
        data: serijalizacija
    });
    
    request.done(function(response, textStatus, jqXHR){
        if(response.trim()==="radi"){                              //iz nekog razloga ne radi uslov u if
            alert("Rezervacija prihvacena");
            console.log("Uspesno zakazivanje");
            location.reload(true);
        }else {
          console.log("Rezervacija neuspesna" +response);
          location.reload(true);
        }
    });

    request.fail(function(jqHR, textStatus,error){
        console.error('Sledeca greska se desila: '+textStatus, errorThrown)
    });
});

$('#izmeniRez').submit(function(){

  event.preventDefault();

  console.log("Izmena je pokrenuta");

/*   const id1 = document.getElementById("stoUpdate");
  const text = id1.options[id1.selectedIndex].text; */
  
  const $form = $(this);
  const $inputs = $form.find(':input');
  const serijalizacija = $form.serialize();
  console.log(serijalizacija);
  // console.log(text);

  request = $.ajax({
      url:'handler/update.php',
      type:'post',
      data: serijalizacija
  });
  
  request.done(function(response, textStatus, jqXHR){
      if(response.trim()==="radi"){                              //iz nekog razloga ne radi uslov u if
          console.log("Uspesna izmena");
          location.reload(true);
      }else {
        console.log("Izmena je neuspesna" +response);
        location.reload(true);
      }
  });

  request.fail(function(jqHR, textStatus,error){
      console.error('Sledeca greska se desila: '+textStatus, errorThrown)
  });
});

$('#dodajSto').submit(function(){
  event.preventDefault();
  console.log("Dodavanje pokrenuto");
  const $form = $(this);
  const $inputs = $form.find(':input');
  const serijalizacija = $form.serialize();
  console.log(serijalizacija);

  request = $.ajax({
      url:'handler/add.php',
      type:'post',
      data: serijalizacija
  });
  
  request.done(function(response, textStatus, jqXHR){

      if(response.trim()==="radi"){                              //iz nekog razloga ne radi uslov u if
          console.log("Uspesno dodat sto");
          location.reload(true);
      }else {
        console.log("Dodavanje stola je neuspesno"+response);
        location.reload(true);
      }
  });

  request.fail(function(jqHR, textStatus,error){
      console.error('Sledeca greska se desila: '+textStatus, errorThrown)
  });
});

function ajaxFunction()
  {
  var xmlHttp;
  try
    {
    // Firefox, Opera 8.0+, Safari
    xmlHttp=new XMLHttpRequest();
    }
  catch (e)
    {
    // Internet Explorer
    try
      {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      }
    catch (e)
      {
      try
        {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
      catch (e)
        {
        alert("Your browser does not support AJAX!");
        return false;
        }
      }
    }
  }