<x-dashboard title="All Users">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h3 mb-0 text-gray-800"><span class="count-category">All Users</span>
        </h1>
        @can('create-user')
        <div id="btn" class="">
            <a href="{{ route('admin.users.create') }}">
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
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <span class="badge bg-primary p-2">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $user->created_at->format('Y - m - d') }}</td>
                                    <td>

                                        @can('update-user')
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="edit-row btn btn-sm btn-primary">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('delete-user')
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
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
                        {{-- {{ $users->links() }} --}}
                    </div>
                </div>

            </div>


        </div>
    </div>



</x-dashboard>
