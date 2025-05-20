 <x-layout title="Cart">

     <!-- ***** Main Banner Area Start ***** -->
     <div class="page-heading about-page-heading" id="top">
         <div class="container">
             <div class="row">
                 <div class="col-lg-12">
                     <div class="inner-content">
                         <h2>Cart Products</h2>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- ***** Main Banner Area End ***** -->



     <!---End of Hero Section-->
     <!--Cart Section-->
     <section class="mt-5">
         <div class="container">
             <div class="cart">
                 <div class="table-responsive">
                     <table class="table">
                         <thead class="thead-dark">
                             <tr>
                                 <th scope="col"class="text-white">Product</th>
                                 <th scope="col"class="text-white">Price</th>
                                 <th scope="col"class="text-white">Quantity</th>
                                 <th scope="col"class="text-white">Total</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($cart->get() as $item)
                                 <tr id="{{ $item->id }}">
                                     <td>
                                         <div class="main">
                                             <a href="{{ route('site.product_single', $item->product->slug) }}">
                                                 <div class="d-flex">
                                                     <!--W=145 H=98--> <img
                                                         style="object-fit: cover; height: 150px; width:50%"
                                                         src="{{ asset('storage/' . $item->product->image->path) }}"alt="">
                                                 </div>
                                                 <div class="des">

                                                     <p>{{ $item->product->trans_name }}</p>

                                                 </div>
                                             </a>
                                         </div>
                                     </td>
                                     <td>
                                         <span class="price"
                                             data-price="{{ $item->product->price }}">{{ Currency::format($item->quantity * $item->product->price) }}</span>
                                     </td>
                                     <td>
                                         <div class="right-content">
                                             <div class="quantity buttons_added">
                                                 <input type="button" value="-" class="minus"><input
                                                     type="number" min="1" name="quantity" title="Qty"
                                                     class="input-text qty text" size="4"
                                                     data-id="{{ $item->id }}" pattern=""
                                                     value="{{ $item->quantity }}" inputmode=""><input type="button"
                                                     value="+" class="plus">
                                             </div>
                                         </div>
                                     </td>
                                     <td>
                                         <a class="remove-item" data-id="{{ $item->id }}">
                                             <i class="fa fa-trash fa-2x" style="color: #c53030;"></i>
                                         </a>
                                     </td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </section>


     <div class="col-md-12">
         <div class="checkout mx-auto">
             <ul>
                 <li class="subtotal">subtotal
                     <span>{{ Currency::format($cart->total()) }}</span>
                 </li>
                 <li class="cart-total">Total
                     <span>$60.00</span>
                 </li>

             </ul>
         </div>
         <a href="{{ route('site.checkout') }}"class="proceed-btn mx-auto">Proceed to Checkout</a>
     </div>




     @push('css')
         <style>
             .checkout {
                 border: 2px solid #ebebeb;
                 background: #f3f3f3;
                 padding-left: 25px;
                 padding-right: 25px;
                 padding-top: 16px;
                 padding-bottom: 20px;
                 width: 350px;
                 margin-top: 30px;
             }

             .checkout ul li {
                 list-style: none;
                 font-size: 16px;
                 font-weight: bold;
                 color: #252525;
                 text-transform: uppercase;
                 overflow: hidden;
             }

             .checkout ul li.subtotal {
                 font-weight: bold;
                 text-transform: capitalize;
                 border-bottom: 1px solid #fff;
                 padding-bottom: 14px;
             }

             .checkout ul li.subtotal span {
                 font-weight: bold;
             }

             .checkout ul li.cart-total {
                 padding-top: 10px
             }

             .checkout ul li.cart-total span {
                 color: #e7ab3c;
             }

             .proceed-btn {
                 font-size: 15px;
                 font-weight: bold;
                 width: 350px;
                 color: #fff;
                 background: #252525;
                 text-transform: uppercase;
                 padding: 15px 25px 14px 25px;
                 display: block;
                 text-align: center;
                 margin-top: 20px;
             }

             .checkout ul li span {
                 float: right;
             }

             .cart .table {
                 margin-bottom: 30px;
                 border-bottom: 1px solid #fff;
             }

             .cart .table thead tr th {
                 border-top: 0px;
                 font-size: 16px;
                 font-weight: bold;
                 border-bottom: 0px;
             }

             .cart .table thead tr td {
                 padding-top: 30px;
                 padding-bottom: 30px;
                 vertical-align: middle;
                 align-self: center;
             }

             .cart .table tbody tr td .main .d-flex {
                 padding-right: 30px;
             }

             .cart .table tbody tr td .main .d-flex img {
                 border: 2px solid #000;
                 border-radius: 3px;
             }

             .cart .table tbody tr td .main .des {
                 vertical-align: middle;
                 align-self: center;
             }

             .cart .table tbody tr td .main .des p {
                 margin-bottom: 0px;
             }

             .cart .table tbody tr td h6 {
                 font-size: 16px;
                 color: #000;
                 margin-bottom: 0px;
             }

             .cart .table tbody tr td .counter {
                 margin-bottom: 0px;
             }

             .counter i {
                 border: 1px solid #000;
                 padding: 7px;
                 display: inline-block;
                 position: relative;
             }

             .cart .table tbody tr td .counter input {
                 width: 100px;
                 padding-left: 30px;
                 height: 40px;
                 outline: none;
                 box-shadow: none;
             }
         </style>
     @endpush

     @push('js')
         <script>
             $('.buttons_added .minus').click(function() {
                 var quantity = parseInt($(this).parent().find('.qty').val());
                 if (quantity > 1) {
                     $(this).parent().find('.qty').val(--quantity);
                     updateQuantity($(this).parent().find('.qty'));
                 }
                 updateTotal();
             });


             $('.buttons_added .plus').click(function() {
                 var quantity = parseInt($(this).parent().find('.qty').val());
                 $(this).parent().find('.qty').val(++quantity);
                 updateQuantity($(this).parent().find('.qty'));
                 updateTotal();

             });

             // change quantity

             $('.qty').on('change', function(e) {
                 updateQuantity($(this));
                 updateTotal();
             });

             function updateQuantity(inputElement) {

                 var quantity = inputElement.val();
                 var cartId = inputElement.data('id');

                 $.ajax({
                     url: '/cart/' + cartId,
                     method: 'PUT',
                     data: {
                         _token: '{{ csrf_token() }}',
                         quantity: quantity
                     },
                 });
             }

             function updateTotal() {
                 let price = $('span.price').data('price')
                 console.log(price);

                 let quantity = parseInt($('.qty').val())
                 console.log(quantity);
                 $('.price').text(price * quantity)
             }


             // remove item
             $('.remove-item').on('click', function(e) {

                 let id = $(this).data('id');
                 $.ajax({
                     url: '/cart/' + id,
                     method: 'DELETE',
                     data: {
                         _token: '{{ csrf_token() }}'
                     },
                     success: () => {
                         $(`#${id}`).remove();
                     }
                 });
             })
         </script>
     @endpush
 </x-layout>
