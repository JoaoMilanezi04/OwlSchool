async function carregarNotasDaProva(provaId) {
  try {
    const formularioDados = new FormData();
    formularioDados.append("prova_id", provaId);

    const resposta = await fetch("/afonso/owl-school/api/prova_nota/read.php", {
      method: "POST",
      body: formularioDados
    });

    const resultado = await resposta.json();

    if (!resultado.success) {
      alert("Erro ao listar notas: " + (resultado.message || ""));
      return;
    }

    const corpoTabela = document.getElementById("tbodyNotas");
    corpoTabela.innerHTML = "";

    if (!resultado.notas || resultado.notas.length === 0) {
      corpoTabela.innerHTML = `
        <tr>
          <td colspan="3" class="text-center text-muted">
            Nenhum aluno encontrado.
          </td>
        </tr>
      `;
      return;
    }

    for (const item of resultado.notas) {
      const notaVal = item.nota ?? "";

      const linha = `
        <tr>
          <td>${item.aluno_nome || ("Aluno #" + item.aluno_id)}</td>
          <td>
            <input type="number"
                   class="form-control form-control-sm"
                   id="nota_${item.aluno_id}"
                   value="${notaVal}">
          </td>
          <td class="text-end">
            <button class="btn btn-sm btn-outline-success me-2"
                    onclick="prepararCriarNota(${item.aluno_id})">
              Salvar
            </button>
            <button class="btn btn-sm btn-outline-secondary me-2"
                    onclick="prepararAtualizarNota(${item.aluno_id})">
              Editar
            </button>
            <button class="btn btn-sm btn-outline-danger"
                    onclick="excluirNota(${item.aluno_id})">
              Excluir
            </button>
          </td>
        </tr>
      `;

      corpoTabela.insertAdjacentHTML("beforeend", linha);
    }

  } catch (erro) {
    alert("Erro de conexão ao listar notas.");
  }
}

// funções auxiliares para manter o innerHTML limpo
function prepararCriarNota(alunoId) {
  document.getElementById("aluno_id").value = alunoId;
  document.getElementById("nota").value = document.getElementById("nota_" + alunoId).value;
  criarNota();
}

function prepararAtualizarNota(alunoId) {
  document.getElementById("aluno_id").value = alunoId;
  document.getElementById("nota").value = document.getElementById("nota_" + alunoId).value;
  atualizarNota();
}
