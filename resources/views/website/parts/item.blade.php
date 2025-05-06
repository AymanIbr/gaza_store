
<div class="item">
    <div class="thumb">
        <div class="hover-content">
            <ul>
                <li><a href="{{ route('site.product_single',$product->slug) }}"><i class="fa fa-eye"></i></a></li>
                <li><a href="single-product.html"><i class="fa fa-star"></i></a></li>
                <li><a href="single-product.html"><i class="fa fa-shopping-cart"></i></a></li>
            </ul>
        </div>
        <img src="{{ asset('storage/'. $product->image->path) }}" alt="">
    </div>
    <div class="down-content">
        <h4><a href="{{ route('site.product_single',$product->slug) }}">{{ $product->trans_name }}</a></h4>
        <span>${{ $product->price }}</span>
        <ul class="stars">
            <li><i class="fa fa-star"></i></li>
            <li><i class="fa fa-star"></i></li>
            <li><i class="fa fa-star"></i></li>
            <li><i class="fa fa-star"></i></li>
            <li><i class="fa fa-star"></i></li>
        </ul>
    </div>
</div>
