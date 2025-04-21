
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <x-form.input label="English Name" name="name_en"
            :oldval="$category->name_en" Placeholder="Enter Category English Name"/>
        </div>

        <div class="mb-3">
            <x-form.area label="English Description" id="description_en" name="description_en" Placeholder="Enter English Description" :oldval="$category->description_en"
                :tiny=false />
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <x-form.input label="Arabic Name" name="name_ar"
            :oldval="$category->name_ar" Placeholder="Enter Category Arabic Name"/>
        </div>
        <div class="mb-3">
            <x-form.area label="Arabic Description" id="description_ar" name="description_ar" Placeholder="Enter Arabic Description" :oldval="$category->description_ar"
                :tiny=false />
        </div>
    </div>

    <div class="col-md-12">
        <label for="image" class="d-block">
            <img class="img-thumbnail prev-img"
                style="width: 100%; height: 150px; cursor: pointer; object-fit: cover"
                src="{{ asset('assets/img/prev.jpg') }}" alt="">
        </label>
        <input type="file" id="image" name="image" class="d-none">
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
    </script>
    @endpush











