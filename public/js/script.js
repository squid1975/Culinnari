"use strict";

/******************** Global Variables **********************/
let error = document.createElement('p');

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

const ingredientSet = document.querySelector("#ingredientInputSet");
const enteredIngredients = document.querySelector("#enteredIngredients");

/** Steps */
const stepDirections = document.querySelector("#stepDirections");
const addStepButton = document.querySelector("#addStep");
const stepsList = document.querySelector("#stepsContainer");
const stepInput = document.querySelector("#stepInput");
const enteredSteps = document.querySelector("#enteredSteps");

const recipeImageInput = document.getElementById('recipe_image');

/**Submit, Reset, Validation */
const resetRecipeFormButton = document.querySelector("#clearRecipeFormButton");
const submitRecipeButton = document.querySelector("#createRecipeButton");


let ingredientIndex = 0;

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
        <div id="ingredientInputSet">
            <label for="measurementAmount">Amount:
                <input type="text" name="ingredient[${ingredientIndex}][ingredient_quantity]" pattern="^\\d+(\\s\\d+/\\d+)?$|^\\d+/\\d+$" placeholder="1/2" maxlength="3" class="measurementAmount" value="${lastQuantity}">
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
    error.remove();
    ingredientIndex++;
    }
}
addIngredientButton.addEventListener('click', addIngredient);

let stepIndex = 0;
addStepButton.addEventListener('click', addStep);

function addStep(){
    let stepInputValue = stepInput.value;
    if(stepInputValue = ""){
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
                <button type="button" class="removeStep">- Remove </button>                     
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

function validateRecipeForm() {
    let isValid = true;
    let errors = [];
    // Time validation
    const prepHours = parseInt(document.getElementById('prep_time_hours').value || 0);
    const prepMinutes = parseInt(document.getElementById('prep_time_minutes').value || 0);
    const cookHours = parseInt(document.getElementById('cook_time_hours').value || 0);
    const cookMinutes = parseInt(document.getElementById('cook_time_minutes').value || 0);
    
    if (prepHours === 0 && prepMinutes === 0 && cookHours === 0 && cookMinutes === 0) {
        errors.push('Please enter a value for the prep time and/or cook time.');
        isValid = false;
    }
    
    
    // Ingredients validation
    const ingredientInputs = document.querySelector('#enteredIngredients');
    if (!ingredientInputs) {
        errors.push('At least one ingredient is required');
        isValid = false;
    }
    
    // Steps validation
    const stepInputs = document.querySelector('#enteredSteps');
    if (!stepInputs) {
        errors.push('At least one step is required');
        isValid = false;
    }
    
    // YouTube link validation (optional)
    const youtubeLink = document.getElementById('youtube_link').value.trim();
    if (youtubeLink !== '') {
        const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/;
        if (!youtubeRegex.test(youtubeLink)) {
            errors.push('Please enter a valid YouTube URL');
            isValid = false;
        }
    }
    
    // Image validation (optional)
    const recipeImage = document.getElementById('recipe_image');
    if (recipeImage.files.length > 0) {
        const file = recipeImage.files[0];
        const fileType = file.type;
        const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        
        if (!validImageTypes.includes(fileType)) {
            errors.push('Please upload a valid image file (JPEG, PNG, JPG, or WEBP)');
            isValid = false;
        }
        
        
    }
    
    // Display errors if any
    if (!isValid) {
        // Create or clear error container
        let errorContainer = document.getElementById('validationErrors');
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.id = 'validationErrors';
            document.getElementById('createRecipeForm').prepend(errorContainer);
        } else {
            errorContainer.innerHTML = '';
        }
        
        // Add error messages
        const errorList = document.createElement('ul');
        errors.forEach(error => {
            const errorItem = document.createElement('li');
            errorItem.textContent = error;
            errorList.appendChild(errorItem);
        });
        
        errorContainer.appendChild(errorList);
        
        // Scroll to top to see errors
        window.scrollTo(0, 0);
    }
    
    return isValid;
}

    // Image preview
    const recipeImage = document.getElementById('recipe_image');
    const imagePreview = document.getElementById('imagePreview');
    
    recipeImage.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        } else {
            imagePreview.style.display = 'none';
        }
});
    

    const servingAmt = document.querySelector('#servingAmt');
    const ingredientQuantityAmt = document.querySelector("#recipeDisplayMeasurementAmount");
    const halfButton = document.querySelector('#halfButton');
    const oneTimeButton = document.querySelector('#1time');
    const twoTimesButton = document.querySelector('#2time');
    const threeTimesButton = document.querySelector('#3time');


    // Function to convert decimal to fraction
function decimalToFraction(decimal) {
        const whole = Math.floor(decimal);
        const fraction = decimal - whole;

        if (fraction === 0) {
            return whole.toString();
        }

        const denominator = 100;
        let numerator = Math.round(fraction * denominator);

        // Simplify fraction (find GCD)
        const gcdValue = gcd(numerator, denominator);
        numerator /= gcdValue;
        denominator /= gcdValue;

        if (whole === 0) {
            return `${numerator}/${denominator}`;
        } else {
            return `${whole} ${numerator}/${denominator}`;
        }
    }
    

    // Helper function to calculate GCD (greatest common divisor)
    function gcd(a, b) {
        while (b !== 0) {
            let temp = b;
            b = a % b;
            a = temp;
        }
        return a;
    }

    // Event listeners for the buttons
    halfButton.addEventListener('click', function() {
        updateIngredients(0.5);
    });
    oneTimeButton.addEventListener('click', function() {
        updateIngredients(1);
    });
    twoTimesButton.addEventListener('click', function() {
        updateIngredients(2);
    });
    threeTimesButton.addEventListener('click', function() {
        updateIngredients(3);
    });