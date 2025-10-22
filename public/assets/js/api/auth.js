
document.getElementById("formLogin").onsubmit = async function (e) {
  e.preventDefault();

  const email = document.getElementById("email").value;
  const senha = document.getElementById("senha").value;

  const formularioDados = new FormData();

  formularioDados.append("email", email);
  formularioDados.append("senha", senha);

  try {

    const resposta = await fetch("/afonso/owl-school/api/auth.php", {
      method: "POST",
      body: formularioDados

    });


    const resultado = await resposta.json();


    const tipo = resultado.usuario.tipo_usuario;


    if (tipo === "aluno")       window.location.href = "/afonso/owl-school/public/aluno/aluno.php";
    else if (tipo === "professor")   window.location.href = "/afonso/owl-school/public/professor/professor.php";
    else if (tipo === "responsavel") window.location.href = "/afonso/owl-school/public/responsavel/responsavel.php";
    else if (tipo === "admin")       window.location.href = "/afonso/owl-school/public/admin/admin.php";
    else alert("Login Inválido")

  } catch (err) {
    alert("Usuário ou senha inválidos.");
  }
};
