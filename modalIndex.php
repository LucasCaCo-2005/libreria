<?php if (!empty($mensaje)): ?>
<!-- Modal de Noticia Importante -->
<div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0" style="background-color: rgba(255, 255, 255, 0.9); backdrop-filter: blur(8px);">
      <div class="modal-header bg-primary text-white border-0">
        <h5 class="modal-title" id="mensajeLabel">
          <?= htmlspecialchars($mensaje['titulo']) ?>
        </h5>
      </div>
      <div class="modal-body text-dark fs-5">
        <?= nl2br(htmlspecialchars($mensaje['contenido'])) ?>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<!-- Estilos personalizados -->
<style>
<<<<<<< HEAD
  /* Fondo semitransparente del backdrop */
  .modal-backdrop.show {
    opacity: 0.1 !important; /* Nivel de transparencia */
    background-color: rgba(0, 0, 0, 0.7) !important;
  }

  /* Animación de aparición suave */
=======
  
  .modal-backdrop.show {
    opacity: 0.1 !important; 
    background-color: rgba(0, 0, 0, 0.7) !important;
  }


>>>>>>> 724c893d0c5e263a04d36fe6479dcd67a1653b7c
  .modal.fade .modal-dialog {
    transform: scale(0.95);
    transition: transform 0.25s ease-out;
  }

  .modal.show .modal-dialog {
    transform: scale(1);
  }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const modal = document.getElementById("mensajeModal");
  if (modal) {
    const myModal = new bootstrap.Modal(modal);
    myModal.show();
  }
});
</script>
<?php endif; ?>
