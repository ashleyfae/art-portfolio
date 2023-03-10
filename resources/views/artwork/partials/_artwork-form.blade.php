@if ($errors->any())
    <div class="errors">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<h2>Primary Image</h2>

<x-artwork.image-form
    :image="$artwork->primaryImage"
    :primary="true"
    number="0"
/>

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
    <p><strong>Categories:</strong></p>
    <ul>
        @foreach($categories as $category)
            <li>
                <input
                    type="checkbox"
                    id="category-{{ $category->id }}"
                    name="categories[]"
                    value="{{ $category->id }}"
                    @if($artwork->categories->pluck('id')->contains($category->id)) checked @endif
                >
                <label for="category-{{ $category->id }}">{{ $category->name }}</label>
            </li>
        @endforeach
    </ul>
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


<h2>Gallery</h2>

<div id="gallery-images">
    @foreach($artwork->galleryImages as $index => $image)
        <div class="gallery-image">
            <x-artwork.image-form
                :image="$image"
                :primary="false"
                number="{{ $index + 1 }}"
            />
        </div>
    @endforeach
</div>

<button
    type="button"
    id="new-gallery-image"
>Add Image</button>

<div id="gallery-image-template" class="hidden">
    <div class="gallery-image">
        <x-artwork.image-form
            :image="null"
            :primary="false"
            :disabled="true"
            number="0"
        />
    </div>
</div>
