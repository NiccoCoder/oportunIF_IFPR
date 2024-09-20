function buscarProjetosGerenciamento(tipo) {
  $.ajax({
    url: "req.php",
    dataType: "json",
    success: function(data) {
      //Zerando a DIV
      $("#resultado").empty();
      //VERIFICANDO SE É MAIOR QUE ZERO A BUSCA DAS LINHAS
      if (data.length > 0) {
      //CASE PARA CADA CASO DA BUSCA DA TABELA
          switch (tipo) {
            //caso seja um projeto
            case 'projeto':
              
            $("#divTabela").append(
              "<table><thead><tr><th>Título do Projeto</th><th>Tipo de Projeto</th></tr></thead><tbody>"
            );
            $.each(data, function(index, item) {
                //MUDAR O TITULO DE TIPO PARA NOME OU OUTRA COISA
              $("#resultado").append("<tr><td>" + item.TITULO + "</td><td>" + item.TIPO + "</td></tr>");
            });
            $("#resultado").append("</tbody></table>");

            
              break;
            case 'discente':

              break;
            case 'docente':
              
              break;
          }
          
        } else {
          $("#resultado").append("<p>Nenhum projeto encontrado para o ID informado.</p>");
        }
      
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $("#resultado").append("<p>Erro ao buscar os projetos: " + errorThrown + "</p>");
    }
  });
}
