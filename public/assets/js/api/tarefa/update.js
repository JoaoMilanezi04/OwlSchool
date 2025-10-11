const elementoModalEdicao = document.getElementById("editModal");
const instanciaModalBootstrap = new bootstrap.Modal(elementoModalEdicao);

const tituloDoModal = document.getElementById("editTituloTopo");
const campoEditarTitulo = document.getElementById("edit_titulo");
const campoEditarDescricao = document.getElementById("edit_descricao");
const campoEditarData = document.getElementById("edit_data");
const botaoSalvarEdicao = document.getElementById("btnSalvar");

let identificadorAtualDaTarefa = null;

window.editarTarefa = async function (identificador) {

  identificadorAtualDaTarefa = identificador;

  tituloDoModal.textContent = "Editar tarefa";

  try {

    const resposta = await fetch("/afonso/owl-school/api/tarefa/read.php");
    const resultado = await resposta.json();

    if (!resultado.success) {
      alert("Erro ao ler tarefas.");
      return;
    }

    const tarefa = (resultado.tarefas || []).find(function (item) {
      return String(item.id) === String(identificador);
    });

    if (!tarefa) {
      alert("Tarefa não encontrada.");
      return;
    }

    campoEditarTitulo.value = tarefa.titulo || "";
    campoEditarDescricao.value = tarefa.descricao || "";
    campoEditarData.value = tarefa.data_entrega || "";

    instanciaModalBootstrap.show();

  } catch (erro) {
    alert("Erro ao carregar tarefa.");
  }
};

botaoSalvarEdicao.addEventListener("click", async function () {

  if (!identificadorAtualDaTarefa) {
    alert("Erro: sem identificador.");
    return;
  }

  const titulo = (campoEditarTitulo.value || "").trim();
  const descricao = (campoEditarDescricao.value || "").trim();
  const data_entrega = campoEditarData.value || "";

  if (!titulo || !descricao || !data_entrega) {
    alert("Preencha todos os campos!");
    return;
  }

  const formularioDados = new FormData();
  formularioDados.append("id", identificadorAtualDaTarefa);
  formularioDados.append("titulo", titulo);
  formularioDados.append("descricao", descricao);
  formularioDados.append("data_entrega", data_entrega);

  botaoSalvarEdicao.disabled = true;

  try {

    const resposta = await fetch("/afonso/owl-school/api/tarefa/update.php", {
      method: "POST",
      body: formularioDados
    });

    const resultado = await resposta.json();

    if (!resultado.success) {
      alert("Erro: " + (resultado.message || "Erro ao atualizar."));
      return;
    }

    instanciaModalBootstrap.hide();
    identificadorAtualDaTarefa = null;

    if (typeof carregarTarefas === "function") carregarTarefas();

    alert("Tarefa atualizada!");

  } catch (erro) {
    alert("Erro ao atualizar tarefa.");
  } finally {
    botaoSalvarEdicao.disabled = false;
  }
});
