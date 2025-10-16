let idDaChamadaAtual = null;

async function editarChamada(idChamada) {
  idDaChamadaAtual = idChamada;

  // abre o modal
  const elementoModal = document.getElementById("editModalChamada");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();

  try {
    // lista e acha a chamada pelo id
    const resposta = await fetch("/afonso/owl-school/api/chamada/read.php", {
      method: "POST"
    });
    const dados = await resposta.json();

    if (!dados.success) throw new Error(dados.message || "Falha ao listar.");

    const chamada = dados.chamadas.find(c => String(c.id) === String(idChamada));
    if (!chamada) throw new Error("Chamada não encontrada.");

    // preenche campos (só data, por enquanto)
    document.getElementById("edit_data_chamada").value = chamada.data;

  } catch (erro) {
    alert("Erro ao carregar chamada.");
  }
}

// salvar atualização
document.getElementById("btnSalvarChamada").onclick = async function () {
  const data = document.getElementById("edit_data_chamada").value;

  const formulario = new FormData();
  formulario.append("id",   idDaChamadaAtual);
  formulario.append("data", data);

  try {
    const resposta = await fetch("/afonso/owl-school/api/chamada/update.php", {
      method: "POST",
      body: formulario
    });

    const resultado = await resposta.json();

    if (resultado.success) {
      alert("Chamada atualizada com sucesso!");

      if (typeof carregarChamadas === "function") carregarChamadas();

      const elementoModal = document.getElementById("editModalChamada");
      const modal = bootstrap.Modal.getInstance(elementoModal);
      modal.hide();

    } else {
      alert("Erro ao atualizar chamada: " + (resultado.message || "erro desconhecido."));
    }
  } catch (erro) {
    alert("Erro ao atualizar chamada.");
  }
};
