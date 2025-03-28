"use strict";
/**************************************************** CREATE RECIPE, VIEW RECIPE PAGES ********************************************************************/
document.createElement('p.error');
const error = document.createElement('p');
/***  CREATE RECIPE VARIABLES */
const createRecipeForm = document.querySelector("#createRecipeForm");

/** Checkboxes */
const checkboxes = document.querySelector("#checkboxes");
const timeInputContainer = document.querySelector("#timeInput");
const totalServingsContainer = document.querySelector("#totalServingsContainer");

/** Ingredient */
const addIngredientButton = document.querySelector("#addIngredient");
const ingredientDirections = document.querySelector("#ingredientDirections");
const measurementAmount = document.querySelector("#measurementAmount");
const measurementUnit = document.querySelector("#ingredientUnit");
const ingredientName = document.querySelector("#ingredientName");
let ingredientIndex = 0;

const ingredientSet = document.querySelector("#ingredientInputSet");
const enteredIngredients = document.querySelector("#enteredIngredients");

/** Steps */
const stepDirections = document.querySelector("#stepDirections");
const addStepButton = document.querySelector("#addStep");
const stepsList = document.querySelector("#stepsContainer");
const stepInput = document.querySelector("#stepInput");
const enteredSteps = document.querySelector("#enteredSteps");
let stepIndex = 0;

/**Image Preview */
const recipeImage = document.getElementById('recipe_image');
const imagePreview = document.getElementById('imagePreview');
const recipeImageInput = document.getElementById('recipe_image');
const recipeAcceptedFiles = document.getElementById('recipeAcceptedFileTypes');

/**Submit, Reset, Validation */
const resetRecipeFormButton = document.querySelector("#clearRecipeFormButton");
const submitRecipeButton = document.querySelector("#createRecipeButton");

addIngredientButton.addEventListener('click', addIngredient);
addStepButton.addEventListener('click', addStep);

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

/**
 * Adds a new ingredient list input box to form
 * 
 * @returns clears input boxes to type next ingredient
 */
function addIngredient() {
    let lastQuantity = measurementAmount.value.trim();
    let lastUnit = measurementUnit.value.trim();
    let lastName = ingredientName.value.trim();
    if(lastQuantity === "" || lastName === ""){
        error.textContent = "Please enter a measurement amount and ingredient name.";
        ingredientDirections.append(error);
        return;
    } else {
    // Create a new ingredient set
    const newIngredientSet = document.createElement("div");
    newIngredientSet.classList.add("addedIngredients");

    // Populate the new ingredient set with the last input values
    newIngredientSet.innerHTML = `
        <div class="ingredientInputSet">
            <label for="measurementAmount">Amount:
                <input type="text" name="ingredient[${ingredientIndex}][ingredient_quantity]" 
                pattern="^\\d{1,2}(\\s\\d{1,2}\\/\\d{1,2})?$|^\\d{1,2}\\/\\d{1,2}$"
                placeholder="1, 1/2, 1 1/2" 
                maxlength="6" 
                id="measurementAmount-${ingredientIndex}" 
                value="${lastQuantity}">
            </label>
            <label for="ingredientUnit">Unit:
                <select name="ingredient[${ingredientIndex}][ingredient_measurement_name]" class="ingredientUnit">
                    <option value="n/a" ${lastUnit === "n/a" ? "selected" : ""}></option>
                    <option value="teaspoon" ${lastUnit === "teaspoon" ? "selected" : ""}>teaspoon(s)</option>
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
                <input type="text" name="ingredient[${ingredientIndex}][ingredient_name]" placeholder="Cookies (crushed)" class="ingredientName" value="${lastName}">
            </label>
            <button type="button" class="removeIngredient">X</button>
        </div>
    `;

    // Add the remove functionality for the new ingredient input set
    newIngredientSet.querySelector(".removeIngredient").addEventListener('click', function () {
        enteredIngredients.removeChild(newIngredientSet);
    });

    // Append the new ingredient input set to the ingredientDirections container
    enteredIngredients.appendChild(newIngredientSet);
    measurementAmount.value = "";
    measurementUnit.value = "n/a"
    ingredientName.value = "";
    error.remove();
    ingredientIndex++;
    }
}


function addStep(){
    let stepInputValue = stepInput.value;
    if(stepInputValue === ""){
        error.textContent = "Please enter a step before adding.";
        stepDirections.appendChild(error);
        return;
    } else { 
    const newStep = document.createElement("div");
    newStep.classList.add("addedSteps");
    // Create and add the fields for the new ingredient
    newStep.innerHTML = `
        <label for="stepInput" class="visuallyHidden">Step:</label>
        <textarea name="step[${stepIndex}][step_description]"  id="stepInput" rows="2" cols="25" maxlength="255">${stepInputValue}</textarea>
        <button type="button" class="removeStep">X</button>                     
    `;

    // Add the remove functionality for the new ingredient input set
    newStep.querySelector(".removeStep").addEventListener('click', function () {
        enteredSteps.removeChild(newStep);
    });

    // Append the new ingredient input set to the ingredientDirections container
    enteredSteps.appendChild(newStep);
    stepInput.value = "";
    stepIndex++;
}
}

