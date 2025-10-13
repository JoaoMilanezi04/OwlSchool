async function excluirComunicado(identificador) {
  if (!identificador) return;

  if (!confirm("Tem certeza que deseja excluir?")) return;

  const dados = new FormData();
  dados.append("id", identificador);

  const resposta = await fetch("/afonso/owl-school/api/comunicado/delete.php", {
    method: "POST",
    body: dados
  });

  const resultado = await resposta.json();

  if (resultado.success) {
    if (typeof carregarComunicados === "function") carregarComunicados();
  } else {
    alert("Erro: " + (resultado.message || "falha ao excluir"));
  }
}
