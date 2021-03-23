$(document).foundation();

// smooth ankor scroll
var body = $("body, html");

// nice scroll
$("html").niceScroll();

// slick slider
    // -- main slider
    $('.main-slider').slick({
        dots: true,
        infinite: true,
        arrows: true,
        autoplay: true,
        speed: 600,
        slidesToShow: 1,
        centerMode: true,
        variableWidth: true,
        prevArrow: '<span class="slick-prev mainPrevBtn"></span>',
        nextArrow: '<span class="slick-next mainNextBtn"></span>',
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                arrows: false
              }
            }
          ]
    });

    // -- brands logos slider

    $('.brands-logos').slick({
      infinite: true,
      autoplay: true,
      slidesToShow: 6,
      slidesToScroll: 1,
      prevArrow: '<span class="slick-prev slick-arrow"> <i class="fa fa-angle-left"></i> </span>',
      nextArrow: '<span class="slick-next slick-arrow"> <i class="fa fa-angle-right"></i> </span>',
      responsive: [
        {
          breakpoint: 1025,
          settings: {
            slidesToShow: 5
          }
        }]
    });

$("a[title='login'], .large-screen-header a.cart-link").click(function(e) {
  e.preventDefault();
});

// SCROLLING
var sunglassLine = $(".main-footer").offset().top;

$(window).scroll(function(){
  var currentScrollFire = $("html, body").scrollTop();
  var currentScrollChr = $("body").scrollTop();

  if((currentScrollFire + 450) >= sunglassLine || (currentScrollChr + 450) >= sunglassLine){
      $(".sunglassSvgCont").addClass("sgl-animate");
  }else{
    $(".sunglassSvgCont").removeClass("sgl-animate");
  };

  if(currentScrollFire >= 300 || currentScrollChr >= 300){
    $("header.large-screen-header").addClass("large-header-scrolled");
  }else{
    $("header.large-screen-header").removeClass("large-header-scrolled");
  };
});

// Cart Checkout items
  $("#cart-content .cart-item div a").click(function () {
    $(this).parents('.cart-item').slideUp( function () {
      $(this).css('display','none');
    } );
  });
  $(".table-of-orders table").find("span.label").click(function () {
    $(this).parents('tr').slideUp( function () {
      $(this).css('display','none');
    } );
  });
// table-of-orders
// Filters in mobile
$("a#filterToggler").click(function () {
  if($("#categoryFilters").hasClass("opened")){
    $("#categoryFilters").removeClass("opened");
  }else{
    $("#categoryFilters").addClass("opened");
  };
});

// cardOptions
$('label.pay-option').click(function () {
  if($('input#visa-master').is(':checked')){
    $("#card-data").css("display", "block");
  } else{
    $("#card-data").css("display", "none");
  };
});
$("input#ccv").focus(function() {
  $(".flip-container").addClass('hover');
}).blur(function () {
  $(".flip-container").removeClass('hover');
});

$('.product-images-slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: true,
  asNavFor: '.product-slider-controller',
  fade: false
});


//  USER DASHBOURD
$(".user-account").find(".user-data-option").each(function () {
  $(this).find("a.edit").click(function () {
    $(this).parents(".user-data-option").next(".editOption").toggleClass("active");
  });
});
$(".editOption").find("a.cancel").click(function () {
  $(this).parents(".editOption").toggleClass("active");
});



$('.product-slider-controller').slick({
  slidesToShow: 6,
  slidesToScroll: 1,
  asNavFor: '.product-images-slider',
  dots: true,
  centerMode: true,
  focusOnSelect: true
});

// Preview Page Scripts
$("img.zoomImage").elevateZoom({
    gallery:'zoomGallery',
    cursor: 'pointer',
    galleryActiveClass: 'active',
    imageCrossfade: true,
    loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'
});

$("img.zoomImage").click(function(e) {
    var ez = $('img.zoomImage').data('elevateZoom');
    $.fancybox(ez.getGalleryList());
    return false;
});

//product-details Quantaty
$(".product-details .add").click(function (e) {
  e.preventDefault();
  var inputValue = Number($(".product-details input[type='number']").val());
  inputValue = inputValue+1;
  $(".product-details input[type='number']").val(inputValue);
});

$(".product-details .minus").click(function (e) {
  e.preventDefault();
  var inputValue = Number($(".product-details input[type='number']").val());
  if(inputValue > 1 ){
    inputValue -=1;
    $(".product-details input[type='number']").val(inputValue);
  }
});


// Stars Ranks

var labels = $("#ranks label");
var labelsTitle = $("#ranks .rateTitle");

labels.hover(function(){
  $(this).css("color", "gold")
    .prevUntil().css("color", "gold");
    labelsTitle.html($(this).attr('data-rate'));

}, function(){
    $(this).css("color", "inherit").prevUntil().css("color", "inherit");
    var checkedNum = $("#ranks label.checked").length;
    if (checkedNum === 1){
      labelsTitle.html( $("#ranks label.checked").attr("data-rate") );
    }else{
      labelsTitle.html("");
    }
});


labels.click(function(){
  var labelSelected = $(this);
  // reset label class and input checkbox
  labels.removeClass("rankChecked checked")
    .find("input[type=checkbox]")
    .removeAttr("checked");

  // add checked when label clicked
  labelSelected.find("input[type=checkbox]").attr("checked","checked")
    .parent().addClass("checked");

  // add rankChecked Class
  labelSelected.addClass("rankChecked").removeAttr("style")
  .prevUntil().removeAttr("style").addClass("rankChecked");

});

//card-data:

// ======= Review Stars

var labels = $(".ranks label");
var labelsTitle = $(".ranks .rateTitle");

labels.hover(function(){
  $(this).css("color", "gold")
    .prevUntil().css("color", "gold");
    labelsTitle.html($(this).attr('data-rate'));

}, function(){
    $(this).css("color", "inherit").prevUntil().css("color", "inherit");
    var checkedNum = $("#ranks label.checked").length;
    if (checkedNum === 1){
      labelsTitle.html( $("#ranks label.checked").attr("data-rate") );
    }else{
      labelsTitle.html("");
    }

});

labels.click(function(){
  var labelSelected = $(this);
  // reset label class and input checkbox
  labels.removeClass("rankChecked checked")
    .find("input[type=checkbox]")
    .removeAttr("checked");

  // add checked when label clicked
  labelSelected.find("input[type=checkbox]").attr("checked","checked")
    .parent().addClass("checked");

  // add rankChecked Class
  labelSelected.addClass("rankChecked")
    .removeAttr("style")
    .prevUntil()
    .removeAttr("style").addClass("rankChecked");

});

// ======== Review End
