
/**
 * Create an arrow function that will be called when an image is selected.
 */
const previewFrontImage = (event) => {
    /**
     * Get the selected files.
     */
    const frontImageFiles = event.target.files;
    /**
     * Count the number of files selected.
     */
    const frontImageFilesLength = frontImageFiles.length;
    /**
     * If at least one image is selected, then proceed to display the preview.
     */
    if (frontImageFilesLength > 0) {
        /**
         * Get the image path.
         */
        const frontImageSrc = URL.createObjectURL(frontImageFiles[0]);
        /**
         * Select the image preview element.
         */
        const frontImagePreviewElement = document.querySelector("#preview-front-image");
        /**
         * Assign the path to the image preview element.
         */
        frontImagePreviewElement.src = frontImageSrc;
        /**
         * Show the element by changing the display value to "block".
         */
        frontImagePreviewElement.style.display = "block";
    }
};




/**
 * Create an arrow function that will be called when an image is selected.
 */
const previewBackImage = (event) => {
    /**
     * Get the selected files.
     */
    const backImageFiles = event.target.files;
    /**
     * Count the number of files selected.
     */
    const backImageFilesLength = backImageFiles.length;
    /**
     * If at least one image is selected, then proceed to display the preview.
     */
    if (backImageFilesLength > 0) {
        /**
         * Get the image path.
         */
        const backImageSrc = URL.createObjectURL(backImageFiles[0]);
        /**
         * Select the image preview element.
         */
        const backImagePreviewElement = document.querySelector("#preview-back-image");
        /**
         * Assign the path to the image preview element.
         */
        backImagePreviewElement.src = backImageSrc;
        /**
         * Show the element by changing the display value to "block".
         */
        backImagePreviewElement.style.display = "block";
    }
};



/**
 * Create an arrow function that will be called when an image is selected.
 */
const previewSelfieImage = (event) => {
    /**
     * Get the selected files.
     */
    const selfieImageFiles = event.target.files;
    /**
     * Count the number of files selected.
     */
    const selfieImageFilesLength = selfieImageFiles.length;
    /**
     * If at least one image is selected, then proceed to display the preview.
     */
    if (selfieImageFilesLength > 0) {
        /**
         * Get the image path.
         */
        const selfieImageSrc = URL.createObjectURL(selfieImageFiles[0]);
        /**
         * Select the image preview element.
         */
        const selfieImagePreviewElement = document.querySelector("#preview-selfie-image");
        /**
         * Assign the path to the image preview element.
         */
        selfieImagePreviewElement.src = selfieImageSrc;
        /**
         * Show the element by changing the display value to "block".
         */
        selfieImagePreviewElement.style.display = "block";
    }
};
