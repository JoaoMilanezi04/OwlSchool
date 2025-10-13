let idDoHorarioAtual = null;

async function editarHorario(idHorario) {
  idDoHorarioAtual = idHorario;

  try {
    const resposta = await fetch("/afonso/owl-school/api/agenda/read.php", { method: "POST" });
    const dados = await resposta.json();
    if (!dados.success) throw new Error(dados.message || "Falha ao listar.");

    // procurar o horário dentro de por_dia
    const dias = ["segunda", "terca", "quarta", "quinta", "sexta"];
    let horario = null;
    for (const d of dias) {
      const lista = (dados.por_dia && dados.por_dia[d]) ? dados.por_dia[d] : [];
      horario = lista.find(h => String(h.id) === String(idHorario));
      if (horario) break;
    }
    if (!horario) throw new Error("Horário não encontrado.");

    // preencher campos
    document.getElementById("edit_dia_semana").value = horario.dia_semana;
    document.getElementById("edit_inicio").value     = horario.inicio; // "HH:MM"
    document.getElementById("edit_fim").value        = horario.fim;    // "HH:MM"
    document.getElementById("edit_disciplina").value = horario.disciplina;

    // abrir modal só depois de preencher
    const elementoModal = document.getElementById("editModalHorario");
    const modal = new bootstrap.Modal(elementoModal);
    modal.show();

  } catch (erro) {
    alert("Erro ao carregar horário.");
    console.error(erro);
  }
}
