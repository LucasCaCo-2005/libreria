<?php if (!empty($mensaje)): ?>

<div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0" style="background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px);">
      <div class="modal-header bg-primary text-white border-0">
        <h5 class="modal-title" id="mensajeLabel">
          <?= htmlspecialchars($mensaje['titulo']) ?>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-dark fs-5" style="max-height: 70vh; overflow-y: auto;">
        <?= nl2br(htmlspecialchars($mensaje['contenido'])) ?>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>


<style>

  body.modal-open {
    overflow: auto !important;
    padding-right: 0 !important;
  }
  
  /* Fondo del modal semitransparente */
  .modal-backdrop {
    opacity: 0.5 !important;
  }
  
  /* Eliminar el backdrop que bloquea el scroll */
  .modal-backdrop.show {
    display: none !important;
  }
  
  /* Alternativa: backdrop muy transparente */
  .modal-backdrop.show.alternative {
    opacity: 0.1 !important;
  }
  

  .modal.fade .modal-dialog {
    transform: translateY(-100px);
    transition: transform 0.3s ease-out;
  }
  
  .modal.show .modal-dialog {
    transform: translateY(0);
  }
  
  /* Z-index para que el modal esté sobre el contenido */
  #mensajeModal {
    z-index: 1060;
  }
  
  /* Permitir scroll detrás del modal */
  .modal {
    overflow: hidden;
    position: fixed;
  }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const modal = document.getElementById("mensajeModal");
  if (modal) {
    // Configurar modal para permitir scroll
    const myModal = new bootstrap.Modal(modal, {
      backdrop: true,  // Cambia a 'static' si quieres que no se cierre al hacer clic fuera
      keyboard: true   // Permite cerrar con ESC
    });
    
    myModal.show();
    
    // Cuando el modal se muestra, permitir scroll en body
    modal.addEventListener('shown.bs.modal', function () {
      document.body.style.overflow = 'auto';
      document.body.style.paddingRight = '0';
    });
    
    // Cuando el modal se oculta, restaurar scroll normal
    modal.addEventListener('hidden.bs.modal', function () {
      document.body.style.overflow = 'auto';
    });
  }
});
</script>
<?php endif; ?>