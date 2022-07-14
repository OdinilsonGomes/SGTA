var data_table;
$(() => {
  fetchAllTurma();
  $('#remove_modal, #update_modal, #insert_modal').on('hide.bs.modal', function (e) {
    clear_form();
  })
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
function fetchAllTurma(){
  URL ="api/Turma";  
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("GET",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  xmlhttp.send();
  var result=xmlhttp.responseText;
  var result_json = JSON.parse(result);
  FillBodyTable(result_json);
}
function fetchAllTurmaByNome(){
  URL ="api/Turma/nome/"+$("#nome_turma_filtro").val();  
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("GET",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  xmlhttp.send();
  var result=xmlhttp.responseText;
  var r = JSON.parse(result);
  // Send to a global display 
  FillBodyTable(r);
  $("#nome_turma_filtro").focus();
  $("#serie_turma_filtro").val("")
}

function fetchAllTurmaBySerie(){
  URL ="api/Turma/serie/"+$("#serie_turma_filtro").val();  
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("GET",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  xmlhttp.send();
  var result=xmlhttp.responseText;
  var r = JSON.parse(result);
  // Send to a global display 
  FillBodyTable(r);

  $("#serie_turma_filtro").focus();
  $("#nome_turma_filtro").val("")
}
function FillBodyTable(data_json){
  var html="";
  if(data_json.status==="success"){
    for(var i=0;i<data_json.dados.length;i++){
      var turma=data_json.dados[i];
     // console.log(turma);
      html+="<tr>"+
              "<td>"+data_json.dados[i]['nome']+"</td>"+
              "<td>"+data_json.dados[i]['serie']+"</td>"+
              "<td><div class='span12' style='text-align:center'><a href='javascript:fetchAllAlunoByTurma("+JSON.stringify(turma)+")' class='btn btn-warning btn-sm'>Ver alunos</a></div></td>"+
              "<td><div class='span12' style='text-align:center'><a href='javascript:update("+JSON.stringify(turma)+")' class='btn btn-info'><i class='fas fa-edit'></i></a></div></td>"+
              "<td><div class='span12' style='text-align:center'><a href='javascript:remove("+data_json.dados[i]['id']+")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div></td>"+
              "</tr>";
    }
  }else{
    html=data_json.dados;
  }
  $("#dataTableBody").html(html);
}
function insert() {
  
  URL ="api/Turma"  
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("POST",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  var nome= $("#nome_turma"),
  serie = $("#serie_turma");
  var ItemJSON=JSON.stringify({
    nome    :  nome.val(),
    serie  :   serie.val()
  });
  xmlhttp.send(ItemJSON);
  var result=xmlhttp.responseText;
  var tips = $("#insert_state");
  tips.addClass("alert-light");
  tips.html("<img src='img/loader.gif' />");
  /* Adicionar outros parametros e verificar */
  tips.removeClass("alert-danger").addClass("alert-light");
  if (nome.val() == "") {
    updateTips(tips, "Por favor peencha o Nome");
    nome.focus();
  } else if (serie.val() == "") {
    updateTips(tips, "Por favor preencha a Serie");
    serie.focus();
  } else {
    try{
      var r = JSON.parse(result);
      if(r.status==="success"){
        tips.html("Registado com sucesso!");
        fechar_modal("insert_modal");
        fetchAllTurma();
      }else{
        updateTips(tips, r.dados);
    }
    }catch (error) {
      updateTips(tips, error);
    }

  }
}


function update(turma) {
  try {
    var tips = $("#update_state");
    $("#id_to_update").val(turma.id);
    $("#nome_turmaU").val(turma.nome);
    tips.addClass("alert-light");
    $("#update_modal").modal("show");
  } catch (error) {
    console.log(error);
  }
}
function updateAsync() {

  URL ="api/Turma"  
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("PATCH",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  var ItemJSON=JSON.stringify({
    id    :   $("#id_to_update").val(),
    nome  :   $("#nome_turmaU").val()
  });
  xmlhttp.send(ItemJSON);
  var result=xmlhttp.responseText;
 
  var tips = $("#update_state");
  tips.addClass("alert-light");
  tips.html("<img src='img/loader.gif' />");
  try{
    var r = JSON.parse(result);
    if(r.status==="success"){
      tips.html("Alterado com sucesso!");
      fechar_modal("update_modal");
      fetchAllTurma();
    }else{
      updateTips(tips, r.dados);
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
  URL ="api/Turma"; 
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("DELETE",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  var ItemJSON=JSON.stringify({
    id    :   $("#id_to_remove").val()
    });
    
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
      fetchAllTurma();
    }else{
      updateTips(tips, r.dados);
  }
  }catch (error) {
    updateTips(tips, error);
  }
}

function fetchAllAlunoByTurma(turma) {

  URL ="api/Turma/"+turma.id+"/aluno";  
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("GET",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  xmlhttp.send();
  var result=xmlhttp.responseText;
  var r = JSON.parse(result);
  var itens = r.dados,html = "",ordem=0;
   if (r.status == "success") {
        try {

          console.log(itens);
          $.each(itens, (i, item) => {
            html += "<tr><b> Turma </b></tr><tr>" 
						+"<td>"+ (++ordem) +"</td>"
						+"<td>"+item['nome']+"</td>"
						+"<td>"+item['data_nasc']+"</td>"
						+"<td>"+item['email']+"</td>"
					  +"</tr>";
          });
          // attribuindo o Id da turma a modal
          $("#id_turma_aluno_filtro").val(turma.id);
          // Esvaziando o campo de pesquisa antes de abrir a modal
          $("#nome_aluno_filtro").val("");
          // Atribuindo um titulo a modal
          $("#aluno_modal_titulo").html("Lista dos Alunos da Turma: "+turma.nome);
          
		  
        } catch (error) {
          html=error;
          console.log(error);
        }
      } else {
        console.log(r.dados);
        html=r.dados;
      }
    // preenchendo a tabela
      $("#bodyDataTableAluno").html(html);
      $("#ver_aluno_modal").modal("show");
}

function fetchAlunoByNome() {
var data ={
  id_turma:   $("#id_turma_aluno_filtro").val(),
    nome  :   $("#nome_aluno_filtro").val()
}
  URL ="api/Turma/"+data.id_turma+"/aluno/"+data.nome;  
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open("GET",URL, false);
  xmlhttp.setRequestHeader("Content-Type","application/json");
  xmlhttp.send();
  var result=xmlhttp.responseText;
  var r = JSON.parse(result);
  var itens = r.dados,html = "",ordem=0;
   if (r.status == "success") {
        try {
          console.log(itens);
          $.each(itens, (i, item) => {
            html += "<tr><b> Turma </b></tr><tr>" 
						+"<td>"+ (++ordem) +"</td>"
						+"<td>"+item['nome']+"</td>"
						+"<td>"+item['data_nasc']+"</td>"
						+"<td>"+item['email']+"</td>"
					  +"</tr>";
          });
         
        } catch (error) {
          html=error;
          console.log(error);
        }
      } else {
        console.log(r.dados);
        html=r.dados;
      }
// preenchendo a tabela
$("#bodyDataTableAluno").html(html);

}
// Reset all input form
function clear_form() {
  /* Insert */
  $("#nome_turma").val("");
  $("#serie_turma").val("");
  $("#insert_state").removeClass("alert-success");
  $("#insert_state").addClass("alert-light");
  $("#insert_state").html("");
  /* Update */
  $("#nome_turmaU").val("");
  $("#update_state").removeClass("alert-success");
  $("#update_state").addClass("alert-light");
  $("#update_state").html("");
  /* Remove */
  $("#id_to_remove").val("");
  $("#remove_state").html("");
  $("#remove_state").removeClass("alert-success");
  $("#remove_state").addClass("alert-light");
  
}
