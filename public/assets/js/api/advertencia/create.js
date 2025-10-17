async function criarAdvertencia() {

  const campoTitulo    = document.getElementById("titulo");
  const campoDescricao = document.getElementById("descricao");
  const campoAluno     = document.getElementById("aluno_id");

  const titulo    = campoTitulo.value;
  const descricao = campoDescricao.value;
  const aluno_id  = campoAluno.value;

  const formularioDados = new FormData();
  formularioDados.append("titulo", titulo);
  formularioDados.append("descricao", descricao);
  formularioDados.append("aluno_id", aluno_id);

  const resposta = await fetch("/afonso/owl-school/api/advertencia/create.php", {
    method: "POST",
    body: formularioDados
  });

  const resultado = await resposta.json();

  if (resultado.success) {
    alert("Advertência criada!");

    campoTitulo.value = "";
    campoDescricao.value = "";
    campoAluno.selectedIndex = 0;

    if (typeof carregarAdvertencias === "function") {
      carregarAdvertencias();
    }

  } else {
    alert("Erro: " + resultado.message);
  }
}

document.getElementById("btnCriarAdvertencia").addEventListener("click", criarAdvertencia);
