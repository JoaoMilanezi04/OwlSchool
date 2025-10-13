async function criarProva() {

  const campoTitulo = document.getElementById("titulo");
  const campoData   = document.getElementById("data");

  const titulo = campoTitulo.value;
  const data   = campoData.value;

  const formularioDados = new FormData();
  formularioDados.append("titulo", titulo);
  formularioDados.append("data", data);

  const resposta = await fetch("/afonso/owl-school/api/prova/create.php", {
    method: "POST",
    body: formularioDados
  });

  const resultado = await resposta.json();

  if (resultado.success) {
    alert("Prova criada!");

    campoTitulo.value = "";
    campoData.value = "";

    if (typeof carregarProvas === "function") {
      carregarProvas();
    }

  } else {
    alert("Erro: " + resultado.message);
  }
}

document.getElementById("btnCriar").addEventListener("click", criarProva);
