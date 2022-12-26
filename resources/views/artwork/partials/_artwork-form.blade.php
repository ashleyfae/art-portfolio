<?php $number = 0; ?>

<h2>Primary Image</h2>

<x-artwork.image-form
    :image="$artwork->primaryImage"
    :primary="true"
    number="{{ $number }}"
/>
<?php $number++; ?>

<h2>Gallery</h2>

<div id="gallery-images">
    @foreach($artwork->galleryImages as $image)
        <div class="gallery-image">
            <x-artwork.image-form
                :image="$image"
                :primary="false"
                number="{{ $number }}"
            />
        </div>
        <?php $number++; ?>
    @endforeach
</div>

<div id="gallery-image-template" class="hidden">
    <div class="gallery-image">
        <x-artwork.image-form
            :image="null"
            :primary="false"
            :disabled="true"
            number="{{ $number }}"
        />
    </div>
</div>

<h2>Settings</h2>

<div class="field">
    <input
        type="checkbox"
        id="is-featured"
        name="is_featured"
        value="1"
        @if($artwork->is_featured) checked @endif
    >
    <label for="is-featured">Featured</label>
</div>

<div class="field">
    <label for="published-at">Published At: <span class="colour--danger">*</span></label>
    <input
        type="text"
        id="published-at"
        name="published_at"
        value="{{ $publishedAt }}"
    >
</div>

<button
    type="button"
    id="new-gallery-image"
>Add Image</button>
