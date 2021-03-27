/**
 * Off-canvas toggler
*/

const offcanvas = (() => {

  const offcanvasTogglers = document.querySelectorAll('[data-bs-toggle="offcanvas"]'),
        offcanvasDismissers = document.querySelectorAll('[data-bs-dismiss="offcanvas"]'),
        offcanvas = document.querySelectorAll('.offcanvas'),
        docBody = document.body,
        fixedElements = document.querySelectorAll('[data-fixed-element]'),
        hasScrollbar = window.innerWidth > docBody.clientWidth;
  
  // Creating backdrop
  const backdrop = document.createElement('div');
  backdrop.classList.add('offcanvas-backdrop');

  // Open off-canvas function
  const offcanvasOpen = (offcanvasID, toggler) => {
    docBody.appendChild(backdrop);
    setTimeout(() => {
      backdrop.classList.add('show');
    }, 20);
    document.querySelector(offcanvasID).classList.add('show');
    if (hasScrollbar) {
      docBody.style.paddingRight = '15px';
      if (fixedElements.length) {
        for (let i = 0; i < fixedElements.length; i++) {
          fixedElements[i].classList.add('right-15');
        }
      }
    }
    docBody.classList.add('offcanvas-open');
  };

  // Close off-canvas function
  const offcanvasClose = () => {
    for (let i = 0; i < offcanvas.length; i++) {
      offcanvas[i].classList.remove('show');
    }
    backdrop.classList.remove('show');
    setTimeout(() => {
      docBody.removeChild(backdrop);
    }, 50);
    if (hasScrollbar) {
      docBody.style.paddingRight = 0;
      if (fixedElements.length) {
        for (let i = 0; i < fixedElements.length; i++) {
          fixedElements[i].classList.remove('right-15');
        }
      }
    }
    docBody.classList.remove('offcanvas-open');
  }

  // Open off-canvas event handler
  for (let i = 0; i < offcanvasTogglers.length; i++) {
    offcanvasTogglers[i].addEventListener('click', (e) => {
      e.preventDefault();
      offcanvasOpen(e.currentTarget.dataset.bsTarget, e.currentTarget);
    });
  }

  // Close off-canvas event handler
  for (let i = 0; i < offcanvasDismissers.length; i++) {
    offcanvasDismissers[i].addEventListener('click', (e) => {
      e.preventDefault();
      offcanvasClose();
    });
  }

  // Close off-canvas by clicking on backdrop
  document.addEventListener('click', (e) => {
    if (e.target.classList[0] === 'offcanvas-backdrop') {
      offcanvasClose();
    }
  });
  
})();

export default offcanvas;
