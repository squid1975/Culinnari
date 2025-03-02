"use strict";

/** Global Variables */
/**Ingredient */
const addIngredientButton = document.querySelector("#addIngredient");
const ingredientDirections = document.querySelector("#ingredientDirections");
const measurementAmount = document.querySelector("#measurementAmount");
const measurementUnit = document.querySelector("#ingredientUnit");
const ingredientName = document.querySelector("#ingredientName");
const ingredientList = document.querySelector("#ingredientsContainer");

/** Steps */
const stepDirections = document.querySelector("#stepDirections");
const addStepButton = document.querySelector("#addStep");
let stepsList = document.querySelector("#stepsContainer");
let stepInput = document.querySelector("#stepInput");

function limitCheckboxSelection(category) {
    const checkboxes = document.querySelectorAll(`input[name^="${category}"]`);

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            let checkedBoxes = document.querySelectorAll(`input[name^="${category}"]:checked`);

            if (checkedBoxes.length > 3) {
                this.checked = false; // Uncheck the last selected checkbox
                alert(`You can select up to 3 options for this category.`);
            }
        });
    });
}

limitCheckboxSelection("mealType");
limitCheckboxSelection("style");
limitCheckboxSelection("diet");
/**
 * Adds the recipe step entered by user under the input element
 * @returns 
 */
let stepsArray = [];

function addRecipeStep() {
    if (stepInput.value === "") {
        alert("Please enter a step before adding it to the recipe.");
        return;
    } else {
        let stepText = stepInput.value.trim();
        let newStep = document.createElement("li");
        newStep.textContent = `${stepText}`;
        
        // Create Remove button for step
        let removeButton = document.createElement("button");
        removeButton.textContent = "Remove";
        removeButton.classList.add("remove-button");
        
        // Add event listener to remove the step when clicked
        removeButton.addEventListener('click', function() {
            stepsList.removeChild(newStep);
            // Remove the step from the array when it is deleted
            stepsArray = stepsArray.filter(step => step !== stepText);
            updateStepsArray();
        });

        // Append the remove button to the step and then to the list
        newStep.appendChild(removeButton);
        stepsList.appendChild(newStep);

        // Add the step to the array
        stepsArray.push(stepText);
        stepInput.value = "";

        // Update hidden input field with the current steps array as a JSON string
        updateStepsArray();
    }
}

function updateStepsArray() {
    // Update the hidden input field with the current steps array
    document.querySelector("#stepsInput").value = JSON.stringify(stepsArray);
}

let ingredientsArray = [];

function addRecipeIngredient() {
    if (ingredientName.value === "" || measurementAmount.value === "") {
        alert("Please enter a measurement amount and ingredient name.");
        return;
    } else {
        let ingredientData = {
            ingredient_quantity: measurementAmount.value.trim(),
            ingredient_measurement_name: measurementUnit.value.trim(),
            ingredient_name: ingredientName.value.trim(),
        };

        let newIngredient = document.createElement("li");

        if (measurementUnit.value === "n/a") {
            newIngredient.textContent = `${measurementAmount.value.trim()} ${ingredientName.value.trim()}`;
        } else {
            newIngredient.textContent = `${measurementAmount.value.trim()} ${measurementUnit.value.trim()} ${ingredientName.value.trim()}`;
        }

        // Create Remove button for ingredient
        let removeButton = document.createElement("button");
        removeButton.textContent = "Remove";
        removeButton.classList.add("remove-button");

        // Add event listener to remove the ingredient when clicked
        removeButton.addEventListener('click', function() {
            ingredientList.removeChild(newIngredient);
            // Remove the ingredient from the array when it is deleted
            ingredientsArray = ingredientsArray.filter(ingredient => ingredient.ingredient_name !== ingredientData.ingredient_name);
            updateIngredientsArray();
        });

        // Append the remove button to the ingredient and then to the list
        newIngredient.appendChild(removeButton);
        ingredientList.appendChild(newIngredient);

        // Add the ingredient to the array
        ingredientsArray.push(ingredientData);

        // Clear input fields for the next ingredient
        ingredientName.value = "";
        measurementAmount.value = "";
        measurementUnit.value = "N/A";

        // Update hidden input field with the current ingredients array as a JSON string
        updateIngredientsArray();
    }
}

function updateIngredientsArray() {
    // Update the hidden input field with the current ingredients array
    document.querySelector("#ingredientsInput").value = JSON.stringify(ingredientsArray);
}

addIngredientButton.addEventListener('click', addRecipeIngredient);
addStepButton.addEventListener('click', addRecipeStep);

const recipeImageInput = document.getElementById('recipeImage');
const imagePreview = document.getElementById('imagePreview');

// Add event listener for the file input
recipeImageInput.addEventListener('change', function(event) {
    const file = event.target.files[0]; // Get the selected file
    if (file) {
        const reader = new FileReader();
        
        // Once the file is read, show it in the image preview
        reader.onload = function(e) {
            imagePreview.src = e.target.result;  // Set the image source to the file data
            imagePreview.style.display = 'block';  // Show the image preview
        };

        // Read the file as a data URL (base64)
        reader.readAsDataURL(file);
    } else {
        imagePreview.style.display = 'none'; // Hide preview if no file is selected
    }
});
