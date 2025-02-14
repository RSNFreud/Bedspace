$(document).ready(function () {
    // Images loaded is zero because we're going to process a new set of images.
    var imagesLoaded = 0;
    // Total images is still the total number of <img> elements on the page.
    var totalImages = $("img").length;

    // Step through each image in the DOM, clone it, attach an onload event
    // listener, then set its source to the source of the original image. When
    // that new image has loaded, fire the imageLoaded() callback.
    $("img").each(function (idx, img) {
        if (img.src.includes("loading.svg")) {
            return imageLoaded();
        }
        if (img.src == "") {
            return imageLoaded();
        }

        $("<img>")
            .on("load", imageLoaded)
            .attr("src", $(img).attr("src"));
    });

    // Do exactly as we had before -- increment the loaded count and if all are
    // loaded, call the allImagesLoaded() function.
    function imageLoaded() {
        imagesLoaded++;
        if (imagesLoaded == totalImages) {
            allImagesLoaded();
        }
    }

    function allImagesLoaded() {
        $("#loader").fadeToggle();

        if (!$('.messageModal.success').is(':empty')) {
            $('.messageModal.success').css({
                'right': 0
            });
            setTimeout(() => {
                $('.messageModal.success').css({
                    'right': '-100vw'
                });
            }, 3000);
        }
    }
});
