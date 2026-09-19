var imagemin = require("imagemin"),    // The imagemin module.
  webp = require("imagemin-webp"),   // imagemin's WebP plugin.
  outputFolder = "./lastup",            // Output folder
  PNGImages = "./lastup/*.png",         // PNG images
  JPEGImages = "./lastup/*.jpg";        // JPEG images



imagemin([PNGImages], outputFolder, {
  plugins: [webp({
      lossless: true // Losslessly encode images
  })]
});

imagemin([JPEGImages], outputFolder, {
  plugins: [webp({
    quality: 90 // Quality setting from 0 to 100
  })]
});