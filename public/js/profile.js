"use strict";


const deleteRecipeButtons = document.querySelectorAll(".deleteRecipeButton");
const removeRecipeButtons = document.querySelectorAll(".removeRecipeButton");

deleteRecipeButtons.forEach(button => {
  
  const container = button.closest(".profileDeleteRecipe");
  const modal = container.querySelector(".modal");
  const closeBtn = modal.querySelector(".close");
  const cancelBtn = modal.querySelector(".cancelRecipeDelete");

  
  button.addEventListener("click", () => {
    modal.style.display = "block";
  });

 
  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  
  cancelBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  
  window.addEventListener("click", event => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
});

