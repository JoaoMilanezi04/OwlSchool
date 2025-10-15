async function excluirNota(alunoId) {
  const provaId = document.getElementById("prova_id").value;
  if (!alunoId || !provaId) return;

  if (!confirm("Tem certeza que deseja excluir esta nota?")) return;

  const dados = new FormData();
  dados.append("prova_id", provaId);
  dados.append("aluno_id", alunoId);

  const resposta = await fetch("/afonso/owl-school/api/prova_nota/delete.php", {
    method: "POST",
    body: dados
  });

  const resultado = await resposta.json();

  if (resultado.success) {
    if (typeof carregarNotas === "function") carregarNotasDaProva(provaId);
  } else {
    alert("Erro: " + (resultado.message || "falha ao excluir"));
  }
}
