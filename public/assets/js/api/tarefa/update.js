async function atualizarTarefa() {
  const id = document.getElementById("id").value;
  const titulo = document.getElementById("titulo").value;
  const descricao = document.getElementById("descricao").value;
  const data_entrega = document.getElementById("data_entrega").value;

  if (!id) return alert("Informe o ID da tarefa.");

  const formData = new FormData();
  formData.append("id", id);
  formData.append("titulo", titulo);
  formData.append("descricao", descricao);
  formData.append("data_entrega", data_entrega);

  const resp = await fetch("/afonso/owl-school/api/tarefa/update.php", {
    method: "POST",
    body: formData
  });

  const data = await resp.json();

  if (data.success) {
    alert("Tarefa atualizada!");
    if (typeof carregarTarefas === "function") carregarTarefas(); // recarrega a lista
  } else {
    alert("Erro: " + data.message);
  }
}

document.getElementById("btnEditar").addEventListener("click", atualizarTarefa);
