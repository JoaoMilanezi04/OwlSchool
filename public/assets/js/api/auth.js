
document.getElementById("formLogin").onsubmit = async function (e) {
  e.preventDefault();

  const email = document.getElementById("email").value;
  const senha = document.getElementById("senha").value;

  const formularioDados = new FormData();

  formularioDados.append("email", email);
  formularioDados.append("senha", senha);

  try {

    const resposta = await fetch("/owl-school/api/auth.php", {
      method: "POST",
      body: formularioDados
    });

    const resultado = await resposta.json();

    // Verificar se o login foi bem-sucedido
    if (!resultado.success) {
      alert(resultado.message || "Erro ao fazer login");
      return;
    }

    const tipo = resultado.usuario.tipo_usuario;

    if (tipo === "aluno")       window.location.href = "/owl-school/public/aluno/aluno.php";
    else if (tipo === "professor")   window.location.href = "/owl-school/public/professor/professor.php";
    else if (tipo === "responsavel") window.location.href = "/owl-school/public/responsavel/responsavel.php";
    else if (tipo === "admin")       window.location.href = "/owl-school/public/admin/admin.php";
    else alert("Tipo de usuário inválido")

  } catch (err) {
    console.error("Erro:", err);
    alert("Erro ao conectar com o servidor. Verifique sua conexão.");
  }
};
