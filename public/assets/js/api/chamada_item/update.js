let idChamadaAtualEditar = null;
let idAlunoAtualEditarChamada = null;

async function abrirModalEditarChamadaItem(chamadaId, alunoId, statusAtual = "presente") {
  idChamadaAtualEditar = chamadaId;
  idAlunoAtualEditarChamada = alunoId;

  const elementoModal = document.getElementById("editChamadaItemModal");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();

  document.getElementById("edit_status").value = statusAtual;
}

document.getElementById("btnSalvarEdicaoChamadaItem").onclick = async function () {
  const status = document.getElementById("edit_status").value;

  const formulario = new FormData();
  formulario.append("chamada_id", idChamadaAtualEditar);
  formulario.append("aluno_id", idAlunoAtualEditarChamada);
  formulario.append("status", status);

  try {
    const resposta = await fetch("/afonso/owl-school/api/chamada_item/update.php", {
      method: "POST",
      body: formulario
    });

    const resultado = await resposta.json();

    if (resultado.success) {
      alert("Status de presença atualizado com sucesso!");

      if (typeof listarItensDaChamada === "function") {
        listarItensDaChamada(idChamadaAtualEditar);
      }

      const modal = bootstrap.Modal.getInstance(document.getElementById("editChamadaItemModal"));
      modal.hide();
    } else {
      alert("Erro ao atualizar presença: " + (resultado.message || "erro desconhecido."));
    }

  } catch (erro) {
    alert("Erro ao atualizar presença.");
  }
};
