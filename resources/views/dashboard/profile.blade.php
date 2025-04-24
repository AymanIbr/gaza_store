<x-dashboard title="Profile">


    @push('css')
        <style>
            .prev-img {
                width: 200px;
                height: 200px;
                object-fit: cover;
                border-radius: 50%;
                padding: 5px;
                border: 1px dashed #b8b8b8;
                cursor: pointer;
                transition: all .3s ease;
            }

            .prev-img:hover {
                opacity: .8;
            }

            /* photo center */
            .prev-img-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: #06060687;
                z-index: 66;
                display: flex;
                justify-content: center;
                align-items: center;
                backdrop-filter: blur(8px);
                display: none;
            }

            .prev-img-modal img {
                width: 300px;
                height: 300px;
                border-radius: 50%;
                object-fit: cover;
            }
        </style>
    @endpush

    <h1 class="h3 mb-4 text-gray-800">Profile Page</h1>


    <form action="{{ route('admin.profile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')


        <div class="prev-img-modal">
            <img src="https://ui-avatars.com/api/?background=random&name=" alt="">
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    @php
                        //https://ui-avatars.com/
                        if ($admin->image) {
                            $url = asset('storage/' . $admin->image->path);
                        } else {
                            $url = 'https://ui-avatars.com/api/?background=random&name=' . $admin->name;
                        }
                    @endphp

                    <div class="text-center">
                        <img title="Edit your photo" id="prevImg" class="im-thumbnail prev-img"
                            src="{{ $url }}" alt="">
                        <br>
                        <label class="btn btn-sm btn-dark mt-2" for="image">
                            Edit Image
                        </label>
                    </div>
                    <div class="d-none">
                        <x-form.file onchange="showImage(event)" name="image" accept=".png, .jpg, .jpeg, .svg" />
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="mb-3">
                    <x-form.input label="Name" name="name" :oldval="$admin->name" />
                </div>
                <div class="mb-3">
                    <x-form.input label="Email" name="email" :oldval="$admin->email" disabled />
                </div>
                <br>
                <h4>Update your Password</h4>

                <div class="mb-3">
                    <x-form.input label="Current Password" name="current_password" Placeholder="Enter Your password"
                        type="password" />
                </div>

                <div class="mb-3">
                    <x-form.input label="New Password" name="password" class="new" disabled
                        Placeholder="Enter Your password" type="password" />
                </div>

                <div class="mb-3">
                    <x-form.input disabled label="Confirm Password" class="new" name="password_confirmation"
                        Placeholder="Enter Your confirm password" type="password" />
                </div>

                <button class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            </div>
        </div>



    </form>



    @push('js')
        <script>
            function showImage(e) {
                // create object url
                const file = e.target.files[0];
                if (file) {
                    prevImg.src = URL.createObjectURL(file);
                }
            }

            $('.prev-img').click(function() {
                let url = $(this).attr('src')
                $('.prev-img-modal img').attr('src', url)

                $('.prev-img-modal').css('display', 'flex')
            })
            $('.prev-img-modal').click(function() {
                $('.prev-img-modal').hide();
            })

            // let current = document.querySelector('#current_password');
            // let newInputs = document.querySelectorAll('.new');

            // current.onkeyup = () => {
            //     newInputs.forEach(e => {
            //         if (current.value.length > 0) {
            //             e.removeAttribute('disabled');
            //             e.value = '';

            //         } else {
            //             e.setAttribute('disabled', true);
            //             e.value = '';
            //         }
            //     });
            // };

            $('#current_password').blur(function(){
            // $('#current_password').keyup(function(){
                $.ajax({
                    url: '{{ route("admin.check_password") }}',
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        password: $('#current_password').val()
                    },
                    success: function(res) {
                        if(res){
                            $('.new').prop('disabled', false)
                            $('#current_password').removeClass('is-invalid')
                            $('#current_password').addClass('is-valid')
                        }else{
                            $('.new').prop('disabled', true)
                             $('.new').val('');
                             $('#current_password').removeClass('is-valid')
                            $('#current_password').addClass('is-invalid')
                        }
                    }
                });
            })
        </script>
    @endpush

</x-dashboard>
