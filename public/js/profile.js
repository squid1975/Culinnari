"use strict";

/******************** Profile Modals **********************/

const deleteRecipeButtons = document.querySelectorAll(".deleteRecipeButton");
const removeRecipeButtons = document.querySelectorAll(".removeRecipeButton");
const createCookbookButton = document.querySelector("#createCookbookButton");

// If the user has not created a cookbook, this will show the create cookbook modal
if(createCookbookButton) {
createCookbookButton.addEventListener("click", () => {
  const createCookbookModal = document.querySelector("#createCookbookModal");
  createCookbookModal.style.display = "block";

  const closeBtn = createCookbookModal.querySelector(".close");
  closeBtn.addEventListener("click", () => {
    createCookbookModal.style.display = "none";
  });
});
}

// Create a modal for each delete recipe button and add event listeners
deleteRecipeButtons.forEach(button => {
  
  const container = button.closest(".profileDeleteRecipe");
  const modal = container.querySelector(".modal");
  const closeBtn = modal.querySelector(".close");

  button.addEventListener("click", () => {
    modal.style.display = "block";
  });

  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  window.addEventListener("click", event => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
});
