@use('App\Models\Category')


<x-dashboard title="All Categories">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h3 mb-0 text-gray-800"><span class="count-category">All Categories {{ $categories->total() }}</span>
        </h1>
        @can('create-category')
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#add-new-category">
                <i class="fas fa-plus"></i> Add New</button>
        @endcan

    </div>

    <div class="my-2">
        <form onsubmit="filter(event)" action="{{ route('admin.categories.index') }}" method="GET">
            <input onkeyup="filter(event)" type="text" name="search" placeholder="Search Courses"
                class="p-2 border custom-input border-gray-400 rounded w-[70%] my-2" value="{{ request()->search }}">
            <select onchange="filter(event)" name="order" class="p-2 border border-gray-400 rounded w-[10%]">
                <option @selected(request()->order == 'ASC') value="ASC">ASC</option>
                <option @selected(request()->order == 'DESC') value="DESC">DESC</option>
            </select>
            <select onchange="filter(event)" name="count" class="p-2 border border-gray-400 rounded w-[10%]">
                <option style="font-weight: bold" value="" disabled selected>Select Count</option>
                <option @selected(request()->count == 10) value="10">10</option>
                <option @selected(request()->count == 20) value="20">20</option>
                <option @selected(request()->count == 30) value="30">30</option>
                <option @selected(request()->count == $categories->total()) value="{{ $categories->total() }}">All</option>
            </select>
            <button type="submit" class="border-none bg-info border-0 text-white p-2 rounded w-[10%]">Filter</button>
        </form>
    </div>


    <div class="card">
        <div class="card-body">

            <div class="table-content">
                @include('dashboard.categories._table')
            </div>


        </div>
    </div>

    {{-- Add new Category Modal --}}

    @can('create-category')
        <div class="modal fade" id="add-new-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="alert-error text-danger d-none rounded"
                            style="background-color: #f8d7da; color: #842029; padding: 10px;"></p>
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                @include('dashboard.categories._form', ['category' => new Category()])
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan



    {{-- Edit Modal Category --}}
    @can('update-category')
        <div class="modal fade" id="edit-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-body">
                            <p class="alert-error text-danger d-none rounded"
                                style="background-color: #f8d7da; color: #842029; padding: 10px;"></p>
                            <form action="" method="POST">
                                @csrf
                                @method('put')
                                @include('dashboard.categories._form', ['category' => new Category()])
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-info">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        @push('css')
            <style>
                .custom-input:focus {
                    outline: none;
                    box-shadow: none;
                }
            </style>
        @endpush



        @push('js')
            <script src="{{ asset('crud/crud.js') }}"></script>
        @endpush

</x-dashboard>
