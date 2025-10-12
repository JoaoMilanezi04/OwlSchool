async function criarTarefa() {



  const campoTitulo = document.getElementById("titulo");
  const campoDescricao = document.getElementById("descricao");
  const campoDataEntrega = document.getElementById("data_entrega");




  const titulo = campoTitulo.value;
  const descricao = campoDescricao.value;
  const data_entrega = campoDataEntrega.value;




  const formularioDados = new FormData();


  formularioDados.append("titulo", titulo);
  formularioDados.append("descricao", descricao);
  formularioDados.append("data_entrega", data_entrega);



  const resposta = await fetch("/afonso/owl-school/api/tarefa/create.php", {
    method: "POST",
    body: formularioDados
  });



  const resultado = await resposta.json();



  if (resultado.success) {
    alert("Tarefa criada!");


    campoTitulo.value = "";
    campoDescricao.value = "";
    campoDataEntrega.value = "";



    if (typeof carregarTarefas === "function") {
      carregarTarefas();
    }


  } else {
    alert("Erro: " + resultado.message);
  }
}


document.getElementById("btnCriar").addEventListener("click", criarTarefa);
