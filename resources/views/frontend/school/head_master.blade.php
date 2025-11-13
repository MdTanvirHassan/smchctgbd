@extends('frontend.school.layouts.app')

@section('content')

    <!-- ✅ Header Master -->
    <section class="head-master-section container my-5">
        <div class="row principal-message">
            <div class="col-md-4 principal-photo">
                <img src="{{asset(get_setting('headmaster_image'))}}" alt="Principal Photo">
                <div class="text-center mt-3 social-icons">
                    <!-- <i class="fab fa-facebook"></i>
                                                        <i class="fab fa-twitter"></i>
                                                        <i class="fab fa-instagram"></i>
                                                        <i class="fab fa-linkedin"></i> -->
                </div>
            </div>
            <div class="col-md-8">
                <div class="principal-name">নাম: {{get_setting('headmaster_name')}}</div>
                <div class="principal-title mb-2">{{get_setting('headmaster_designation')}}</div>
                <div class="principal-school">{{ get_setting('school_name') }}</div>
                <div class="principal-title mt-2">নাম্বার : {{ get_setting('headmaster_phone') }}</div>
                <div class="principal-title mt-2">মেইল : {{ get_setting('headmaster_email') }}</div>
                <div class="quote-text">
                    {{get_setting('headmaster_speech')}}
                </div>
            </div>
        </div>
    </section>

@endsection