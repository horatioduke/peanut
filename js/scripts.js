/*
Main Navigation Animation
*/

$("#nav-toggle").click(function () {
    $(this).toggleClass("active");
    $(".overlay").toggleClass("open");
});

$(".overlay a").click(function () {
    $("#nav-toggle").toggleClass("active");
    $(".overlay").toggleClass("open");
    $("body").toggleClass("locked");
});

/*
"Jankybox" Initialization
*/

(function($) {
 
    // Initialize the modal lightbox for any links with the 'jankybox' class
    $(".jankybox").jankybox();
 
    // Initialize the lightbox automatically for any links to images with extensions .jpg, .jpeg, .png or .gif
    $("a[href$='.jpg'], a[href$='.png'], a[href$='.jpeg'], a[href$='.gif']").jankybox();
 
    // Initialize the lightbox and add data-jankybox="gallery" to all gallery images when the gallery is set up using [gallery link="file"] so that a lightbox gallery exists
    $(".blocks-gallery-item a[href$='.jpg'], .blocks-gallery-item a[href$='.png'], .blocks-gallery-item a[href$='.jpeg'], .blocks-gallery-item a[href$='.gif']").attr('data-jankybox','gallery').jankybox();
 
    // Initalize the lightbox for any links with the 'video' class and provide improved video embed support
    $(".video").jankybox({
        maxWidth        : 800,
        maxHeight       : 600,
        fitToView       : false,
        width           : '70%',
        height          : '70%',
        autoSize        : false,
        closeClick      : false,
        openEffect      : 'none',
        closeEffect     : 'none'
    });
 
})(jQuery);