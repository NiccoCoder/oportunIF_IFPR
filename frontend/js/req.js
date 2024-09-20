function buscarProjetosGerenciamento() {
  //alert("opa");
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
      if (data.length > 0) {
        $.each(data, function(index, item) {

        if(item.POSSUI_BOLSA == '0'){
          possui = 'Não';
        }
        else{
          possui = 'Sim';
        }
        //  //$("#resultado").append("<tr><td>" + item.TITULO + "</td><td>" + item.TIPO + "</td></tr>");   
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
                            <td>` + item.TITULO +`</td>
                            <td>`+ item.NOME_TIPO_PROJETO +`</td>
                            <td>`+ item.NOME +`</td>
                            <td>`+ possui +`</td>
                            <td>
                              <div class="action-buttons">
                                <button title="Visualizar" onclick="openModal('`+ item.TITULO +`', '`+ item.NOME_TIPO_PROJETO +`','`+ item.NOME +`','`+ possui +`','`+ item.RESUMO +`')">
                                  <i class="mdi mdi-eye icon text-success ml-auto"></i>
                                </button>
                                <button title="Deletar" onclick="openDeleteModal('`+item.TITULO+`',`+ item.ID_PROJETO+`)">
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
        $("#resultado").append("<p>Nenhum projeto encontrado.</p>");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $("#resultado").append("<p>Erro ao buscar os projetos: " + errorThrown + "</p>");
    }
  });
}


function deletarProjeto(idProjeto){
  
  $.ajax({
    type: "POST",
    url: "../../backend/requisicoes/req_deletar_projeto.php",
    data: "id=" +idProjeto, 
    success: function(data){
      alert("Projeto deletado com sucesso!");
      console.log(idProjeto);
      closeDeleteModal();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      //$("#resultado").append("<p>Erro ao buscar os projetos: " + errorThrown + "</p>");
    }
  });

}
