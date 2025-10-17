let idChamadaAtual = null;
let idAlunoAtualChamada = null;

async function abrirModalCriarChamadaItem(chamadaId, alunoId) {
  idChamadaAtual = chamadaId;
  idAlunoAtualChamada = alunoId;

  const elementoModal = document.getElementById("createChamadaItemModal");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();

  document.getElementById("create_status").value = "presente";
}

document.getElementById("btnSalvarChamadaItem").onclick = async function () {
  const status = document.getElementById("create_status").value;

  const formulario = new FormData();
  formulario.append("chamada_id", idChamadaAtual);
  formulario.append("aluno_id", idAlunoAtualChamada);
  formulario.append("status", status);

  try {
    const resposta = await fetch("/afonso/owl-school/api/chamada_item/create.php", {
      method: "POST",
      body: formulario
    });

    const resultado = await resposta.json();

    if (resultado.success) {
      alert("Presença lançada com sucesso!");
      if (typeof listarItensDaChamada === "function") listarItensDaChamada(idChamadaAtual);
      bootstrap.Modal.getInstance(document.getElementById("createChamadaItemModal")).hide();
    } else {
      alert("Erro ao lançar presença: " + (resultado.message || "erro desconhecido."));
    }
  } catch (erro) {
    alert("Erro ao lançar presença.");
  }
};
