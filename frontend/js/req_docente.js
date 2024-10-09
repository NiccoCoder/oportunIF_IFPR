//var idSelecionado;
$(document).ready(function () {
  buscarProjetos();
  console.log("opa");
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

      // //MODAL
      // $("#nomeModal").text("Detalhes do Projeto");
      // $("#tituloModal").text("Titulo:");
      // $("#tipoModal").text("Tipo:");
      // $("#responsavelModal").text("Responsavel:");
      // $("#bolsaModal").text("Com bolsa:");
      // $("#resumoModal").text("Resumo:");

      if (data.length > 0) {
        $.each(data, function (index, item) {
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
                            <td>`+ item.ID_TIPO_PROJETO + `</td>
                            <td>`+ item.NOME + `</td>
                            <td>` + `</td>
                            <td>
                              <div class="action-buttons">
                                <button title="Visualizar" ">
                                  <i class="mdi mdi-eye icon text-success ml-auto"></i>
                                </button>
                                <button title="Deletar" >
                                  <i class="mdi mdi-delete icon text-danger ml-auto"></i>
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

function deletarProjeto() {

  $.ajax({
    type: "POST",
    url: "../../backend/requisicoes/req_deletar_projeto.php",
    data: "id=" + idSelecionado,
    success: function (data) {
      alert("Projeto deletado com sucesso!" + data);
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

function openModal(title, type, responsible, grant, summary) {
  document.getElementById("modalTitle").textContent = title;
  document.getElementById("modalType").textContent = type;
  document.getElementById("modalResponsible").textContent = responsible;
  document.getElementById("modalGrant").textContent = grant;
  document.getElementById("modalSummary").textContent = summary;
  projectModal.style.display = "block";
}


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




