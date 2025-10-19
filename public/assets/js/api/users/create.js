async function criarUsuario() {

  const campoNome         = document.getElementById("nome");
  const campoEmail        = document.getElementById("email");
  const campoSenha        = document.getElementById("senha");
  const campoTipoUsuario  = document.getElementById("tipo_usuario");
  const campoTelefone     = document.getElementById("telefone");


  const nome         = campoNome.value;
  const email        = campoEmail.value;
  const senha        = campoSenha.value;
  const tipo_usuario = campoTipoUsuario.value;
  const telefone     = campoTelefone.value;


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
    alert("Usuário criado!");

    campoNome.value = "";
    campoEmail.value = "";
    campoSenha.value = "";
    campoTipoUsuario.value = "";
    campoTelefone.value = "";

    if (typeof carregarUsuarios === "function") {
      carregarUsuarios();
    }

  } else {
    alert("Erro: " + resultado.message);
  }
}

document.getElementById("btnCriar").addEventListener("click", criarUsuario);
