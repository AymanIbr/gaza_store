<x-dashboard title="Edit Product">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Edit Product</h1>

        @can('products')
        <a href="{{ route('admin.products.index') }}" class="btn btn-info"><i class="fas fa-long-arrow-alt-left"></i> All Products</a>
        @endcan
    </div>


    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <input type="hidden" name="page" value="{{ request('page') }}">
                    @include('dashboard.products._form')
                </div>
                <button class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            </form>
        </div>
    </div>

</x-dashboard>
