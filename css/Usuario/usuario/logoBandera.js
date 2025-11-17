// Obtener el modal y las imágenes
var modal = document.getElementById("imageModal");
var modalImg = document.getElementById("modalImage");
var captionText = document.getElementById("caption");

// Obtener las imágenes de la página (Bandera y Logo)
var images = document.querySelectorAll('.image-thumbnail');

// Añadir un evento de clic para cada imagen
images.forEach(function(image) {
    image.onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src; // Cambiar la imagen del modal
        captionText.innerHTML = this.alt; // Mostrar el texto alternativo (si lo tiene)
  
     // Si la imagen clickeada es el logo, añadir la clase 'logo' para darle un ajuste diferente
        if (this.id === "logo") {
            modalImg.classList.add("logo");
        } else {
            modalImg.classList.remove("logo"); // Asegurarse de que no se quede la clase en otras imágenes
        }
    };
});

// Cuando se haga clic en el botón de cerrar, se oculta el modal
var span = document.getElementById("closeModal");
span.onclick = function() {
    modal.style.display = "none";
};

// Cuando se haga clic fuera de la imagen del modal, también se cierra
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};
