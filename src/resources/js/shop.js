$(document).ready(function() {

    var selected = sessionStorage.getItem('selected');

    if (selected) {
        $('#selectSort').val(selected);
    }

    $('#selectSort').on('change', function() {
        sessionStorage.setItem('selected', $('#selectSort').val());
        location.href = url + 'sortby=' + $('#selectSort').val();
    });
    $('#selectSortCat').on('change', function() {
        var id = $(this).children(":selected").attr("id");
        $('#optionList' + id).removeClass('d-none');
        sessionStorage.setItem('selected', 'relevant');
        sessionStorage.setItem('selectedSubCat', '');
        sessionStorage.setItem('selectedSortCat', $('#selectSortCat').val());
        sessionStorage.setItem('range', '100-20000');
        location.href = '/items/search?category=' + $('#selectSortCat').val();

    });



    $("#price-btn").click(function(e) {
        e.preventDefault();
        var value = $("#amount").val();
        var urlParams = new URLSearchParams(url);
        var slugUrl = urlParams.get('amount');
        url = url.replace('&amount=' + slugUrl, '');

        location.href = url + 'amount=' + value;

    });

    //---------------------------------
    // Subcategory parameter from url
    //---------------------------------
    var urlParams = new URLSearchParams(window.location.search);
    var slugUrl = urlParams.get('sub');
    var slugUrlMain = urlParams.get('category');
    var sortBy = urlParams.get('sortby');

    //---------------------------------
    // ARRAY FUNCTION
    //---------------------------------
    function range(start, end) {
        var myArray = [];
        for (var i = start; i <= end; i += 1) {
            myArray.push(i);
        }
        return myArray;
    };


    //---------------------------------
    // SUBCATEGORY LOOP
    //---------------------------------
    $.each(range(1, 1000), function(index, value) {
        var subCategoryId = sessionStorage.getItem('subCategorySlug');

        //---------------------------------
        // sets subcategory active
        //---------------------------------
        if (subCategoryId == value) {
            $('#subCategory' + value).addClass('active');
        }

        //---------------------------------
        // sets subcategory active by url
        //---------------------------------
        if ($('#subCategory' + value).hasClass(slugUrl)) {
            $('#subCategory' + value).addClass('active');
        }

        //---------------------------------
        // On subcategory click
        //---------------------------------
        $('#subCategory' + value).on('click', function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/subcategory/" + value,
                method: 'GET',
                success: function(data) {

                    sessionStorage.setItem('range', '100-20000');
                    sessionStorage.setItem('selected', 'relevant');
                    sessionStorage.setItem('subCategorySlug', data.subCategory.id);

                    $.each(id, function(index, categoryValue) {

                        if (data.subCategory.category_id == categoryValue.id) {
                            window.open("/items/search?category=" + categoryValue.slug + "&sub=" + data.subCategory.slug, "_self");
                        }

                    });

                }
            });

        });
    });


    //---------------------------------------------
    // stores sortby and category in session
    //---------------------------------------------

    if (catslug != '') {
        sessionStorage.setItem('selectedSortCat', catslug);
    }

    //---------------------------------
    // filters by category
    //---------------------------------

    $.each(id, function(index, value) {

        //---------------------------------
        // if category is selected
        //---------------------------------
        if (catslug == value.slug) {
            $('#category' + value.id).css("color", "black");
            $('#subList' + value.id).toggleClass('d-none');
            $('#selectSortSubCat' + value.id).removeClass('d-none');
            $('#selectSortSubCat' + value.id).val(slugUrl);
        }

        //---------------------------------
        // on category click
        //---------------------------------
        $('#category' + value.id).on('click', function() {
            sessionStorage.setItem('range', '100-20000');
            sessionStorage.setItem('selected', 'relevant');
            sessionStorage.setItem('subCategorySlug', '');
            sessionStorage.setItem('selectedSubCat', '');
            window.open("/items/search?category=" + value.slug, "_self");

        });
    });


    //---------------------------------
    // sets sortby to relevant on null
    //---------------------------------
    if (sortBy == null) {
        $('#selectSort').val('relevant');
    }

    //---------------------------------
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
    }

    //---------------------------------------
    // sub category filter (small-screens)
    //---------------------------------------
    $.each(range(1, 1000), function(index, value) {

        $('#selectSortSubCat' + value).on('change', function() {
            sessionStorage.setItem('selectedSubCat', $('#selectSortSubCat' + value).val());
            sessionStorage.setItem('range', '100-20000');
            location.href = '/items/search?category=' + selectedCat + '&sub=' + $('#selectSortSubCat' + value).val();

        });
    });

});