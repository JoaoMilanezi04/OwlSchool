let idProvaAtual = null;
let idAlunoAtual = null;

async function abrirModalCriarNota(provaId, alunoId) {
  idProvaAtual = provaId;
  idAlunoAtual = alunoId;

  const elementoModal = document.getElementById("createNotaModal");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();


  document.getElementById("create_nota").value = "";
}

document.getElementById("btnSalvarNota").onclick = async function () {
  let nota = document.getElementById("create_nota").value;
  nota = nota.replace(",", "."); 

  const formulario = new FormData();
  formulario.append("prova_id", idProvaAtual);
  formulario.append("aluno_id", idAlunoAtual);
  formulario.append("nota", nota);

  try {
    const resposta = await fetch("/afonso/owl-school/api/prova_nota/create.php", {
      method: "POST",
      body: formulario
    });

    const resultado = await resposta.json();

    if (resultado.success) {
      alert("Nota lançada com sucesso!");
      if (typeof listarNotasDaProva === "function") listarNotasDaProva(idProvaAtual);
      bootstrap.Modal.getInstance(document.getElementById("createNotaModal")).hide();
    } else {
      alert("Erro ao criar nota: " + (resultado.message || "erro desconhecido."));
    }
  } catch (erro) {
    alert("Erro ao criar nota.");
  }
};
