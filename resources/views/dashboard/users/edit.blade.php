<x-dashboard title="Edit User">

    <!-- Page Heading -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">Edit User</h1>

        @can('users')
        <div class="" id="btn">
        <a href="{{ route('admin.users.index') }}"><i class="fas fa-long-arrow-alt-left"></i> All Users</a>

        </div>
        @endcan

    </div>


    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update',$user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    @include('dashboard.users._form')
                </div>
                <button class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            </form>
        </div>
    </div>

</x-dashboard>
