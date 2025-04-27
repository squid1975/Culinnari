"use strict";

const searchForm = document.getElementById("searchForm");
const searchInputs = searchForm.querySelectorAll("input, select");
const dropdowns = document.querySelectorAll(".dropdown");
const sortByButton = document.getElementById("sortByButton");
const radioButtons = document.querySelectorAll("input[name='sortBy']");
const searchReset = document.querySelector(".searchReset");

// Changes the dropdown button for the 'Sort By' radio buttons
if (sortByButton && radioButtons.length > 0) {
  radioButtons.forEach((radio) => {
    radio.addEventListener("change", function () {
      sortByButton.textContent = this.parentElement.textContent.trim();
    });
  });
}

// Changes text of dropdown button based on selected checkboxes in the search menu
if (dropdowns.length > 0) {
  dropdowns.forEach((dropdown) => {
    const button = dropdown.querySelector(".dropdown-button");
    const checkboxes = dropdown.querySelectorAll("input[type='checkbox']");
    if (!button || checkboxes.length === 0) return;

    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener("change", function () {
        updateCheckboxDropdownButton(button, checkboxes);
      });
    });

    // Set initial state
    updateCheckboxDropdownButton(button, checkboxes);
  });
}

// Resets the dropdown buttons when reset button is clicked
searchReset.addEventListener("click", function () {
  dropdowns.forEach((dropdown) => {
    const button = dropdown.querySelector(".dropdown-button");
    if (button) button.textContent = "ANY";
  });

  if (sortByButton) {
    sortByButton.textContent = "Newest";
  }
  searchForm.reset();
});

/**
 * Updates the text of the dropdown button based on selected checkboxes in the search menu
 *
 * @param {Element} button - The button element whose text will be updated
 * @param {Element} checkboxes A collection of checkbox elements inside the dropdown to check for selected filter options
 *
 */
function updateCheckboxDropdownButton(button, checkboxes) {
  if (!button || !checkboxes) return;
  let selected = Array.from(checkboxes)
    .filter((checkbox) => checkbox.checked)
    .map((checkbox) => checkbox.parentElement.textContent.trim());
  button.textContent = selected.length > 0 ? selected.join(", ") : "ANY";
}
