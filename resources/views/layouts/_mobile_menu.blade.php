<div class="mobile-menu-container mobile-menu-light">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-close"></i></span>

        <form action="#" method="get" class="mobile-search">
            <label for="mobile-search" class="sr-only">Search</label>
            <input type="search" class="form-control" name="mobile-search" id="mobile-search" placeholder="Search in..."
                required>
            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
        </form>

        <ul class="nav nav-pills-mobile nav-border-anim" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="mobile-menu-link" data-toggle="tab" href="#mobile-menu-tab"
                    role="tab" aria-controls="mobile-menu-tab" aria-selected="true">Menu</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="mobile-menu-tab" role="tabpanel"
                aria-labelledby="mobile-menu-link">
                <nav class="mobile-nav">
                    <ul class="mobile-menu">
                        <li class="{{ Request::segment(1) == '' ? 'active' : '' }}">
                            <a href="{{ url('') }}">Home</a>
                        </li>

                        @php
                            $categories_m = App\Models\CategoryModel::getCategories();
                        @endphp
                        @foreach ($categories_m as $category_m)
                            @if (!empty($category_m->getCategorySubCategories->count()))
                                <li>
                                    <a href="{{ url($category_m->slug) }}">{{ $category_m->name }}</a>
                                    <ul>
                                        @foreach ($category_m->getCategorySubCategories as $p_s_c_m)
                                            <li><a
                                                    href="{{ $category_m->slug . '/' . $p_s_c_m->slug }}">{{ ucfirst($p_s_c_m->name) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach

                        <li>
                            <a href="{{ url('about') }}" class="">About Us</a>
                        </li>
                        <li>
                            <a href="{{ url('blog') }}">Blog</a>
                        </li>
                        <li>
                            <a href="{{ url('contact') }}">Contact Us</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="social-icons">
            <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
        </div>
    </div>
</div>
