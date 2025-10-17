let idAdvertenciaAtual = null;

async function abrirModalEditarAdvertencia(id, titulo, descricao) {

  idAdvertenciaAtual = id;

  // Preenche os campos direto, sem precisar buscar de novo
  document.getElementById("edit_titulo").value = titulo;
  document.getElementById("edit_descricao").value = descricao;

  // Abre o modal
  const elementoModal = document.getElementById("editModalAdvertencia");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();
}

document.getElementById("btnSalvarAdvertencia").onclick = async function () {
  const titulo = document.getElementById("edit_titulo").value;
  const descricao = document.getElementById("edit_descricao").value;

  const formulario = new FormData();
  formulario.append("id", idAdvertenciaAtual);
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

      if (typeof carregarAdvertencias === "function") {
        carregarAdvertencias();
      }

      const modal = bootstrap.Modal.getInstance(document.getElementById("editModalAdvertencia"));
      modal.hide();

    } else {
      alert("Erro ao atualizar advertência: " + (resultado.message || "erro desconhecido."));
    }

  } catch (erro) {
    alert("Erro ao atualizar advertência.");
  }
};
