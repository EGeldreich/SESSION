// MODAL HANDLING ______________________________________________________________
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

// UTILITY FUNCTION AND MAX WORKING DAYS CALCULATION ___________________________________________
    // Find the number of working days max of the session
    function getWorkingDays(startDateStr, endDateStr) {
        let count = 0;
        let endDate = new Date(endDateStr);
        let currentDate = new Date(startDateStr);

        while (currentDate <= endDate) {
            const dayOfWeek = currentDate.getDay();
            if (dayOfWeek !== 0 && dayOfWeek !== 6) { // Exclude Sundays (0) and Saturdays (6)
                count++;
            }
            currentDate.setDate(currentDate.getDate() + 1);
        }

        return count;
    }

    // Get session dates and get max duration from it
    let startDate = document.querySelector('.date-start').textContent;
    let endDate = document.querySelector('.date-end').textContent;
    let maxDuration = getWorkingDays(startDate, endDate);

// COLLECTION TYPE HANDLING ______________________________________________________________
    // Get relevant elements
        // Container
        let collectionHolder = document.querySelector('#lesson-form_container');
        // Div with de data-prototype
        let prototypeDiv = document.querySelector('#lesson-form_container');
        // Add a row btn
        let addButton = document.querySelector('.add-item');
        // Get session duration container
        let sessionDuration = document.querySelector('.session-duration');
        // Get session duration current number
        let daysOnOpen = parseInt(sessionDuration.textContent);
        // Create index to make each id unique
        let index = collectionHolder.querySelectorAll('div').length;
        // Variable to keep track of numbers added to counter
        let totalAddedNumber = 0;

    // CREATE A NEW FORM, HANDLE EVERYTHING RELATED TO IT
    function addFormEntry() {

        // CREATE NEW FORM ______
            // Get data-prototype value
            let prototype = prototypeDiv.getAttribute('data-prototype');
            // Replace __name__ with index to make it unique and easier to handle
            let newForm = prototype.replace(/__name__/g, index);
            // Create a new div element and add classes to it
            let newFormElement = document.createElement('div');
            newFormElement.classList.add('lesson-form_row', 'grey2-bg', 'row');

            //insert prototype HTML into the new div
            newFormElement.innerHTML = newForm;


        // HANDLE COUNTER CHANGE WHEN TYPING ______
            // Define variable used if user delete a row
            let rowValue = 0;

            // Get input Element
            let input = newFormElement.querySelector('input[type="number"]');
            // Add an eventListener on change
            input.addEventListener('change', () => {

                // Get the value inputed by the user
                let newValue = parseInt(input.value);

                // if incorrect value inputed, set as 0
                if (!Number.isInteger(newValue)) {
                    newValue = 0;
                }

                // Make relevant calculation and update
                totalAddedNumber = totalAddedNumber - rowValue + newValue;
                rowValue = newValue;

                // Change the display
                sessionDuration.textContent = daysOnOpen + totalAddedNumber;

                // Handle color change
                if(parseInt(sessionDuration.textContent) > maxDuration){
                    sessionDuration.style.color = 'var(--red)';
                } else {
                    sessionDuration.style.color = 'var(--white)';
                }
            })


        // REMOVE BTN ______
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
                // Remove HTML Element
                newFormElement.remove();

                // HANDLE COUNTER _____
                    totalAddedNumber -= rowValue;
                    sessionDuration.textContent = daysOnOpen + totalAddedNumber;
                    rowValue = 0;

                    if (parseInt(sessionDuration.textContent) < maxDuration) {
                        sessionDuration.style.color = 'var(--white)';
                    }
            });

        // HANDLE COMPLETED HTML ELEMENT ______
            // Append the new div to the collection holder
            collectionHolder.appendChild(newFormElement);
            // Add classes to a relevant div into the freshly created div
            let formDiv = newFormElement.querySelector(`#program_programs_${index}`);
            formDiv.classList.add('lesson-form_entry', 'row');
            //increment index (to make it unique)
            index++;
    }


// On btn click, add a new row
addButton.addEventListener('click', () => {
    addFormEntry();
});

// Call the function once to start with one form
addFormEntry();




