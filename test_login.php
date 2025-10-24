<?php
require_once __DIR__ . '/db/conexao.php';

// Testar conexão
echo "Testando conexão com banco de dados...<br>";
if ($conn->connect_error) {
    die("ERRO: " . $conn->connect_error);
}
echo "✓ Conexão OK<br><br>";

// Testar se existem usuários
echo "Verificando usuários no banco:<br>";
$result = $conn->query("SELECT id, nome, email, tipo_usuario FROM usuario");
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['tipo_usuario'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum usuário encontrado!";
}

echo "<br><br>";

// Testar login específico
echo "Testando login com joao.aluno@teste.com / 123456:<br>";
$email = 'joao.aluno@teste.com';
$senha = '123456';

$stmt = $conn->prepare("SELECT id, nome, tipo_usuario FROM usuario WHERE email = ? AND senha = ?");
$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if ($usuario) {
    echo "✓ Login OK! Dados:<br>";
    echo "ID: " . $usuario['id'] . "<br>";
    echo "Nome: " . $usuario['nome'] . "<br>";
    echo "Tipo: " . $usuario['tipo_usuario'] . "<br>";
} else {
    echo "✗ Login falhou!";
}

$conn->close();
?>
