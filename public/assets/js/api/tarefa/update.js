let idDaTarefaAtual = null;


async function editarTarefa(idTarefa) {
  idDaTarefaAtual = idTarefa;



  const elementoModal = document.getElementById("editModal");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();



  try {
    const resposta = await fetch("/afonso/owl-school/api/tarefa/read.php");
    const dados = await resposta.json();
    const tarefa = dados.tarefas.find(t => String(t.id) === String(idTarefa));



    document.getElementById("edit_titulo").value = tarefa.titulo;
    document.getElementById("edit_descricao").value = tarefa.descricao;
    document.getElementById("edit_data").value = tarefa.data_entrega;



  } catch (erro) {
    alert("Erro ao carregar tarefa.");
  }
}



document.getElementById("btnSalvar").onclick = async function () {


  const titulo = document.getElementById("edit_titulo").value;
  const descricao = document.getElementById("edit_descricao").value;
  const dataEntrega = document.getElementById("edit_data").value;



  const formulario = new FormData();

  formulario.append("id", idDaTarefaAtual);
  formulario.append("titulo", titulo);
  formulario.append("descricao", descricao);
  formulario.append("data_entrega", dataEntrega);



  try {
    const resposta = await fetch("/afonso/owl-school/api/tarefa/update.php", {
      method: "POST",
      body: formulario
    });


    const resultado = await resposta.json();


    if (resultado.success) {
      alert("Tarefa atualizada com sucesso!");


      if (typeof carregarTarefas === "function") carregarTarefas();


      const elementoModal = document.getElementById("editModal");
      const modal = bootstrap.Modal.getInstance(elementoModal);
      modal.hide();
      

    } else {
      alert("Erro ao atualizar tarefa: " + (resultado.message || "erro desconhecido."));
    }
    
  } catch (erro) {
    alert("Erro ao atualizar tarefa.");
  }
};

