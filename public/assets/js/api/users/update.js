let idDoUsuarioAtual = null;
let tipoDoUsuarioAtual = null;

async function editarUsuario(idUsuario) {
  idDoUsuarioAtual = idUsuario;

  try {
    const resp = await fetch("/afonso/owl-school/api/users/read.php", { method: "POST" });
    const dados = await resp.json();
    
    if (!dados.success) throw new Error(dados.message || "Falha ao listar.");

    const usuario = dados.usuarios.find(u => String(u.id) === String(idUsuario));
    if (!usuario) throw new Error("Usuário não encontrado.");

    tipoDoUsuarioAtual = usuario.tipo_usuario;

    if (tipoDoUsuarioAtual === "professor" || tipoDoUsuarioAtual === "responsavel") {

      document.getElementById("edit_pr_nome").value     = usuario.nome || "";
      document.getElementById("edit_pr_email").value    = usuario.email || "";
      document.getElementById("edit_pr_senha").value    = "";
      document.getElementById("edit_pr_tipo").value     = tipoDoUsuarioAtual;
      document.getElementById("edit_pr_telefone").value = (usuario.tel_prof || usuario.tel_resp || "");

      new bootstrap.Modal(document.getElementById("editModalProfResp")).show();
    } else {

      document.getElementById("edit_aluno_nome").value  = usuario.nome || "";
      document.getElementById("edit_aluno_email").value = usuario.email || "";
      document.getElementById("edit_aluno_senha").value = "";
      document.getElementById("edit_aluno_tipo").value  = tipoDoUsuarioAtual;

      new bootstrap.Modal(document.getElementById("editModalAluno")).show();
    }

  } catch (e) {
    alert("Erro ao carregar usuário.");
  }
}


document.getElementById("btnSalvarAluno").onclick = async function () {
  const fd = new FormData();
  fd.append("id",   idDoUsuarioAtual);
  fd.append("nome", document.getElementById("edit_aluno_nome").value);
  fd.append("email",document.getElementById("edit_aluno_email").value);
  fd.append("senha",document.getElementById("edit_aluno_senha").value); // vazio = manter
  fd.append("tipo_usuario", tipoDoUsuarioAtual); // 'aluno' ou 'admin'
  fd.append("telefone", ""); // não precisa

  const resp = await fetch("/afonso/owl-school/api/users/update.php", { method: "POST", body: fd });
  const res  = await resp.json();

  if (res.success) {
    alert("Usuário atualizado!");
    if (typeof carregarUsuarios === "function") carregarUsuarios();
    bootstrap.Modal.getInstance(document.getElementById("editModalAluno")).hide();
  } else {
    alert("Erro ao atualizar: " + (res.message || "erro desconhecido."));
  }
};

// salvar PROFESSOR/RESPONSÁVEL
document.getElementById("btnSalvarProfResp").onclick = async function () {
  const fd = new FormData();
  fd.append("id",   idDoUsuarioAtual);
  fd.append("nome", document.getElementById("edit_pr_nome").value);
  fd.append("email",document.getElementById("edit_pr_email").value);
  fd.append("senha",document.getElementById("edit_pr_senha").value); // vazio = manter
  fd.append("tipo_usuario", tipoDoUsuarioAtual); // 'professor' ou 'responsavel'
  fd.append("telefone", document.getElementById("edit_pr_telefone").value || "");

  const resp = await fetch("/afonso/owl-school/api/users/update.php", { method: "POST", body: fd });
  const res  = await resp.json();

  if (res.success) {
    alert("Usuário atualizado!");
    if (typeof carregarUsuarios === "function") carregarUsuarios();
    bootstrap.Modal.getInstance(document.getElementById("editModalProfResp")).hide();
  } else {
    alert("Erro ao atualizar: " + (res.message || "erro desconhecido."));
  }
};

