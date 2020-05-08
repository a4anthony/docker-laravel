/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/shop.js":
/*!******************************!*\
  !*** ./resources/js/shop.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var selected = sessionStorage.getItem('selected');

  if (selected) {
    $('#selectSort').val(selected);
  }

  $('#selectSort').on('change', function () {
    sessionStorage.setItem('selected', $('#selectSort').val());
    location.href = url + 'sortby=' + $('#selectSort').val();
  });
  $('#selectSortCat').on('change', function () {
    var id = $(this).children(":selected").attr("id");
    $('#optionList' + id).removeClass('d-none');
    sessionStorage.setItem('selected', 'relevant');
    sessionStorage.setItem('selectedSubCat', '');
    sessionStorage.setItem('selectedSortCat', $('#selectSortCat').val());
    sessionStorage.setItem('range', '100-20000');
    location.href = '/items/search?category=' + $('#selectSortCat').val();
  });
  $("#price-btn").click(function (e) {
    e.preventDefault();
    var value = $("#amount").val();
    var urlParams = new URLSearchParams(url);
    var slugUrl = urlParams.get('amount');
    url = url.replace('&amount=' + slugUrl, '');
    location.href = url + 'amount=' + value;
  }); //---------------------------------
  // Subcategory parameter from url
  //---------------------------------

  var urlParams = new URLSearchParams(window.location.search);
  var slugUrl = urlParams.get('sub');
  var slugUrlMain = urlParams.get('category');
  var sortBy = urlParams.get('sortby'); //---------------------------------
  // ARRAY FUNCTION
  //---------------------------------

  function range(start, end) {
    var myArray = [];

    for (var i = start; i <= end; i += 1) {
      myArray.push(i);
    }

    return myArray;
  }

  ; //---------------------------------
  // SUBCATEGORY LOOP
  //---------------------------------

  $.each(range(1, 1000), function (index, value) {
    var subCategoryId = sessionStorage.getItem('subCategorySlug'); //---------------------------------
    // sets subcategory active
    //---------------------------------

    if (subCategoryId == value) {
      $('#subCategory' + value).addClass('active');
    } //---------------------------------
    // sets subcategory active by url
    //---------------------------------


    if ($('#subCategory' + value).hasClass(slugUrl)) {
      $('#subCategory' + value).addClass('active');
    } //---------------------------------
    // On subcategory click
    //---------------------------------


    $('#subCategory' + value).on('click', function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: "/subcategory/" + value,
        method: 'GET',
        success: function success(data) {
          sessionStorage.setItem('range', '100-20000');
          sessionStorage.setItem('selected', 'relevant');
          sessionStorage.setItem('subCategorySlug', data.subCategory.id);
          $.each(id, function (index, categoryValue) {
            if (data.subCategory.category_id == categoryValue.id) {
              window.open("/items/search?category=" + categoryValue.slug + "&sub=" + data.subCategory.slug, "_self");
            }
          });
        }
      });
    });
  }); //---------------------------------------------
  // stores sortby and category in session
  //---------------------------------------------

  if (catslug != '') {
    sessionStorage.setItem('selectedSortCat', catslug);
  } //---------------------------------
  // filters by category
  //---------------------------------


  $.each(id, function (index, value) {
    //---------------------------------
    // if category is selected
    //---------------------------------
    if (catslug == value.slug) {
      $('#category' + value.id).css("color", "black");
      $('#subList' + value.id).toggleClass('d-none');
      $('#selectSortSubCat' + value.id).removeClass('d-none');
      $('#selectSortSubCat' + value.id).val(slugUrl);
    } //---------------------------------
    // on category click
    //---------------------------------


    $('#category' + value.id).on('click', function () {
      sessionStorage.setItem('range', '100-20000');
      sessionStorage.setItem('selected', 'relevant');
      sessionStorage.setItem('subCategorySlug', '');
      sessionStorage.setItem('selectedSubCat', '');
      window.open("/items/search?category=" + value.slug, "_self");
    });
  }); //---------------------------------
  // sets sortby to relevant on null
  //---------------------------------

  if (sortBy == null) {
    $('#selectSort').val('relevant');
  } //---------------------------------
  // sets selected (small-screens)
  //---------------------------------


  var selectedCat = sessionStorage.getItem('selectedSortCat');
  var selectedSubCat = sessionStorage.getItem('selectedSubCat');

  if (selectedCat != '') {
    $('#dummy-list').addClass('d-none');
  }

  if (selectedCat) {
    $('#selectSortCat').val(selectedCat);

    if (selectedCat == 'all') {
      $('#selectSortCat').val('');
    }
  } //---------------------------------------
  // sub category filter (small-screens)
  //---------------------------------------


  $.each(range(1, 1000), function (index, value) {
    $('#selectSortSubCat' + value).on('change', function () {
      sessionStorage.setItem('selectedSubCat', $('#selectSortSubCat' + value).val());
      sessionStorage.setItem('range', '100-20000');
      location.href = '/items/search?category=' + selectedCat + '&sub=' + $('#selectSortSubCat' + value).val();
    });
  });
});

/***/ }),

/***/ 3:
/*!************************************!*\
  !*** multi ./resources/js/shop.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/anthony/www/melamart/resources/js/shop.js */"./resources/js/shop.js");


/***/ })

/******/ });