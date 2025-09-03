<?php
require_once __DIR__ . "/../db/conexao.php";

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$sql = "SELECT * FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if ($senha === $user['senha_hash']) {
        switch ($user['tipo_usuario']) {
            case 'aluno':       header("Location: ../public/aluno/aluno.php"); break;
            case 'professor':   header("Location: ../public/professor/professor.php"); break;
            case 'responsavel': header("Location: ../public/responsavel/responsavel.php"); break;
            case 'admin':       header("Location: ../public/admin/admin.php"); break;
            default:
                header("Location: ../index.php?erro=tipo");
        }
        exit;
    } else {
        // senha errada
        header("Location: ../public/index.php?erro=senha&email=" . urlencode($email));
        exit;
    }
} else {
    // usuário não encontrado
    header("Location: ../public/index.php?erro=usuario&email=" . urlencode($email));
    exit;
}

$conn->close();
?>
