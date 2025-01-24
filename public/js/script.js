// FLASH MESSAGES DISMISS ______________________________________________________________
// document.addEventListener('turbo:load', function() {
  let flashMessage = document.querySelector('.flash');

  if (flashMessage) {
    // Wait 2 seconds before fading out
    setTimeout(() => {
      flashMessage.style.transition = 'opacity 1s';
      flashMessage.style.opacity = '0';
      // After that, wait 100 miliseconds before removing element
      setTimeout(() => {
        flashMessage.style.display = 'none';
      }, 100);

    }, 3000);
  }
// });