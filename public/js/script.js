"use strict";

/******************** Global Variables **********************/


let newUsername = document.getElementById('newUsername');


/**** Login / Signup  */

// Add event listeners for each input field
newUsername.addEventListener('focus', function() {
    document.getElementById('username-requirements').innerHTML = 'Username must be between 8 and 32 characters long.';
    document.getElementById('username-requirements').style.display = 'block';
  });
  
  document.getElementById('userFirstName').addEventListener('focus', function() {
    document.getElementById('firstname-requirements').innerHTML = 'First name must be between 2 and 50 characters long. ';
    document.getElementById('firstname-requirements').style.display = 'block';
  });
  
  document.getElementById('userLastName').addEventListener('focus', function() {
    document.getElementById('lastname-requirements').innerHTML = 'Last name must be between 2 and 50 characters long.';
    document.getElementById('lastname-requirements').style.display = 'block';
  });
  
  document.getElementById('newPassword').addEventListener('focus', function() {
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
  
  document.getElementById('newUsername').addEventListener('blur', function() {
    document.getElementById('username-requirements').style.display = 'none';
  });
  
  document.getElementById('userFirstName').addEventListener('blur', function() {
    document.getElementById('firstname-requirements').style.display = 'none';
  });
  
  document.getElementById('userLastName').addEventListener('blur', function() {
    document.getElementById('lastname-requirements').style.display = 'none';
  });
  
  document.getElementById('newPassword').addEventListener('blur', function() {
    document.getElementById('password-requirements').style.display = 'none';
  });
  
  document.getElementById('confirmPassword').addEventListener('blur', function() {
    document.getElementById('confirmPassword-requirements').style.display = 'none';
  });

