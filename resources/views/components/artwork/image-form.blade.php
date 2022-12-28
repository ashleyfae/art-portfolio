@if($image && $image->image_path)
    <figure class="gallery-image-image">
        <img
            src="{{ $image->imageUrl }}"
        >
    </figure>
@endif

<div class="field">
    <label for="artwork-image-{{ $uniqueId }}">Image: <span class="colour--danger">*</span></label>
    <input
        type="file"
        id="artwork-image-{{ $uniqueId }}"
        name="images[{{ $number }}][image]"
        data-key="image"
        @if($disabled) disabled @endif
    >
</div>

<div class="field">
    <label for="artwork-title-{{ $uniqueId }}">Title:</label>
    <input
        type="text"
        id="artwork-title-{{ $uniqueId }}"
        name="images[{{ $number }}][title]"
        value="{{ $image?->title }}"
        data-key="title"
        @if($disabled) disabled @endif
    >
</div>

<div class="field">
    <label for="artwork-description-{{ $uniqueId }}">Description:</label>
    <textarea
        id="artwork-description-{{ $uniqueId }}"
        class="visual-editor"
        name="images[{{ $number }}][description]"
        rows="10"
        data-key="description"
        @if($disabled) disabled @endif
    >{{ $image?->description }}</textarea>
</div>

<div class="field">
    <label for="artwork-alt-text-{{ $uniqueId }}">Alt Text:</label>
    <textarea
        id="artwork-alt-text-{{ $uniqueId }}"
        name="images[{{ $number }}][alt_text]"
        data-key="alt_text"
        @if($disabled) disabled @endif
    >{{ $image?->alt_text }}</textarea>
</div>

<input
    type="hidden"
    name="images[{{ $number }}][id]"
    value="{{ $image?->id }}"
    data-key="id"
    @if($disabled) disabled @endif
>

<input
    type="hidden"
    name="images[{{ $number }}][primary]"
    value="{{ (int) $primary }}"
    data-key="primary"
    @if($disabled) disabled @endif
>
