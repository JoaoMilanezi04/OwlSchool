async function excluirProva(id) {

  if (!id) return;

  if (!confirm("Tem certeza que deseja excluir?")) return;

  const formularioDados = new FormData();

  formularioDados.append("id", id);

  const resposta = await fetch("/afonso/owl-school/api/prova/delete.php", {
    method: "POST",
    body: formularioDados

  });

  const resultado = await resposta.json();

  if (resultado.success) {

    alert(resultado.success);

    location.reload();  

  } else {
    alert(resultado.message);
  }
}
