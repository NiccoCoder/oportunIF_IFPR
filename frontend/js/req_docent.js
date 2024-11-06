var idSelecionado = null;
$(document).ready(function () {
  buscarProjetos();
  buscarTotalProjetos();

});

//  PROJETOS
function buscarProjetos() {
  $.ajax({
    url: "../../backend/requisicoes/req_projeto_docente.php",
    dataType: "json",
    success: function (data) {
      console.log(data);
      //Zerando o titulo
      $("#tituloTabela").empty();
      //zerando a tabela
      $('#tabelaInfo').empty();

      $('#linhaTabela').empty();
      //Dando nome a tabela
      $("#tituloTabela").append("Projetos");
      //começar a tabela
      $('#tabelaInfo').append(`
        <tr><th>
                              <div class="form-check form-check-muted m-0">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                </label>
                              </div>
                            </th>
                            <th> Titulo </th>
                            <th> Tipo   </th>
                            <th> Responsável </th>
                            <th> C/ Bolsa</th>
                            <th> Opções </th>
                          </tr>
        `);
      var possui = null;

      //MODAL
      $("#nomeModal").text("Detalhes do Projeto");
      $("#tituloModal").text("Titulo:");
      $("#tipoModal").text("Tipo:");
      $("#responsavelModal").text("Responsavel:");
      $("#bolsaModal").text("Com bolsa:");
      $("#resumoModal").text("Resumo:");

      if (data.length > 0) {
        $.each(data, function (index, item) {


          if (item.POSSUI_BOLSA == '0') {
            possui = 'Não';
            
          }
          else {
            possui = 'Sim';
          }
          
          $("#linhaTabela").append(
            `
              <tr>                  
                            <td>
                              <div class="form-check form-check-muted m-0">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                </label>
                              </div>
                            </td>
                            <td>` + item.TITULO + `</td>
                            <td>`+ item.NOME_TIPO_PROJETO + `</td>
                            <td>`+ item.NOME + `</td>
                            <td>`+ possui + `</td>
                            <td>
                              <div class="action-buttons">
                                <button title="Visualizar" onclick="openModal('`+ item.TITULO + `', '` + item.NOME_TIPO_PROJETO + `','` + item.NOME + `','` + possui + `','` + item.RESUMO + `','` + item.CRITERIOS + `','` + item.DESCRICAO  + `','` + item.REQUISITOS + `')">
                                  <i class="mdi mdi-eye icon text-success ml-auto"></i>
                                </button>
                                <button title="Deletar" onclick="openDeleteModal('`+ item.TITULO + `',` + item.ID_PROJETO + `)">
                                  <i class="mdi mdi-delete icon text-danger ml-auto"></i>
                                </button>
                                <button title="Editar"
                                  onclick="openEditModal('`+ item.TITULO + `', '` + item.NOME_TIPO_PROJETO +  `','` + possui + `','` + item.RESUMO + `','` + item.CRITERIOS + `','` + item.DESCRICAO  + `','` + item.REQUISITOS + `')"
                                  style="display: flex; justify-content: center; align-items: center;">
                                  <i class="mdi mdi-pencil icon text-primary ml-auto"></i>
                                </button>
                              </div>
                            </td>
                          </tr>
              `
          );
        });
      }
      else {
        $("#tituloTabela").empty();
        $("#tituloTabela").append("Nenhum projeto encontrado!");
        $('#tabelaInfo').empty();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $("#resultado").append("<p>Erro ao buscar os projetos: " + errorThrown + "</p>");
    }
  });
}


function buscarTotalProjetos() {
  $.ajax({
    url: "../../backend/requisicoes/req_total_projeto_docente.php",
    dataType: "json",
    success: function (data) {
      console.log(data);
      $("#totalProjetos").empty();
      if (data.length > 0) {
        $.each(data, function (index, item) {
          $("#totalProjetos").append(item.NUMERO_PROJETOS);
          console.log(item.NUMERO_PROJETOS);
        });
      }
      else {
        $("#totalProjetos").append("0");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
    }
  });
}


function openDeleteModal(title, id) {
  console.log(id);
  idSelecionado = id;
  document.getElementById("deleteTitle").textContent = title;

  document.getElementById("deleteModal").style.display = "block";

  //botaoDeletarProjeto.removeEventListener("onclick", deletarProjeto);
  deleteModal.style.display = "block";
}

// function openDeleteModal(title, id) {
//   console.log(id);
//   idSelecionado = id;
//   //document.getElementById("deleteTitle").textContent = title;


//   //botaoDeletarProjeto.removeEventListener("onclick", deletarProjeto);
//   deleteModal.style.display = "block";
// }


function deletarProjeto() {
  $.ajax({
    type: "POST",
    url: "../../backend/requisicoes/req_deletar_projeto.php",
    data: "id=" + idSelecionado,
    success: function (data) {
      alert("Projeto deletado com sucesso!");
      console.log(idSelecionado);
      closeDeleteModal();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      //$("#resultado").append("<p>Erro ao buscar os projetos: " + errorThrown + "</p>");
    }
  });
}

const projectModal = document.getElementById("projectModal");
const deleteModal = document.getElementById("deleteModal");



function closeDeleteModal() {
  deleteModal.style.display = "none";
}

const closeButtons = document.getElementsByClassName("close");
Array.from(closeButtons).forEach(function (btn) {
  btn.onclick = function () {
    projectModal.style.display = "none";
    deleteModal.style.display = "none";
  }
});

window.onclick = function (event) {
  if (event.target == projectModal || event.target == deleteModal) {
    projectModal.style.display = "none";
    deleteModal.style.display = "none";
  }
};




