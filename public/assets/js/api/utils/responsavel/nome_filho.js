async function carregarNomeFilho() {
  try {
    const response = await fetch("/afonso/owl-school/api/utils/responsavel/nome_filho.php", {
      method: "POST"
    });

    const resultado = await response.json();

    if (!resultado.success) {
      alert("Erro: " + resultado.message);
      return;
    }

    const container = document.getElementById("nomeFilho");
    container.innerHTML = "";
    container.insertAdjacentHTML("beforeend", `<span>${resultado.nome_filho}</span>`);

  } catch (erro) {
    alert("Erro de conexão ao buscar nome do filho.");
  }
}

document.addEventListener("DOMContentLoaded", carregarNomeFilho);
