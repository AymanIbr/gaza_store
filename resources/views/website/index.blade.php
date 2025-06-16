<x-layout title="Home">

    <!-- ***** Main Banner Area Start ***** -->
    <div class="main-banner" id="top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-content">
                        <div class="thumb">
                            <div class="inner-content">
                                <h4>We Are Hexashop</h4>
                                <span>Awesome, clean &amp; creative HTML5 Template</span>
                                <div class="main-border-button">
                                    <a href="{{ route('site.products') }}">Purchase Now!</a>
                                </div>
                            </div>
                            <img src="{{ asset('website/assets/images/left-banner-image.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-content">
                        <div class="row">
                            @foreach ($categories as $category)
                                <div class="col-lg-6">
                                    <div class="right-first-image">
                                        <div class="thumb">
                                            <div class="inner-content">
                                                <h4>{{ $category->trans_name }}</h4>
                                                <span>{{ $category->trans_description }}</span>
                                            </div>
                                            <div class="hover-content">
                                                <div class="inner">
                                                    <h4>{{ $category->trans_name }}</h4>
                                                    <p>{{ $category->trans_description }}</p>
                                                    <div class="main-border-button">
                                                        <a href="{{ route('site.category', $category->slug) }}">Discover
                                                            More</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <img src="{{ asset('storage/' . $category->image->path) }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    @foreach ($categories as $category)
        <section class="section" id="men">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="section-heading">
                            <h2>{{ $category->trans_name }} Latest</h2>
                            <span>{{ $category->trans_description }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="men-item-carousel">
                            <div class="owl-men-item owl-carousel">
                                @foreach ($category->products as $product)
                                    @include('website.parts.item')
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                @if ($productView->isNotEmpty())
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-heading">
                                <h2>Recently Viewed</h2>
                            </div>
                            <div class="men-item-carousel">
                                <div class="owl-men-item owl-carousel">
                                    @foreach ($productView as $view)
                                        @if ($view->product)
                                            @include('website.parts.item', ['product' => $view->product])
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

        </div>

        </div>
    </section>
@endforeach

</x-layout>
