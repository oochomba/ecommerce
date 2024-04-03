<header class="header header-intro-clearance header-4">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <a href="tel:#" class="mr-3"><i class="icon-phone"></i>Call: +0123 456 789</a>

                <a href="mailto:{{ config('siteconfig.contacts.email.contact') }}"><i
                        class="icon-envelope"></i>{{ config('siteconfig.contacts.email.contact') }}</a>
            </div>

            <div class="header-right">

                <ul class="top-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <li>
                                <div class="header-dropdown">
                                    <a href="#">KES</a>
                                    <div class="header-menu">
                                        <ul>
                                            <li><a href="#">KES</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="header-dropdown">
                                    <a href="#">English</a>
                                    <div class="header-menu">
                                        <ul>
                                            <li><a href="#">English</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            @if (!empty(Auth::guard('customer')->check()))
                                <li><a href="{{ url('logout') }}"><i class="icon-user"></i> Logout</a></li>
                            @else
                                <li><a href="#signin-modal" data-toggle="modal">Sign in / Sign up</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{ url('') }}" class="logo">
                    <img src="{{ url('assets/front/images/demos/demo-4/logo.png') }}" alt="Molla Logo" width="105"
                        height="25">
                </a>
            </div>

            <div class="header-center">
                <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                    <form action="{{ url('search') }}" method="get">
                        <div class="header-search-wrapper search-wrapper-wide">
                            <label for="q" class="sr-only">Search</label>
                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                            <input type="search" class="form-control" name="q" id="q"
                                placeholder="Search product ..."
                                value="{{ !empty(Request::get('q')) ? Request::get('q') : '' }}" required>
                        </div>
                    </form>
                </div>
            </div>

            <div class="header-right">

                <div class="wishlist">
                    <a href="wishlist.html" title="Wishlist">
                        <div class="icon">
                            <i class="icon-heart-o"></i>
                            <span class="wishlist-count badge">3</span>
                        </div>
                        <p>Wishlist</p>
                    </a>
                </div>

                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" data-display="static">
                        <div class="icon">
                            <i class="icon-shopping-cart"></i>
                            <span class="cart-count">{{ Cart::getContent()->count() }}</span>
                        </div>
                        <p>Cart</p>
                    </a>

                    @if (!Cart::isEmpty())
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-cart-products">
                                @foreach (Cart::getContent() as $header_cart)
                                    @php
                                        $getCartProduct = App\Models\ProductModel::getSingle($header_cart->id);
                                        $productImageCart = $getCartProduct->getImageSingle($header_cart->id);
                                    @endphp
                                    @if (!empty($getCartProduct))
                                        <div class="product">
                                            <div class="product-cart-details">
                                                <h4 class="product-title">
                                                    <a
                                                        href="{{ $getCartProduct->slug }}">{{ $getCartProduct->title }}</a>
                                                </h4>

                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty">{{ $header_cart->quantity }}</span>
                                                    x KES {{ number_format($header_cart->price, 2) }}
                                                </span>
                                            </div>

                                            <figure class="product-image-container">
                                                <a href="{{ $getCartProduct->slug }}" class="product-image">
                                                    <img src="{{ $productImageCart->getImageInfo() }}"
                                                        style="height: 60px;  width: 60px; object-fit: cover;"
                                                        alt="product">
                                                </a>
                                            </figure>
                                            <a href="{{ url('delete-cart-item/' . $header_cart->id) }}"
                                                class="btn-remove cursor-pointer" title="Remove Product"><i
                                                    class="icon-close"></i></a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="dropdown-cart-total">
                                <span>Total</span>

                                <span class="cart-total-price">KES {{ number_format(Cart::getSubTotal(), 2) }}</span>
                            </div>

                            <div class="dropdown-cart-action">
                                <a href="{{ url('cart') }}" class="btn btn-primary">View Cart</a>
                                <a href="{{ url('checkout') }}"
                                    class="btn btn-outline-primary-2"><span>Checkout</span><i
                                        class="icon-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <div class="header-bottom sticky-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto col-lg-3 col-xl-3 col-xxl-2 header-left">
                    @php
                        $categories = App\Models\CategoryModel::getCategories();
                    @endphp
                    <div class="dropdown category-dropdown show is-on" data-visible="true">
                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" data-display="static"
                            title="Browse Categories">
                            Browse Categories
                        </a>

                        <div class="dropdown-menu show">
                            <nav class="side-nav">
                                <ul class="menu-vertical sf-arrows">
                                    @foreach ($categories as $category)
                                        @if (!empty($category->getCategorySubCategories->count()))
                                            <li class="megamenu-container">
                                                <a class="sf-with-ul" href="{{ url($category->slug) }}"><i
                                                        class="icon-laptop"></i>{{ ucwords($category->name) }}</a>

                                                <div class="megamenu">
                                                    <div class="row no-gutters">
                                                        <div class="col-md-12">
                                                            <div class="menu-col">
                                                                <div class="row">
                                                                    @foreach ($category->getCategorySubCategories as $p_s_c)
                                                                        @if (!empty($p_s_c->getSubCategorySubCategories->count()))
                                                                            <div class="col-md-4">

                                                                                <div class="menu-title">
                                                                                    <a
                                                                                        href="{{ url($category->slug . '/' . $p_s_c->slug) }}">{{ ucwords($p_s_c->name) }}</a>
                                                                                </div>
                                                                                <ul>
                                                                                    @foreach ($p_s_c->getSubCategorySubCategories as $p_s_s_c)
                                                                                        <li>
                                                                                            <a
                                                                                                href="{{ url($category->slug . '/' . $p_s_c->slug . '/' . $p_s_s_c->slug) }}">
                                                                                                {{ $p_s_s_c->name }}
                                                                                            </a>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="col col-lg-6 col-xl-6 col-xxl-8 header-center">
                    <nav class="main-nav">
                        <ul class="menu sf-arrows">
                            <li class="{{ Request::segment(1) == '' ? 'active' : '' }}">
                                <a href="{{ url('') }}">Home</a>
                            </li>
                            <li class="{{ Request::segment(1) == 'shop' ? 'active' : '' }}">
                                <a href="{{ url('shop') }}" class="sf-with-ul">Shop</a>

                                <div class="megamenu megamenu-md">
                                    <div class="row no-gutters">
                                        <div class="col-md-12">
                                            <div class="menu-col">
                                                <div class="row">

                                                    @foreach ($categories as $category)
                                                        @if (!empty($category->getCategorySubCategories->count()))
                                                            <div class="col-md-4">
                                                                <a href="{{ url($category->slug) }}"
                                                                    class="menu-title">{{ $category->name }}</a>
                                                                <ul>
                                                                    @foreach ($category->getCategorySubCategories as $p_s_c)
                                                                        @if (!empty($p_s_c->getSubCategorySubCategories->count()))
                                                                            <li><a
                                                                                    href="{{ url($category->slug . '/' . $p_s_c->slug) }}">{{ ucwords($p_s_c->name) }}</a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    @endforeach


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <a href="{{ url('about') }}" class="">About Us</a>
                            </li>
                            <li>
                                <a href="{{ url('blog') }}">Blog</a>
                            </li>
                            <li class="{{ Request::segment(1) == 'contact' ? 'active' : '' }}">
                                <a href="{{ url('contact') }}">Contact Us</a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <div class="col col-lg-3 col-xl-3 col-xxl-2 header-right">
                    <i class="la la-lightbulb-o"></i>
                    <p>Clearance Up to 30% Off</p>
                </div>
            </div>
        </div>
    </div>
</header>
