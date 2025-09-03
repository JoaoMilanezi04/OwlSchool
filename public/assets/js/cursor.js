console.log("cursor.js carregado");
(function () {
  const isTouch = "ontouchstart" in window || navigator.maxTouchPoints > 0;
  if (isTouch) return; // em dispositivos touch, não exibe

  // cria o elemento caso não exista
  let ring = document.getElementById("cursor-ring");
  if (!ring) {
    ring = document.createElement("div");
    ring.id = "cursor-ring";
    document.body.appendChild(ring);
  }

  let targetX = window.innerWidth / 2;
  let targetY = window.innerHeight / 2;
  let currentX = targetX;
  let currentY = targetY;
  const ease = 0.18; // suavização do movimento

  function raf() {
    // interpolação (lerp) para suavizar
    currentX += (targetX - currentX) * ease;
    currentY += (targetY - currentY) * ease;
    ring.style.transform = `translate(${currentX - 0.5}px, ${
      currentY - 0.5
    }px) translate(-50%, -50%)`;
    requestAnimationFrame(raf);
  }

  // mostra ao primeiro movimento
  function onMove(e) {
    targetX = e.clientX;
    targetY = e.clientY;
    if (ring.style.opacity !== "1") ring.style.opacity = "1";
  }

  // efeito de clique
  function onDown() {
    ring.classList.add("ring-click");
  }
  function onUp() {
    ring.classList.remove("ring-click");
  }

  // esconder ao sair da janela
  function onLeave() {
    ring.style.opacity = "0";
  }
  function onEnter() {
    ring.style.opacity = "1";
  }

  window.addEventListener("mousemove", onMove, { passive: true });
  window.addEventListener("mousedown", onDown);
  window.addEventListener("mouseup", onUp);
  window.addEventListener("mouseleave", onLeave);
  window.addEventListener("mouseenter", onEnter);

  requestAnimationFrame(raf);
})();
