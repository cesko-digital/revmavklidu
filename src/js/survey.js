document.addEventListener("DOMContentLoaded", function () {
  // Get all steps
  const steps = Array.from(document.querySelectorAll(".step"));

  // Add event listener to each 'next' button
  const nextButtons = Array.from(
    document.querySelectorAll(".next .elementor-button-text")
  );

  const prevButtons = Array.from(
    document.querySelectorAll(".back .elementor-button-text")
  );
  prevButtons.forEach((prevButton, index) => {
    prevButton.addEventListener("click", function () {
      // Back button is not on first step
      const activeStep = steps[index + 1];

      if (!activeStep) {
        return;
      }

      activeStep.classList.remove("active");
      activeStep.style.display = "none";
      const nextStepIndex = index;

      if (steps[nextStepIndex]) {
        steps[nextStepIndex].classList.add("active");
        steps[nextStepIndex].style.display = "block";
      }
    });
  });

  nextButtons.forEach((nextButton, index) => {
    nextButton.addEventListener("click", function () {
      // Find the current active step
      const activeStep = steps[index];

      // If there is no active step, do nothing
      if (!activeStep) {
        return;
      }

      // Hide the current active step
      activeStep.classList.remove("active");
      activeStep.style.display = "none";

      // Get the index of the next step
      const nextStepIndex = index + 1;

      // If there is a next step, show it
      if (steps[nextStepIndex]) {
        steps[nextStepIndex].classList.add("active");
        steps[nextStepIndex].style.display = "block";
      }
    });
  });

  setTimeout(function () {
    disableAllNextButtons();
    checkRadios();
  }, 1000);

  let radioButtons = document.querySelectorAll('input[type="radio"]');
  radioButtons.forEach(function (radioButton) {
    radioButton.addEventListener("change", checkRadios);
  });

  function disableAllNextButtons() {
    let nextButtons = document.querySelectorAll(
      ".e-form__buttons__wrapper__button-next"
    );
    nextButtons.forEach(function (button) {
      console.log(button);
      button.classList.add("disabled");
    });
  }

  function checkRadios() {
    let radioContainers = document.querySelectorAll(
      ".elementor-field-type-radio"
    );

    radioContainers.forEach(function (container) {
      let stepContainer = container.closest(".elementor-field-type-step");

      const nextButton = container.nextElementSibling.querySelector(
        "button.e-form__buttons__wrapper__button-next"
      );

      // Make sure stepContainer is not null before calling querySelector
      if (nextButton) {
        if (container.querySelector('input[type="radio"]:checked')) {
          nextButton.classList.remove("disabled");
        } else {
          nextButton.classList.add("disabled");
        }
      }
    });
  }
});
