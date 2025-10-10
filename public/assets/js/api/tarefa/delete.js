async function excluirTarefa(id) {
  if (!id) return;

  if (!confirm("Tem certeza que deseja excluir?")) return;

  const fd = new FormData();
  fd.append("id", id);

  const resp = await fetch("/afonso/owl-school/api/tarefa/delete.php", {
    method: "POST",
    body: fd
  });

  const data = await resp.json();

  if (data.success) {
    if (typeof carregarTarefas === "function") carregarTarefas();
  } else {
    alert("Erro: " + (data.message || "falha ao excluir"));
  }
}
