"use strict";

/** Global Variables */

const addStepButton = document.querySelector("#addStep");
const addIngredientButton = document.querySelector("#addIngredient");
const ingredientDirections = document.querySelector("#ingredientDirections");
const stepDirections = document.querySelector("#stepDirections");
let stepsList = document.querySelector("#stepsContainer");
let stepInput = document.querySelector("#stepInput");
let stepCount = 1;

const measurementAmount = document.querySelector("#measurementAmount");
const measurementUnit = document.querySelector("#ingredientUnit");
const ingredientName = document.querySelector("#ingredientName");
const ingredientList = document.querySelector("#ingredientsContainer");
let ingredientCount = 1;


/**
 * Adds the recipe step entered by user under the input element
 * @returns 
 */
function addRecipeStep() {
    if (stepInput.value === "") {
        alert("Please enter a step before adding it to the recipe.");
        return;
    } else {
        let newStep = document.createElement("li");
        newStep.textContent = `${stepCount}: ${stepInput.value.trim()}`;
        
        // Create Remove button for step
        let removeButton = document.createElement("button");
        removeButton.textContent = "Remove";
        removeButton.classList.add("remove-button");
        
        // Add event listener to remove the step when clicked
        removeButton.addEventListener('click', function() {
            stepsList.removeChild(newStep);
        });

        // Append the remove button to the step and then to the list
        newStep.appendChild(removeButton);
        stepsList.appendChild(newStep);
        stepCount++;
        stepInput.value = "";
    }
}

function addRecipeIngredient() {
    if(ingredientName.value === "" || measurementAmount.value === "") {
        alert("Please enter a measurement amount and ingredient name.");
        return;
    } else {
        let newIngredient = document.createElement("li");
        if(measurementUnit.value === "n/a") {
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
        });

        // Append the remove button to the ingredient and then to the list
        newIngredient.appendChild(removeButton);
        ingredientList.appendChild(newIngredient);

        ingredientCount++;
        ingredientName.value = "";
        measurementAmount.value = "";
        measurementUnit.value = "N/A";
    }
}
addIngredientButton.addEventListener('click', addRecipeIngredient);
addStepButton.addEventListener('click', addRecipeStep);