// STUDENT MODAL HANDLING ______________________________________________________________
// Get relevant elements
let studentModal = document.querySelector("#student-modal");
let studentBtn = document.querySelector("#add-student-button");

// Open modal
studentBtn.onclick = function() {
    studentModal.style.display = "grid";

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
studentModal.onclick = function(event) {
    if (event.target == studentModal) {
    studentModal.style.display = "none";
    }
}
