async function criarHorario() {



  const campoDia = document.getElementById("dia_semana");
  const campoInicio = document.getElementById("inicio");
  const campoFim = document.getElementById("fim");
  const campoDisciplina = document.getElementById("disciplina");



  const dados = new FormData();


  dados.append("dia_semana", campoDia.value);
  dados.append("inicio", campoInicio.value);
  dados.append("fim", campoFim.value);
  dados.append("disciplina", campoDisciplina.value);



  const resposta = await fetch("/afonso/owl-school/api/agenda/create.php", {
    method: "POST",
    body: dados
  });



  const resultado = await resposta.json();



  if (resultado.success) {
    alert("Horário criado!");

    campoDia.value = "";
    campoInicio.value = "";
    campoFim.value = "";
    campoDisciplina.value = "";

    
    if (typeof carregarAgenda === "function") carregarAgenda();
  } else {
    alert("Erro: " + resultado.message);
  }
}

document.getElementById("btnCriarHorario").addEventListener("click", criarHorario);
