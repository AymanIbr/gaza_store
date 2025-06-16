<div class="row">
    <div class="col-md-9">
        <div class="row">
            <!-- English Name -->
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input label="English Name" name="name_en" :oldval="$product->name_en"
                        placeholder="Enter product English Name" />
                </div>
            </div>

            <!-- Arabic Name -->
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input label="Arabic Name" name="name_ar" :oldval="$product->name_ar"
                        placeholder="Enter product Arabic Name" />
                </div>
            </div>
        </div>


        <div class="row">
            <!-- English Name -->
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input type="number" label="Price" name="price" :oldval="$product->price"
                        placeholder="Enter product price" />
                </div>
            </div>

            <!-- Arabic Name -->
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input type="number" label="Quantity" name="quantity" :oldval="$product->quantity"
                        placeholder="Enter product quantity" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">

                <!-- Gallery -->
                <div class="mb-3">
                    <x-form.file label="Gallery" name="gallery[]" multiple />
                    @error('gallery')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @if ($product->gallery)
                        <div class="gallery-wrapper">
                            @foreach ($product->gallery as $item)
                                <div>
                                    <img class="gallery-image img-thumbnail mt-1"
                                        src="{{ asset('storage/' . $item->path) }}" alt="">
                                    <span onclick="delImg(event, {{ $item->id }})">x</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <!-- Category -->
                <div class="mb-3">
                    <x-form.select label="Category" name="category_id" :oldval="$product->category_id" placeholder="Select Category"
                        :options="$categories" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!-- Content -->
                <div class="mb-3">
                    <x-form.area label="English Description" id="description_en" name="description_en"
                        placeholder="Enter Product English description" :oldval="$product->description_en" :tiny=false />
                </div>
            </div>
            <div class="col-md-6">
                <!-- Content -->
                <div class="mb-3">
                    <x-form.area label="Arabic Description" id="description_ar" name="description_ar"
                        placeholder="Enter Product Arabic description" :oldval="$product->description_ar" :tiny=false />
                </div>
            </div>
        </div>

      <div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
                    value="1"
                    {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">Featured Product</label>
            </div>
            @error('is_featured')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

    </div>

    <div class="col-md-3">
        <!-- Image Upload and Preview -->
        <div class="mb-3">
            <label class="d-block" for="image">
                <img class="img-thumbnail prev-img"
                    style="width: 100%; height: 300px; cursor: pointer; object-fit: cover" {{-- $post->image ? $post->image --}}
                    src="{{ $product->id ? asset('storage/' . $product->image->path) : asset('assets/img/prev.jpg') }}"
                    alt="Product Image">
            </label>
            @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div class="d-none">
                <x-form.file name="image" :oldimage="$product->image->path ?? null" />
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('#image').on('change', function() {
                let file = this.files[0];
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('.prev-img').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            })
        });

        function delImg(e, id) {
            $.ajax({
                type: 'get',
                url: '{{ route('admin.delete_img') }}/' + id,
                success: (res) => {
                    if (res) {
                        e.target.closest('div').remove();
                    }
                },
                error: (err) => {
                    console.log(err);
                }
            })
        }
    </script>

    @push('css')
        <style>
            .gallery-image {
                width: 80px;
                height: 100px;
                object-fit: cover;
            }

            .gallery-wrapper {
                display: flex;
            }

            .gallery-wrapper div {
                position: relative;
            }

            .gallery-wrapper div span {
                position: absolute;
                width: 15px;
                height: 15px;
                top: 5px;
                right: 5px;
                background: #ff8282;
                display: flex;
                justify-content: center;
                align-items: center;
                color: white;
                border-radius: 50%;
                cursor: pointer;
                opacity: 0;
                visibility: hidden;
                transition: all .3s ease;
            }

            .gallery-wrapper div:hover span {
                opacity: 1;
                visibility: visible;
            }

            .gallery-wrapper div span:hover {
                background: #f00;
            }
        </style>
    @endpush
@endpush
