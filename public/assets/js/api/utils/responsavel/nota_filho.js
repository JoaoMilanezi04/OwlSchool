async function carregarNotasFilhos() {
  try {
    const response = await fetch("/afonso/owl-school/api/utils/responsavel/nota_filho.php", {
      method: "POST"
    });
    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const corpoTabela = document.getElementById("tbodyNotas");
    corpoTabela.innerHTML = "";

    if (!resultado.notas || resultado.notas.length === 0) {
      corpoTabela.insertAdjacentHTML("beforeend", `
        <tr>
          <td colspan="4" class="text-center text-muted">Nenhuma nota encontrada.</td>
        </tr>
      `);
      return;
    }

    for (const item of resultado.notas) {
      corpoTabela.insertAdjacentHTML("beforeend", `
        <tr>
          <td>${item.aluno_nome}</td>
          <td>${item.titulo}</td>
          <td>${item.data}</td>
          <td>${item.nota}</td>
        </tr>
      `);
    }

  } catch (erro) {
    alert("Erro de conexão ao listar notas.");
  }
}

document.addEventListener("DOMContentLoaded", carregarNotasFilhos);
