"use strict";
/**************************************************** CREATE RECIPE PAGE ********************************************************************/
const errorsBox = document.createElement('div');
errorsBox.classList.add('errors');
const error = document.createElement('p');
/***  CREATE RECIPE VARIABLES */
const recipeFormHeading = document.querySelector(".recipeFormHeading");
const recipeForm = document.querySelector(".recipeForm");
const recipeName = document.querySelector("#recipeName");
const recipeDescriptionDirections = document.querySelector("#recipeDescriptionDirections");
const recipeDifficultyLabel  = document.querySelector("#recipeDifficultyLabel");
const timeFieldset = document.querySelector("#timeDirections");


/** Checkboxes */
const checkboxes = document.querySelector("#checkboxes");
const timeInputContainer = document.querySelector("#timeInput");
const totalServingsContainer = document.querySelector("#totalServingsContainer");

/** Ingredients */
const addIngredientButton = document.querySelector("#addIngredient");
const ingredientDirections = document.querySelector("#ingredientDirections");
const measurementAmount = document.querySelector("#measurementAmount");
const measurementUnit = document.querySelector("#ingredientUnit");
const ingredientName = document.querySelector("#ingredientName");
const newIngredientSet = document.createElement("div");
newIngredientSet.classList.add("addedIngredients");
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
const clearRecipeFormModal = document.getElementById('clearRecipeFormModal');
const confirmFormResetButton = document.getElementById('confirmFormReset');
const cancelResetButton = document.getElementById('cancelReset');

addIngredientButton.addEventListener('click', addIngredient);
addStepButton.addEventListener('click', addStep);

enteredIngredients.addEventListener("click", function (event) {
    if (event.target.classList.contains("removeIngredient")) {
        const ingredientSet = event.target.closest(".addedIngredients");
        if (ingredientSet) {
            ingredientSet.remove(); // Remove the clicked ingredient set
        }
    }
});

enteredSteps.addEventListener("click", function (event) {
    if (event.target.classList.contains("removeStep")) {
        const stepSet = event.target.closest(".addedSteps");
        if (stepSet) {
            stepSet.remove(); // Remove the clicked ingredient set
        }
    }
});

recipeForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const errors = validateRecipeForm();
    if(errors.length === 0) {
        recipeForm.submit();
    } else {
        window.scrollTo(0,0);
        errorsBox.innerHTML = ""; // Clear previous error messages
        errorsBox.textContent = "Please fix the errors below:";
        recipeFormHeading.appendChild(errorsBox);

    }

});


limitCheckboxSelection("meal_types");
limitCheckboxSelection("styles");
limitCheckboxSelection("diets");

/**
 * Limits the number of checkboxes that can be selected in a category to 3
 * 
 * @param {string} category the name of the category (diet, meal type, style, etc)
 */
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
            <label for="measurementAmount-${ingredientIndex}">Amount:
                <input type="text" 
                name="ingredient[${ingredientIndex}][ingredient_quantity]" 
                pattern="^\\d{1,2}(\\s\\d{1,2}\\/\\d{1,2})?$|^\\d{1,2}\\/\\d{1,2}$"
                placeholder="1, 1/2, 1 1/2" 
                maxlength="6" 
                id="measurementAmount-${ingredientIndex}" 
                value="${lastQuantity}">
            </label>
            <label for="ingredientUnit">Unit:
                <select name="ingredient[${ingredientIndex}][ingredient_measurement_name]" class="ingredientUnit">
                    <option value="n/a" ${lastUnit === "n/a" ? "selected" : ""}></option>
                    <option value="teaspoon" ${lastUnit === "teaspoon" ? "selected" : ""}>teaspoon</option>
                    <option value="tablespoon" ${lastUnit === "tablespoon" ? "selected" : ""}>tablespoon</option>
                    <option value="fluid ounce" ${lastUnit === "fluid ounce" ? "selected" : ""}>fluid ounce</option>
                    <option value="cup" ${lastUnit === "cup" ? "selected" : ""}>cup</option>                           
                    <option value="pint" ${lastUnit === "pint" ? "selected" : ""}>pint</option>
                    <option value="quart" ${lastUnit === "quart" ? "selected" : ""}>quart</option>
                    <option value="gallon" ${lastUnit === "gallon" ? "selected" : ""}>gallon</option>
                    <option value="milliliter" ${lastUnit === "milliliter" ? "selected" : ""}>milliliter</option>                                    
                    <option value="liter" ${lastUnit === "liter" ? "selected" : ""}>liter</option>
                    <option value="ounce" ${lastUnit === "ounce" ? "selected" : ""}>ounce</option>
                    <option value="pound" ${lastUnit === "pound" ? "selected" : ""}>pound</option>
                </select>
            </label>
            <label for="ingredientName[${ingredientIndex}]">Name:
                <input type="text" name="ingredient[${ingredientIndex}][ingredient_name]" placeholder="Cookies (crushed)" id="ingredientName[${ingredientIndex}]" value="${lastName}">
            </label>
            <button type="button" class="removeIngredient">X</button>
        </div>
    `;

    // Append the new ingredient input set to the ingredientDirections container
    enteredIngredients.appendChild(newIngredientSet);
    // Clear the input fields for the next ingredient
    measurementAmount.value = "";
    ingredientUnit.selectedIndex = 0;
    ingredientName.value = "";
    error.remove();
    ingredientIndex++;
    }
}

/**
 * Adds a new step to the list of steps
 * 
 * @returns clears input box to type next step
 */
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
        <label for="stepInput[${stepIndex}]" class="visuallyHidden">Step:</label>
        <textarea name="step[${stepIndex}][step_description]"  id="stepInput[${stepIndex}]" rows="2" cols="25" maxlength="255">${stepInputValue}</textarea>
        <button type="button" class="removeStep">X</button>                     
    `;

    // Append the new ingredient input set to the ingredientDirections container
    enteredSteps.appendChild(newStep);
    stepInput.value = "";
    stepIndex++;
    }
}

