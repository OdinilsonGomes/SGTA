var user_data_table;
$(() => {
  user_data_table = $("#dataTable").DataTable({
    processing: true,
    serverSide: false,
    order: [],
    ajax: {
      url: "servicos/cms.php?action=fetchAllUser",
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
    columnDefs: [{ orderable: false, targets: [1, 3, 4] }],
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
  var username_to_insert = $("#username_to_insert"),
    password_to_insert = $("#password_to_insert"),
    access_to_insert = $("#access_to_insert"),
    bValid = true,
    tips = $("#insert_state");
  tips.removeClass("alert-danger").addClass("alert-light");
  if (username_to_insert.val() == "") {
    updateTips(tips, "Por favor preencha o nome do utilisador");
    username_to_insert.focus();
  } else if (password_to_insert.val() == "") {
    updateTips(tips, "Por favor preencha o nome do utilisador");
    password_to_insert.focus();
  } else if (username_to_insert.val() == password_to_insert.val()) {
    updateTips(
      tips,
      "O Nome do utilisador e a palavra passe não podem ser iguais"
    );
    password_to_insert.focus();
  } else if (password_to_insert.val().includes(username_to_insert.val())) {
    updateTips(tips, "A palavra passe não pode conter o nome do utilisador");
    password_to_insert.focus();
  } else {
    bValid = bValid && checkLength(tips, username_to_insert, "username", 5, 20);
    bValid =
      bValid &&
      checkRegexp(
        tips,
        username_to_insert,
        /[QWERTYUIOPASDFGHJKLZXCVBNM]([0-9qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM])+$/i,
        "The username must begin with a letter and followed by numbers or letters."
      );
    bValid = bValid && checkLength(tips, password_to_insert, "password", 6, 20);
    bValid =
      bValid &&
      checkRegexp(
        tips,
        password_to_insert,
        /[0-9]/,
        "The password must containt at least one number."
      );
    bValid =
      bValid &&
      checkRegexp(
        tips,
        password_to_insert,
        /[qwertyuiopasdfghjklzxcvbnm]/,
        "The password must contain at least one lowercase letter."
      );
    bValid =
      bValid &&
      checkRegexp(
        tips,
        password_to_insert,
        /[QWERTYUIOPASDFGHJKLZXCVBNM]/,
        "The password must contain at least one capital letter."
      );
    bValid =
      bValid &&
      checkRegexp(
        tips,
        password_to_insert,
        /[@£€#$%&*+-?!]/,
        "The password must consist of at least 1 special character, namely @, £, €, #, $, %, &, *, +, -, ? or !."
      );
    bValid =
      bValid &&
      checkRegexp(tips, access_to_insert, /[01]/, "The access must be 0 or 1.");
    if (bValid) {
      insertAsync();
    }
  }
}

function insertAsync() {
  var tips = $("#insert_state");
  tips.addClass("alert-light");
  tips.html("<img src='img/loader.gif' />");
  $.post(
    "servicos/cms.php?action=insertUser",
    {
      username: $("#username_to_insert").val(),
      password: $("#password_to_insert").val(),
      access: $("#access_to_insert").val(),
    },
    (data, status) => {
      if (status == "success") {
        try {
          var r = JSON.parse(data);
          if (parseInt(r.result) != NaN && parseInt(r.result) == 1) {
            tips.html("Registado com sucesso");
            $("#insert_modal").modal("hide");
            clear_form();
            user_data_table.ajax.reload();
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
function update(user) {
  var tips = $("#update_state");
  $("#id_to_update").val(user.id);
  $("#username_to_update").val(user.username);
  $("#password_to_update").val(user.password);
  $("#access_to_update").val(user.access);
  tips.addClass("alert-light");
  $("#update_modal").modal("show");
}
function updateAsync() {
  var tips = $("#update_state");
  tips.addClass("alert-light");
  tips.html("<img src='img/loader.gif' />");
  $.post(
    "servicos/cms.php?action=updateUser",
    {
      id: $("#id_to_update").val(),
      username: $("#username_to_update").val(),
      password: $("#password_to_update").val(),
      access: $("#access_to_update").val(),
    },
    (data, status) => {
      if (status == "success") {
        try {
          var r = JSON.parse(data);
          if (parseInt(r.result) != NaN && parseInt(r.result) == 1) {
            tips.html("Alterardo com sucesso!");
            $("#update_modal").modal("hide");
            clear_form();
            user_data_table.ajax.reload();
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
    "servicos/cms.php?action=removeUser",
    {
      id: $("#id_to_remove").val(),
    },
    (data, status) => {
      if (status == "success") {
        try {
          var r = JSON.parse(data);
          if (parseInt(r.result) != NaN && parseInt(r.result) == 1) {
            tips.html("Removido com sucesso!");
            $("#remove_modal").modal("hide");
            clear_form();
            user_data_table.ajax.reload();
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
// Reset all input form
function clear_form() {
  /* Insert */
  $("#username_to_insert").val("");
  $("#password_to_insert").val("");
  $("#access_to_insert").val("");
  $("#insert_state").removeClass("alert-success");
  $("#insert_state").addClass("alert-light");
  $("#insert_state").html("");
  /* Update */
  $("#username_to_update").val("");
  $("#password_to_update").val("");
  $("#access_to_update").val("");
  $("#update_state").removeClass("alert-success");
  $("#update_state").addClass("alert-light");
  $("#update_state").html("");
  /* Remove */
  $("#id_to_remove").val("");
  $("#remove_state").removeClass("alert-success");
  $("#remove_state").addClass("alert-light");
  $("#remove_state").html("");
}
