  <?php

if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  header('Location: afonso/owl-school/public/index.php?erro=acesso_negado');
  exit;
}

?>
  
  
  
  <nav class="bg-dark text-white p-3 vh-100" style="width: 220px; position: fixed;">
    <h4 class="fw-bold mb-4">OlwSchool</h4>
    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="admin.php">🏠 Início</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="agenda.php">📅 Agenda</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="comunicado.php">📢 Comunicados</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="usuario.php">👤 Usuários</a>
      </li>
      <li class="nav-item mt-3">
        <a class="nav-link text-danger fw-bold" href="../logout.php">🚪 Sair</a>
      </li>
    </ul>
  </nav>