document.addEventListener('DOMContentLoaded', () => {
    const newImageButton = document.getElementById('new-gallery-image');

    if (newImageButton) {
        newImageButton.addEventListener('click', (e) => {
            e.preventDefault();
            addGalleryImageHtml();
        })
    }
});

function addGalleryImageHtml()
{
    const galleryImageTemplate = document.getElementById('gallery-image-template');
    const galleryImages = document.getElementById('gallery-images');

    if (! galleryImageTemplate || ! galleryImages) {
        return;
    }

    const numberOfImages = document.querySelectorAll('.gallery-image').length;

    const templateContents = updateGalleryForm(
        galleryImageTemplate.querySelector('.gallery-image').cloneNode(true),
        numberOfImages + 1
    );

    galleryImages.innerHTML += templateContents;
}

function updateGalleryForm(formNode, imageNumber)
{
    // un-disable the selectors
    const selectorsToUpdate = ['input', 'textarea'];

    selectorsToUpdate.forEach(selector => {
        formNode.querySelectorAll(selector).forEach((input) => {
            input.disabled = false;

            const existingId = input.getAttribute('id');
            if (existingId) {
                input.setAttribute( 'id', existingId + '-' + imageNumber );
            }

            const newFieldName = 'images[' + imageNumber + '][' + input.getAttribute('data-key') + ']';
            input.setAttribute('name', newFieldName);
        });
    });

    formNode.querySelectorAll('label').forEach((input) => {
        const existingForAttr = input.getAttribute('for');
        if (existingForAttr) {
            input.setAttribute( 'for', existingForAttr + '-' + imageNumber );
        }
    });

    return formNode.outerHTML;
}
