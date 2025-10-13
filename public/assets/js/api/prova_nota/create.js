async function criarNota() {
  const provaId = document.getElementById("prova_id").value;
  const alunoId = document.getElementById("aluno_id").value;
  const nota    = document.getElementById("nota").value;

  const dados = new FormData();
  dados.append("prova_id", provaId);
  dados.append("aluno_id", alunoId);
  dados.append("nota", nota);

  const resposta = await fetch("/afonso/owl-school/api/prova_nota/create.php", {
    method: "POST",
    body: dados
  });

  const resultado = await resposta.json();

  if (resultado.success) {
    alert("Nota criada!");

    document.getElementById("aluno_id").value = "";
    document.getElementById("nota").value = "";

    if (typeof carregarNotas === "function") carregarNotas(provaId);
  } else {
    alert("Erro: " + resultado.message);
  }
}

document.getElementById("btnCriarNota")?.addEventListener("click", criarNota);
