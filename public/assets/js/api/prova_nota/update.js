let idProvaAtualEditar = null;
let idAlunoAtualEditar = null;

async function abrirModalEditarNota(provaId, alunoId, notaAtual = "") {
  idProvaAtualEditar = provaId;
  idAlunoAtualEditar = alunoId;

  const elementoModal = document.getElementById("editNotaModal");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();

  document.getElementById("edit_nota").value = notaAtual;
}

document.getElementById("btnSalvarEdicaoNota").onclick = async function () {
  let nota = document.getElementById("edit_nota").value;
  nota = nota.replace(",", ".");

  const formulario = new FormData();
  formulario.append("prova_id", idProvaAtualEditar);
  formulario.append("aluno_id", idAlunoAtualEditar);
  formulario.append("nota", nota);

  try {
    const resposta = await fetch("/afonso/owl-school/api/prova_nota/update.php", {
      method: "POST",
      body: formulario
    });

    const resultado = await resposta.json();

    if (resultado.success) {
      alert("Nota atualizada com sucesso!");

      if (typeof listarNotasDaProva === "function") {
        listarNotasDaProva(idProvaAtualEditar); // recarrega a lista dessa prova
      }

      const modal = bootstrap.Modal.getInstance(document.getElementById("editNotaModal"));
      modal.hide();

    } else {
      alert("Erro ao atualizar nota: " + (resultado.message || "erro desconhecido."));
    }

  } catch (erro) {
    alert("Erro ao atualizar nota.");
  }
};
