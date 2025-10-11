async function carregarTarefas() {

  try {

    const response = await fetch("/afonso/owl-school/api/tarefa/read.php");
    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const corpoTabela = document.getElementById("tbodyTarefas");
    if (!corpoTabela) return;

    corpoTabela.innerHTML = "";

    for (const tarefa of resultado.tarefas) {

      const linha = document.createElement("tr");
      linha.innerHTML = `
        <td>${tarefa.titulo}</td>
        <td>${tarefa.data_entrega}</td>
        <td class="small">${tarefa.descricao}</td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-secondary" onclick="editarTarefa(${tarefa.id})">Editar</button>
          <button class="btn btn-sm btn-outline-danger" onclick="excluirTarefa(${tarefa.id})">Excluir</button>
        </td>
      `;

      corpoTabela.appendChild(linha);
    }

  } catch (erro) {
    alert("Erro de conexão ao listar tarefas.");
  }
}

document.addEventListener("DOMContentLoaded", carregarTarefas);
