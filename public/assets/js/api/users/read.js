async function carregarUsuarios() {
  try {
    const response = await fetch("/afonso/owl-school/api/usuarios/read.php", {
      method: "POST"
    });

    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const corpoTabela = document.getElementById("tbodyUsuarios");
    corpoTabela.innerHTML = "";

    for (const usuario of resultado.usuarios) {
      const telefone = usuario.tel_prof || usuario.tel_resp || "-";
      const linha = document.createElement("tr");

      linha.innerHTML = `
        <td>${usuario.id}</td>
        <td>${usuario.nome}</td>
        <td>${usuario.email}</td>
        <td><span class="badge bg-secondary">${usuario.tipo_usuario}</span></td>
        <td>${telefone}</td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-secondary" onclick="editarUsuario(${usuario.id})">Editar</button>
          <button class="btn btn-sm btn-outline-danger" onclick="excluirUsuario(${usuario.id})">Excluir</button>
        </td>
      `;

      corpoTabela.appendChild(linha);
    }
  } catch (erro) {
    alert("Erro de conexão ao listar usuários.");
  }
}

document.addEventListener("DOMContentLoaded", carregarUsuarios);
