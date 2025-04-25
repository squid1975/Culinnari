"use strict";

/******************** Global Variables **********************/

const signupHeading = document.getElementById('signupHeading');
const newUsername = document.getElementById('newUsername');
const userFirstName = document.getElementById('userFirstName');
const userLastName = document.getElementById('userLastName');
const newPassword = document.getElementById('newPassword');
const confirmPassword = document.getElementById('confirmPassword');
const newUserForm = document.getElementById("newUserForm");

/**** Login / Signup  */

// Add event listeners for each input field, displays required information when focused and hides on blur
newUsername.addEventListener('focus', function() {
    document.getElementById('username-requirements').innerHTML = 'Username must be between 5 and 25 characters long.';
    document.getElementById('username-requirements').style.display = 'block';
  });
  
userFirstName.addEventListener('focus', function() {
    document.getElementById('firstname-requirements').innerHTML = 'First name must be between 2 and 50 characters long. ';
    document.getElementById('firstname-requirements').style.display = 'block';
  });
  
userLastName.addEventListener('focus', function() {
    document.getElementById('lastname-requirements').innerHTML = 'Last name must be between 2 and 50 characters long.';
    document.getElementById('lastname-requirements').style.display = 'block';
  });
  
newPassword.addEventListener('focus', function() {
    document.getElementById('password-requirements').innerHTML = `
      Requirements:
      <ul>
        <li>At least 12 characters </li>
        <li>1 uppercase letter</li>
        <li>1 lowercase letter</li>
        <li>1 number</li>
        <li>1 symbol/special character</li>
      </ul>`;
    document.getElementById('password-requirements').style.display = 'block';
  });
  
  newUsername.addEventListener('blur', function() {
    document.getElementById('username-requirements').style.display = 'none';
  });
  
  userFirstName.addEventListener('blur', function() {
    document.getElementById('firstname-requirements').style.display = 'none';
  });
  
  userLastName.addEventListener('blur', function() {
    document.getElementById('lastname-requirements').style.display = 'none';
  });
  
  newPassword.addEventListener('blur', function() {
    document.getElementById('password-requirements').style.display = 'none';
  });
  
  confirmPassword.addEventListener('blur', function() {
    document.getElementById('confirmPassword-requirements').style.display = 'none';
  });

  newUserForm.addEventListener('submit', function (event) {
    event.preventDefault();
    let errors = validateUser();
    if(errors.length === 0) {
        newUserForm.submit();
    } else {
        window.scrollTo(0,0);
    }
});

  function displayErrors(errors) {
    errors.forEach(error => {
        const inputField = document.getElementById(error.field);
        if (inputField) {
            const errorMessage = document.createElement('span');
            errorMessage.classList.add('error-message');
            errorMessage.style.color = 'red';
            errorMessage.textContent = error.message;
            inputField.parentNode.appendChild(errorMessage);
        }
    });
}
  
/**
 * Validation for creating a new user
 * 
 
 * @returns {array} errors - an object containing error messages for each field
 */
function validateUser() {
  const errors = [];

  let username = document.getElementById('newUsername').value;
  let userFirstName = document.getElementById('userFirstName').value;
  let userLastName = document.getElementById('userLastName').value;
  let userEmail = document.getElementById('userEmailAddress').value;
  let password = document.getElementById('newPassword').value;
  let confirmPassword = document.getElementById('confirmPassword').value;

  const isBlank = str => !str || str.trim() === '';
  const hasLength = (str, { min = 0, max = 255 }) => str.length >= min && str.length <= max;
  const hasValidEmailFormat = email => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

  // Username
  if (isBlank(username)) {
    errors.push({ field: 'newUsername', message: 'Username cannot be blank.' });
  } else if (!hasLength(username, { min: 8, max: 25 })) {
    errors.push({ field: 'newUsername', message: 'Username must be between 5 and 25 characters.' });
  }

  // First name
  if (isBlank(userFirstName)) {
    errors.push({ field: 'userFirstName', message: 'First name cannot be blank.' });
  }

  // Last name
  if (isBlank(userLastName)) {
    errors.push({ field: 'userLastName', message: 'Last name cannot be blank.' });
  } else if (!hasLength(userLastName, { min: 2, max: 50 })) {
    errors.push({ field: 'userLastName', message: 'Last name must be between 2 and 50 characters.' });
  }

  // Email
  if (isBlank(userEmail)) {
    errors.push({ field: 'userEmail', message: 'Email cannot be blank.' });
  } else if (!hasValidEmailFormat(userEmail)) {
    errors.push({ field: 'userEmail', message: 'Email must be a valid format.' });
  }

  // Password
  const passwordRequired = true; 

  if (passwordRequired) {
    if (isBlank(password)) {
      errors.push({ field: 'newPassword', message: 'Password cannot be blank.' });
    } else {
      if (!hasLength(password, { min: 12 })) {
        errors.push({ field: 'newPassword', message: 'Password must contain 12 or more characters.' });
      }
      if (!/[A-Z]/.test(password)) {
        errors.push({ field: 'newPassword', message: 'Password must contain at least 1 uppercase letter.' });
      }
      if (!/[a-z]/.test(password)) {
        errors.push({ field: 'newPassword', message: 'Password must contain at least 1 lowercase letter.' });
      }
      if (!/[0-9]/.test(password)) {
        errors.push({ field: 'newPassword', message: 'Password must contain at least 1 number.' });
      }
      if (!/[^A-Za-z0-9\s]/.test(password)) {
        errors.push({ field: 'newPassword', message: 'Password must contain at least 1 symbol.' });
      }
    }

    if (isBlank(confirmPassword)) {
      errors.push({ field: 'confirmPassword', message: 'Confirm password cannot be blank.' });
    } else if (password !== confirmPassword) {
      errors.push({ field: 'confirmPassword', message: 'Password and confirm password must match.' });
    }
  }

  displayErrors(errors);
  return(errors);
}
