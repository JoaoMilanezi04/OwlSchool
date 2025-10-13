let idDoComunicadoAtual = null;

async function editarComunicado(idComunicado) {
  idDoComunicadoAtual = idComunicado;

  const elementoModal = document.getElementById("editModalComunicado");
  const modal = new bootstrap.Modal(elementoModal);
  modal.show();

  try {
    const resposta = await fetch("/afonso/owl-school/api/comunicado/read.php", {
      method: "POST"
    });
    const dados = await resposta.json();

    const comunicado = dados.comunicados.find(c => String(c.id) === String(idComunicado));
    if (!comunicado) throw new Error("Comunicado não encontrado.");

    document.getElementById("edit_titulo").value = comunicado.titulo;
    document.getElementById("edit_corpo").value  = comunicado.corpo;

  } catch (erro) {
    alert("Erro ao carregar comunicado.");
  }
}

document.getElementById("btnSalvarComunicado").onclick = async function () {
  const titulo = document.getElementById("edit_titulo").value;
  const corpo  = document.getElementById("edit_corpo").value;

  const form = new FormData();
  form.append("id", idDoComunicadoAtual);
  form.append("titulo", titulo);
  form.append("corpo",  corpo);

  try {
    const resposta = await fetch("/afonso/owl-school/api/comunicado/update.php", {
      method: "POST",
      body: form
    });
    const resultado = await resposta.json();

    if (resultado.success) {
      alert("Comunicado atualizado com sucesso!");
      if (typeof carregarComunicados === "function") carregarComunicados();

      const elementoModal = document.getElementById("editModalComunicado");
      const modal = bootstrap.Modal.getInstance(elementoModal);
      modal.hide();

    } else {
      alert("Erro ao atualizar comunicado: " + (resultado.message || "erro desconhecido."));
    }
  } catch (erro) {
    alert("Erro ao atualizar comunicado.");
  }
};
