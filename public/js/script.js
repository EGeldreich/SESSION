// document.addEventListener('turbo:load', function() {
//   const links = document.querySelectorAll('nav a');
  
//   console.log(links)
  
//   // Récupère l'ID du lien actif depuis localStorage
//   const activeLinkId = localStorage.getItem('activeLinkId');
  
//   if (activeLinkId) {
//       const activeLink = document.getElementById(activeLinkId);
//       if (activeLink) {
//           activeLink.classList.add('active');
//       }
//   }
  
//   links.forEach(link => {
//       link.addEventListener('click', function() {
//           // Enregistre l'ID du lien actif dans localStorage avant de changer de page
//           localStorage.setItem('activeLinkId', this.id);
//           window.location.reload()
//       });
//   });

// });

// SESSION LIST DISPLAY _________________________________________________________
document.addEventListener('turbo:load', function() {
  let sessionBtn = document.querySelectorAll('.session-display-btn');
  let sessionLists = document.querySelectorAll('.session-card-container');

  sessionBtn.forEach(btn => {
    btn.addEventListener('click', function() {
      let target = btn.id.replace('-btn', '');
      let targetList = document.querySelector(`.session-card-container__${target}`);

      sessionBtn.forEach(btn => {
        btn.classList.remove('blue-bg');
        btn.classList.add('grey2-bg');
      });
      sessionLists.forEach(list => list.classList.add('hidden'));
      targetList.classList.remove('hidden');

      btn.classList.remove('grey2-bg');
      btn.classList.add('blue-bg');
    });
  });
});

// STUDENT MODAL HANDLING ______________________________________________________________
document.addEventListener('turbo:load', function() {

  let modal = document.querySelector("#student-modal");
  let btn = document.querySelector("#add-student-button");
  // let closeBtn = document.querySelector("#student-modal_close");
  
  // When the user clicks on the button, open the modal
  btn.onclick = function() {
    modal.style.display = "grid";
  }
  
  // When the user clicks on <closeBtn> (x), close the modal
  // closeBtn.onclick = function() {
  //   modal.style.display = "none";
  // }
  
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

});