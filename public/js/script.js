
// const links = document.querySelectorAll('nav a');

// console.log(links)

// // Récupère l'ID du lien actif depuis localStorage
// const activeLinkId = localStorage.getItem('activeLinkId');

// if (activeLinkId) {
//     const activeLink = document.getElementById(activeLinkId);
//     if (activeLink) {
//         activeLink.classList.add('active');
//     }
// }

// links.forEach(link => {
//     link.addEventListener('click', function() {
//         // Enregistre l'ID du lien actif dans localStorage avant de changer de page
//         localStorage.setItem('activeLinkId', this.id);
//         window.location.reload()
//     });
// });


// MODAL HANDLING
// Get the modal
var modal = document.querySelector(".modal");

// Get the button that opens the modal
var btn = document.querySelector(".modal-button");

// Get the <span> element that closes the modal
var closeBtn = document.querySelector(".modal-close");

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <closeBtn> (x), close the modal
closeBtn.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}