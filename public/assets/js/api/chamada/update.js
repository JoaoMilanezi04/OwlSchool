let idDaChamadaAtual = null;


async function editarChamada(idChamada) {

  idDaChamadaAtual = idChamada;


  const elementoModal = document.getElementById("editModalChamada");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();


  const resposta = await fetch("/afonso/owl-school/api/chamada/read.php", {
    method: "POST"
  });

  const dados = await resposta.json();

  if (!dados.success) {
    alert("Erro ao carregar chamada.");
    return;
  }

  const chamada = dados.chamadas.find(c => String(c.id) === String(idChamada));

  if (!chamada) {
    alert(resultado.success);
    return;
  }

  document.getElementById("edit_data_chamada").value = chamada.data;
}


async function salvarChamada() {

  const data = document.getElementById("edit_data_chamada").value;

  const formularioDados = new FormData();

  formularioDados.append("id", idDaChamadaAtual);
  formularioDados.append("data", data);


  const resposta = await fetch("/afonso/owl-school/api/chamada/update.php", {
    method: "POST",
    body: formularioDados

  });


  const resultado = await resposta.json();


  if (resultado.success) {

    alert(resultado.success);

    if (typeof carregarChamadas === "function") {
      carregarChamadas();
    }

    const modal = bootstrap.Modal.getInstance(document.getElementById("editModalChamada"));
    modal.hide();

  } else {
    alert(resultado.success);
  }
}


document.getElementById("btnSalvarChamada").addEventListener("click", salvarChamada);
