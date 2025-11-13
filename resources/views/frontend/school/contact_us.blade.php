@extends('frontend.school.layouts.app')

@section('content')
    <!-- ✅ Contact Us -->
    <section class="contact-us-section">
        <div class="container shadow-bg p-4 mt-5 mb-5 bg-light rounded">
            <h1>যোগাযোগ</h1>

            <div class="row">
                <!-- Location -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="contact-item">
                        <img src="{{ asset('/public/assets/icons/location.png') }}" class="img-hover" alt="Location Icon" />
                        <h3>Our Location</h3>
                        <p class="subtitle">
                            {{ get_setting('school_address', 'Mirpur-12, Dhaka') }}
                        </p>
                    </div>
                </div>

                <!-- Call Us -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="contact-item">
                        <img src="{{ asset('/public/assets/icons/call.png') }}" class="img-hover" alt="Call Icon" />
                        <h3>CALL US</h3>
                        <p class="subtitle">
                            ইমেইল :
                            <a href="">
                                {{ get_setting('school_email') }}
                            </a>
                        </p>
                        <p class="subtitle">
                            নম্বর :
                            {{ get_setting('school_phone') }}
                        </p>


                        <!-- <div id="tooltip-modal">
                                                                                            <div class="tooltip-content">
                                                                                                <img src="" alt="Payment QR" />
                                                                                            </div>
                                                                                        </div> -->
                    </div>
                </div>

                <!-- Working Hours -->
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="contact-item">
                        <img src="{{ asset('/public/assets/icons/watch.png') }}" class="img-hover"
                            alt="Working Hours Icon" />
                        <h3>Working Hours</h3>
                        <!-- <p class="subtitle">
                                            <span class='items'>
                                                Sat-Thurs: 8AM to 6PM
                                            </span><br>
                                            <span class='items'>Off Day:</span>
                                            Friday
                                        </p> -->
                        <!-- <p class="subtitle">
                                                                                            <span class='items'>Off Day:</span>
                                                                                            Friday
                                                                                        </p> -->
                    </div>
                </div>
            </div>

            <!-- Google Map -->
            <!-- <div class="mt-4">
                                                                                <iframe allowfullscreen height="450" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src=""
                                                                                    style="border: 0; width: 100%;"></iframe>
                                                                            </div> -->
        </div>
    </section>

@endsection