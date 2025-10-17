async function listarItensDaChamada(chamadaId, dataChamada) {
  try {
    const fd = new FormData();
    fd.append("chamada_id", chamadaId);

    const resp = await fetch("/afonso/owl-school/api/chamada_item/read.php", {
      method: "POST",
      body: fd
    });
    const dados = await resp.json();

    if (!dados.success) {
      alert("Erro: " + (dados.message || "Falha ao listar presenças."));
      return;
    }

    const cardChamada = document.getElementById("cardChamada");
    cardChamada.classList.remove("d-none");


    cardChamada.innerHTML = `
      <div class="card-body">
        <h5 class="card-title mb-3">Chamada do dia ${dataChamada}</h5>
        <input type="hidden" id="chamada_id" value="${chamadaId}">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Aluno</th>
              <th>Status</th>
              <th class="text-end">Ações</th>
            </tr>
          </thead>
          <tbody id="tbodyChamada"></tbody>
        </table>
      </div>
    `;

    const corpo = document.getElementById("tbodyChamada");
    corpo.innerHTML = "";

    const itens = dados.itens;
    if (!itens.length) {
      corpo.innerHTML = `<tr><td colspan="3" class="text-muted">Nenhum aluno encontrado.</td></tr>`;
      return;
    }

    for (const i of itens) {
      corpo.insertAdjacentHTML("beforeend", `
        <tr>
          <td>${i.aluno_nome}</td>
          <td>${i.status ?? "-"}</td>
          <td class="text-end">
            <button class="btn btn-sm btn-outline-success me-2"
                    onclick="abrirModalCriarChamadaItem(${chamadaId}, ${i.aluno_id})">Salvar</button>
            <button class="btn btn-sm btn-outline-secondary me-2"
                    onclick="abrirModalEditarChamadaItem(${chamadaId}, ${i.aluno_id}, '${i.status ?? ""}')">Editar</button>
            <button class="btn btn-sm btn-outline-danger"
                    onclick="excluirChamadaItem(${chamadaId}, ${i.aluno_id})">Excluir</button>
          </td>
        </tr>
      `);
    }
  } catch {
    alert("Erro de conexão ao listar presenças.");
  }
}
