async function criarComunicado() {


  const titulo = document.getElementById("titulo").value;
  const corpo  = document.getElementById("corpo").value;


  const formularioDados = new FormData();

  formularioDados.append("titulo", titulo);
  formularioDados.append("corpo", corpo);


  const resposta = await fetch("/afonso/owl-school/api/comunicado/create.php", {
    method: "POST",
    body: formularioDados

  });


  const resultado = await resposta.json();


  if (resultado.success) {

    alert(resultado.message);

    document.getElementById("titulo").value = "";
    document.getElementById("corpo").value  = "";

    if (typeof carregarComunicados === "function") {carregarComunicados();}

  } else {
    alert(resultado.message);
  }
}


document.getElementById("btnCriar").addEventListener("click", criarComunicado);
