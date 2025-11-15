  
        // JavaScript para el carrusel
        const carruselInner = document.querySelector('.carrusel-inner');
        const items = document.querySelectorAll('.carrusel-item');
        const totalItems = items.length;
        let index = 0;

        // Eventos de botones
        document.querySelector('.carrusel-btn.next').addEventListener('click', () => {
            index = (index + 1) % totalItems;
            updateCarrusel();
        });

        document.querySelector('.carrusel-btn.prev').addEventListener('click', () => {
            index = (index - 1 + totalItems) % totalItems;
            updateCarrusel();
        });

        // Función de actualización
        function updateCarrusel() {
            carruselInner.style.transform = `translateX(-${index * 100}%)`;
        }

        // Deslizar automáticamente cada 5 segundos
        setInterval(() => {
            index = (index + 1) % totalItems;
            updateCarrusel();
        }, 5000);
