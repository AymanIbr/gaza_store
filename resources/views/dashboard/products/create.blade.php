<x-dashboard title="Create Product">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Add new Product</h1>
        @can('products')
        <div class="" id="btn">
            <a href="{{ route('admin.products.index') }}"><i class="fas fa-long-arrow-alt-left"></i> All
                Products</a>
        </div>

        @endcan
    </div>


    <div class="card">
        <div class="card-body">
            <form id="create-form" enctype="multipart/form-data">

                {{-- <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"> --}}
                @csrf
                <div class="mb-3">

                    {{-- <x-form.input label="Name" name="name" Placeholder="Enter Category Name" value="name" /> --}}
                    @include('dashboard.products._form')
                </div>
                
                <button type="button" onclick="store()" class="btn btn-success"><i class="fas fa-save"></i>
                    Save</button>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            function store() {
                let formData = new FormData();

                formData.append('name_en', document.querySelector('[name="name_en"]').value);
                formData.append('name_ar', document.querySelector('[name="name_ar"]').value);
                formData.append('price', document.querySelector('[name="price"]').value);
                formData.append('quantity', document.querySelector('[name="quantity"]').value);
                formData.append('description_en', document.querySelector('[name="description_en"]').value);
                formData.append('description_ar', document.querySelector('[name="description_ar"]').value);
                formData.append('category_id', document.querySelector('[name="category_id"]').value);

                formData.append('is_featured', document.getElementById('is_featured').checked ? 1 : 0);
                formData.append('image', document.getElementById('image').files[0]);


                const galleryInput = document.querySelector('input[name="gallery[]"]');
                if (galleryInput && galleryInput.files.length > 0) {
                    for (let i = 0; i < galleryInput.files.length; i++) {
                        formData.append('gallery[]', galleryInput.files[i]);
                    }
                }

                axios.post("{{ route('admin.products.store') }}", formData)
                    .then(function(response) {
                        toastr.success(response.data.message || 'Product created successfully!');
                        document.getElementById('create-form').reset();
                        document.querySelector('.prev-img').src = "{{ asset('assets/img/prev.jpg') }}";
                    })
                    .catch(function(error) {
                        if (error.response && error.response.status === 422) {
                            let errors = error.response.data.errors;
                            for (let key in errors) {
                                toastr.error(errors[key][0]);
                            }
                        } else {
                            toastr.error('Something went wrong!');
                            console.log(error);
                        }
                    });
            }
        </script>
    @endpush

</x-dashboard>
