let idDaProvaAtual = null;

async function editarProva(idProva) {
  idDaProvaAtual = idProva;


  const elementoModal = document.getElementById("editModalProva");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();

  try {

    const resposta = await fetch("/afonso/owl-school/api/prova/read.php", {
      method: "POST"
    });
    const dados = await resposta.json();

    const prova = dados.provas.find(p => String(p.id) === String(idProva));
    if (!prova) throw new Error("Prova não encontrada.");


    document.getElementById("edit_titulo_prova").value = prova.titulo;
    document.getElementById("edit_data_prova").value   = prova.data;

  } catch (erro) {
    alert("Erro ao carregar prova.");
  }
}


document.getElementById("btnSalvarProva").onclick = async function () {
  const titulo = document.getElementById("edit_titulo_prova").value;
  const data   = document.getElementById("edit_data_prova").value;

  const formulario = new FormData();
  formulario.append("id", idDaProvaAtual);
  formulario.append("titulo", titulo);
  formulario.append("data", data);

  try {
    const resposta = await fetch("/afonso/owl-school/api/prova/update.php", {
      method: "POST",
      body: formulario
    });

    const resultado = await resposta.json();

    if (resultado.success) {
      alert("Prova atualizada com sucesso!");

      if (typeof carregarProvas === "function") carregarProvas();

      const elementoModal = document.getElementById("editModalProva");
      const modal = bootstrap.Modal.getInstance(elementoModal);
      modal.hide();

    } else {
      alert("Erro ao atualizar prova: " + (resultado.message || "erro desconhecido."));
    }
  } catch (erro) {
    alert("Erro ao atualizar prova.");
  }
};