// Add event listener for the file input
recipeImageInput.addEventListener('change', function(event) {
    const file = event.target.files[0]; // Get the selected file
    
    // Clear any previous error message
    error.textContent = '';

    // Check if a file is selected
    if (file) {
        const acceptedTypes = ['image/jpeg', 'image/png', 'image/webp']; // List of accepted file types
        if (acceptedTypes.includes(file.type)) {
            const reader = new FileReader();

            // Once the file is read, show it in the image preview
            reader.onload = function(e) {
                imagePreview.src = e.target.result;  // Set the image source to the file data
                imagePreview.style.display = 'block';  // Show the image preview
            };

            // Read the file as a data URL (base64)
            reader.readAsDataURL(file);
        } else {
            // Show an error message if the file type is not accepted
            error.textContent = "Invalid file type. Please upload a JPG/JPEG, PNG, or WEBP image.";
            recipeAcceptedFiles.appendChild(error);
            event.target.value = ''; // Clear the file input
            imagePreview.style.display = 'none'; // Hide the preview if the file type is invalid
        }
    } else {
        imagePreview.style.display = 'none'; // Hide preview if no file is selected
    }
});




function validateRecipeForm() {
    let isValid = true;
    let errors = [];
    
    // Time validation
    const prepHours = parseInt(document.getElementById('prep_time_hours').value || 0);
    const prepMinutes = parseInt(document.getElementById('prep_time_minutes').value || 0);
    const cookHours = parseInt(document.getElementById('cook_time_hours').value || 0);
    const cookMinutes = parseInt(document.getElementById('cook_time_minutes').value || 0);
    
    if (prepHours === 0 && prepMinutes === 0 && cookHours === 0 && cookMinutes === 0) {
        errors.push({
            field: 'prep_time_hours',
            message: 'Please enter a value for the prep time and/or cook time.'
        });
    }
    
    // Ingredients validation
    const ingredientInputs = document.querySelector('.addedIngredients');
    if (!ingredientInputs) {
        errors.push({
            field: 'ingredientInputs',
            message: 'At least one ingredient is required.'
        });
    }
    
    // Steps validation
    const stepInputs = document.querySelector('.addedSteps');
    if (!stepInputs) {
        errors.push({
            field: 'stepInputs',
            message: 'At least one step is required'
        });
    }
    
    // YouTube link validation (optional)
    const youtubeLink = document.getElementById('youtube_link').value.trim();
    if (youtubeLink !== '') {
        const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/;
        if (!youtubeRegex.test(youtubeLink)) {
            errors.push({
                field: 'youtube_link',
                message: 'Please enter a valid YouTube URL'
            });
        }
    }
    
    // Image validation (optional)
    const recipeImage = document.getElementById('recipe_image');
    if (recipeImage.files.length > 0) {
        const file = recipeImage.files[0];
        const fileType = file.type;
        const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        
        if (!validImageTypes.includes(fileType)) {
            errors.push({
                field: 'recipe_image',
                message: 'Please upload a valid image file (JPEG, PNG, JPG, or WEBP)'
            });
        } 
    }
    
    // Display errors under the corresponding fields
    errors.forEach(error => {
        const inputField = document.getElementById(error.field);
        if (inputField) {
            // Clear existing error messages
            let existingError = inputField.nextElementSibling;
            if (existingError && existingError.classList.contains('error-message')) {
                existingError.remove();
            }

            // Create new error message
            const errorMessage = document.createElement('span');
            errorMessage.classList.add('error-message');
            errorMessage.textContent = error.message;
            inputField.parentNode.appendChild(errorMessage);
        }
    });
    
    // Set isValid to false if there are errors
    isValid = errors.length === 0;
    
    return isValid;
}

function convertToDecimal(fraction) {
    if (fraction.includes(' ')) {
        const [whole, frac] = fraction.split(' ');
        const [numerator, denominator] = frac.split('/');
        return parseFloat(whole) + parseFloat(numerator) / parseFloat(denominator);
    }
    if (fraction.includes('/')) {
        const [numerator, denominator] = fraction.split('/');
        return parseFloat(numerator) / parseFloat(denominator);
    }
    return parseFloat(fraction); // if it's a whole number
}

// Helper function to convert a decimal to a mixed fraction
function decimalToMixedFraction(decimal) {
    const whole = Math.floor(decimal);
    const fractionPart = decimal - whole;

    if (fractionPart === 0) {
        return whole.toString(); // if no fraction part, just return the whole number
    }

    let denominator = 1000; // Start with a larger denominator for precision
    let numerator = Math.round(fractionPart * denominator);

    // Simplify the fraction
    const gcd = (a, b) => {
        while (b !== 0) {
            let temp = b;
            b = a % b;
            a = temp;
        }
        return a;
    };
    const commonDivisor = gcd(numerator, denominator);
    numerator /= commonDivisor;
    denominator /= commonDivisor;

    // If the numerator is greater than the denominator, we need to adjust the whole number part
    if (numerator >= denominator) {
        return `${whole + Math.floor(numerator / denominator)} ${numerator % denominator}/${denominator}`;
    }

    // Return the fraction part if the whole part is zero
    if (whole === 0) {
        return `${numerator}/${denominator}`;
    }

    return `${whole} ${numerator}/${denominator}`;
}