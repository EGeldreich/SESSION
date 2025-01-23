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
  // Get relevant elements
  let modal = document.querySelector("#student-modal");
  let btn = document.querySelector("#add-student-button");
  
  // Open modal
  btn.onclick = function() {
    modal.style.display = "grid";

    // Dynamic places display

    // Get relevant elements
    let placesLeft = document.querySelector('.places-left');
    let studentCheckboxes = document.querySelectorAll('.student-modal_checkbox');
    let placesLeftOnOpen = document.querySelector('.places-left').textContent;
    // Transform string to number
    placesLeftOnOpen = parseInt(placesLeftOnOpen);

    // Update places left on checkbox click
    studentCheckboxes.forEach(checkbox => {
      checkbox.addEventListener('click', function() {
        // minus one place if checkbox is checked
        if (checkbox.checked) {
          placesLeftOnOpen --;
          placesLeft.textContent = placesLeftOnOpen;
        }
        // plus one place if checkbox is unchecked
        else {
          placesLeftOnOpen ++;
          placesLeft.textContent = placesLeftOnOpen;
        }
      });
    });
  }
  
  // Close modal on click outside of modal-content
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
});

//  LESSON MODAL HANDLING ______________________________________________________________
document.addEventListener('turbo:load', function() {
  // Get relevant elements
  let modal = document.querySelector("#lesson-modal");
  let btn = document.querySelector("#add-lesson-button");
  
  // Open modal
  btn.onclick = function() {
    modal.style.display = "grid";
    // SET DURATION DYNAMICALLY ??
  }
  
  // Close modal on click outside of modal-content
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
});

// FLASH MESSAGES DISMISS ______________________________________________________________
document.addEventListener('turbo:load', function() {
  let flashMessage = document.querySelector('.flash');

  if (flashMessage) {
    // Wait 2 seconds before fading out
    setTimeout(() => {
      flashMessage.style.transition = 'opacity 1s';
      flashMessage.style.opacity = '0';
      // After that, wait 100 miliseconds before removing element
      setTimeout(() => {
        flashMessage.style.display = 'none';
      }, 100);

    }, 2000);
  }
});