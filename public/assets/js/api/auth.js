// login.js — simples: getElementById + fetch + FormData
document.getElementById("formLogin").onsubmit = async function (e) {
  e.preventDefault();

  const email = document.getElementById("email").value;
  const senha = document.getElementById("senha").value;

  const dados = new FormData();
  dados.append("email", email);
  dados.append("senha", senha);

  try {
    const resp = await fetch("/afonso/owl-school/api/auth.php", {
      method: "POST",
      body: dados
    });

    const resultado = await resp.json();

    if (!resultado.success) {
      alert(resultado.message || "Usuário ou senha inválidos.");
      return;
    }

    const tipo = resultado.usuario.tipo_usuario;

    if (tipo === "aluno")       window.location.href = "/afonso/owl-school/public/aluno/aluno.php";
    else if (tipo === "professor")   window.location.href = "/afonso/owl-school/public/professor/professor.php";
    else if (tipo === "responsavel") window.location.href = "/afonso/owl-school/public/responsavel/responsavel.php";
    else if (tipo === "admin")       window.location.href = "/afonso/owl-school/public/admin/admin.php";
    else alert("Tipo de usuário inválido.");

  } catch (err) {
    alert("Erro de conexão. Tente novamente.");
  }
};
