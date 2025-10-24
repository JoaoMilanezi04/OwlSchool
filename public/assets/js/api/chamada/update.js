let idDaChamadaAtual = null;

async function editarChamada(idChamada) {

  idDaChamadaAtual = idChamada;

  const elementoModal = document.getElementById("editModalChamada");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();


  const resposta = await fetch("/owl-school/api/chamada/read.php", { method: "POST"});

  const dados = await resposta.json();
  const chamada = dados.chamadas.find(chamada => String(chamada.id) === String(idChamada));


  document.getElementById("edit_data_chamada").value = chamada.data;
}


async function salvarChamada() {

  const data = document.getElementById("edit_data_chamada").value;

  const formularioDados = new FormData();

  formularioDados.append("id", idDaChamadaAtual);
  formularioDados.append("data", data);


  const resposta = await fetch("/owl-school/api/chamada/update.php", {
    method: "POST",
    body: formularioDados

  });


  const resultado = await resposta.json();


  if (resultado.success) {

    alert(resultado.message);

    if (typeof carregarChamadas === "function") {carregarChamadas();}

    const modal = bootstrap.Modal.getInstance(document.getElementById("editModalChamada"));
    modal.hide();

  } else {
    alert(resultado.message);
  }
}


document.getElementById("btnSalvarChamada").addEventListener("click", salvarChamada);
