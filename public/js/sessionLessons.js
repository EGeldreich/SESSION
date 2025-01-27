//  LESSON MODAL HANDLING ______________________________________________________________
// Get relevant elements
let lessonModal = document.querySelector("#lesson-modal");
let lessonBtn = document.querySelector("#add-lesson-button");

// Open modal
lessonBtn.onclick = function() {
    lessonModal.style.display = "grid";
    // SET DURATION DYNAMICALLY ??
}

// Close modal on click outside of modal-content
lessonModal.onclick = function(event) {
    if (event.target == lessonModal) {
    lessonModal.style.display = "none";
    }
}


// COLLECTION TYPE HANDLING ______________________________________________________________

// Get relevant elements
// Container
let collectionHolder = document.querySelector('#lesson-form_container');
console.log(collectionHolder);
// Div with de data-prototype
let prototypeDiv = document.querySelector('#lesson-form_container');
// Add a row btn
let addButton = document.querySelector('.add-item');
console.log(addButton);
// index ?
let index = collectionHolder.querySelectorAll('div').length;
console.log(index);

// CREATE NEW FORM ELEMENT AND ADD REMOVE BUTTON EVENT LISTENER
function addFormEntry() {
    // Get data-prototype value
    let prototype = prototypeDiv.getAttribute('data-prototype');
    // Replace __name__ with index to make it unique and easier to handle
    let newForm = prototype.replace(/__name__/g, index);
    // Create a new div element and add classes to it
    let newFormElement = document.createElement('div');
    newFormElement.classList.add('lesson-form_row', 'grey2-bg', 'row');

    //insert prototype HTML into the new div
    newFormElement.innerHTML = newForm;

    // Get the remove button
    let removeBtnTemplate = document.querySelector('#removeBtn-template');
    // Clone the remove button template
    let removeBtn = removeBtnTemplate.content.cloneNode(true);

    // Append the btn to the element
    newFormElement.appendChild(removeBtn);
    
    // Append the remove button to the new form element
    newFormElement.appendChild(removeBtn);
    
    // get the newly created btn
    let removeBtnElement = newFormElement.querySelector('.remove-btn');

    // Add event listener to the remove button
    removeBtnElement.addEventListener('click', function() {
        newFormElement.remove();
    });

    // Append the new div to the collection holder
    collectionHolder.appendChild(newFormElement);
    // Add classes to a relevant div into the freshly created div
    let formDiv = newFormElement.querySelector(`#program_programs_${index}`);
    formDiv.classList.add('lesson-form_entry', 'row');
    //increment index (to make it unique)
    index++;
}

// On btn click, add a new row
addButton.addEventListener('click', addFormEntry);

addFormEntry();