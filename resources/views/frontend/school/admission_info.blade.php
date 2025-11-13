@extends('frontend.school.layouts.app')

@section('content')

    <!-- ✅ Admission Information -->
    <section class="admission-info-section">
        <div class="container admission-section">
            <div class="admission-title">ভর্তি তথ্য</div>

            <div class="admission-content">
                <p>
                    {{ get_setting('admission_description') }}
                </p>
                <p><strong>ফরম মূল্য :</strong> {{ get_setting('monthly_fee') }}<br><strong>ভর্তি ফি
                        :</strong>{{ get_setting('admission_fee') }}</p>

                <div class="principal-signature">
                    <strong>{{get_setting('headmaster_name')}}</strong>
                    {{get_setting('headmaster_designation')}}<br>
                    {{ get_setting('school_name') }}<br>
                </div>
            </div>

            <div class="form-img">
                <img src="{{ get_setting('admission_form_image') }}" alt="Student Application Form">
            </div>
            <div class="apply-btn">
                <!-- <a href="#" class="btn btn-success btn-lg mt-3">ভর্তি ফরম পূরণ করুন</a> -->
            </div>
        </div>

    </section>

@endsection