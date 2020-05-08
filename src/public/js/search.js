$(document).ready(function() {
    $('.first-button').on('click', function() {
        $('.animated-icon1').toggleClass('open');
    });
    $('.second-button').on('click', function() {
        $('body').toggleClass('no-scroll');
        $('.animated-icon2').toggleClass('open');
        $('.overlay-bottom').css("top", (50 + $('.navbar-collapse').height()) + "px");
    });
    $('.third-button').on('click', function() {

        $('.animated-icon3').toggleClass('open');
    });


    $('#link1').on('click', function() {
        location.href = '/account';
    });
    $('#link2').on('click', function() {
        location.href = '/account/orders';
    });
    $('#link3').on('click', function() {
        location.href = '/account/wishlist';
    });
    $('#link4').on('click', function() {
        location.href = '/account/address-book';
    });
    $('#link5').on('click', function() {
        location.href = '/account/edit/details';
    });
    $('#link6').on('click', function() {
        location.href = '/account/update/password';
    });




    setInterval(function() {
        var navbar = $('.header-area').height();
        $('.navbar-collapse').css("top", navbar + "px");
        $('.navbar-collapse').css("left", ($('.animated-icon2').position().left) + "px");
    }, .0000000000000000000000000001);

    $(document).mouseup(function(e) {
        var container = $("#search, #searchdiv");

        // If the target of the click isn't the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('#searchdiv').addClass('d-none');
        }
    });

    $("#search").keyup(function() {
        var search = $(this).val();

        if (search != "") {
            var width = $('#search-btn').width();
            var width2 = $('.input-group-append').width();
            var width1 = $('#search').width();
            $('#searchdiv').css("width", (width1 + (width2 - width)) + "px");

            $.ajax({
                //url: "products/upload/subcategory?btn-submit_id=" + $(this).val(),
                url: "/autocomplete",
                method: 'POST',
                data: $('#searchform').serialize(),
                success: function(response) {
                    var len = response.length;
                    $("#searchdiv ul").empty();
                    $('#searchdiv').removeClass('d-none');

                    for (var i = 0; i < len; i++) {
                        var id = response[i]['id'];
                        var fname = response[i]['name'];
                        var category = response[i]['category'];
                        var image = response[i]['image'];
                        var url = response[i]['url'];

                        $("#searchdiv ul").append("<a href='/item/" + url + "'><li class='wrap-text' value='searchresult_" + id + "'><img style='width: 3rem;' src='" + imageUrl + image + "' class='img-fluid search-img'>" + fname + "</li></a><hr style='margin:0; padding:0;'>");


                    }
                }
            });
        } else {
            $('#searchdiv').addClass('d-none');
        }

    });
    $("#search").click(function() {
        var search = $(this).val();
        if (search != "") {
            $('#searchdiv').removeClass('d-none;')
        }

    });


    $("#search-btn").click(function(e) {
        e.preventDefault();
        sessionStorage.setItem('range', '100-20000');
        sessionStorage.setItem('selected', 'relevant');
        sessionStorage.setItem('selectedSortCat', '');
        sessionStorage.setItem('selectedSubCat', '');

        var value = $("#search").val();
        value = value.replace(/[^\w\s]/gi, "").trim();

        var i = 0,
            strLength = value.length;

        for (i; i < strLength; i++) {

            value = value.replace(" ", "+").trim();
            //    value = value.preg_replace( '/[^a-z0-9 ]/i', '');

        }

        $("#search").attr('name', '');
        //$("#searchform").attr('action', '/items/search/' + value);
        location.href = '/items/search?key=' + value;

        // $("#searchform").submit();
    });

    // Get the input field
    var input = document.getElementById("search");

    // Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            // Cancel the default action, if needed
            event.preventDefault();
            // Trigger the button element with a click
            $('#searchform').submit();
        }
    });

    $(document).mouseup(function(e) {
        var container = $("#search-sm, #searchdiv-sm");

        // If the target of the click isn't the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('#searchdiv-sm').addClass('d-none');
        }
    });

    $("#search-sm").keyup(function() {
        var search = $(this).val();

        if (search != "") {
            var width = $('#search-btn-sm').width();
            var width2 = $('#searchform-sm .input-group-append').width();
            var width1 = $('#search-sm').width();
            $('#searchdiv-sm').css("width", (width1 + (width2 - width)) + "px");

            $.ajax({
                //url: "products/upload/subcategory?btn-submit_id=" + $(this).val(),
                url: "/autocomplete",
                method: 'POST',
                data: $('#searchform-sm').serialize(),
                success: function(response) {
                    var len = response.length;
                    $("#searchdiv-sm ul").empty();
                    $('#searchdiv-sm').removeClass('d-none');
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['id'];
                        var fname = response[i]['name'];
                        var category = response[i]['category'];
                        var image = response[i]['image'];
                        var url = response[i]['url'];

                        $("#searchdiv-sm ul").append("<a href='/item/" + url + "'><li class='wrap-text' value='searchresult_" + id + "'><img style='width: 3rem;' src='" + imageUrl + image + "' class='img-fluid search-img'>" + fname + "</li></a><hr style='margin:0; padding:0;'>");


                    }
                }
            });
        } else {
            $('#searchdiv-sm').addClass('d-none');
        }

    });
    $("#search-sm").click(function() {
        var search = $(this).val();
        if (search != "") {
            $('#searchdiv-sm').removeClass('d-none;')
        }

    });


    $("#search-btn-sm").click(function(e) {
        e.preventDefault();
        sessionStorage.setItem('range', '100-20000');
        sessionStorage.setItem('selected', 'relevant');
        sessionStorage.setItem('selectedSortCat', '');
        sessionStorage.setItem('selectedSubCat', '');


        var value = $("#search-sm").val();
        value = value.replace(/[^\w\s]/gi, "").trim();

        var i = 0,
            strLength = value.length;

        for (i; i < strLength; i++) {

            value = value.replace(" ", "+").trim();
            //    value = value.preg_replace( '/[^a-z0-9 ]/i', '');

        }

        $("#search-sm").attr('name', '');
        //$("#searchform").attr('action', '/items/search/' + value);
        location.href = '/items/search?key=' + value;

    });
    // Get the input field
    var input = document.getElementById("search-sm");

    // Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            // Cancel the default action, if needed
            event.preventDefault();
            // Trigger the button element with a click
            $('#searchform-sm').submit();
        }
    });
});