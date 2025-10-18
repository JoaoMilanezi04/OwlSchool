async function carregarAdvertencias() {
  try {
    const response = await fetch("/afonso/owl-school/api/utils/advertencia/advertencia_aluno.php", {
      method: "POST"
    });

    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const corpoTabela = document.getElementById("tbodyAdvertencias");
    corpoTabela.innerHTML = "";

    // caso não tenha nenhuma advertência
    if (!resultado.advertencias || resultado.advertencias.length === 0) {
      corpoTabela.insertAdjacentHTML("beforeend", `
        <tr>
          <td colspan="2" class="text-center text-muted">Nenhuma advertência encontrada.</td>
        </tr>
      `);
      return;
    }

    for (const adv of resultado.advertencias) {
      corpoTabela.insertAdjacentHTML("beforeend", `
        <tr>
          <td>${adv.titulo}</td>
          <td class="small">${adv.descricao}</td>
        </tr>
      `);
    }

  } catch (erro) {
    alert("Erro de conexão ao listar advertências.");
  }
}

document.addEventListener("DOMContentLoaded", carregarAdvertencias);
