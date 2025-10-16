async function carregarAdvertencias() {
  try {
    const response = await fetch("/afonso/owl-school/api/advertencia/read.php", {
      method: "POST"
    });
    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const corpoTabela = document.getElementById("tbodyAdvertencias");
    corpoTabela.innerHTML = "";

    for (const advertencia of resultado.advertencias) {
      const linha = document.createElement("tr");
      linha.innerHTML = `
        <td>${advertencia.titulo}</td>
        <td class="small">${advertencia.descricao}</td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-secondary" onclick="editarAdvertencia(${advertencia.id})">Editar</button>
          <button class="btn btn-sm btn-outline-danger" onclick="excluirAdvertencia(${advertencia.id})">Excluir</button>
        </td>
      `;
      corpoTabela.appendChild(linha);
    }

  } catch (erro) {
    alert("Erro de conexão ao listar advertências.");
  }
}

document.addEventListener("DOMContentLoaded", carregarAdvertencias);
