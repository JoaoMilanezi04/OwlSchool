async function carregarChamadas() {
  try {
    const response = await fetch("/afonso/owl-school/api/chamada/read.php", {
      method: "POST"
    });
    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const corpoTabela = document.getElementById("tbodyChamadas");
    corpoTabela.innerHTML = "";

    for (const chamada of resultado.chamadas) {
      const linha = document.createElement("tr");
      linha.innerHTML = `
        <td>${chamada.data}</td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-primary"
                  onclick="listarAlunosDaChamada(${chamada.id})">
            Lançar presença
          </button>
          <button class="btn btn-sm btn-outline-secondary"
                  onclick="editarChamada(${chamada.id})">
            Editar
          </button>
          <button class="btn btn-sm btn-outline-danger"
                  onclick="excluirChamada(${chamada.id})">
            Excluir
          </button>
        </td>
      `;
      corpoTabela.appendChild(linha);
    }
  } catch (erro) {
    alert("Erro de conexão ao listar chamadas.");
  }
}

document.addEventListener("DOMContentLoaded", carregarChamadas);
