<x-dashboard title="Edit Product">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Edit Product</h1>

        @can('products')
            <div id="btn" class="">
                <a href="{{ route('admin.products.index') }}"><i class="fas fa-long-arrow-alt-left"></i> All
                    Products</a>
            </div>
        @endcan
    </div>


    <div class="card">
        <div class="card-body">
            {{-- <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"> --}}
            <form id="update-form" enctype="multipart/form-data">
                @csrf
                {{-- @method('PUT') --}}
                <div class="mb-3">
                    <input type="hidden" name="page" value="{{ request('page') }}">
                    @include('dashboard.products._form')
                </div>
                <div id="btn" class="">
                    <button type="button" onclick="update({{ $product->id }},'{{ $redirect ?? true }}')"
                        class="btn btn-success"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>



    @push('js')
        <script>
            function update(id, redirect) {
                let formData = new FormData();

                formData.append('_method', 'put'); // لأن تستخدم axios.post مع override لـ PUT
                formData.append('name_en', document.querySelector('[name="name_en"]').value);
                formData.append('name_ar', document.querySelector('[name="name_ar"]').value);
                formData.append('price', document.querySelector('[name="price"]').value);
                formData.append('quantity', document.querySelector('[name="quantity"]').value);
                formData.append('description_en', document.querySelector('[name="description_en"]').value);
                formData.append('description_ar', document.querySelector('[name="description_ar"]').value);
                formData.append('category_id', document.querySelector('[name="category_id"]').value);
                formData.append('is_featured', document.getElementById('is_featured').checked ? 1 : 0);

                const imageInput = document.querySelector('input[name="image"]');
                if (imageInput && imageInput.files.length > 0) {
                    formData.append('image', imageInput.files[0]);
                }

                const galleryInput = document.querySelector('input[name="gallery[]"]');
                if (galleryInput && galleryInput.files.length > 0) {
                    for (let i = 0; i < galleryInput.files.length; i++) {
                        formData.append('gallery[]', galleryInput.files[i]);
                    }
                }

                axios.post('/admin/products/' + id, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        toastr.success(response.data.message);
                        if (redirect) {
                            window.location.href = "/admin/products";
                        }
                    })
                    .catch(error => {
                        if (error.response && error.response.status === 422) {
                            // عرض أول رسالة خطأ فقط
                            toastr.error(error.response.data.message);
                            console.log(error.response.data.errors);
                        } else {
                            toastr.error('Something went wrong!');
                        }
                    });
            }
        </script>
    @endpush


</x-dashboard>
