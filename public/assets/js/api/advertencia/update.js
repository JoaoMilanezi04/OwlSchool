let idAdvertenciaAtual = null;

async function abrirModalEditarAdvertencia(id, titulo, descricao) {

  idAdvertenciaAtual = id;

  document.getElementById("edit_titulo").value = titulo;
  document.getElementById("edit_descricao").value = descricao;


  const elementoModal = document.getElementById("editModalAdvertencia");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();

}

async function salvarAdvertencia() {


  const titulo = document.getElementById("edit_titulo").value;
  const descricao = document.getElementById("edit_descricao").value;


  const formularioDados = new FormData();

  formularioDados.append("id", idAdvertenciaAtual);
  formularioDados.append("titulo", titulo);
  formularioDados.append("descricao", descricao);


  const resposta = await fetch("/afonso/owl-school/api/advertencia/update.php", {
    method: "POST",
    body: formularioDados

  });

  const resultado = await resposta.json();

  if (resultado.success) {


    alert("Advertência atualizada com sucesso!");

    if (typeof carregarAdvertencias === "function") {carregarAdvertencias();}

    const modal = bootstrap.Modal.getInstance(document.getElementById("editModalAdvertencia"));
    modal.hide();

  } else {
    alert(resultado.success);
  }
}


document.getElementById("btnSalvarAdvertencia").addEventListener("click", salvarAdvertencia);