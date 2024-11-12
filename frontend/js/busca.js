//Quando estiver pronto

$(document).ready(function(){


        //ele vai ver se foi clicado em algo    
    $(document).on("keyup","#busca",function(e){
        e.preventDefault();
        //vai pegar o valor do busca ali em cima, e colocar em uma variavel
        var buscar = $("#busca").val();
        //fazer a requisição ajax
        $.ajax({
            url: '../../backend/requisicoes/req_busca.php',
            method: 'POST',
            data: "busca=" + buscar,
            //quando estiver feita ele vai mudar o html da tabela para a resposta
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
                                      <th> E-mail</th>
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
                                      <td>`+ item.EMAIL   + `</td>
                                      <td>
                                        <div class="action-buttons">
                                          <button title="Visualizar" onclick="openModal('`+ item.TITULO + `', '` + item.NOME_TIPO_PROJETO + `','` + item.NOME + `','` + item.EMAIL + `','` +possui + `','` + item.RESUMO + `','` + item.CRITERIOS + `','` + item.DESCRICAO  + `','` + item.REQUISITOS + `')">
                                            <i class="mdi mdi-eye icon text-success ml-auto"></i>
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
              }
        // }).done(function(data){
        //     $(".tabela").html(data)
        })
    })
})