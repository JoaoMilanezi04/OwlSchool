async function excluirNota(provaId, alunoId) {
  if (!confirm("Tem certeza que deseja excluir esta nota?")) return;

  const fd = new FormData();
  fd.append("prova_id", provaId);
  fd.append("aluno_id", alunoId);

  try {
    const resp = await fetch("/afonso/owl-school/api/prova_nota/delete.php", {
      method: "POST",
      body: fd
    });
    const resultado = await resp.json();

    alert(resultado.message);
    if (resultado.success) listarNotasDaProva(provaId);
  } catch (erro) {
    alert("Erro ao excluir nota.");
  }
}
