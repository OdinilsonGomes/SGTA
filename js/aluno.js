var data_table;
$(() => {
  data_table = $("#dataTable").DataTable({
    processing: true,
    serverSide: false,
    order: [],
    ajax: {
      url: "servicos/cms.php?action=fetchAllAluno",
      type: "POST",
      data: {},
    },
    oLanguage: {
      sLengthMenu: "Mostrar _MENU_ Linhas por pagina",
      sZeroRecords: "Nenhum Registro Encontrado!",
      sInfo: "Mostrar _START_ de _END_ de _TOTAL_ linhas",
      sInfoEmpty: "Mostrando 0 de 0 de 0 linhas",
      sInfoFiltered: "(Filtro de _MAX_ total linhas)",
      sSearch: "Procurar <i class='fa fa-search'></i>",
      oPaginate: {
        sFirst: "Primeiro", // This is the link to the first page
        sPrevious: "<i class='fas fa-arrow-circle-left'></i> Anterior", // This is the link to the previous page
        sNext: "Proximo <i class='fas fa-arrow-circle-right'></i>", // This is the link to the next page
        sLast: "Ultimo", // This is the link to the last page
      },
    },
    columnDefs: [{ orderable: false, targets: [0,0,2,0] }],
  });
 
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


function insert() {
  var nome = $("#nome_aluno"),
	  data_nasc = $("#data_nasc_aluno"),
	  email = $("#email_aluno"),
	  id_turma = $("#turma_aluno_insert"),
    tips = $("#insert_state");
  /* Adicionar outros parametros e verificar */
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
    
      var formData = new FormData();
	  formData.append("nome", nome.val());
	  formData.append("data_nasc", data_nasc.val());
	  formData.append("email", email.val());
	  formData.append("id_turma", id_turma.val());
	  tips.addClass("alert-light");
	  tips.html("<img src='img/loader.gif' />");
	  $.ajax({
		type: "POST",
		url: "servicos/cms.php?action=insertAluno",
		data: formData,
		contentType: false,
		processData: false,
		cache: false,
		success: function (data) {
		  try {
			var r = JSON.parse(data);
			if (parseInt(r.result) != NaN && parseInt(r.result) == 1) {
			  tips.html("Registado com sucesso!");
        data_table.ajax.reload();
        fechar_modal("insert_modal");
			  
			  
			} else {
			  updateTips(tips, r.result);
			}
		  } catch (error) {
			updateTips(tips, error);
		  }
		},
	  });
    
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
 
  $("#transferir_modal").modal("show");
}

function updateAsync() {
  var id 		= $("#id_aluno_update").val(),
    nome 		= $("#nome_aluno_update").val(),
    data_nasc 	= $("#data_nasc_aluno_update").val(),
    email 		= $("#email_aluno_update").val(),
    id_turma 	= $("#turma_aluno_update").val(),
	tips 		= $("#update_state");
  var formData  = new FormData();
  formData.append("id", id);
  formData.append("nome", nome);
  formData.append("data_nasc", data_nasc);
  formData.append("email", email);
  formData.append("id_turma", id_turma);
  tips.addClass("alert-light");
  tips.html("<img src='img/loader.gif' />");
  $.ajax({
    type: "POST",
    url: "servicos/cms.php?action=updateAluno",
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (data) {
      try {
        var r = JSON.parse(data);
        if (parseInt(r.result) != NaN && parseInt(r.result) == 1) {
          tips.html("Alterado com sucesso!");
          data_table.ajax.reload();
          fechar_modal("update_modal");
         
        } else {
          updateTips(tips, r.result);
        }
      } catch (error) {
        updateTips(tips, error);
      }
    },
  });
}

function transferirAsync() {
  var id_aluno		= $("#id_aluno_tranferir_insert").val(),
    data 		= $("#data_transferir").val(),
    motivo 	= $("#motivo_transferir").val(),
    id_turma_destino 	= $("#turma_tranferir_insert").val(),
	tips 		= $("#transferir_state");
  var formData  = new FormData();
  formData.append("id_aluno", id_aluno);
  formData.append("data", data);
  formData.append("motivo", motivo);
  formData.append("id_turma_destino", id_turma_destino);
  tips.addClass("alert-light");
  tips.html("<img src='img/loader.gif' />");
  $.ajax({
    type: "POST",
    url: "servicos/cms.php?action=insertTransferancia",
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (data) {
      try {
        var r = JSON.parse(data);
        if (parseInt(r.result) != NaN && parseInt(r.result) == 1) {
          tips.html("Transferido com sucesso!");
          fechar_modal("transferir_modal");
          clear_form();
		  $('#aluno-transferir').trigger("reset");
          data_table.ajax.reload();
        } else {
          updateTips(tips, r.result);
        }
      } catch (error) {
        updateTips(tips, error);
      }
    },
  });
}

function remove(id) {
  var tips = $("#remove_state");
  $("#id_to_remove").val(id);
  tips.addClass("alert-light");
  $("#remove_modal").modal("show");
}
function removeAsync() {
  var tips = $("#remove_state");
  tips.addClass("alert-light");
  tips.html("<img src='img/loader.gif' />");
  $.post(
    "servicos/cms.php?action=removeAluno",
    {
      id: $("#id_to_remove").val(),
    },
    (data, status) => {
      if (status == "success") {
        try {
          var r = JSON.parse(data);
          if (parseInt(r.result) != NaN && parseInt(r.result) == 1) {
            tips.html("Removido com sucesso!");
            data_table.ajax.reload();
            fechar_modal("remove_modal");
            
          } else {
            updateTips(tips, r.result);
          }
        } catch (error) {
          updateTips(tips, error);
        }
      } else {
        updateTips(tips, data);
      }
    }
  );
}
function loadSelectTurma() {
	
  $.post(
    "servicos/cms.php?action=fetchAllTurmaToSelect",
    {},
    (data, status) => {
      if (status == "success") {
        try {
          var r = JSON.parse(data),
            itens = r.data,
            html = "";
          $.each(itens, (i, item) => {
            html += "<option value='" + item[0] + "'>" + item[1] + "</option>";
          });
		 
          $("#turma_aluno_insert").html(html);
          $("#turma_aluno_update").html(html);
          $("#turma_tranferir_insert").html(html);
        } catch (error) {
          console.log(error);
        }
      } else {
        console.log(data);
      }
    }
  );
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

