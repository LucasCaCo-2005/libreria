  </div> <!-- /.row -->
</div> <!-- /.container-fluid -->

<!-- ✅ Bootstrap 5 JS (con Popper incluido) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<!-- 🔹 Scripts Mejorados -->
<script>
  // Autoremover alertas después de 5 segundos
  setTimeout(() => {
    const alertas = document.querySelectorAll('.alert');
    alertas.forEach(alerta => {
      alerta.style.opacity = '0';
      alerta.style.transition = 'opacity 0.5s ease';
      setTimeout(() => alerta.remove(), 500);
    });
  }, 5000);

  // Efecto de scroll suave para enlaces internos
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // Resaltar elemento activo en el menú
  document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
      if (link.getAttribute('href') === currentPage) {
        link.classList.add('active');
      }
    });
  });

  // Tooltips para elementos con data-bs-toggle
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Prevenir envío doble de formularios
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
      const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        
        // Re-enable after 5 seconds in case of error
        setTimeout(() => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = submitBtn.getAttribute('data-original-text') || 'Enviar';
        }, 5000);
      }
    });
  });

  // Guardar texto original de botones
  document.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(btn => {
    btn.setAttribute('data-original-text', btn.innerHTML);
  });
</script>

<!-- 🔸 Estilos adicionales para el footer -->
<style>
  .container-fluid {
    padding-left: 20px;
    padding-right: 20px;
  }
  
  /* Mejoras para las alertas */
  .alert {
    border: none;
    border-radius: 12px;
    border-left: 4px solid;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }
  
  .alert-success {
    background: #d4edda;
    border-left-color: #28a745;
    color: #155724;
  }
  
  .alert-danger {
    background: #f8d7da;
    border-left-color: #dc3545;
    color: #721c24;
  }
  
  .alert-warning {
    background: #fff3cd;
    border-left-color: #ffc107;
    color: #856404;
  }
  
  .alert-info {
    background: #d1ecf1;
    border-left-color: #17a2b8;
    color: #0c5460;
  }
</style>

</body>
</html>