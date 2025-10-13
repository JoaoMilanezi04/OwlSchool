async function carregarProvas() {
  try {
    const response = await fetch("/afonso/owl-school/api/prova/read.php", {
      method: "POST"
    });
    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const corpoTabela = document.getElementById("tbodyProvas");
    corpoTabela.innerHTML = "";

    for (const prova of resultado.provas) {
      const linha = document.createElement("tr");
      linha.innerHTML = `
        <td>${prova.titulo}</td>
        <td>${prova.data}</td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-secondary" onclick="editarProva(${prova.id})">Editar</button>
          <button class="btn btn-sm btn-outline-danger" onclick="excluirProva(${prova.id})">Excluir</button>
        </td>
      `;
      corpoTabela.appendChild(linha);
    }
  } catch (erro) {
    alert("Erro de conexão ao listar provas.");
  }
}

document.addEventListener("DOMContentLoaded", carregarProvas);
