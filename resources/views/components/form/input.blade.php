@props(['label' => '', 'name' => '', 'placeholder' => '', 'oldval' => '', 'type' => 'text'])


@if ($label)
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
@endif


<input type="{{ $type }}" class="form-control" @error($name) is-invalid @enderror id="{{ $name }}"
    name="{{ $name }}" placeholder="{{ $placeholder }}" {{ $attributes }} value="{{ old($name, $oldval) }}">


@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
