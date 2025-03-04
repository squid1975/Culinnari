"use strict";

/******************** Global Variables **********************/
const error = document.createElement('p');
error.id = 'error';

const createRecipeForm = document.querySelector("#createRecipeForm");

/** Checkboxes */
const checkboxes = document.querySelector("#checkboxes");

/** Ingredient */
const addIngredientButton = document.querySelector("#addIngredient");
const ingredientDirections = document.querySelector("#ingredientDirections");
const measurementAmount = document.querySelector("#measurementAmount");
const measurementUnit = document.querySelector("#ingredientUnit");
const ingredientName = document.querySelector("#ingredientName");

const ingredientSet = document.querySelector("#ingredientInputSet");
const enteredIngredients = document.querySelector("#enteredIngredients");

/** Steps */
const stepDirections = document.querySelector("#stepDirections");
const addStepButton = document.querySelector("#addStep");
const stepsList = document.querySelector("#stepsContainer");
const stepInput = document.querySelector("#stepInput");
const enteredSteps = document.querySelector("#enteredSteps");


/**Submit, Reset, Validation */
const resetRecipeFormButton = document.querySelector("#clearRecipeFormButton");
const submitRecipeButton = document.querySelector("#createRecipeButton");


const newIngredientSet = document.createElement("div");

addIngredientButton.addEventListener('click', function () {
    
    let lastQuantity = measurementAmount.value;
    let lastUnit = measurementUnit.value;
    let lastName = ingredientName.value;
    // Create a new ingredient set
    const newIngredientSet = document.createElement("div");
    newIngredientSet.classList.add("addedIngredients");

    // Populate the new ingredient set with the last input values
    newIngredientSet.innerHTML = `
        <div id="ingredientInputSet">
            <label for="measurementAmount">Amount:
                <input type="text" name="ingredient[][ingredient_quantity]" pattern="^\\d+(\\s\\d+/\\d+)?$|^\\d+/\\d+$" placeholder="1/2" maxlength="4" class="measurementAmount" value="${lastQuantity}">
            </label>
            <label for="ingredientUnit">Unit:
                <select name="ingredient[][ingredient_measurement_name]" class="ingredientUnit">
                    <option value="n/a" ${lastUnit === "n/a" ? "selected" : ""}></option>
                    <option value="teaspoons" ${lastUnit === "teaspoons" ? "selected" : ""}>teaspoon(s)</option>
                    <option value="tablespoon" ${lastUnit === "tablespoon" ? "selected" : ""}>tablespoon(s)</option>
                    <option value="fluid ounce" ${lastUnit === "fluid ounce" ? "selected" : ""}>fluid ounce(s)</option>
                    <option value="cup" ${lastUnit === "cup" ? "selected" : ""}>cup(s)</option>                           
                    <option value="pint" ${lastUnit === "pint" ? "selected" : ""}>pint(s)</option>
                    <option value="quart" ${lastUnit === "quart" ? "selected" : ""}>quart(s)</option>
                    <option value="gallon" ${lastUnit === "gallon" ? "selected" : ""}>gallon(s)</option>
                    <option value="milliliter" ${lastUnit === "milliliter" ? "selected" : ""}>milliliter(s)</option>                                    
                    <option value="liter" ${lastUnit === "liter" ? "selected" : ""}>liter(s)</option>
                    <option value="ounce" ${lastUnit === "ounce" ? "selected" : ""}>ounce(s)</option>
                    <option value="pound" ${lastUnit === "pound" ? "selected" : ""}>pound(s)</option>
                </select>
            </label>
            <label for="ingredientName">Name:
                <input type="text" name="ingredient[][ingredient_name]" placeholder="Cookies (crushed)" class="ingredientName" value="${lastName}">
            </label>
            <button type="button" class="removeIngredient">- Remove</button>
        </div>
    `;

    // Add the remove functionality for the new ingredient input set
    newIngredientSet.querySelector(".removeIngredient").addEventListener('click', function () {
        enteredIngredients.removeChild(newIngredientSet);
    });

    // Append the new ingredient input set to the ingredientDirections container
    enteredIngredients.appendChild(newIngredientSet);
    measurementAmount.value = "";
    ingredientName.value = "";
    measurementAmount.value = "";
});


addStepButton.addEventListener('click', function () {
    let stepInputValue = stepInput.value;
    const newStep = document.createElement("div");
    newStep.classList.add("addedSteps");
    // Create and add the fields for the new ingredient
    newStep.innerHTML = `
        <label for="stepInput" class="visuallyHidden">Step:</label>
                <textarea name="step[]"  id="stepInput" rows="2" cols="25" maxlength="255">${stepInputValue}</textarea>
                <button type="button" class="removeStep">- Remove </button>                     
    `;

    // Add the remove functionality for the new ingredient input set
    newStep.querySelector(".removeStep").addEventListener('click', function () {
        enteredSteps.removeChild(newStep);
    });

    // Append the new ingredient input set to the ingredientDirections container
    enteredSteps.appendChild(newStep);
    stepInput.value = "";
});



function limitCheckboxSelection(category) {
    const checkboxes = document.querySelectorAll(`input[name="${category}[]"]`);

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            let checkedBoxes = document.querySelectorAll(`input[name="${category}[]"]:checked`);

            if (checkedBoxes.length > 3) {
                this.checked = false; // Uncheck the last selected checkbox
            }
        });
    });
}

limitCheckboxSelection("meal_types");
limitCheckboxSelection("styles");
limitCheckboxSelection("diets");






const recipeImageInput = document.getElementById('recipe_image');
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





function limitCheckboxSelection(category) {
    const checkboxes = document.querySelectorAll(`input[name="${category}[]"]`);

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function () {
            let checkedBoxes = document.querySelectorAll(`input[name="${category}[]"]:checked`);

            if (checkedBoxes.length > 3) {
                this.checked = false; // Uncheck the last selected checkbox
            }
        });
    });
}

limitCheckboxSelection("meal_types");
limitCheckboxSelection("styles");
limitCheckboxSelection("diets");

function validateRecipeForm(){
    if(document.querySelector(".ingredient-input-list")){
        error.textContent = "Please enter an ingredient to add to your recipe.";
        return;
    } 
}