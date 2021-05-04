function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/**
 * Cartzilla | Bootstrap E-Commerce Template
 * Copyright 2021 Createx Studio
 * Theme core scripts
 * 
 * @author Createx Studio
 * @version 2.0.0
 */
(function () {
  'use strict';
  /**
   * Enable sticky behaviour of navigation bar on page scroll
  */

  var stickyNavbar = function () {
    var navbar = document.querySelector('.navbar-sticky');
    if (navbar == null) return;
    var navbarClass = navbar.classList,
        navbarH = navbar.offsetHeight,
        scrollOffset = 500;
    window.addEventListener('scroll', function (e) {
      if (e.currentTarget.pageYOffset > scrollOffset) {
        document.body.style.paddingTop = navbarH + 'px';
        navbar.classList.add('navbar-stuck');
      } else {
        document.body.style.paddingTop = '';
        navbar.classList.remove('navbar-stuck');
      }
    });
  }();
  /**
   * Menu toggle for 3 level navbar stuck state
  */


  var stuckNavbarMenuToggle = function () {
    var toggler = document.querySelector('.navbar-stuck-toggler'),
        stuckMenu = document.querySelector('.navbar-stuck-menu');
    if (toggler == null) return;
    toggler.addEventListener('click', function (e) {
      stuckMenu.classList.toggle('show');
      e.preventDefault();
    });
  }();
  /**
   * Cascading (Masonry) grid layout
   * 
   * @requires https://github.com/desandro/imagesloaded
   * @requires https://github.com/Vestride/Shuffle
  */


  var masonryGrid = function () {
    var grid = document.querySelectorAll('.masonry-grid'),
        masonry;
    if (grid === null) return;

    for (var i = 0; i < grid.length; i++) {
      masonry = new Shuffle(grid[i], {
        itemSelector: '.masonry-grid-item',
        sizer: '.masonry-grid-item'
      });
      imagesLoaded(grid[i]).on('progress', function () {
        masonry.layout();
      });
    }
  }();
  /**
   * Toggling password visibility in password input
  */


  var passwordVisibilityToggle = function () {
    var elements = document.querySelectorAll('.password-toggle');

    var _loop = function _loop(i) {
      var passInput = elements[i].querySelector('.form-control'),
          passToggle = elements[i].querySelector('.password-toggle-btn');
      passToggle.addEventListener('click', function (e) {
        if (e.target.type !== 'checkbox') return;

        if (e.target.checked) {
          passInput.type = 'text';
        } else {
          passInput.type = 'password';
        }
      }, false);
    };

    for (var i = 0; i < elements.length; i++) {
      _loop(i);
    }
  }();
  /**
   * Custom file drag and drop area
  */


  var fileDropArea = function () {
    var fileArea = document.querySelectorAll('.file-drop-area');

    var _loop2 = function _loop2(i) {
      var input = fileArea[i].querySelector('.file-drop-input'),
          message = fileArea[i].querySelector('.file-drop-message'),
          icon = fileArea[i].querySelector('.file-drop-icon'),
          button = fileArea[i].querySelector('.file-drop-btn');
      button.addEventListener('click', function () {
        input.click();
      });
      input.addEventListener('change', function () {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            var fileData = e.target.result;
            var fileName = input.files[0].name;
            message.innerHTML = fileName;

            if (fileData.startsWith('data:image')) {
              var image = new Image();
              image.src = fileData;

              image.onload = function () {
                icon.className = 'file-drop-preview img-thumbnail rounded';
                icon.innerHTML = '<img src="' + image.src + '" alt="' + fileName + '">';
              };
            } else if (fileData.startsWith('data:video')) {
              icon.innerHTML = '';
              icon.className = '';
              icon.className = 'file-drop-icon fas fa-video';
            } else {
              icon.innerHTML = '';
              icon.className = '';
              icon.className = 'file-drop-icon far fa-file';
            }
          };

          reader.readAsDataURL(input.files[0]);
        }
      });
    };

    for (var i = 0; i < fileArea.length; i++) {
      _loop2(i);
    }
  }();
  /**
   * Form validation
  */


  var formValidation = function () {
    var selector = 'needs-validation';
    window.addEventListener('load', function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName(selector); // Loop over them and prevent submission

      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (e) {
          if (form.checkValidity() === false) {
            e.preventDefault();
            e.stopPropagation();
          }

          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  }();
  /**
   * Anchor smooth scrolling
   * @requires https://github.com/cferdinandi/smooth-scroll/
  */


  var smoothScroll = function () {
    var selector = '[data-scroll]',
        fixedHeader = '[data-scroll-header]',
        scroll = new SmoothScroll(selector, {
      speed: 800,
      speedAsDuration: true,
      offset: 40,
      header: fixedHeader,
      updateURL: false
    });
  }();
  /**
   * Off-canvas toggler
  */


  var offcanvas = function () {
    var offcanvasTogglers = document.querySelectorAll('[data-bs-toggle="offcanvas"]'),
        offcanvasDismissers = document.querySelectorAll('[data-bs-dismiss="offcanvas"]'),
        offcanvas = document.querySelectorAll('.offcanvas'),
        docBody = document.body,
        fixedElements = document.querySelectorAll('[data-fixed-element]'),
        hasScrollbar = window.innerWidth > docBody.clientWidth; // Creating backdrop

    var backdrop = document.createElement('div');
    backdrop.classList.add('offcanvas-backdrop'); // Open off-canvas function

    var offcanvasOpen = function offcanvasOpen(offcanvasID, toggler) {
      docBody.appendChild(backdrop);
      setTimeout(function () {
        backdrop.classList.add('show');
      }, 20);
      document.querySelector(offcanvasID).classList.add('show');

      if (hasScrollbar) {
        docBody.style.paddingRight = '15px';

        if (fixedElements.length) {
          for (var i = 0; i < fixedElements.length; i++) {
            fixedElements[i].classList.add('right-15');
          }
        }
      }

      docBody.classList.add('offcanvas-open');
    }; // Close off-canvas function


    var offcanvasClose = function offcanvasClose() {
      for (var i = 0; i < offcanvas.length; i++) {
        offcanvas[i].classList.remove('show');
      }

      backdrop.classList.remove('show');
      setTimeout(function () {
        docBody.removeChild(backdrop);
      }, 50);

      if (hasScrollbar) {
        docBody.style.paddingRight = 0;

        if (fixedElements.length) {
          for (var _i = 0; _i < fixedElements.length; _i++) {
            fixedElements[_i].classList.remove('right-15');
          }
        }
      }

      docBody.classList.remove('offcanvas-open');
    }; // Open off-canvas event handler


    for (var i = 0; i < offcanvasTogglers.length; i++) {
      offcanvasTogglers[i].addEventListener('click', function (e) {
        e.preventDefault();
        offcanvasOpen(e.currentTarget.dataset.bsTarget, e.currentTarget);
      });
    } // Close off-canvas event handler


    for (var _i2 = 0; _i2 < offcanvasDismissers.length; _i2++) {
      offcanvasDismissers[_i2].addEventListener('click', function (e) {
        e.preventDefault();
        offcanvasClose();
      });
    } // Close off-canvas by clicking on backdrop


    document.addEventListener('click', function (e) {
      if (e.target.classList[0] === 'offcanvas-backdrop') {
        offcanvasClose();
      }
    });
  }();
  /**
   * Animate scroll to top button in/off view
  */


  var scrollTopButton = function () {
    var element = document.querySelector('.btn-scroll-top'),
        scrollOffset = 600;
    if (element == null) return;
    var offsetFromTop = parseInt(scrollOffset, 10);
    window.addEventListener('scroll', function (e) {
      if (e.currentTarget.pageYOffset > offsetFromTop) {
        element.classList.add('show');
      } else {
        element.classList.remove('show');
      }
    });
  }();
  /**
   * Tooltip
   * @requires https://getbootstrap.com
   * @requires https://popper.js.org/
  */


  var tooltip = function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl, {
        trigger: 'hover'
      });
    });
  }();
  /**
   * Popover
   * @requires https://getbootstrap.com
   * @requires https://popper.js.org/
  */


  var popover = function () {
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl);
    });
  }();
  /**
   * Toast
   * @requires https://getbootstrap.com
  */


  var toast = function () {
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function (toastEl) {
      return new bootstrap.Toast(toastEl);
    });
  }();
  /**
   * Disable dropdown autohide when select is clicked
  */


  var disableDropdownAutohide = function () {
    var elements = document.querySelectorAll('.disable-autohide .form-select');

    for (var i = 0; i < elements.length; i++) {
      elements[i].addEventListener('click', function (e) {
        e.stopPropagation();
      });
    }
  }();
  /**
   * Content carousel with extensive options to control behaviour and appearance
   * @requires https://github.com/ganlanyuan/tiny-slider
  */


  var carousel = function () {
    // forEach function
    var forEach = function forEach(array, callback, scope) {
      for (var i = 0; i < array.length; i++) {
        callback.call(scope, i, array[i]); // passes back stuff we need
      }
    }; // Carousel initialisation


    var carousels = document.querySelectorAll('.tns-carousel .tns-carousel-inner');
    forEach(carousels, function (index, value) {
      var defaults = {
        container: value,
        controlsText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
        navPosition: 'bottom',
        mouseDrag: true,
        speed: 500,
        autoplayHoverPause: true,
        autoplayButtonOutput: false
      };
      var userOptions;
      if (value.dataset.carouselOptions != undefined) userOptions = JSON.parse(value.dataset.carouselOptions);
      var options = Object.assign({}, defaults, userOptions);
      var carousel = tns(options);
    });
  }();
  /**
   * Lightbox component for presenting various types of media
   * @requires https://github.com/sachinchoolur/lightgallery.js
  */


  var gallery = function () {
    var gallery = document.querySelectorAll('.gallery');

    if (gallery.length) {
      for (var i = 0; i < gallery.length; i++) {
        lightGallery(gallery[i], {
          selector: '.gallery-item',
          download: false,
          videojs: true,
          youtubePlayerParams: {
            modestbranding: 1,
            showinfo: 0,
            rel: 0
          },
          vimeoPlayerParams: {
            byline: 0,
            portrait: 0,
            color: 'fe696a'
          }
        });
      }
    }
  }();
  /**
   * Shop product page gallery with thumbnails
   * @requires https://github.com/sachinchoolur/lightgallery.js
  */


  var productGallery = function () {
    var gallery = document.querySelectorAll('.product-gallery');

    if (gallery.length) {
      var _loop3 = function _loop3(i) {
        var thumbnails = gallery[i].querySelectorAll('.product-gallery-thumblist-item:not(.video-item)'),
            previews = gallery[i].querySelectorAll('.product-gallery-preview-item'),
            videos = gallery[i].querySelectorAll('.product-gallery-thumblist-item.video-item');

        for (var n = 0; n < thumbnails.length; n++) {
          thumbnails[n].addEventListener('click', changePreview);
        } // Changer preview function


        function changePreview(e) {
          e.preventDefault();

          for (var _i3 = 0; _i3 < thumbnails.length; _i3++) {
            previews[_i3].classList.remove('active');

            thumbnails[_i3].classList.remove('active');
          }

          this.classList.add('active');
          gallery[i].querySelector(this.getAttribute('href')).classList.add('active');
        } // Video thumbnail - open video in lightbox


        for (var m = 0; m < videos.length; m++) {
          lightGallery(videos[m], {
            selector: 'this',
            download: false,
            videojs: true,
            youtubePlayerParams: {
              modestbranding: 1,
              showinfo: 0,
              rel: 0,
              controls: 0
            },
            vimeoPlayerParams: {
              byline: 0,
              portrait: 0,
              color: 'fe696a'
            }
          });
        }
      };

      for (var i = 0; i < gallery.length; i++) {
        _loop3(i);
      }
    }
  }();
  /**
   * Image zoom on hover (used inside Product Gallery)
   * @requires https://github.com/imgix/drift
  */


  var imageZoom = function () {
    var images = document.querySelectorAll('.image-zoom');

    for (var i = 0; i < images.length; i++) {
      new Drift(images[i], {
        paneContainer: images[i].parentElement.querySelector('.image-zoom-pane')
      });
    }
  }();
  /**
   * Countdown timer
  */


  var countdown = function () {
    var coundown = document.querySelectorAll('.countdown');
    if (coundown == null) return;

    var _loop4 = function _loop4(i) {
      var endDate = coundown[i].dataset.countdown,
          daysVal = coundown[i].querySelector('.countdown-days .countdown-value'),
          hoursVal = coundown[i].querySelector('.countdown-hours .countdown-value'),
          minutesVal = coundown[i].querySelector('.countdown-minutes .countdown-value'),
          secondsVal = coundown[i].querySelector('.countdown-seconds .countdown-value'),
          days = void 0,
          hours = void 0,
          minutes = void 0,
          seconds = void 0;
      endDate = new Date(endDate).getTime();
      if (isNaN(endDate)) return {
        v: void 0
      };
      setInterval(calculate, 1000);

      function calculate() {
        var startDate = new Date().getTime();
        var timeRemaining = parseInt((endDate - startDate) / 1000);

        if (timeRemaining >= 0) {
          days = parseInt(timeRemaining / 86400);
          timeRemaining = timeRemaining % 86400;
          hours = parseInt(timeRemaining / 3600);
          timeRemaining = timeRemaining % 3600;
          minutes = parseInt(timeRemaining / 60);
          timeRemaining = timeRemaining % 60;
          seconds = parseInt(timeRemaining);

          if (daysVal != null) {
            daysVal.innerHTML = parseInt(days, 10);
          }

          if (hoursVal != null) {
            hoursVal.innerHTML = hours < 10 ? '0' + hours : hours;
          }

          if (minutesVal != null) {
            minutesVal.innerHTML = minutes < 10 ? '0' + minutes : minutes;
          }

          if (secondsVal != null) {
            secondsVal.innerHTML = seconds < 10 ? '0' + seconds : seconds;
          }
        } else {
          return;
        }
      }
    };

    for (var i = 0; i < coundown.length; i++) {
      var _ret = _loop4(i);

      if (_typeof(_ret) === "object") return _ret.v;
    }
  }();
  /**
   * Charts
   * @requires https://github.com/gionkunz/chartist-js
  */


  var charts = function () {
    var lineChart = document.querySelectorAll('[data-line-chart]'),
        barChart = document.querySelectorAll('[data-bar-chart]'),
        pieChart = document.querySelectorAll('[data-pie-chart]');

    var sum = function sum(a, b) {
      return a + b;
    };

    if (lineChart.length === 0 && barChart.length === 0 && pieChart.length === 0) return; // Create <style> tag and put it to <head> for changing colors of charts via data attributes

    var head = document.head || document.getElementsByTagName('head')[0],
        style = document.createElement('style'),
        css;
    head.appendChild(style); // Line chart

    for (var i = 0; i < lineChart.length; i++) {
      var data = JSON.parse(lineChart[i].dataset.lineChart),
          options = lineChart[i].dataset.options != undefined ? JSON.parse(lineChart[i].dataset.options) : '',
          seriesColor = lineChart[i].dataset.seriesColor,
          userColors = void 0;
      lineChart[i].classList.add('line-chart-' + i);

      if (seriesColor != undefined) {
        userColors = JSON.parse(seriesColor);

        for (var n = 0; n < userColors.colors.length; n++) {
          css = "\n          .line-chart-".concat(i, " .ct-series:nth-child(").concat(n + 1, ") .ct-line,\n          .line-chart-").concat(i, " .ct-series:nth-child(").concat(n + 1, ") .ct-point {\n            stroke: ").concat(userColors.colors[n], " !important;\n          }\n        ");
          style.appendChild(document.createTextNode(css));
        }
      }

      new Chartist.Line(lineChart[i], data, options);
    } // Bar chart


    for (var _i4 = 0; _i4 < barChart.length; _i4++) {
      var _data = JSON.parse(barChart[_i4].dataset.barChart),
          _options = barChart[_i4].dataset.options != undefined ? JSON.parse(barChart[_i4].dataset.options) : '',
          _seriesColor = barChart[_i4].dataset.seriesColor,
          _userColors = void 0;

      barChart[_i4].classList.add('bar-chart-' + _i4);

      if (_seriesColor != undefined) {
        _userColors = JSON.parse(_seriesColor);

        for (var _n = 0; _n < _userColors.colors.length; _n++) {
          css = "\n        .bar-chart-".concat(_i4, " .ct-series:nth-child(").concat(_n + 1, ") .ct-bar {\n            stroke: ").concat(_userColors.colors[_n], " !important;\n          }\n        ");
          style.appendChild(document.createTextNode(css));
        }
      }

      new Chartist.Bar(barChart[_i4], _data, _options);
    } // Pie chart


    var _loop5 = function _loop5(_i5) {
      var data = JSON.parse(pieChart[_i5].dataset.pieChart),
          seriesColor = pieChart[_i5].dataset.seriesColor,
          userColors = void 0;

      pieChart[_i5].classList.add('cz-pie-chart-' + _i5);

      if (seriesColor != undefined) {
        userColors = JSON.parse(seriesColor);

        for (var _n2 = 0; _n2 < userColors.colors.length; _n2++) {
          css = "\n        .cz-pie-chart-".concat(_i5, " .ct-series:nth-child(").concat(_n2 + 1, ") .ct-slice-pie {\n            fill: ").concat(userColors.colors[_n2], " !important;\n          }\n        ");
          style.appendChild(document.createTextNode(css));
        }
      }

      new Chartist.Pie(pieChart[_i5], data, {
        labelInterpolationFnc: function labelInterpolationFnc(value) {
          return Math.round(value / data.series.reduce(sum) * 100) + '%';
        }
      });
    };

    for (var _i5 = 0; _i5 < pieChart.length; _i5++) {
      _loop5(_i5);
    }
  }();
  /**
   * Open YouTube / Vimeo video in lightbox
   * @requires @requires https://github.com/sachinchoolur/lightgallery.js
  */


  var videoButton = function () {
    var button = document.querySelectorAll('[data-bs-toggle="video"]');

    if (button.length) {
      for (var i = 0; i < button.length; i++) {
        lightGallery(button[i], {
          selector: 'this',
          download: false,
          videojs: true,
          youtubePlayerParams: {
            modestbranding: 1,
            showinfo: 0,
            rel: 0
          },
          vimeoPlayerParams: {
            byline: 0,
            portrait: 0,
            color: 'fe696a'
          }
        });
      }
    }
  }();
  /**
   * Ajaxify MailChimp subscription form
  */


  var subscriptionForm = function () {
    var form = document.querySelectorAll('.subscription-form');
    if (form === null) return;

    var _loop6 = function _loop6(i) {
      var button = form[i].querySelector('button[type="submit"]'),
          buttonText = button.innerHTML,
          input = form[i].querySelector('.form-control'),
          antispam = form[i].querySelector('.subscription-form-antispam'),
          status = form[i].querySelector('.subscription-status');
      form[i].addEventListener('submit', function (e) {
        if (e) e.preventDefault();
        if (antispam.value !== '') return;
        register(this, button, input, buttonText, status);
      });
    };

    for (var i = 0; i < form.length; i++) {
      _loop6(i);
    }

    var register = function register(form, button, input, buttonText, status) {
      button.innerHTML = 'Sending...'; // Get url for MailChimp

      var url = form.action.replace('/post?', '/post-json?'); // Add form data to object

      var data = '&' + input.name + '=' + encodeURIComponent(input.value); // Create and add post script to the DOM

      var script = document.createElement('script');
      script.src = url + '&c=callback' + data;
      document.body.appendChild(script); // Callback function

      var callback = 'callback';

      window[callback] = function (response) {
        // Remove post script from the DOM
        delete window[callback];
        document.body.removeChild(script); // Change button text back to initial

        button.innerHTML = buttonText; // Display content and apply styling to response message conditionally

        if (response.result == 'success') {
          input.classList.remove('is-invalid');
          input.classList.add('is-valid');
          status.classList.remove('status-error');
          status.classList.add('status-success');
          status.innerHTML = response.msg;
          setTimeout(function () {
            input.classList.remove('is-valid');
            status.innerHTML = '';
            status.classList.remove('status-success');
          }, 6000);
        } else {
          input.classList.remove('is-valid');
          input.classList.add('is-invalid');
          status.classList.remove('status-success');
          status.classList.add('status-error');
          status.innerHTML = response.msg.substring(4);
          setTimeout(function () {
            input.classList.remove('is-invalid');
            status.innerHTML = '';
            status.classList.remove('status-error');
          }, 6000);
        }
      };
    };
  }();
  /**
   * Range slider
   * @requires https://github.com/leongersen/noUiSlider
  */


  var rangeSlider = function () {
    var rangeSliderWidget = document.querySelectorAll('.range-slider');

    var _loop7 = function _loop7(i) {
      var rangeSlider = rangeSliderWidget[i].querySelector('.range-slider-ui'),
          valueMinInput = rangeSliderWidget[i].querySelector('.range-slider-value-min'),
          valueMaxInput = rangeSliderWidget[i].querySelector('.range-slider-value-max');
      var options = {
        dataStartMin: parseInt(rangeSliderWidget[i].dataset.startMin, 10),
        dataStartMax: parseInt(rangeSliderWidget[i].dataset.startMax, 10),
        dataMin: parseInt(rangeSliderWidget[i].dataset.min, 10),
        dataMax: parseInt(rangeSliderWidget[i].dataset.max, 10),
        dataStep: parseInt(rangeSliderWidget[i].dataset.step, 10)
      };
      noUiSlider.create(rangeSlider, {
        start: [options.dataStartMin, options.dataStartMax],
        connect: true,
        step: options.dataStep,
        pips: {
          mode: 'count',
          values: 5
        },
        tooltips: true,
        range: {
          'min': options.dataMin,
          'max': options.dataMax
        },
        format: {
          to: function to(value) {
            return '$' + parseInt(value, 10);
          },
          from: function from(value) {
            return Number(value);
          }
        }
      });
      rangeSlider.noUiSlider.on('update', function (values, handle) {
        var value = values[handle];
        value = value.replace(/\D/g, '');

        if (handle) {
          valueMaxInput.value = Math.round(value);
        } else {
          valueMinInput.value = Math.round(value);
        }
      });
      valueMinInput.addEventListener('change', function () {
        rangeSlider.noUiSlider.set([this.value, null]);
      });
      valueMaxInput.addEventListener('change', function () {
        rangeSlider.noUiSlider.set([null, this.value]);
      });
    };

    for (var i = 0; i < rangeSliderWidget.length; i++) {
      _loop7(i);
    }
  }();
  /**
   * Data filtering (Comparison table)
  */


  var dataFilter = function () {
    var trigger = document.querySelector('[data-filter-trigger]'),
        target = document.querySelectorAll('[data-filter-target]');
    if (trigger === null) return;
    trigger.addEventListener('change', function () {
      var selected = this.options[this.selectedIndex].value.toLowerCase();

      if (selected === 'all') {
        for (var i = 0; i < target.length; i++) {
          target[i].classList.remove('d-none');
        }
      } else {
        for (var n = 0; n < target.length; n++) {
          target[n].classList.add('d-none');
        }

        document.querySelector('#' + selected).classList.remove('d-none');
      }
    });
  }();
  /**
   * Updated the text of the label when radio button changes (mainly for color options)
  */


  var labelUpdate = function () {
    var radioBtns = document.querySelectorAll('[data-bs-label]');

    for (var i = 0; i < radioBtns.length; i++) {
      radioBtns[i].addEventListener('change', function () {
        var target = this.dataset.bsLabel;

        try {
          document.getElementById(target).textContent = this.value;
        } catch (err) {
          if (err.message = "Cannot set property 'textContent' of null") {
            console.error('Make sure the [data-label] matches with the id of the target element you want to change text of!');
          }
        }
      });
    }
  }();
  /**
   * Change tabs with radio buttons
  */


  var radioTab = function () {
    var radioBtns = document.querySelectorAll('[data-bs-toggle="radioTab"]');

    for (var i = 0; i < radioBtns.length; i++) {
      radioBtns[i].addEventListener('click', function () {
        var target = this.dataset.bsTarget,
            parent = document.querySelector(this.dataset.bsParent),
            children = parent.querySelectorAll('.radio-tab-pane');
        children.forEach(function (element) {
          element.classList.remove('active');
        });
        document.querySelector(target).classList.add('active');
      });
    }
  }();
  /**
   * Change tabs with radio buttons
  */


  var creditCard = function () {
    var selector = document.querySelector('.credit-card-form');
    if (selector === null) return;
    var card = new Card({
      form: selector,
      container: '.credit-card-wrapper'
    });
  }();
  /**
   * Master checkbox that checkes / unchecks all target checkboxes at once
  */


  var masterCheckbox = function () {
    var masterCheckbox = document.querySelectorAll('[data-master-checkbox-for]');
    if (masterCheckbox.length === 0) return;

    for (var i = 0; i < masterCheckbox.length; i++) {
      masterCheckbox[i].addEventListener('change', function () {
        var targetWrapper = document.querySelector(this.dataset.masterCheckboxFor),
            targetCheckboxes = targetWrapper.querySelectorAll('input[type="checkbox"]');

        if (this.checked) {
          for (var n = 0; n < targetCheckboxes.length; n++) {
            targetCheckboxes[n].checked = true;

            if (targetCheckboxes[n].dataset.checkboxToggleClass) {
              document.querySelector(targetCheckboxes[n].dataset.target).classList.add(targetCheckboxes[n].dataset.checkboxToggleClass);
            }
          }
        } else {
          for (var m = 0; m < targetCheckboxes.length; m++) {
            targetCheckboxes[m].checked = false;

            if (targetCheckboxes[m].dataset.checkboxToggleClass) {
              document.querySelector(targetCheckboxes[m].dataset.target).classList.remove(targetCheckboxes[m].dataset.checkboxToggleClass);
            }
          }
        }
      });
    }
  }();
})();