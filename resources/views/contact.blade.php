@extends('layouts.app')

@section('content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                </ol>
            </div>
        </nav>

        <div class="page-content pb-0">
            <div class="container">
                <div class="row bg-white p-3 border-radius pt-lg-5">
                    <div class="col-lg-6 mb-2 mb-lg-0">
                        <h2 class="title mb-1">Contact Information</h2>
                        <p class="mb-3">
                            Welecome to <strong>{{ config('siteconfig.sitename') }}</strong> your number one online stop
                            shop.
                            We value your feedback. Incase of any quaries feel free to contact our customer care through:
                        </p>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="contact-info">
                                    <h3>Our Shop Contacts</h3>

                                    <ul class="contact-list">
                                        <li>
                                            <i class="icon-map-marker"></i>
                                            {{ config('siteconfig.contacts.location') }}
                                        </li>
                                        <li>
                                            <i class="icon-phone"></i>
                                            <a href="tel:#">{{ config('siteconfig.contacts.phone') }}</a>
                                        </li>
                                        <li>
                                            <i class="icon-envelope"></i>
                                            <a
                                                href="mailto:{{ config('siteconfig.contacts.email.contact') }}">{{ config('siteconfig.contacts.email.contact') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="contact-info">
                                    <h3>Working Hours</h3>

                                    <ul class="contact-list">
                                        <li>
                                            <i class="icon-clock-o"></i>
                                            <span class="text-dark">Monday-Saturday</span> <br>8.00am - 8.00pm EAT
                                        </li>
                                        <li>
                                            <i class="icon-calendar"></i>
                                            <span class="text-dark">Sunday</span> <br>8.00am - 5.00pm EAT
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">

                        <h2 class="title mb-1">Got Any Questions?</h2>
                        <p class="mb-2">Use the form below to get in touch with the sales team</p>
                        @include('layouts._message')

                        <form action="" method="POST" class="contact-form mb-3">
                            <div class="row">
                                {{ csrf_field() }}
                                <div class="col-sm-6">
                                    <label for="cname" class="sr-only">Name</label>
                                    <input type="text" name="name"
                                        class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="cname"
                                        placeholder="Name *" required>
                                </div>

                                <div class="col-sm-6">
                                    <label for="cemail" class="sr-only">Email</label>
                                    <input type="email" name="email"
                                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="cemail"
                                        placeholder="Email *" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="cphone" class="sr-only">Phone</label>
                                    <input type="tel" name="phone"
                                        class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="cphone"
                                        placeholder="Phone">
                                </div>

                                <div class="col-sm-6">
                                    <label for="csubject" class="sr-only">Subject</label>
                                    <input type="text" name="subject"
                                        class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}"
                                        id="csubject" placeholder="Subject" required>
                                </div>
                            </div>

                            <label for="cmessage" class="sr-only">Message</label>
                            <textarea name="message" class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" cols="30"
                                rows="4" id="cmessage" placeholder="Message *" required></textarea>
                            <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                <span>SUBMIT</span> <i class="icon-long-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="row bg-white p-3 border-radius mt-4 mb-4">
                    <div class="stores mb-4 mb-lg-5 mt-lg-2">
                        <h2 class="title text-center mb-3">Our Stores</h2>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="store">
                                    <div class="row">
                                        <div class="col-sm-5 col-xl-6">
                                            <figure class="store-media mb-2 mb-lg-0">
                                                <img src="{{ url('assets/front/images/stores/img-1.jpg') }}"
                                                    alt="image">
                                            </figure>
                                        </div>
                                        <div class="col-sm-7 col-xl-6">
                                            <div class="store-content">
                                                <h3 class="store-title">Wall Street Plaza</h3>
                                                <address>88 Pine St, New York, NY 10005, USA</address>
                                                <div><a href="tel:#">+1 987-876-6543</a></div>

                                                <h4 class="store-subtitle">Store Hours:</h4>
                                                <div>Monday - Saturday 11am to 7pm</div>
                                                <div>Sunday 11am to 6pm</div>

                                                <a href="#" class="btn btn-link" target="_blank"><span>View
                                                        Map</span><i class="icon-long-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="store">
                                    <div class="row">
                                        <div class="col-sm-5 col-xl-6">
                                            <figure class="store-media mb-2 mb-lg-0">
                                                <img src="{{ url('assets/front/images/stores/img-2.jpg') }}"
                                                    alt="image">
                                            </figure>
                                        </div>

                                        <div class="col-sm-7 col-xl-6">
                                            <div class="store-content">
                                                <h3 class="store-title">One New York Plaza</h3>
                                                <address>88 Pine St, New York, NY 10005, USA</address>
                                                <div><a href="tel:#">+1 987-876-6543</a></div>

                                                <h4 class="store-subtitle">Store Hours:</h4>
                                                <div>Monday - Friday 9am to 8pm</div>
                                                <div>Saturday - 9am to 2pm</div>
                                                <div>Sunday - Closed</div>

                                                <a href="#" class="btn btn-link" target="_blank"><span>View
                                                        Map</span><i class="icon-long-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="map"></div>
        </div>
    </main>
@endsection
