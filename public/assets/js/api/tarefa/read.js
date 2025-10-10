async function carregarTarefas() {
  try {

    const resp = await fetch("/afonso/owl-school/api/tarefa/read.php");

    const data = await resp.json();

    if (!data.success) {
      alert("Erro: " + data.message);
      return;
    }

    // Se tiver uma <tbody id="tbodyTarefas">, preenche:
    const tbody = document.getElementById("tbodyTarefas");
    if (!tbody) {
      console.log("tarefas:", data.tarefas);
      return; // sem tabela, apenas loga
    }

    tbody.innerHTML = "";
    for (const t of data.tarefas) {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${t.titulo}</td>
        <td>${t.data_entrega}</td>
        <td class="small">${t.descricao}</td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-secondary"
                  onclick="abrirEdicao(${t.id}, '${t.titulo.replace(/'/g,"&#39;")}', '${t.descricao.replace(/'/g,"&#39;")}', '${t.data_entrega}')">
            Editar
          </button>
          <button class="btn btn-sm btn-outline-danger" onclick="excluirTarefa(${t.id})">
            Excluir
          </button>
        </td>
      `;
      tbody.appendChild(tr);
    }
  } catch (e) {
    console.error(e);
    alert("Erro de conexão ao listar tarefas.");
  }
}

document.addEventListener("DOMContentLoaded", carregarTarefas);
