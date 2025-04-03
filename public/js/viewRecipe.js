"use strict";

/**     VIEW RECIPE VARIABLES */
const addToCookbookButton = document.querySelector('#recipeDisplayAddToCookbook');
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

function resetAmounts() {
    ingredientAmounts.forEach(item => {
        item.innerHTML = item.getAttribute("data-original");
    });

    // Reset serving amount
    servingAmtElement.textContent = originalServingAmt;
}

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

// Event listeners
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

// Function to update active button state
function setActiveButton(activeButton) {
    [oneTimeButton, twoTimeButton, threeTimeButton, halfButton].forEach(btn => {
        btn.id = ""; // Remove 'selected' from all buttons
    });
    activeButton.id = "selected"; // Set the clicked button as active
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


/**
 * Function to print the recipe
 */
function printRecipe() {
    window.print();
}

