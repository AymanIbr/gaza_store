<x-dashboard title="Settings">

    <h1 class="h3 mb-4 text-gray-800">Website Settings</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <x-form.input label="Site Name" name="site_name" oldval="{{ $settings['site_name'] }}" placeholder="Enter Website Name"/>
                </div>

                <div class="mb-3">
                    <x-form.file label="Site Logo" name="site_logo" oldimage="{{ 'storage/'. $settings['site_logo'] ?? '' }}" can_delete="true"/>
                </div>

                <div class="mb-3">
                    <x-form.input label="Facebook" name="facebook" oldval="{{ $settings['facebook'] }}" placeholder="Enter Facebook URL"/>
                </div>

                <div class="mb-3">
                    <x-form.input label="Twitter" name="twitter" oldval="{{ $settings['twitter'] }}" placeholder="Enter Twitter URL"/>
                </div>

                <div class="mb-3">
                    <x-form.input label="Linked In" name="linkedin" oldval="{{ $settings['linkedin'] }}" placeholder="Enter Linked In URL"/>
                </div>

                <div class="mb-3">
                    <x-form.area label="Copyright" name="copyright" oldval="{{ $settings['copyright'] }}" placeholder="Enter Copyright"/>
                </div>

                <button class="btn btn-success"><i class="fas fa-save"></i> Save</button>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            let del_img = document.querySelector('#del_site_image');
            // JQuery
            del_img.onclick = () => {
                $.get('/admin/delete-site-logo')
                .done((res) => {
                    del_img.parentElement.remove();
                })
                .fail((err) => {

                })
            }

        </script>
    @endpush

</x-dashboard>
