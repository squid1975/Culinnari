"use strict";

/** VIEW RECIPE VARIABLES */
const addToCookbookButton = document.querySelector('#addToCookbookButton');
const addToCookbookModal = document.querySelector('#addToCookbookModal');


/** Change Ingredient Amount Variables */
const servingAmtElement = document.querySelector("#servingAmt");
const originalServingAmt = parseFloat(servingAmtElement.textContent.trim());
const halfButton = document.getElementById("halfButton");
const oneTimeButton = document.getElementById("1timeButton");
oneTimeButton.id = 'selected';
const twoTimeButton = document.getElementById("2timeButton");
const threeTimeButton = document.getElementById("3timeButton");
const closeRatingButton = document.querySelector("#closeRatingWidget");
const servingAmt = document.querySelector("#servingAmt").textContent;
const ingredientAmounts = document.querySelectorAll(".recipeDisplayMeasurementAmount");

ingredientAmounts.forEach(item => {
    item.setAttribute("data-original", item.innerHTML.trim());
});

if (addToCookbookButton && addToCookbookModal) {
    const closeCookbookModalButton = addToCookbookModal.querySelector('.close');
  
    addToCookbookButton.addEventListener('click', function () {
      addToCookbookModal.style.display = 'block';
    });
  
    if (closeCookbookModalButton) {
      closeCookbookModalButton.addEventListener('click', () => {
        addToCookbookModal.style.display = 'none';
      });
    }
  
    window.addEventListener('click', function (event) {
      if (event.target === addToCookbookModal) {
        addToCookbookModal.style.display = 'none';
      }
    });
  }

/**
 * Resets all ingredient amounts and the serving amount
 * back to their original values displayed on the page.
 */
function resetAmounts() {
    ingredientAmounts.forEach(item => {
        item.innerHTML = item.getAttribute("data-original");
    });
    // Reset serving amount
    servingAmtElement.textContent = originalServingAmt;
}

/**
 * Updates ingredient amounts and serving size by the given multiplier.
 * @param {number} multiplier - The value to multiply each ingredient amount by.
 */
function updateAmounts(multiplier) {
    ingredientAmounts.forEach(item => {
        let fraction = item.getAttribute("data-original"); // Get original value
        // Convert to decimal
        const decimalValue = convertToDecimal(fraction);
        // Multiply by the amount (multiplier)
        const multipliedValue = decimalValue * multiplier;
        // Convert the result back to a fraction
        const fractionResult = decimalToMixedFraction(multipliedValue);
        // Set the inner HTML to the fraction result
        item.innerHTML = fractionResult;
    });

    // Update serving amount
    servingAmtElement.textContent = originalServingAmt * multiplier;
}

// Event listeners for serving size buttons
oneTimeButton.addEventListener('click', function() {
    resetAmounts();
    setActiveButton(oneTimeButton);
});

twoTimeButton.addEventListener('click', function() {
    updateAmounts(2);
    setActiveButton(twoTimeButton);
});

halfButton.addEventListener('click', function() {
    updateAmounts(0.5);
    setActiveButton(halfButton);
});

threeTimeButton.addEventListener('click', function() {
    updateAmounts(3);
    setActiveButton(threeTimeButton);
});

/**
 * Applies the "selected" class state to the clicked serving size button.
 * Removes the state from all other buttons.
 * @param {HTMLElement} activeButton - The serving amount button that was clicked.
 */
function setActiveButton(activeButton) {
    [oneTimeButton, twoTimeButton, threeTimeButton, halfButton].forEach(btn => {
        btn.id = ""; // Remove 'selected' from all buttons
    });
    activeButton.id = "selected"; // Set the clicked button as active
}

/**
 * Converts a numerical string (example: 1 1/2, 3/4, 2) to a decimal number
 * 
 * @param {string} fraction 
 * @returns {number} - The decimal value of the fraction
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
    return parseFloat(fraction); 
}

/**
 * Converts a decimal number to a simplified mixed fraction string.
 * @param {number} decimal - The decimal value to convert.
 * @returns {string} - A string representing a mixed fraction (e.g., "1 1/2").
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


/**
 * Opens browser dialog to print recipe
 */
function printRecipe() {
    window.print();
}

