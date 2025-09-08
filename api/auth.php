<?php
// owl-school/api/auth.php
declare(strict_types=1);
require_once __DIR__ . "/../db/conexao.php";
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    header("Location: ../public/index.php?erro=usuario");
    exit;
}

// Busca o usuário pelo e-mail
$sql = "SELECT id, nome, email, senha, tipo_usuario FROM usuario WHERE email = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: ../public/index.php?erro=usuario&email=" . urlencode($email));
    exit;
}

$user = $result->fetch_assoc();

// ✅ Aceita password_hash() OU (temporário) texto puro igual ao seed
$senhaConfere = password_verify($senha, $user['senha']) || hash_equals((string)$user['senha'], (string)$senha);
if (!$senhaConfere) {
    header("Location: ../public/index.php?erro=senha&email=" . urlencode($email));
    exit;
}


// Busca o id específico conforme o tipo de usuário
$alunoId = $profId = $respId = $adminId = null;
if ($user['tipo_usuario'] === 'aluno') {
    $sqlAluno = "SELECT id FROM aluno WHERE usuario_id = ? LIMIT 1";
    $stmtA = $conn->prepare($sqlAluno);
    $stmtA->bind_param("i", $user['id']);
    $stmtA->execute();
    $resA = $stmtA->get_result();
    if ($resA->num_rows !== 1) {
        header("Location: ../public/index.php?erro=tipo&email=" . urlencode($email));
        exit;
    }
    $alunoRow = $resA->fetch_assoc();
    $alunoId = (int)$alunoRow['id'];
}
if ($user['tipo_usuario'] === 'professor') {
    $sqlProf = "SELECT id FROM professor WHERE usuario_id = ? LIMIT 1";
    $stmtP = $conn->prepare($sqlProf);
    $stmtP->bind_param("i", $user['id']);
    $stmtP->execute();
    $resP = $stmtP->get_result();
    if ($resP->num_rows !== 1) {
        header("Location: ../public/index.php?erro=tipo&email=" . urlencode($email));
        exit;
    }
    $profRow = $resP->fetch_assoc();
    $profId = (int)$profRow['id'];
}
if ($user['tipo_usuario'] === 'responsavel') {
    $sqlResp = "SELECT id FROM responsavel WHERE usuario_id = ? LIMIT 1";
    $stmtR = $conn->prepare($sqlResp);
    $stmtR->bind_param("i", $user['id']);
    $stmtR->execute();
    $resR = $stmtR->get_result();
    if ($resR->num_rows !== 1) {
        header("Location: ../public/index.php?erro=tipo&email=" . urlencode($email));
        exit;
    }
    $respRow = $resR->fetch_assoc();
    $respId = (int)$respRow['id'];
}

// Preenche a sessão
$_SESSION = [];
$_SESSION['user_id']    = (int)$user['id'];
$_SESSION['user_name']  = $user['nome'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['role']       = $user['tipo_usuario'];

if ($alunoId !== null) { $_SESSION['aluno_id'] = $alunoId; }
if ($profId !== null)  { $_SESSION['professor_id'] = $profId; }
if ($respId !== null)  { $_SESSION['responsavel_id'] = $respId; }
// Para admin, não há id específico, usa user_id

// Redireciona por papel
switch ($user['tipo_usuario']) {
    case 'aluno':
        header("Location: ../public/aluno/aluno.php");
        break;
    case 'professor':
        header("Location: ../public/professor/professor.php");
        break;
    case 'responsavel':
        header("Location: ../public/responsavel/responsavel.php");
        break;
    case 'admin':
        header("Location: ../public/admin/admin.php");
        break;
    default:
        header("Location: ../public/index.php?erro=tipo");
}
exit;
