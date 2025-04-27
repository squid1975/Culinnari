"use strict";

/**
 * Handle form validation and submission 
 * 
 * @param {string} formId - The ID of the form to validate and submit 
 * @param {string} fieldId - The ID of the field to validate
 */
function addFormValidation(formId, fieldId) {
  const form = document.querySelector(`#${formId}`);
  if (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      const errors = validateName(fieldId);
      if (errors.length === 0) {
        form.submit();
      } else {
        window.scrollTo(0, 0);
      }
    });
  }
}

// Initialize form validation for all forms
addFormValidation('createDietForm', 'dietName');
addFormValidation('editDietForm', 'dietName');
addFormValidation('createStyleForm', 'styleName');
addFormValidation('editStyleForm', 'styleName');
addFormValidation('createMealTypeForm', 'mealTypeName');
addFormValidation('editMealTypeForm', 'mealTypeName');

/**
 * Validate the value of a name field in a form, checking if  it is blank, has a valid length, and contains only valid characters (letters, spaces, hyphens, and apostrophes)
 * 
 * @param {string} fieldId - The ID of the name field to validate
 * @returns {Array} An array of error objects, each containing the field ID and an error message. If there are no errors, the array will be empty.
 *                     
 */
function validateName(fieldId) {
  const errors = [];
  const fieldValue = document.getElementById(fieldId).value;

  const isBlank = str => !str || str.trim() === '';
  const hasLength = (str, { min = 2, max = 50 }) => str.length >= min && str.length <= max;
  
  // Check if the field is blank
  if (isBlank(fieldValue)) {
    errors.push({ field: fieldId, message: 'Name cannot be blank.' });
  } 
  // Check length
  else if (!hasLength(fieldValue, { min: 2, max: 50 })) {
    errors.push({ field: fieldId, message: 'Name must be between 2 and 50 characters.' });
  } 
  // Check for invalid characters (only letters, spaces, hyphens, apostrophes)
  else if (!/^[A-Za-z\-']+( [A-Za-z\-']+)*$/.test(fieldValue)) {
    errors.push({ field: fieldId, message: 'Name can only contain letters, single spaces, hyphens, and apostrophes.' });
  }

  // Display errors
  displayNameErrors(errors);
  return errors;
}

/**
 * Displays error messages for form field validation by inserting them above the form field element 
 * 
 * @param {Array} errors - An array of error objects, each containing the field ID and an error message. 
 */
function displayNameErrors(errors) {
  // Clear existing error messages
  document.querySelectorAll('.error-message').forEach(el => el.remove());

  errors.forEach(error => {
    const inputField = document.getElementById(error.field); // Get the input field based on the error field
    if (inputField) {
      const formField = inputField.parentElement; // Get the parent formField container

      const errorMessage = document.createElement('span');
      errorMessage.classList.add('error-message');
      errorMessage.style.color = 'red';
      errorMessage.style.display = 'block';
      errorMessage.textContent = error.message;

      // Insert the error message *above* the form field
      formField.parentElement.insertBefore(errorMessage, formField);
    }
  });
}
