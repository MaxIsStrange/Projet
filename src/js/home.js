/* Animation du carousel */
bulmaCarousel.attach('#slider', {
  slidesToScroll: 1,
  slidesToShow: 3,
  infinite: true,
});


/* animation du navbar-burger pour l'affichage mobile */
document.addEventListener('DOMContentLoaded', () => {

  // Récupère tous les "navbar-burger"
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Vérifie so il y a d'autre navbar burger
  if ($navbarBurgers.length > 0) {

    // Ajout de l'action du click pour le navbar-burger
    $navbarBurgers.forEach(el => {
      el.addEventListener('click', () => {

        // Récupeère la cible depuis "data_target"
        const target = el.dataset.target;
        const $target = document.getElementById(target);

        // Déroule la classe "is-active" pour le "navbar-burger" et le "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
  }
});