// Add event listener for the recipe image to preview the image
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

/**
 * Validates the recipe form fields and returns an array of errors
 * 
 * @returns {Array} errors An array of error objects containing field names and messages
 */
function validateRecipeForm() {
    let errors = [];
    // Clear previous errors
    document.querySelectorAll('.error-message').forEach(el => el.remove());

    // Recipe name validation
    const recipeName = document.getElementById('recipeName')?.value.trim();
    if (!recipeName) {
        errors.push({
            field: 'recipeName',
            message: 'Please enter a recipe name.'
        });
    } else if (recipeName.length < 2 || recipeName.length > 40) {
        errors.push({
            field: 'recipeName',
            message: 'Recipe name must be between 2 and 40 characters.'
        });
    } else if (!/^[A-Za-z0-9\-'\s]+$/.test(recipeName)) {
        errors.push({
            field: 'recipeName',
            message: "Recipe name can only contain letters, numbers, hyphens, apostrophes, and spaces."
        });
    }

    // Recipe description validation 
    const recipeDescription = document.getElementById('recipeDescription')?.value.trim();
    if (!recipeDescription) {
        errors.push({
            field: 'recipeDescriptionDirections',
            message: 'Please enter a recipe description.'
        });
    } else if (!/^[A-Za-z0-9\-'\s]+$/.test(recipeDescription)) {
        errors.push({
            field: 'recipeDescriptionDirections',
            message: "Recipe description can only contain letters, numbers, hyphens, apostrophes, and spaces."
        });
    }
    
    const difficultyRadio = document.querySelector('input[name="recipe[recipe_difficulty]"]:checked');
    if (!difficultyRadio) {
        errors.push({
            field: 'recipeDifficultyLabel',
            message: 'Please select a difficulty level.'
        });
    }

    // Time validation
    const prepHours = parseInt(document.getElementById('prepTimeHours')?.value || 0);
    const prepMinutes = parseInt(document.getElementById('prepTimeMinutes')?.value || 0);
    const cookHours = parseInt(document.getElementById('cookTimeHours')?.value || 0);
    const cookMinutes = parseInt(document.getElementById('cookTimeMinutes')?.value || 0);

    if (prepHours === 0 && prepMinutes === 0 && cookHours === 0 && cookMinutes === 0) {
        errors.push({
            field: 'timeDirections',
            message: 'Please enter a value for the prep time and/or cook time.'
        });
    }

    // Ingredients validation
    const ingredientInputs = document.querySelectorAll('.addedIngredients');
    if (ingredientInputs.length === 0) {
        errors.push({
            field: 'ingredientDirections',
            message: 'At least one ingredient is required.'
        });
    }


    // Steps validation
    const stepInputs = document.querySelectorAll('.addedSteps');
    if (stepInputs.length === 0) {
        errors.push({
            field: 'stepDirections',
            message: 'At least one step is required.'
        });
    } 

    // YouTube validation (optional)
    const youtubeLink = document.getElementById('youtube_link')?.value.trim();
    if (youtubeLink) {
        const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com\/(?:[^\/\n\s]+\/\S+|(?:v|e(?:mbed)?)\/(\S+))|youtu\.be\/\S+)$/;
        if (!youtubeRegex.test(youtubeLink)) {
            errors.push({
                field: 'youtube_link',
                message: 'Please enter a valid YouTube share link URL.'
            });
        }
    }

    // Image validation (optional)
    const recipeImage = document.getElementById('recipe_image');
    if (recipeImage?.files.length > 0) {
        const file = recipeImage.files[0];
        const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

        if (!validImageTypes.includes(file.type)) {
            errors.push({
                field: 'recipe_image',
                message: 'Please upload a valid image file (JPEG, PNG, JPG, or WEBP).'
            });
        }
    }
    displayErrors(errors);
    return errors;
}


/**
 * Display error messages for the corresponding input fields
 * @param {Array} errors 
 */
function displayErrors(errors) {
    errors.forEach(error => {
        const inputField = document.getElementById(error.field);
        if (inputField) {
            const existingError = inputField.parentNode.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }
            const errorMessage = document.createElement('span');
            errorMessage.classList.add('error-message');
            errorMessage.style.color = 'red';
            errorMessage.textContent = error.message;
            inputField.appendChild(errorMessage);
        }
    });
}

/**
 * 
 * @param {Integer} fraction The fraction, whole number, or mixed number to convert to a decimal 
 * @returns 
 */
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

/**
 * Converts a decimal number to a simplified mixed fraction string.
 * 
 * @param {integer} decimal The decimal value to convert to a mixed fraction 
 * @returns {string} A string representing a mixed fraction (e.g., "1 1/2").
 */
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
