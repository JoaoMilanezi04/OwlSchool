async function excluirHorario(id) {
  if (!id) return;

  if (!confirm("Tem certeza que deseja excluir este horário?")) return;

  const dados = new FormData();
  dados.append("id", id);

  const resposta = await fetch("/afonso/owl-school/api/agenda/delete.php", {
    method: "POST",
    body: dados
  });

  const resultado = await resposta.json();

  if (resultado.success) {
    if (typeof carregarAgenda === "function") carregarAgenda(); // recarrega lista se existir
  } else {
    alert("Erro: " + (resultado.message || "Falha ao excluir horário."));
  }
}
