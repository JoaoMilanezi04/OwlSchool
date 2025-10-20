async function carregarAdvertencias() {
  try {
    const response = await fetch("/afonso/owl-school/api/advertencia/read.php", {
      method: "POST"
    });
    const resultado = await response.json();

    if (!resultado.success) {
      alert(resultado.success);
      return;
    }

    const corpoTabela = document.getElementById("tbodyAdvertencias");
    corpoTabela.innerHTML = "";

    for (const advertencia of resultado.advertencias) {
      corpoTabela.insertAdjacentHTML("beforeend", `
        <tr>
          <td>
            <strong>${advertencia.titulo}</strong><br>
            <small class="text-muted">${advertencia.descricao}</small>
          </td>
          <td>${advertencia.aluno_nome}</td>
          <td class="text-end">
            <button class="btn btn-sm btn-outline-secondary"
              onclick="abrirModalEditarAdvertencia(${advertencia.id}, '${advertencia.titulo}', '${advertencia.descricao}')">
              Editar
            </button>
            <button class="btn btn-sm btn-outline-danger"
              onclick="excluirAdvertencia(${advertencia.id})">
              Excluir
            </button>
          </td>
        </tr>
      `);
    }

  } catch (erro) {
    alert(resultado.success);
  }
}

document.addEventListener("DOMContentLoaded", carregarAdvertencias);
