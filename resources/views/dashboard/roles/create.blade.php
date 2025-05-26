<x-dashboard title="Create Role">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Add new Role</h1>

        @can('create-role')
        <a href="{{ route('admin.roles.index') }}" class="btn btn-info"><i class="fas fa-long-arrow-alt-left"></i> All Roles</a>
        @endcan

    </div>


    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    @include('dashboard.roles._form')
                </div>
                <button class="btn btn-success"><i class="fas fa-save"></i> Save</button>
            </form>
        </div>
    </div>

</x-dashboard>
