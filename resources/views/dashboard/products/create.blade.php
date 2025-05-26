<x-dashboard title="Create Product">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Add new Product</h1>
        @can('products')
        <a href="{{ route('admin.products.index') }}" class="btn btn-info"><i class="fas fa-long-arrow-alt-left"></i> All Products</a>
        @endcan
    </div>


    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">

                  {{-- <x-form.input label="Name" name="name" Placeholder="Enter Category Name" value="name" /> --}}
                    @include('dashboard.products._form')
                </div>
                <button class="btn btn-success"><i class="fas fa-save"></i> Save</button>
            </form>
        </div>
    </div>

</x-dashboard>
