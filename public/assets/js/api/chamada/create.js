async function criarChamada() {

  const campoData = document.getElementById("data");

  const data = campoData.value;

  const formularioDados = new FormData();
  formularioDados.append("data", data);

  const resposta = await fetch("/afonso/owl-school/api/chamada/create.php", {
    method: "POST",
    body: formularioDados
  });

  const resultado = await resposta.json();

  if (resultado.success) {
    alert("Chamada criada!");

    campoData.value = "";

    if (typeof carregarChamadas === "function") {
      carregarChamadas();
    }

  } else {
    alert("Erro: " + resultado.message);
  }
}

document.getElementById("btnCriarChamada").addEventListener("click", criarChamada);
