var idSelecionado;
$(document).ready(function () {
  $.ajax({
    url: "../../backend/requisicoes/req_gerenciamento.php",
    dataType: "json",
    success: function (data) {
      if (data.length > 0) {
        $.each(data, function (index, item) {
          $("#totalDiscente").append(item.NUMERO_DISCENTES);
          $("#totalDocente").append(item.NUMERO_DOCENTES);
          $("#totalProjeto").append(item.NUMERO_PROJETOS);
        });
      }
    },
  });
  // PADRAO DA PAGINA MOSTRAR OS PROJETOS
  buscarProjetosGerenciamento();
});

//  PROJETOS
function buscarProjetosGerenciamento() {
  $.ajax({
    url: "../../backend/requisicoes/req_projeto.php",
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
                                <button title="Visualizar" onclick="openModal('`+ item.TITULO + `', '` + item.NOME_TIPO_PROJETO + `','` + item.NOME + `','` + possui + `','` + item.RESUMO + `')">
                                  <i class="mdi mdi-eye icon text-success ml-auto"></i>
                                </button>
                                <button title="Deletar" onclick="openDeleteModal('`+ item.TITULO + `',` + item.ID_PROJETO + `)">
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


function buscarDocentesGerenciamento() {
  $.ajax({
    url: "../../backend/requisicoes/req_docente.php",
    dataType: "json",
    success: function (data) {
      console.log(data);
      //Zerando o titulo
      $("#tituloTabela").empty();
      //zerando a tabela
      $('#tabelaInfo').empty();

      $('#linhaTabela').empty();
      //Dando nome a tabela
      $("#tituloTabela").append("Docentes");
      //começar a tabela
      $('#tabelaInfo').append(`
        <tr><th>
                              <div class="form-check form-check-muted m-0">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                </label>
                              </div>
                            </th>
                            <th> Nome </th>
                            <th> Email   </th>
                            <th> Situação </th>
                            <th> Numero de projetos </th>
                            <th> Opções </th>
                            
                          </tr>
        `);

      //Modal
      $("#nomeModal").text("Detalhes do Docente");
      $("#tituloModal").text("Nome:");
      $("#tipoModal").text("Email:");
      $("#responsavelModal").text("Numero de projetos:");
      $("#bolsaModal").text("Situação")
      $("#resumoModal").empty();

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
                            <td>` + item.NOME + `</td>
                            <td>`+ item.EMAIL + `</td>
                            <td>`+ item.SITUACAO + `</td>
                            <td>`+ item.TOTAL_PROJETOS + `</td>
                            <td>
                              <div class="action-buttons">
                                <button title="Visualizar" onclick="openModal('`+ item.NOME + `', '` + item.EMAIL + `','` + item.TOTAL_PROJETOS + `','` + item.SITUACAO + `', null )">
                                  <i class="mdi mdi-eye icon text-success ml-auto"></i>
                                </button>
                                <button title="Deletar" onclick="openDeleteModal('`+ item.TITULO + `',` + item.ID_PROJETO + `)">
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
        $("#tituloTabela").append("Nenhum docente encontrado!");
        $('#tabelaInfo').empty();
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $("#resultado").append("<p>Erro ao buscar os projetos: " + errorThrown + "</p>");
    }
  });
}

function buscarDiscentesGerenciamento() {
  $.ajax({
      url: "../../backend/requisicoes/req_discente.php", // Verifique se o caminho está correto
      dataType: "json",
      success: function (data) {
          console.log(data);
          // Zerar o título
          $("#tituloTabela").empty();
          // Zerar a tabela
          $('#tabelaInfo').empty();
          $('#linhaTabela').empty();
          // Dando nome à tabela
          $("#tituloTabela").append("Discentes");
          // Começar a tabela
          $('#tabelaInfo').append(`
              <tr>
                  <th>
                      <div class="form-check form-check-muted m-0">
                          <label class="form-check-label">
                              <input type="checkbox" class="form-check-input">
                          </label>
                      </div>
                  </th>
                  <th> Nome </th>
                  <th> Email </th>
                  <th> Situação </th>
                  <th> Opções </th>
              </tr>
          `);

          // Modal
          $("#nomeModal").text("Detalhes do Discente");
          $("#tituloModal").text("Nome:");
          $("#tipoModal").text("Email:");
          $("#bolsaModal").text("Situação");
          $("#resumoModal").empty();

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
                          <td>${item.NOME}</td>
                          <td>${item.EMAIL}</td>
                          <td>${item.SITUACAO}</td>
                          <td>
                              <div class="action-buttons">
                                  <button title="Visualizar" onclick="openModal('${item.NOME}', '${item.EMAIL}', '${item.SITUACAO}', null)">
                                      <i class="mdi mdi-eye icon text-success ml-auto"></i>
                                  </button>
                                  <button title="Deletar" onclick="openDeleteModal('${item.NOME}', ${item.ID_DISCENTE})">
                                      <i class="mdi mdi-delete icon text-danger ml-auto"></i>
                                  </button>
                              </div>
                          </td>
                      </tr>
                      `
                  );
              });
          } else {
              $("#tituloTabela").empty();
              $("#tituloTabela").append("Nenhum discente encontrado!");
              $('#tabelaInfo').empty();
          }
      },
      error: function (jqXHR, textStatus, errorThrown) {
          $("#resultado").append("<p>Erro ao buscar os discentes: " + errorThrown + "</p>");
      }
  });
}


function openDeleteModal(title, id) {
  idSelecionado = id;
  document.getElementById("deleteTitle").textContent = title;
  botaoDeletarProjeto.removeEventListener("onclick", deletarProjeto);

  $('#botaoDeletarProjeto').onclick(deletarProjeto());

  //botaoDeletarProjeto.addEventListener("onclick", deletarProjeto.bind(id));
  deleteModal.style.display = "block";
}
function openDeleteModal(title, id) {
  console.log(id);
  idSelecionado = id;
  //document.getElementById("deleteTitle").textContent = title;


  //botaoDeletarProjeto.removeEventListener("onclick", deletarProjeto);
  deleteModal.style.display = "block";
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




