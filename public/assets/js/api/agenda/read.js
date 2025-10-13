async function carregarAgenda() {
  try {
    const resposta = await fetch("/afonso/owl-school/api/agenda/read.php", { method: "POST" });
    const resultado = await resposta.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const dias = ["segunda", "terca", "quarta", "quinta", "sexta"];
    const dados = resultado.por_dia || {};

    for (const dia of dias) {
      const corpo = document.getElementById(dia);
      if (!corpo) continue;

      const lista = dados[dia] || [];
      corpo.innerHTML = "";

      if (!lista.length) {
        corpo.innerHTML = `<tr><td colspan="4" class="text-muted">Sem horários.</td></tr>`;
        continue;
      }

      for (const h of lista) {
        const linha = document.createElement("tr");
        linha.innerHTML = `
          <td>${h.inicio}</td>
          <td>${h.fim}</td>
          <td>${h.disciplina}</td>
          <td class="text-end">
            <button class="btn btn-sm btn-outline-secondary me-1" onclick="editarHorario(${h.id})">Editar</button>
            <button class="btn btn-sm btn-outline-danger" onclick="excluirHorario(${h.id})">Excluir</button>
          </td>
        `;
        corpo.appendChild(linha);
      }
    }
  } catch {
    alert("Erro de conexão ao listar horários.");
  }
}

document.addEventListener("DOMContentLoaded", carregarAgenda);
