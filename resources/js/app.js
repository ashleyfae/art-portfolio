import './bootstrap';
import './imagesloaded.pkgd.min';
import './artwork-form';
import './masonry';

document.addEventListener('DOMContentLoaded', () => {
    if (typeof ClassicEditor === 'function') {
        const editors = document.querySelectorAll('.visual-editor');

        if (editors) {
            editors.forEach(editor => {
                ClassicEditor
                    .create(editor)
                    .catch(error => {
                        console.log('Editor error', error);
                    })
            })
        }
    }
})
