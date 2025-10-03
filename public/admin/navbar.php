<?php
// admin/navbar.php
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="admin.php">OlwSchool</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="admin.php">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="agenda.php">Agenda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comunicado.php">Comunicados</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="usuario.php">Usuários</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../logout.php">Sair</a>
      </ul>
    </div>
  </div>
</nav>
