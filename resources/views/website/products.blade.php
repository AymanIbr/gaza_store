<x-layout title="Products">


    <!-- ***** Main Banner Area Start ***** -->
    <div class="page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2>Check Our Products</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->


    <!-- ***** Products Area Starts ***** -->
    <section class="section" id="products">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2>Our Latest Products</h2>
                        <span>Check out all of our products.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">

                @foreach ($products as $product)
                <div class="col-lg-4">

                    @include('website.parts.item')

                </div>
                @endforeach

                <div class="col-lg-12">
                    <div class="page-links">
                        {{ $products->links() }}
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ***** Products Area Ends ***** -->







</x-layout>
