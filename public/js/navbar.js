let documentWidth = window.innerWidth;
window.addEventListener("resize", function () {

    documentWidth = window.innerWidth;
    if (documentWidth > '880') {
        $('#navLinks').show();
        $('.searchBarContainer').hide();
        $('#openSearch').show();
        $('#closeSearch').hide();
        $('.searchBarContainer').css({
            width: '0'
        })
    } else {
        $('#navLinks').hide();
        $('.searchBarContainer').css({
            width: '100%'
        })
    }
})


$('body').click(function (e) {
    if (documentWidth > '880') {
        if (!$(e.target).is('#openLogin,  #openCart')) {
            $('#shoppingModal').hide();
            $('#userModal').hide();
        }
    }
});

$('.modalDropdown').click(function (e) {
    e.stopPropagation();
})
$('#mobileMenu').click(function () {
    $('#navLinks').slideToggle();
    $('#userModal').hide();
    $('#shoppingModal').hide();
    closeSearch();
});


function closeCart() {
    $('#shoppingModal').toggle();
};

function openCart() {
    closeSearch();
    $('#shoppingModal').toggle();
    if (documentWidth < '815') {
        $('#navLinks').hide();
    }
    $('#userModal').hide();
};
$('#closeUser').click(function () {
    $('#userModal').toggle();
});
$('#openLogin').click(function (e) {
    openLogin(e);

});

function openLogin(e) {
    e.stopImmediatePropagation();
    closeSearch();
    if (documentWidth < '880') {
        $('#navLinks').hide();
    }
    $('#shoppingModal').hide();
    $('#userModal').toggle();
    $('#userModal input[name="email"').focus();
}
$('#openSearch').click(function () {
    $('#shoppingModal').hide();
    $('#userModal').hide();
    $('#navLinks').hide();

    if (documentWidth > '880') {
        $('.searchBarContainer').animate({
            'width': "100%"
        });
        $('.searchBarContainer').show();
        $('#navLinks').hide();

    } else {
        $('.searchBarContainer').slideToggle();
    }
    $('.searchBar').focus();
    $('#closeSearch').show();
    $('#openSearch').hide();
});
$('#closeSearch').click(function () {
    closeSearch()
});

function closeSearch() {
    $('.searchResults').html("");
    if (documentWidth > '880') {
        $('.searchBarContainer').animate({
            'width': "0"
        }, 200);
        setTimeout(() => {
            $('#navLinks').show();
            $('.searchBarContainer').hide();
        }, 195);
    } else {
        $('.searchBarContainer').hide();

    }
    $('#openSearch').show();
    $('#closeSearch').hide();
}
