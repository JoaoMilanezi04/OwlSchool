<?php
require_once __DIR__ . '/db/conexao.php';

echo "<h2>Teste de Conexão com o Banco de Dados</h2>";

// Testar conexão
if ($conn->connect_error) {
    die("❌ Falha na conexão: " . $conn->connect_error);
}
echo "✅ Conexão bem-sucedida!<br><br>";

// Listar todos os usuários
$sql = "SELECT id, nome, email, tipo_usuario FROM usuario";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h3>Usuários cadastrados:</h3>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["nome"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["tipo_usuario"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "❌ Nenhum usuário encontrado no banco de dados.";
}

$conn->close();
?>
