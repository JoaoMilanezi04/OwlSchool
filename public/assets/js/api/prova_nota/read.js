// public/assets/js/api/prova_nota/read.js
async function carregarNotas(provaId, containerId) {
  const container = document.getElementById(containerId || `notasArea${provaId}`);
  if (!container) return;

  try {
    const fd = new FormData();
    fd.append("prova_id", provaId);

    const resp = await fetch("/afonso/owl-school/api/prova_nota/read.php", {
      method: "POST",
      body: fd
    });

    const json = await resp.json();
    if (!json.success) {
      container.innerHTML = `<div class="alert alert-warning mb-0">Erro: ${json.message || "falha ao listar notas."}</div>`;
      return;
    }

    const notas = json.notas || [];

    // monta tabela (sem colocar string em value de <input type="number">)
    let linhas = notas.map(nota => {
      const value = (nota.lancada && nota.nota !== null && nota.nota !== undefined) ? String(nota.nota) : "";
      const placeholder = (!value ? 'NAO_LANCADA' : '');

      return `
        <tr>
          <td>${nota.nome} <span class="text-muted">(#${nota.aluno_id})</span></td>
          <td>
            <input type="number" step="0.01" min="0" max="10"
                   class="form-control form-control-sm"
                   value="${value}"
                   ${placeholder ? `placeholder="${placeholder}"` : ""}>
          </td>
          <td class="text-end">
            <button class="btn btn-sm btn-outline-primary me-1"
              onclick="(function(el){preencherFormularioNota(${nota.aluno_id}, el.value || '');})(this.closest('tr').querySelector('input'))">
              Editar
            </button>
            <button class="btn btn-sm btn-outline-danger"
              onclick="excluirNota(${nota.aluno_id})">
              Excluir
            </button>
          </td>
        </tr>
      `;
    }).join("");

    if (!linhas) {
      linhas = `<tr><td colspan="3" class="text-muted">Nenhum aluno encontrado.</td></tr>`;
    }

    container.innerHTML = `
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <thead>
            <tr>
              <th>Aluno</th>
              <th>Nota</th>
              <th class="text-end">Ações</th>
            </tr>
          </thead>
          <tbody>${linhas}</tbody>
        </table>
      </div>

      <div class="d-flex flex-wrap gap-2">
        <button class="btn btn-success" onclick="if(window.salvarTodasNotas) salvarTodasNotas(${provaId}, '${container.id}'); else if(window.criarNota) criarNota();">Salvar todas</button>
        <button class="btn btn-outline-danger ms-auto" onclick="if(window.limparTodasNotas) limparTodasNotas(${provaId}); else if(window.excluirNotas) excluirNotas();">Limpar todas</button>
      </div>
    `;
  } catch (e) {
    alert("Erro de conexão ao listar notas.");
    container.innerHTML = `<div class="alert alert-danger mb-0">Falha de conexão.</div>`;
  }
}
