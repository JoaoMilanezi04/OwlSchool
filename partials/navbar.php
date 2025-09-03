<?php /* partials/navbar.php */ ?>



<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container">
    <!-- Logo / Nome -->
    <a class="navbar-brand fw-bold" href="/public/index.php">🦉 OlwSchool</a>

    <!-- Botão hamburguer (mobile) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/public/about.php">Sobre</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/public/help.php">Ajuda</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-outline-primary btn-sm ms-lg-3" href="/public/index.php">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
