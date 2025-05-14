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
                            <img class="main-image" src="{{ asset('storage/' . $product->image->path) }}"
                                alt="">
                            @if ($product->gallery)
                                <div class="gallery-images d-flex flex-wrap gap-2 mt-3">
                                    @foreach ($product->gallery as $img)
                                        <img src="{{ asset('storage/' . $img->path) }}" alt=""
                                            class="gallery-thumbnail">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="col-lg-5">
                        <div class="right-content">
                            <h4>{{ $product->trans_name }}</h4>
                            <span class="price" data-price="{{ $product->price }}">${{ $product->price }}</span>
                            <ul class="stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
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
    <!-- ***** Product Area Ends ***** -->

    @push('css')
        <style>
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
        </style>
    @endpush

    @push('js')
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
                            text: response.message ,
                            icon: "success",
                            draggable: true
                        });
                    }
                })

            })
        </script>
    @endpush


</x-layout>
