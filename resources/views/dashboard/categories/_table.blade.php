<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Product Count</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Product Count</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </tfoot>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        {{-- @if ($category->image) --}}
                        {{-- @dump($category->image->path) --}}
                            <img width="100px" height="100px"  style="object-fit: cover" class="img-thumbnail" src="{{ $category->image_path }}" alt="">
                        {{-- @endif --}}

                    </td>
                    <td>{{ $category->trans_name }}</td>
                    <td>{{ $category->trans_description }}</td>
                    <td>{{ $category->products_count }}</td>
                    <td>{{ $category->created_at->diffForHumans() }}</td>
                    <td>{{ $category->updated_at->diffForHumans() }}</td>
                    <td>

                        @can('update-category')
                        <a href="{{ route('admin.categories.edit', [$category->id, 'page' => request()->page]) }}"
                            class="edit-row btn btn-sm btn-primary edit-category" data-id="{{ $category->id }}"
                            data-bs-toggle="modal" data-bs-target="#edit-category">
                            <i class="fa fa-edit"></i>
                        </a>
                        @endcan


                        @can('delete-category')
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                            style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button onclick="confirmDestroy(event)" type="submit" class="btn btn-sm btn-danger"><i
                                    class="fa fa-trash"></i></button>
                        </form>
                        @endcan


                    </td>
                @empty
                <tr>
                    <td colspan="6">No Data Found</td>
                </tr>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination">
        {{ $categories->appends($_GET)->links() }}
    </div>
</div>
