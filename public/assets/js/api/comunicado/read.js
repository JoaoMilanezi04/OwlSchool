// comunicado/read.js — usando sessão PHP (resultado.tipo_usuario)

async function carregarComunicados() {
  try {
    const resposta = await fetch("/afonso/owl-school/api/comunicado/read.php", {
      method: "POST"
    });
    const resultado = await resposta.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const tipoUsuario = resultado.tipo_usuario;
    const corpoTabela = document.getElementById("tbodyComunicados");
    corpoTabela.innerHTML = "";

    for (const comunicado of resultado.comunicados) {
      let acoesHTML = "";
      if (tipoUsuario === "professor" || tipoUsuario === "admin") {
        acoesHTML = `
          <button class="btn btn-sm btn-outline-secondary" onclick="editarComunicado(${comunicado.id})">Editar</button>
          <button class="btn btn-sm btn-outline-danger ms-1" onclick="excluirComunicado(${comunicado.id})">Excluir</button>
        `;
      }

      corpoTabela.insertAdjacentHTML("beforeend", `
        <tr>
          <td>${comunicado.titulo}</td>
          <td class="small">${comunicado.corpo}</td>
          <td class="text-end">${acoesHTML}</td>
        </tr>
      `);
    }

  } catch (erro) {
    alert("Erro de conexão ao listar comunicados.");
  }
}

document.addEventListener("DOMContentLoaded", carregarComunicados);
