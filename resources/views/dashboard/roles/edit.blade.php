<x-dashboard title="Edit Role">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Edit Role</h1>
        @can('roles')
        <div class="" id="btn">
<a href="{{ route('admin.roles.index') }}"><i class="fas fa-long-arrow-alt-left"></i> All Roles</a>
        </div>
        @endcan

    </div>


    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.roles.update',$role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    @include('dashboard.roles._form')
                </div>
                <button class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            </form>
        </div>
    </div>

</x-dashboard>
