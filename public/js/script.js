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

// COLLECTION TYPE HANDLING ______________________________________________________________
document.addEventListener('turbo:load', function() {
  // Get relevant elements
  // Container
  let collectionHolder = document.querySelector('#lesson-form_container');
  console.log(collectionHolder);
  // Div with de data-prototype
  let prototypeDiv = document.querySelector('#program_programs');
  // Add a row btn
  let addButton = document.querySelector('.add-item');
  console.log(addButton);
  // index ?
  let index = collectionHolder.querySelectorAll('div').length;
  console.log(index);

  // On btn click, add a new row
  addButton.addEventListener('click', function() {

    // Get data-prototype value
      let prototype = prototypeDiv.getAttribute('data-prototype');
    // Replace __name__ with index to make it unique and easier to handle
      let newForm = prototype.replace(/__name__/g, index);
    // Create a new div element and add classes to it
      let newFormElement = document.createElement('div');
      newFormElement.classList.add('lesson-form_row', 'grey2-bg');

      //insert prototype HTML into the new div
      newFormElement.innerHTML = newForm;
      // Append the new div to the collection holder
      collectionHolder.appendChild(newFormElement);
      // Add classes to a relevant div into the freshly created div
      let formDiv = newFormElement.querySelector(`#program_programs_${index}`);
      formDiv.classList.add('lesson-form_entry', 'row');
      //increment index (to make it unique)
      index++;
  });

  collectionHolder.addEventListener('click', function(e) {
      if (e.target.classList.contains('remove-item')) {
          e.target.closest('div').remove();
      }
  });
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