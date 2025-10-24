<?php

if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  header('Location: /owl-school/public/index.php?erro=acesso_negado');
  exit;
}

?>
  
  
  
  
  <nav class="bg-dark text-white p-3 vh-100" style="width: 220px; position: fixed;">
    <h4 class="fw-bold mb-4">OlwSchool</h4>
    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="professor.php">🏠 Início</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="chamada.php">📋 Chamadas</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="tarefas.php">📝 Tarefas</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="comunicado.php">📢 Comunicados</a>
      </li>
      <li class="nav-item mb-2">
        <a class="nav-link text-white" href="provas.php">🧮 Provas</a>
      </li>
      <li class="nav-item mt-3">
        <a class="nav-link text-danger fw-bold" href="/owl-school/public/logout.php">🚪 Sair</a>
      </li>
    </ul>
  </nav>