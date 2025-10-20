async function criarUsuario() {


  const nome         = document.getElementById("nome").value;
  const email        = document.getElementById("email").value;
  const senha        = document.getElementById("senha").value;
  const tipo_usuario = document.getElementById("tipo_usuario").value;
  const telefone     = document.getElementById("telefone").value;


  const formularioDados = new FormData();


  formularioDados.append("nome", nome);
  formularioDados.append("email", email);
  formularioDados.append("senha", senha);
  formularioDados.append("tipo_usuario", tipo_usuario);
  formularioDados.append("telefone", telefone);


  const resposta = await fetch("/afonso/owl-school/api/usuarios/create.php", {
    method: "POST",
    body: formularioDados

  });

  const resultado = await resposta.json();

  if (resultado.success) {

    alert(resultado.message);

    document.getElementById("nome").value         = "";
    document.getElementById("email").value        = "";
    document.getElementById("senha").value        = "";
    document.getElementById("tipo_usuario").value = "";
    document.getElementById("telefone").value     = "";

    if (typeof carregarUsuarios === "function") {carregarUsuarios();}

  } else {
    alert(resultado.message);
  }
}

document.getElementById("btnCriar").addEventListener("click", criarUsuario);