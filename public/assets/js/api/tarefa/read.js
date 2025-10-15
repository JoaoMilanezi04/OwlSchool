async function carregarTarefas() {
  try {
    const response = await fetch("/afonso/owl-school/api/tarefa/read.php", {
      method: "POST"

    });

    
    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const corpoTabela = document.getElementById("tbodyTarefas");
    corpoTabela.innerHTML = "";

    for (const tarefa of resultado.tarefas) {

corpoTabela.innerHTML += `
  <tr>
    <td>${tarefa.titulo}</td>
    <td>${tarefa.data_entrega}</td>
    <td class="small">${tarefa.descricao}</td>
    <td class="text-end">
      <button class="btn btn-sm btn-outline-secondary" onclick="editarTarefa(${tarefa.id})">Editar</button>
      <button class="btn btn-sm btn-outline-danger" onclick="excluirTarefa(${tarefa.id})">Excluir</button>
    </td>
  </tr>
`;

    }
  } catch (erro) {
    alert("Erro de conexão ao listar tarefas.");
  }
}

document.addEventListener("DOMContentLoaded", carregarTarefas);
