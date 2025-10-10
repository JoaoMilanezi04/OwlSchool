async function criarTarefa() {



  const titulo = document.getElementById("titulo").value;
  const descricao = document.getElementById("descricao").value;
  const data_entrega = document.getElementById("data_entrega").value;



  const formData = new FormData();



  formData.append("titulo", titulo);
  formData.append("descricao", descricao);
  formData.append("data_entrega", data_entrega);






const resp = await fetch("/afonso/owl-school/api/tarefa/create.php", { method:"POST", body: formData });






  const data = await resp.json();

if (data.success) {
  alert("Tarefa criada!");

  // atualiza a tabela sem precisar dar F5
  if (typeof carregarTarefas === "function") {
    carregarTarefas();
  }

} else {
  alert("Erro: " + data.message);
}

}




document.getElementById("btnCriar").addEventListener("click", criarTarefa);