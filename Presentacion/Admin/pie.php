</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

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

  document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
      if (link.getAttribute('href') === currentPage) {
        link.classList.add('active');
      }
    });
  });
  
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // **CORRECCIÓN: Prevenir envío doble de formularios SOLO después de que se procese**
  document.querySelectorAll('form').forEach(form => {
    let isSubmitting = false;
    
    form.addEventListener('submit', function(e) {
      if (isSubmitting) {
        e.preventDefault();
        return;
      }
      
      const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
      if (submitBtn && !submitBtn.disabled) {
        isSubmitting = true;
        
        // Guardar el texto original si no existe
        if (!submitBtn.getAttribute('data-original-text')) {
          submitBtn.setAttribute('data-original-text', submitBtn.innerHTML);
        }
        
        // Deshabilitar después de un pequeño delay para permitir el envío
        setTimeout(() => {
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        }, 100);
        
        // Restaurar después de 5 segundos por si hay error
        setTimeout(() => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = submitBtn.getAttribute('data-original-text');
          isSubmitting = false;
        }, 5000);
      }
    });
  });

  // **OPCIÓN ALTERNATIVA MÁS SEGURA: Solo para formularios que no recargan la página**
  /*
  document.querySelectorAll('form[data-ajax="true"]').forEach(form => {
    form.addEventListener('submit', function(e) {
      const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        
        setTimeout(() => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = submitBtn.getAttribute('data-original-text') || 'Enviar';
        }, 5000);
      }
    });
  });
  */
</script>

<style>
  .container-fluid {
    padding-left: 20px;
    padding-right: 20px;
  }
  

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