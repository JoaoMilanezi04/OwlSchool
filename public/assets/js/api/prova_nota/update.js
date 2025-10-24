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


async function salvarEdicaoNota() {

  let nota = document.getElementById("edit_nota").value;

  nota = nota.replace(",", ".");


  const formularioDados = new FormData();

  formularioDados.append("prova_id", idProvaAtualEditar);
  formularioDados.append("aluno_id", idAlunoAtualEditar);
  formularioDados.append("nota", nota);


  const resposta = await fetch("/owl-school/api/prova_nota/update.php", {
    method: "POST",
    body: formularioDados

  });


  const resultado = await resposta.json();


  if (resultado.success) {

    alert(resultado.message);

    if (typeof listarNotasDaProva === "function") {listarNotasDaProva(idProvaAtualEditar);}

    const modal = bootstrap.Modal.getInstance(document.getElementById("editNotaModal"));
    modal.hide();

  } else {
    alert(resultado.message);
  }
}


document.getElementById("btnSalvarEdicaoNota").addEventListener("click", salvarEdicaoNota);