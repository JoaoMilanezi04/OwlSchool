async function criarComunicado() {
  const campoTitulo = document.getElementById("titulo");
  const campoCorpo = document.getElementById("corpo");

  const titulo = campoTitulo.value;
  const corpo = campoCorpo.value;

  const dados = new FormData();
  dados.append("titulo", titulo);
  dados.append("corpo", corpo);

  const resposta = await fetch("/afonso/owl-school/api/comunicado/create.php", {
    method: "POST",
    body: dados
  });

  const resultado = await resposta.json();

  if (resultado.success) {
    alert("Comunicado criado!");
    campoTitulo.value = "";
    campoCorpo.value = "";
    if (typeof carregarComunicados === "function") carregarComunicados();
  } else {
    alert("Erro: " + resultado.message);
  }
}

document.getElementById("btnCriar").addEventListener("click", criarComunicado);
