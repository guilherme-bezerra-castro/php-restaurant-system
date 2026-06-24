document.addEventListener('DOMContentLoaded', () => {
  const totalSlides = document.querySelectorAll('carousel-item').length;

  const inner = document.querySelector('.carousel-inner');
  const indicators = document.querySelector('.carousel-indicators');

  function inicializarCarousel() {
    let indiceAtual = 0;

    function showSlide(n) {
      indiceAtual = n;

      const offset = -n * 100;
      inner.style.transform = `translateX(${offset}%)`;
      document.querySelectorAll('.carousel-indicators button')
        .forEach((btn, i) => btn.classList.toggle('active', i === n));
    }

    function inicializarAvancaAutomatico() {
      const intervalId = setInterval(() => {
        indiceAtual = (indiceAtual + 1) % imagens.length;

        showSlide(indiceAtual);

      }, 5000);
    }

    function inicializarIndicadores(showSlide) {
      document.querySelectorAll('.carousel-indicators button')
        .forEach((btn, i) => btn.addEventListener('click', () => showSlide(i)))
    }

    inicializarAvancaAutomatico();

    inicializarIndicadores(showSlide);
  }

  inicializarCarousel();
  
});