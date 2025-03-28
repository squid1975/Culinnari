"use strict";

const deleteRecipe = document.querySelectorAll('.profileDeleteRecipe');
const deleteRecipeContainer = document.querySelector('.deleteRecipeForm');
const cancelDeleteRecipe = document.querySelector('.cancelRecipeDelete');

deleteRecipe.forEach(deleteItem => {
    deleteItem.addEventListener('click', showDeleteForm);
});

cancelDeleteRecipe.addEventListener('click', hideDeleteForm);


function showDeleteForm() {
    deleteRecipeContainer.style.display = 'block';
}

function hideDeleteForm() {
    deleteRecipeContainer.style.display = 'none';
}