async function excluirChamadaItem(chamadaId, alunoId) {
  if (!confirm("Tem certeza que deseja excluir este registro de presença?")) return;

  const fd = new FormData();
  fd.append("chamada_id", chamadaId);
  fd.append("aluno_id", alunoId);

  try {
    const resp = await fetch("/afonso/owl-school/api/chamada_item/delete.php", {
      method: "POST",
      body: fd
    });
    const resultado = await resp.json();

    alert(resultado.message);
    if (resultado.success) listarItensDaChamada(chamadaId);
  } catch (erro) {
    alert("Erro ao excluir presença.");
  }
}
