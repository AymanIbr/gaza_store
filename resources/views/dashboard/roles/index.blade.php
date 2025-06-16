<x-dashboard title="All Roles">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><span class="count-category">All Roles {{ $roles->total() }}</span>
        </h1>
        @can('create-role')
            <div class="" id="btn">
                <a href="{{ route('admin.roles.create') }}">
                    <i class="fas fa-plus"></i> Add New
                </a>
            </div>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">

            <div class="table-content">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->created_at->format('Y - m - d') }}</td>
                                    <td>

                                        @can('update-role')
                                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                class="edit-row btn btn-sm btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('delete-role')
                                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                style="display: inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="" type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        @endcan
                                    </td>
                                @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="4">No Data Found</td>
                                </tr>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $roles->links() }}
                    </div>
                </div>

            </div>


        </div>
    </div>



</x-dashboard>
