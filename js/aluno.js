var data_table;
$(() => {
  fetchAllAluno();
 // Caregar turma e prencher no formulario quando a modal é aberta
$('#insert_modal, #update_modal, #transferir_modal').on('shown.bs.modal', function (e) {
  loadSelectTurma();
});
$('#remove_modal, #update_modal, #insert_modal, #transferir_modal').on('hide.bs.modal', function (e) {
  clear_form();
});
  /* This function will update the text in the tips div the the text and the css */
  function updateTips(tips, text) {
    tips.text(text).removeClass("alert-light").addClass("alert-danger");
  }
  /* This function will check the length of the JS objects is between min and max, and will update tip div */
  function checkLength(tips, o, n, min, max) {
    if (o.val().length > max || o.val().length < min) {
      o.addClass("alert-danger");
      updateTips(
        tips,
        "A longetude de " + n + " tem de estar entre " + min + " e " + max + "."
      );
      return false;
    } else {
      return true;
    }
  }
  /* This function will check if the regular expression is true or false, and will update the tip div */
  function checkRegexp(tips, o, regexp, n) {
    if (!regexp.test(o.val())) {
      o.addClass("alert-danger");
      updateTips(tips, n);
      return false;
    } else {
      return true;
    }
  }

});
/* This function will update the text in the tips div the the text and the css */
function updateTips(tips, text) {
  tips.text(text).removeClass("alert-light").addClass("alert-danger");
}
/* This function will check the length of the JS objects is between min and max, and will update tip div */
function checkLength(tips, o, n, min, max) {
  if (o.val().length > max || o.val().length < min) {
    o.addClass("alert-danger");
    updateTips(
      tips,
      "A longetude de " + n + " tem de estar entre " + min + " e " + max + "."
    );
    return false;
  } else {
    return true;
  }
}
/* This function will check if the regular expression is true or false, and will update the tip div */
function checkRegexp(tips, o, regexp, n) {
  if (!regexp.test(o.val())) {
    o.addClass("alert-danger");
    updateTips(tips, n);
    return false;
  } else {
    return true;
  }
}
function fetchAllAluno(){
  URL ="api/Aluno";  
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("GET",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  xmlhttp.send();
  var result=xmlhttp.responseText;
  console.log(result);
  var result_json = JSON.parse(result);
  FillBodyTable(result_json);
}

function insert() {

  URL ="api/Aluno";  
  var xmlhttp       = new XMLHttpRequest();
  var nome          = $("#nome_aluno"),
	    data_nasc     = $("#data_nasc_aluno"),
	    email         = $("#email_aluno"),
	    id_turma      = $("#turma_aluno_insert"),
      tips          = $("#insert_state");
  /*** Adicionar outros parametros e verificar ***/
  tips.removeClass("alert-danger").addClass("alert-light");
  if (nome.val() == "") {
    updateTips(tips, "Por favor peencha o Nome");
    nome.focus();
  } else if (data_nasc.val() == "") {
    updateTips(tips, "Por favor preencha a data de nascimento");
    data_nasc.focus();
  } else if (email.val() == "") {
    updateTips(tips, "Por favor preencha o email");
    email.focus();
  } else if (id_turma.val() == "") {
    updateTips(tips, "Por favor preencha a turma");
    id_turma.focus();
  } else {
    tips.addClass("alert-light");
	  tips.html("<img src='img/loader.gif' />");
    xmlhttp.open("POST",URL, false);
    xmlhttp.setRequestHeader("Content-Type","application/json");
    tips.addClass("alert-light");
    tips.html("<img src='img/loader.gif' />");
    var ItemJSON=JSON.stringify({
        nome          :   nome.val(),
        data_nasc     :   data_nasc.val(),
        email         :   email.val(),
        id_turma      :   id_turma.val(),
        });
    
    try{
      // send json data to api
      xmlhttp.send(ItemJSON);
      var result=xmlhttp.responseText;
      
      var data_json = JSON.parse(result);
      if(data_json.status==="success"){
        tips.html("Registado com sucesso!");
          fechar_modal("insert_modal");
          fetchAllAluno();
      }else{
        updateTips(tips, data_json.dados);
      }
    }catch (error) {
      updateTips(tips, error);
    }
    
  }
}

function update(aluno) {
  // Eliminando qualquer atributo selected 
  $('#turma_aluno_update option').removeAttr('selected')
  // Atribuindo o valor ao select de acordo ao aluno selecionado
  $('#turma_aluno_update option[value='+aluno.id_turma+']').attr('selected','selected');
  $("#id_aluno_update").val(aluno.id);
  $("#nome_aluno_update").val(aluno.nome);
  $("#data_nasc_aluno_update").val(aluno.data_nasc);
  $("#email_aluno_update").val(aluno.email);
  $("#update_modal").modal("show");
  
  
}
function transferir(id) {

 $("#id_aluno_tranferir_insert").val(id);
 $("#transferir_state").val("");
  $("#transferir_modal").modal("show");
}

function updateAsync() {
  URL ="api/Aluno";  
  var xmlhttp       = new XMLHttpRequest();
  var nome          = $("#nome_aluno_update"),
	    data_nasc     = $("#data_nasc_aluno_update"),
	    email         = $("#email_aluno_update"),
	    id            = $("#id_aluno_update"),
      tips          = $("#update_state");
  /*** Adicionar outros parametros e verificar ***/
  tips.removeClass("alert-danger").addClass("alert-light");
  if (nome.val() == "") {
    updateTips(tips, "Por favor peencha o Nome");
    nome.focus();
  } else if (data_nasc.val() == "") {
    updateTips(tips, "Por favor preencha a data de nascimento");
    data_nasc.focus();
  } else if (email.val() == "") {
    updateTips(tips, "Por favor preencha o email");
    email.focus();
  }  else {
   
    try{
      tips.addClass("alert-light");
      tips.html("<img src='img/loader.gif' />");
      xmlhttp.open("PATCH",URL, false);
      xmlhttp.setRequestHeader("Content-Type","application/json");
      var ItemJSON=JSON.stringify({
          nome          :   nome.val(),
          data_nasc     :   data_nasc.val(),
          email         :   email.val(),
          id            :   id.val(),
          });
      
      // send json data to api
      xmlhttp.send(ItemJSON);
      var result=xmlhttp.responseText;
      var data_json = JSON.parse(result);
      console.log(data_json);
      if(data_json.status==="success"){
        tips.html("Alterado com sucesso!");
        fechar_modal("update_modal");
         
          fetchAllAluno();
      }else{
        updateTips(tips, data_json.dados);
      }
    }catch (error) {
      updateTips(tips, error);
    }
    
  }
}

function transferirAsync() {

  URL ="api/Transferencia";  
  var xmlhttp=new XMLHttpRequest();
  var tips 		= $("#transferir_state");
  xmlhttp.open("POST",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  tips.addClass("alert-light");
  tips.html("<img src='img/loader.gif' />");
  var ItemJSON=JSON.stringify({
    id_aluno          :   $("#id_aluno_tranferir_insert").val(),
    id_turma_destino  :   $("#turma_tranferir_insert").val()
  });
  xmlhttp.send(ItemJSON);
  try{
    var result=xmlhttp.responseText;
    var data_json = JSON.parse(result);
    console.log(data_json);
    if(data_json.status==="success"){
      tips.html("Transferido com sucesso!");
            fechar_modal("transferir_modal");
            clear_form();
        $('#aluno-transferir').trigger("reset");
        fetchAllAluno();
    }else{
      updateTips(tips, data_json.dados);
    }
  }catch (error) {
    updateTips(tips, error);
  }
  

}

function remove(id) {
  var tips = $("#remove_state");
  $("#id_to_remove").val(id);
  tips.addClass("alert-light");
  $("#remove_modal").modal("show");
}
function removeAsync() {

  URL ="api/Aluno"; 
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("DELETE",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  var ItemJSON=JSON.stringify({
    id    :   $("#id_to_remove").val()
    });
    // Send request with json
  xmlhttp.send(ItemJSON);
  var result=xmlhttp.responseText;
 
  var tips = $("#remove_state");
  tips.addClass("alert-light");
  tips.html("<img src='img/loader.gif' />");
  try{
    var r = JSON.parse(result);
    if(r.status==="success"){
      tips.html("Removido com sucesso!");
      fechar_modal("remove_modal");
      fetchAllAluno();
    }else{
      updateTips(tips, r.dados);
  }
  }catch (error) {
    updateTips(tips, error);
  }

}
function loadSelectTurma() {
  URL ="api/Turma";  
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("GET",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  xmlhttp.send();
  var html="";
  var result=xmlhttp.responseText;
  var data_json = JSON.parse(result);
  if(data_json.status==="success"){
    for(var i=0;i<data_json.dados.length;i++){
      var turma=data_json.dados[i];
      html += "<option value='" + data_json.dados[i]['id'] + "'>" + data_json.dados[i]['nome'] + "</option>";        
    }
    $("#turma_aluno_insert").html(html);
    $("#turma_aluno_update").html(html);
    $("#turma_tranferir_insert").html(html);
  }else{
    html=data_json.dados;
  }

}
// Create a Glabal function to list
function FillBodyTable(data_json){
  var html="";
  if(data_json.status==="success"){
    for(var i=0;i<data_json.dados.length;i++){
      var aluno=data_json.dados[i];
      html+="<tr>"+
              "<td>"+data_json.dados[i]['nome']+"</td>"+
              "<td>"+data_json.dados[i]['data_nasc']+"</td>"+
              "<td>"+data_json.dados[i]['email']+"</td>"+
              "<td>"+data_json.dados[i]['turma']+"</td>"+
              "<td><div class='span12' style='text-align:center'><a href='javascript:transferir("+data_json.dados[i]['id']+")' class='btn btn-warning btn-sm'>Transferir</a></div></td>"+
              "<td><div class='span12' style='text-align:center'><a href='javascript:update("+JSON.stringify(aluno)+")' class='btn btn-info'><i class='fas fa-edit'></i></a></div></td>"+
              "<td><div class='span12' style='text-align:center'><a href='javascript:remove("+data_json.dados[i]['id']+")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div></td>"+
              "</tr>";
    }
    
    
  }else{
    html=data_json.dados;
  }
  $("#dataTableBody").html(html);
}
// Reset all input form
function clear_form() {
  /* Insert */
  $("#nome_aluno").val("");
  $("#data_nasc_aluno").val("");
  $("#email_aluno").val("");
  $("#insert_state").removeClass("alert-success");
  $("#insert_state").addClass("alert-light");
  $("#insert_state").html("");
  /* Update */
  $("#id_aluno_update").val("");
  $("#nome_aluno_update").val("");
  $("#email_aluno_update").val("");
  $("#data_nasc_aluno_update").val("");
  $("#turma_aluno_update").val("");
  $("#update_state").removeClass("alert-success");
  $("#update_state").addClass("alert-light");
  $("#update_state").html("");
  /* Remove */
  $("#id_to_remove").val("");
  $("#remove_state").removeClass("alert-success");
  $("#remove_state").addClass("alert-light");
  $("#remove_state").html("");
}

