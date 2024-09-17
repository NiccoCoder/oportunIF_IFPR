function buscarProjetos() {
    //buscando os projetos de talusuario com o id abaixo
    var idUsuario = $('#id_usuario').val();
    $.ajax({
        //qual pagina ele fara  requisição
      url: "req.php",
        //o metodo utilizado para isso
      type: "POST",
        //a variavel que ele ira passar no post
      data: { id: idUsuario },
        //o tipo do qual ira retornar
      dataType: "json",
      success: function(data) {
        //ira resetar a div
        $("#resultado").empty();
        //caso o retorno for maior que 0,ele ira executar
        if (data.length > 0) {
          $("#resultado").append("<table><thead><tr><th>Título do Projeto</th><th>Tipo de Projeto</th></tr></thead><tbody>");
          //ele ira pegar o retorno o tranformara 
          $.each(data, function(index, item) {
              //MUDAR O TITULO DE TIPO PARA NOME OU OUTRA COISA
            $("#resultado").append("<tr><td>" + item.TITULO + "</td><td>" + item.TIPO + "</td></tr>");
          });
          $("#resultado").append("</tbody></table>");
        } else {
          $("#resultado").append("<p>Nenhum projeto encontrado para o ID informado.</p>");
        }
      },
      //caso de erro, ele mostra o erro
      error: function(jqXHR, textStatus, errorThrown) {
        $("#resultado").append("<p>Erro ao buscar os projetos: " + errorThrown + "</p>");
      }
    });
  }

  function buscarCursos(){

    $.ajax({
        //qual pagina ele fara  requisição
      url: "../../backend/requisicoes/req_cursos.php",
        //o metodo utilizado para isso
      type: "POST",
        //a variavel que ele ira passar no post
      data: { id: idUsuario },
        //o tipo do qual ira retornar
      dataType: "json",
      success: function(data) {
        //ira resetar a div
        $("#resultado").empty();
        //caso o retorno for maior que 0,ele ira executar
        if (data.length > 0) {
          $("#resultado").append("<table><thead><tr><th>Título do Projeto</th><th>Tipo de Projeto</th></tr></thead><tbody>");
          //ele ira pegar o retorno o tranformara 
          $.each(data, function(index, item) {
              //MUDAR O TITULO DE TIPO PARA NOME OU OUTRA COISA
            $("#resultado").append("<tr><td>" + item.TITULO + "</td><td>" + item.TIPO + "</td></tr>");
          });
          $("#resultado").append("</tbody></table>");
        } else {
          $("#resultado").append("<p>Nenhum projeto encontrado para o ID informado.</p>");
        }
      },
      //caso de erro, ele mostra o erro
      error: function(jqXHR, textStatus, errorThrown) {
        $("#resultado").append("<p>Erro ao buscar os projetos: " + errorThrown + "</p>");
      }
    });

  }