async function excluirProva(identificador) {
  if (!identificador) return;
  if (!confirm("Tem certeza que deseja excluir?")) return;

  const dados = new FormData();
  dados.append("id", identificador);

  const resposta = await fetch("/afonso/owl-school/api/prova/delete.php", {
    method: "POST",
    body: dados
  });

  const resultado = await resposta.json();

if (resultado.success) {
  location.reload();
} else {
  alert("Erro: " + (resultado.message || "Falha ao excluir chamada."));
}
}