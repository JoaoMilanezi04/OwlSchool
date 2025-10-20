let idDaProvaAtual = null;


async function editarProva(idProva) {

  idDaProvaAtual = idProva;


  const elementoModal = document.getElementById("editModalProva");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();


  const resposta = await fetch("/afonso/owl-school/api/prova/read.php", {
    method: "POST"
  });

  const dados = await resposta.json();

  const prova = dados.provas.find(p => String(p.id) === String(idProva));

  if (!prova) {
    alert("Prova não encontrada.");
    return;
  }

  document.getElementById("edit_titulo_prova").value = prova.titulo;
  document.getElementById("edit_data_prova").value   = prova.data;
}


async function salvarProva() {

  const titulo = document.getElementById("edit_titulo_prova").value;
  const data   = document.getElementById("edit_data_prova").value;


  const formularioDados = new FormData();

  formularioDados.append("id", idDaProvaAtual);
  formularioDados.append("titulo", titulo);
  formularioDados.append("data", data);


  const resposta = await fetch("/afonso/owl-school/api/prova/update.php", {
    method: "POST",
    body: formularioDados

  });


  const resultado = await resposta.json();


  if (resultado.success) {

    alert("Prova atualizada com sucesso!");

    if (typeof carregarProvas === "function") {
      carregarProvas();
    }

    const modal = bootstrap.Modal.getInstance(document.getElementById("editModalProva"));
    modal.hide();

  } else {
    alert("Erro ao atualizar prova: " + (resultado.message || "erro desconhecido."));
  }
}


document.getElementById("btnSalvarProva").addEventListener("click", salvarProva);
