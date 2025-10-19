async function carregarFrequencias() {
  try {
    const response = await fetch("/afonso/owl-school/api/utils/aluno/frequencia_aluno.php", {
      method: "POST"
    });

    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const corpoTabela = document.getElementById("tbodyFrequencias");
    corpoTabela.innerHTML = "";

    // nenhum registro
    if (!resultado.frequencias || resultado.frequencias.length === 0) {
      corpoTabela.insertAdjacentHTML("beforeend", `
        <tr>
          <td colspan="2" class="text-center text-muted">Nenhum registro de frequência.</td>
        </tr>
      `);
      return;
    }

    for (const item of resultado.frequencias) {
      corpoTabela.insertAdjacentHTML("beforeend", `
        <tr>
          <td>${item.data}</td>
          <td class="text-capitalize">${item.status}</td>
        </tr>
      `);
    }

  } catch (erro) {
    alert("Erro de conexão ao listar a frequência.");
  }
}

document.addEventListener("DOMContentLoaded", carregarFrequencias);