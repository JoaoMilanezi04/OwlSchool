async function criarChamada() {


  const data = document.getElementById("data").value;

  const formularioDados = new FormData();

  formularioDados.append("data", data);


  const resposta = await fetch("/owl-school/api/chamada/create.php", {
    method: "POST",
    body: formularioDados

  });

  const resultado = await resposta.json();

  if (resultado.success) {

    alert(resultado.message);

    document.getElementById("data").value = "";

    if (typeof carregarChamadas === "function") {carregarChamadas()}

  } else {
    alert(resultado.message);
  }
}


document.getElementById("btnCriarChamada").addEventListener("click", criarChamada);
