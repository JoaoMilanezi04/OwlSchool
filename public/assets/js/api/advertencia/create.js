async function criarAdvertencia() {

  const campoTitulo     = document.getElementById("titulo");
  const campoDescricao  = document.getElementById("descricao");

  const titulo    = campoTitulo.value;
  const descricao = campoDescricao.value;

  const formularioDados = new FormData();
  formularioDados.append("titulo", titulo);
  formularioDados.append("descricao", descricao);

  const resposta = await fetch("/afonso/owl-school/api/advertencia/create.php", {
    method: "POST",
    body: formularioDados
  });

  const resultado = await resposta.json();

  if (resultado.success) {
    alert("Advertência criada!");

    campoTitulo.value = "";
    campoDescricao.value = "";

    if (typeof carregarAdvertencias === "function") {
      carregarAdvertencias();
    }

  } else {
    alert("Erro: " + resultado.message);
  }
}

document.getElementById("btnCriar").addEventListener("click", criarAdvertencia);
