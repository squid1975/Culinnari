"use strict";

let dropdowns = document.querySelectorAll(".dropdown");
const sortByButton = document.getElementById("sortByButton");
const radioButtons = document.querySelectorAll("input[name='sortBy']");

radioButtons.forEach(radio => {
    radio.addEventListener("change", function () {
    sortByButton.textContent = this.parentElement.textContent.trim();
});
});


dropdowns.forEach((dropdown) => {
const button = dropdown.querySelector(".dropdown-button");
const checkboxes = dropdown.querySelectorAll("input[type='checkbox']");


checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
        updateDropdownButton(button, checkboxes);
    });
});

// Initialize button text in case of pre-selected options
updateDropdownButton(button, checkboxes);
});

function updateDropdownButton(button, checkboxes) {
let selected = Array.from(checkboxes)
.filter((checkbox) => checkbox.checked)
.map((checkbox) => checkbox.parentElement.textContent.trim()); // Get label text

button.textContent = selected.length > 0 ? selected.join(", ") : "ANY"; // Join multiple selections or show "ANY"
}