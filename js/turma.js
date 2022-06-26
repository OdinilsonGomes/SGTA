var data_table;
$(() => {
  data_table = $("#dataTable").DataTable({
    processing: true,
    serverSide: false,
	searching:false,
	//paging:false,
    order: [],
    ajax: {
      url: "servicos/cms.php?action=fetchAllTurma",
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

function fetchAllTurmaByNome(){

	data_table.destroy();
	data_table = $("#dataTable").DataTable({
    processing: true,
    serverSide: false,
	searching:false,
    order: [],
    ajax: {
      url: "servicos/cms.php?action=fetchAllTurmaByNome",
      type: "POST",
      data: {nome:$("#nome_turma_filtro").val()},
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
  $("#nome_turma_filtro").focus();
  $("#serie_turma_filtro").val("")
}

function fetchAllTurmaBySerie(){

	data_table.destroy();
	data_table = $("#dataTable").DataTable({
    processing: true,
    serverSide: false,
	searching:false,
    order: [],
    ajax: {
      url: "servicos/cms.php?action=fetchAllTurmaBySerie",
      type: "POST",
      data: {serie:$("#serie_turma_filtro").val()},
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
  $("#serie_turma_filtro").focus();
  $("#nome_turma_filtro").val("")
}

function insert() {
  var nome = $("#nome_turma"),
	  serie = $("#serie_turma"),
    tips = $("#insert_state");
  /* Adicionar outros parametros e verificar */
  tips.removeClass("alert-danger").addClass("alert-light");
  if (nome.val() == "") {
    updateTips(tips, "Por favor peencha o Nome");
    nome.focus();
  } else if (serie.val() == "") {
    updateTips(tips, "Por favor preencha a Serie");
    serie.focus();
  } else {
    
      var formData = new FormData();
	  formData.append("nome", nome.val());
	  formData.append("serie", serie.val());
	  tips.addClass("alert-light");
	  tips.html("<img src='img/loader.gif' />");
	  $.ajax({
		type: "POST",
		url: "servicos/cms.php?action=insertTurma",
		data: formData,
		contentType: false,
		processData: false,
		cache: false,
		success: function (data) {
		  try {
			var r = JSON.parse(data);
			if (parseInt(r.result) != NaN && parseInt(r.result) == 1) {
			  tips.html("Registado com sucesso!");
        fechar_modal("insert_modal");
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
}


function update(id) {
  var formData = new FormData();
  formData.append("id", id);
  $.ajax({
    type: "POST",
    url: "servicos/cms.php?action=fetchAllTurmaById",
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (result) {
      try {
        var turma = JSON.parse(result),
          tips = $("#update_state");
        $("#id_to_update").val(turma.id);
        $("#nome_turmaU").val(turma.nome);
        tips.addClass("alert-light");
        $("#update_modal").modal("show");
      } catch (error) {
        console.log(error);
      }
    },
  });
}
function updateAsync() {
  var id = $("#id_to_update").val(),
    nome = $("#nome_turmaU").val(),
	tips = $("#update_state");
  var formData = new FormData();
  formData.append("id", id);
  formData.append("nome", nome);
  tips.addClass("alert-light");
  tips.html("<img src='img/loader.gif' />");
  $.ajax({
    type: "POST",
    url: "servicos/cms.php?action=updateTurma",
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (data) {
      try {
        var r = JSON.parse(data);
        if (parseInt(r.result) != NaN && parseInt(r.result) == 1) {
          tips.html("Alterado com sucesso!");
          fechar_modal("update_modal");
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
    "servicos/cms.php?action=removeTurma",
    {
      id: $("#id_to_remove").val(),
    },
    (data, status) => {
      if (status == "success") {
        try {
          var r = JSON.parse(data);
          if (parseInt(r.result) != NaN && parseInt(r.result) == 1) {
            tips.html("Removido com sucesso!");
            fechar_modal("remove_modal");
            data_table.ajax.reload();
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

function fetchAllAlunoByTurma(turma) {
  $.post(
    "servicos/cms.php?action=fetchAllAlunoByTurma",
    {id_turma:turma.id},
    (data, status) => {
      if (status == "success") {
        try {
          var r = JSON.parse(data),
            itens = r.data,html = "",ordem=0;
          $.each(itens, (i, item) => {
            html += "<tr><b> Turma </b></tr><tr>" 
						+"<td>"+ (++ordem) +"</td>"
						+"<td>"+item[0]+"</td>"
						+"<td>"+item[1]+"</td>"
						+"<td>"+item[2]+"</td>"
					  +"</tr>";
					
          });
          // attribuindo o Id da turma a modal
          $("#id_turma_aluno_filtro").val(turma.id);
          // Esvaziando o campo de pesquisa antes de abrir a modal
          $("#nome_aluno_filtro").val("");
          // Atribuindo um titulo a modal
          $("#aluno_modal_titulo").html("Lista dos Alunos da Turma: "+turma.nome);
          // preenchendo a tabela
          $("#bodyDataTableAluno").html(html);
		  $("#ver_aluno_modal").modal("show");
        } catch (error) {
          console.log(error);
        }
      } else {
        console.log(data);
      }
    }
  );
}

function fetchAlunoByNome() {
  $.post(
    "servicos/cms.php?action=fetchAlunoByNome",
    {
      id_turma:$("#id_turma_aluno_filtro").val(),
      nome: $("#nome_aluno_filtro").val()
      },
    (data, status) => {
      if (status == "success") {
        try {
          var r = JSON.parse(data),
            itens = r.data,html = "",ordem=0;
          $.each(itens, (i, item) => {
            html += "<tr><b> Turma </b></tr><tr>" 
						+"<td>"+ (++ordem) +"</td>"
						+"<td>"+item[0]+"</td>"
						+"<td>"+item[1]+"</td>"
						+"<td>"+item[2]+"</td>"
					+"</tr>";
					
          });
		 
          $("#bodyDataTableAluno").html(html);
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
