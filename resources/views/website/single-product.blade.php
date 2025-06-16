<x-layout title="Product - {{ $product->trans_name }}">






    <!-- ***** Main Banner Area Start ***** -->
    <div class="page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Product- {{ $product->trans_name }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->


    <!-- ***** Product Area Starts ***** -->
    <section class="section" id="product">
        <div class="container">
            <form action="{{ route('site.cart.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-7">
                        <div class="left-images">
                            <img class="main-image" name="main" src="{{ asset('storage/' . $product->image->path) }}"
                                alt="">
                            @if ($product->gallery)
                                <div class="gallery-images d-flex flex-wrap gap-2 mt-3">
                                    @foreach ($product->gallery as $img)
                                        <img src="{{ asset('storage/' . $img->path) }}"
                                            onmouseenter="main.src = this.src" alt="" class="gallery-thumbnail">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="col-lg-5">
                        <div class="right-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>{{ $product->trans_name }}</h4>
                                    <span class="price"
                                        data-price="{{ $product->price }}">${{ $product->price }}</span>

                                    <span class="ratings">
                                        @if ($ratings->count() > 0)
                                            <p>{{ $ratings->count() }} Ratings</p>
                                        @else
                                            <p>No Ratings</p>
                                        @endif
                                    </span>

                                    <ul class="d-flex" style="cursor: pointer">
                                        @php
                                            $ratedNum = number_format($ratings_value);
                                        @endphp
                                        @for ($i = 1; $i <= $ratedNum; $i++)
                                            <li><i class="checked fa fa-star m-1"></i></li>
                                        @endfor
                                        @for ($j = $ratedNum + 1; $j <= 5; $j++)
                                            <li><i class="fa fa-star m-1"></i></li>
                                        @endfor
                                    </ul>
                                </div>
                                <div class="rating-css col-md-6">
                                    <button type="button" class="btn btn-xl btn-outline-secondary"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Rate this product
                                    </button>
                                </div>
                            </div>


                            <span>{{ $product->trans_description }}</span>
                            <div class="quantity-content">
                                <div class="left-content">
                                    <h6>No. of Orders</h6>
                                </div>
                                <div class="right-content">
                                    <div class="quantity buttons_added">
                                        <input type="button" value="-" class="minus"><input type="number"
                                            step="1" min="1" name="quantity" value="1" title="Qty"
                                            class="input-text qty text" size="4" pattern=""
                                            inputmode=""><input type="button" value="+" class="plus">
                                    </div>
                                </div>
                            </div>
                            <div class="total">
                                <h4>Total: $<b class="final">{{ $product->price }}</b></h4>
                                <div class="main-border-button add-to-cart" data-id="{{ $product->id }}">
                                    <button class="btn btn-outline-secondary" type="button">Add To Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>



    {{-- Modal Rate --}}

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="rating-form" action="{{ route('rating.store', $product) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Rate {{ $product->trans_name }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="rating-css">
                            <div class="star-icon">
                                @if ($user_rating)
                                    @for ($i = 1; $i <= $user_rating->stars_rated; $i++)
                                        <input type="radio" value="{{ $i }}" name="product_rating" checked
                                            id="rating{{ $i }}">
                                        <label for="rating{{ $i }}" class="fa fa-star"></label>
                                    @endfor
                                    @for ($j = $user_rating->stars_rated + 1; $j <= 5; $j++)
                                        <input type="radio" value="{{ $j }}" name="product_rating"
                                            id="rating{{ $j }}">
                                        <label for="rating{{ $j }}" class="fa fa-star"></label>
                                    @endfor
                                @else
                                    <input type="radio" value="1" name="product_rating" checked
                                        id="rating1">
                                    <label for="rating1" class="fa fa-star"></label>
                                    <input type="radio" value="2" name="product_rating" id="rating2">
                                    <label for="rating2" class="fa fa-star"></label>
                                    <input type="radio" value="3" name="product_rating" id="rating3">
                                    <label for="rating3" class="fa fa-star"></label>
                                    <input type="radio" value="4" name="product_rating" id="rating4">
                                    <label for="rating4" class="fa fa-star"></label>
                                    <input type="radio" value="5" name="product_rating" id="rating5">
                                    <label for="rating5" class="fa fa-star"></label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="rateProduct(event)" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ***** Product Area Ends ***** -->

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <style>
            .checked {
                color: #ffe400;
            }

            .main-image {
                object-fit: cover;
                height: 400px !important;
                width: 100% !important;
            }

            .gallery-images {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .gallery-thumbnail {
                width: 150px !important;
                height: 200px !important;
                object-fit: cover;
                border-radius: 5px;
                border: 1px solid #ddd;
                transition: transform 0.3s ease;
                cursor: pointer;
            }

            .gallery-thumbnail:hover {
                transform: scale(1.05);
                border-color: #aaa;
            }


            .rating-css div {
                color: #ffe400;
                font-size: 30px;
                font-family: sans-serif;
                font-weight: 800;
                text-align: center;
                text-transform: uppercase;
                padding: 20px 0;
            }

            .rating-css input {
                display: none;
            }

            .rating-css input+label {
                font-size: 30px;
                text-shadow: 1px 1px 0 #8f8420;
                cursor: pointer;
            }

            .rating-css input:checked+label~label {
                color: #b4afaf;
            }

            .rating-css label:active {
                transform: scale(0.8);
                transition: 0.3s ease;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <script>
            $('.buttons_added .minus').click(function() {
                var quantity = parseInt($(this).parent().find('.qty').val());
                if (quantity > 1) {
                    $(this).parent().find('.qty').val(--quantity);
                }
                updateTotal()
            })


            $('.buttons_added .plus').click(function() {
                var quantity = parseInt($(this).parent().find('.qty').val());
                $(this).parent().find('.qty').val(++quantity);

                updateTotal()
            })

            function updateTotal() {
                let price = $('span.price').data('price')
                let quantity = parseInt($('.qty').val())
                $('.final').text(price * quantity)
            }


            // add to cart
            $('.add-to-cart').click(function() {
                let id = $(this).data('id');
                $.ajax({
                    url: '/cart',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: id,
                        quantity: parseInt($('.qty').val()),
                    },
                    success: (response) => {
                        Swal.fire({
                            title: "Item Added!",
                            text: response.message,
                            icon: "success",
                            draggable: true
                        });
                    }
                })

            })

            // rated Product

            function rateProduct(event) {
                event.preventDefault();
                const rating = document.querySelector('input[name="product_rating"]:checked').value;

                let formData = new FormData();
                formData.append('product_rating', rating);

                axios.post("{{ route('rating.store', $product) }}", formData)
                    .then(response => {

                        toastr.success(response.data.message);
                        // reload the page
                        window.location.reload();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                        modal.hide();
                    })
                    .catch(function(error) {
                        if (error.response && error.response.status === 422) {
                            let errors = error.response.data.errors || error.response.data;
                            for (let key in errors) {
                                toastr.error(errors[key]);
                            }
                        } else {
                            toastr.error('Something went wrong!');
                            console.log(error);
                        }
                    });
            }
        </script>
    @endpush


</x-layout>
