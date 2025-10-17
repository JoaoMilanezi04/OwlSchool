async function carregarAdvertencias() {
  try {
    const form = new FormData();
    form.append("responsavel_id", idDoResponsavel); // define essa variável no login ou global

    const response = await fetch("/afonso/owl-school/api/utils/advertencia_filho.php", {
      method: "POST",
      body: form
    });

    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const corpoTabela = document.getElementById("tbodyAdvertencias");
    corpoTabela.innerHTML = "";

    for (const adv of resultado.advertencias) {
      corpoTabela.innerHTML += `
        <tr>
          <td>${adv.titulo}</td>
          <td class="small">${adv.descricao}</td>
        </tr>
      `;
    }

  } catch (erro) {
    alert("Erro de conexão ao listar advertências.");
  }
}

document.addEventListener("DOMContentLoaded", carregarAdvertencias);
