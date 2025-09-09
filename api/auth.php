<?php
// owl-school/api/auth.php
declare(strict_types=1);
require_once __DIR__ . "/../db/conexao.php"; // carrega conexão ($conn)
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } // garante sessão

$email = trim($_POST['email'] ?? '');  // e-mail do form
$senha = $_POST['senha'] ?? '';        // senha do form

if ($email === '' || $senha === '') {  // valida campos obrigatórios
    header("Location: ../public/index.php?erro=usuario"); // volta com erro genérico
    exit;
}

// busca usuário por e-mail
$sql  = "SELECT id, nome, email, senha, tipo_usuario FROM usuario WHERE email = ? LIMIT 1"; // query única
$stmt = $conn->prepare($sql);                 // prepara
$stmt->bind_param("s", $email);               // vincula e-mail
$stmt->execute();                              // executa
$result = $stmt->get_result();                 // resultado

if ($result->num_rows !== 1) {                // não achou exatamente 1
    header("Location: ../public/index.php?erro=usuario&email=" . urlencode($email)); // retorna com info
    exit;
}

$user = $result->fetch_assoc();                // dados do usuário

// aceita password_hash() OU (temporário) texto puro igual ao seed
$senhaConfere = password_verify($senha, $user['senha']) || hash_equals((string)$user['senha'], (string)$senha); // compara com segurança
if (!$senhaConfere) {                          // senha inválida
    header("Location: ../public/index.php?erro=senha&email=" . urlencode($email)); // erro de senha
    exit;
}

// mapeia papeis que têm tabela específica (admin não precisa)
$roleMap = [                                   // papel => [tabela, chave_de_sessao]
  'aluno'       => ['aluno',       'aluno_id'],
  'professor'   => ['professor',   'professor_id'],
  'responsavel' => ['responsavel', 'responsavel_id'],
];

$extraId = null;                               // id específico (aluno/professor/responsavel)
if (isset($roleMap[$user['tipo_usuario']])) {  // se papel tem tabela própria
    [$table, $sessKey] = $roleMap[$user['tipo_usuario']]; // nome da tabela e chave da sessão
    $sqlId = "SELECT id FROM {$table} WHERE usuario_id = ? LIMIT 1"; // busca id por usuário
    $stmt2 = $conn->prepare($sqlId);           // prepara
    $stmt2->bind_param("i", $user['id']);      // vincula id do usuário
    $stmt2->execute();                         // executa
    $res2 = $stmt2->get_result();              // pega resultado
    if ($res2->num_rows !== 1) {               // não encontrou vínculo
        header("Location: ../public/index.php?erro=tipo&email=" . urlencode($email)); // erro de tipo/vínculo
        exit;
    }
    $extraId = (int)$res2->fetch_assoc()['id']; // guarda id específico
}

// preenche sessão básica
$_SESSION = [];                                // reseta arr de sessão
$_SESSION['user_id']    = (int)$user['id'];    // id do usuário
$_SESSION['user_name']  = $user['nome'];       // nome do usuário
$_SESSION['user_email'] = $user['email'];      // e-mail do usuário
$_SESSION['role']       = $user['tipo_usuario']; // papel atual

// adiciona id específico se existir
if ($extraId !== null) {
    $_SESSION[$roleMap[$user['tipo_usuario']][1]] = $extraId; // ex.: $_SESSION['aluno_id'] = 123
}

// redireciona por papel (mantém rotas existentes)
switch ($user['tipo_usuario']) {               // decide destino
    case 'aluno':       header("Location: ../public/aluno/aluno.php");           break; // área do aluno
    case 'professor':   header("Location: ../public/professor/professor.php");   break; // área do professor
    case 'responsavel': header("Location: ../public/responsavel/responsavel.php");break; // área do responsável
    case 'admin':       header("Location: ../public/admin/admin.php");           break; // área do admin
    default:            header("Location: ../public/index.php?erro=tipo");       // papel inválido
}
exit; // encerra o script após header
