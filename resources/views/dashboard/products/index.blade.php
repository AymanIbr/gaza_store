
<x-dashboard title="All Products">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h3 mb-0 text-gray-800"><span class="count-category">All Products {{ $products->total() }}</span>
        </h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-info">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="table-content">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                            <img width="100px" height="100px"  style="object-fit: cover" class="img-thumbnail" src="{{ $product->image_path }}" alt="">
                                    </td>
                                    <td>{{ $product->trans_name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->category->trans_name }}</td>
                                    <td>

                                        <a href="{{ route('admin.products.edit', [$product->id, 'page' => request()->page]) }}"
                                            class="edit-row btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>


                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="" type="submit" class="btn btn-sm btn-danger"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>

                                    </td>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="7">No Data Found</td>
                                </tr>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $products->appends($_GET)->links() }}
                    </div>
                </div>

            </div>


        </div>
    </div>



</x-dashboard>
