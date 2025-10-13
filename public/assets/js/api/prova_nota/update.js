async function atualizarNota() {
  const provaId = document.getElementById("prova_id").value;
  const alunoId = document.getElementById("aluno_id").value;
  const nota    = document.getElementById("nota").value;

  const dados = new FormData();
  dados.append("prova_id", provaId);
  dados.append("aluno_id", alunoId);
  dados.append("nota", nota);

  const resposta = await fetch("/afonso/owl-school/api/prova_nota/update.php", {
    method: "POST",
    body: dados
  });

  const resultado = await resposta.json();

  if (resultado.success) {
    alert("Nota atualizada!");
    if (typeof carregarNotas === "function") carregarNotas(provaId);
  } else {
    alert("Erro: " + resultado.message);
  }
}


function preencherFormularioNota(alunoId, valorNota) {
  document.getElementById("aluno_id").value = alunoId;
  document.getElementById("nota").value = valorNota;
  document.getElementById("aluno_id").focus();
}


document.getElementById("btnAtualizarNota")?.addEventListener("click", atualizarNota);
