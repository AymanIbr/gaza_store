<x-layout title="Checkout">






    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('site.index') }}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Checkout</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                <form action="{{ route('site.checkout') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                {{-- <x-form.input class="form-control" type="text" name="addr[billing][first_name]" --}}
                                {{-- placeholder="First Name" /> --}}
                                <input type="text"
                                    class="form-control @error('addr.billing.first_name') is-invalid @enderror"
                                    name="addr[billing][first_name]" value="{{ old('addr.billing.first_name') }}"
                                    placeholder="First Name">
                                @error('addr.billing.first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input type="text"
                                    class="form-control @error('addr.billing.last_name') is-invalid @enderror"
                                    name="addr[billing][last_name]" value="{{ old('addr.billing.last_name') }}"
                                    placeholder="Last Name">
                                @error('addr.billing.last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input type="email"
                                    class="form-control @error('addr.billing.email') is-invalid @enderror"
                                    name="addr[billing][email]" value="{{ old('addr.billing.email') }}"
                                    placeholder="example@gmail.com">
                                @error('addr.billing.email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input type="text"
                                    class="form-control @error('addr.billing.phone') is-invalid @enderror"
                                    name="addr[billing][phone]" value="{{ old('addr.billing.phone') }}"
                                    placeholder="Phone">
                                @error('addr.billing.phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Mailing Address</label>
                                {{-- <input class="form-control" name="addr[billing][street_address]" type="text" --}}
                                {{-- placeholder="123 Street" /> --}}
                                <input type="text"
                                    class="form-control @error('addr.billing.street_address') is-invalid @enderror"
                                    name="addr[billing][street_address]"
                                    value="{{ old('addr.billing.street_address') }}" placeholder="Street Address">
                                @error('addr.billing.street_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                {{-- <x-form.select class="custom-select" name="addr[billing][country]" :options="$countries" placeholder="Country" /> --}}
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select name="addr[billing][country]"
                                        class="form-control custom-select @error('addr[billing][country]') is-invalid @enderror">
                                        <option value="" selected>Country</option>
                                        @foreach ($countries as $code => $name)
                                            <option value="{{ $code }}"
                                                {{ old('addr.billing.country') == $code ? 'selected' : '' }}>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('addr[billing][country]')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input type="text"
                                    class="form-control @error('addr.billing.city') is-invalid @enderror"
                                    name="addr[billing][city]" value="{{ old('addr.billing.city') }}"
                                    placeholder="City">
                                @error('addr.billing.city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input type="text"
                                    class="form-control @error('addr.billing.state') is-invalid @enderror"
                                    name="addr[billing][state]" value="{{ old('addr.billing.state') }}"
                                    placeholder="State">
                                @error('addr.billing.state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Postal Code</label>
                                <input type="text"
                                    class="form-control @error('addr.billing.postal_code') is-invalid @enderror"
                                    name="addr[billing][postal_code]" value="{{ old('addr.billing.postal_code') }}"
                                    placeholder="Postal code">
                                @error('addr.billing.postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="col-md-12 form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="newaccount">
                                    <label class="custom-control-label" for="newaccount">Create an account</label>
                                </div>
                            </div> --}}
                            <div class="col-md-12 form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="shipto">
                                    <label class="custom-control-label" for="shipto" data-toggle="collapse"
                                        data-target="#shipping-address">Ship to different address</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collapse mb-4" id="shipping-address">
                        <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                {{-- <x-form.input class="form-control" type="text" name="addr[billing][first_name]" --}}
                                {{-- placeholder="First Name" /> --}}
                                <input type="text"
                                    class="form-control @error('addr.shipping.first_name') is-invalid @enderror"
                                    name="addr[shipping][first_name]" value="{{ old('addr.shipping.first_name') }}"
                                    placeholder="First Name">
                                @error('addr.shipping.first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input type="text"
                                    class="form-control @error('addr.shipping.last_name') is-invalid @enderror"
                                    name="addr[shipping][last_name]" value="{{ old('addr.shipping.last_name') }}"
                                    placeholder="Last Name">
                                @error('addr.shipping.last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input type="email"
                                    class="form-control @error('addr.shipping.email') is-invalid @enderror"
                                    name="addr[shipping][email]" value="{{ old('addr.shipping.email') }}"
                                    placeholder="example@gmail.com">
                                @error('addr.shipping.email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input type="text"
                                    class="form-control @error('addr.shipping.phone') is-invalid @enderror"
                                    name="addr[shipping][phone]" value="{{ old('addr.shipping.phone') }}"
                                    placeholder="Phone">
                                @error('addr.shipping.phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Mailing Address</label>
                                <input type="text"
                                    class="form-control @error('addr.shipping.street_address') is-invalid @enderror"
                                    name="addr[shipping][street_address]"
                                    value="{{ old('addr.shipping.street_address') }}" placeholder="Street Address">
                                @error('addr.shipping.street_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                {{-- <x-form.select class="custom-select" name="addr[billing][country]" :options="$countries" placeholder="Country" /> --}}
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <select name="addr[shipping][country]"
                                        class="form-control custom-select @error('addr[shipping][country]') is-invalid @enderror">
                                        <option value="" selected>Country</option>
                                        @foreach ($countries as $code => $name)
                                            <option value="{{ $code }}"
                                                {{ old('addr.shipping.country') == $code ? 'selected' : '' }}>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('addr[shipping][country]')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>

                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input type="text"
                                    class="form-control @error('addr.shipping.city') is-invalid @enderror"
                                    name="addr[shipping][city]" value="{{ old('addr.shipping.city') }}"
                                    placeholder="City">
                                @error('addr.shipping.city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input type="text"
                                    class="form-control @error('addr.shipping.state') is-invalid @enderror"
                                    name="addr[shipping][state]" value="{{ old('addr.shipping.state') }}"
                                    placeholder="Postal code">
                                @error('addr.shipping.state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Postal Code</label>
                                <input type="text"
                                    class="form-control @error('addr.shipping.postal_code') is-invalid @enderror"
                                    name="addr[shipping][postal_code]" value="{{ old('addr.shipping.postal_code') }}"
                                    placeholder="Postal code">
                                @error('addr.shipping.postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="col-md-12 form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="newaccount">
                                    <label class="custom-control-label" for="newaccount">Create an account</label>
                                </div>
                            </div> --}}
                        </div>


                    </div>
                    <button type="submit" class="btn btn-info rounded-sm">pay now</button>
                </form>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Pricing Table</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Subtotal Price</h6>
                            <h6 class="font-weight-medium">{{ Currency::format($cart->total()) }}</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Subtotal Price</h6>
                            <h6 class="font-weight-medium">$150</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Subtotal Price</h6>
                            <h6 class="font-weight-medium">$150</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">{{ Currency::format($cart->total()) }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                                <label class="custom-control-label" for="directcheck">Direct Check</label>
                            </div>
                        </div>
                        <div class="">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place
                            Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->








    @push('css')
        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
            rel="stylesheet">
        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('che/css/style.css') }}" rel="stylesheet">
    @endpush



</x-layout>
