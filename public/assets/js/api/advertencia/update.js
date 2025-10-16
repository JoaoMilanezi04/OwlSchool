let idDaAdvertenciaAtual = null;

async function editarAdvertencia(idAdvertencia) {
  idDaAdvertenciaAtual = idAdvertencia;

  // abre o modal
  const elementoModal = document.getElementById("editModalAdvertencia");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();

  try {
    // carrega lista e acha a advertência pelo id
    const resposta = await fetch("/afonso/owl-school/api/advertencia/read.php", {
      method: "POST"
    });
    const dados = await resposta.json();

    const advertencia = dados.advertencias.find(a => String(a.id) === String(idAdvertencia));
    if (!advertencia) throw new Error("Advertência não encontrada.");

    // preenche campos
    document.getElementById("edit_titulo_advertencia").value    = advertencia.titulo;
    document.getElementById("edit_descricao_advertencia").value = advertencia.descricao;

  } catch (erro) {
    alert("Erro ao carregar advertência.");
  }
}

// salvar atualização
document.getElementById("btnSalvarAdvertencia").onclick = async function () {
  const titulo    = document.getElementById("edit_titulo_advertencia").value;
  const descricao = document.getElementById("edit_descricao_advertencia").value;

  const formulario = new FormData();
  formulario.append("id", idDaAdvertenciaAtual);
  formulario.append("titulo", titulo);
  formulario.append("descricao", descricao);

  try {
    const resposta = await fetch("/afonso/owl-school/api/advertencia/update.php", {
      method: "POST",
      body: formulario
    });

    const resultado = await resposta.json();

    if (resultado.success) {
      alert("Advertência atualizada com sucesso!");

      if (typeof carregarAdvertencias === "function") carregarAdvertencias();

      const elementoModal = document.getElementById("editModalAdvertencia");
      const modal = bootstrap.Modal.getInstance(elementoModal);
      modal.hide();

    } else {
      alert("Erro ao atualizar advertência: " + (resultado.message || "erro desconhecido."));
    }
  } catch (erro) {
    alert("Erro ao atualizar advertência.");
  }
};
