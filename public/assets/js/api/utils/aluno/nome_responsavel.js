async function carregarNomeResponsavel() {
  try {
    const response = await fetch("/afonso/owl-school/api/utils/aluno/nome_responsavel.php", {
      method: "POST"
    });

    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const container = document.getElementById("nomeResponsavel");
    container.innerHTML = "";
    container.insertAdjacentHTML("beforeend", `<span>${resultado.nome_responsavel}</span>`);

  } catch (erro) {
    alert("Erro de conexão ao buscar nome do responsável.");
  }
}

document.addEventListener("DOMContentLoaded", carregarNomeResponsavel);
