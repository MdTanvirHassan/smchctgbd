@extends('frontend.modern.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">{{ __('routine.page_title') }}</h1>
    </div>
</section>
<!-- ✅ Routine -->
<section class="routine-section my-5">
    <div class="container px-4 py-2 bg-white rounded shadow-lg">
        <div class="col-md-12">
            <div class="routine-wraper">
                <h1  class="text-center" style="margin: 50px  0 0px 0;">{{ __('routine.class_routine') }}</h1>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" style="font-size:18px; text-align:center;">
                    <thead class="background">
                        <tr>
                            <th class="text-center">৬ষ্ঠ শ্রেণির রুটিন</th>
                            <th class="text-center">৭ম শ্রেণির রুটিন</th>
                            <th class="text-center">৮ম শ্রেণির রুটিন</th>
                            <th class="text-center">৯ম শ্রেণির রুটিন</th>
                            <th class="text-center">১০ম শ্রেণির রুটিন</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center"><i class="fa fa-download" aria-hidden="true"></i> <a
                                    href="">{{ __('routine.download') }}</a> </th>
                            <td><i class="fa fa-download" aria-hidden="true"></i> <a href="">{{ __('routine.download') }}</a> </td>
                            <td><i class="fa fa-download" aria-hidden="true"></i> <a href="">{{ __('routine.download') }}</a> </td>
                            <td><i class="fa fa-download" aria-hidden="true"></i> <a href="">{{ __('routine.download') }}</a> </td>
                            <td><i class="fa fa-download" aria-hidden="true"></i> <a href="">{{ __('routine.download') }}</a> </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="routine-wraper">
                <h1 class="text-center" style="margin: 50px  0 0px 0;"> {{ __('routine.exam_routine') }} </h1>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" style="font-size:18px; text-align:center;">
                    <thead style="background-color: #008ccd; color: #fff; height: 50px;">
                        <tr>
                            <th class="text-center">৬ষ্ঠ শ্রেণির রুটিন</th>
                            <th class="text-center">৭ম শ্রেণির রুটিন</th>
                            <th class="text-center">৮ম শ্রেণির রুটিন</th>
                            <th class="text-center">৯ম শ্রেণির রুটিন</th>
                            <th class="text-center">১০ম শ্রেণির রুটিন</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center"><i class="fa fa-download" aria-hidden="true"></i> <a
                                    href="">{{ __('routine.download') }}</a> </th>
                            <td><i class="fa fa-download" aria-hidden="true"></i> <a href="">{{ __('routine.download') }}</a> </td>
                            <td><i class="fa fa-download" aria-hidden="true"></i> <a href="">{{ __('routine.download') }}</a> </td>
                            <td><i class="fa fa-download" aria-hidden="true"></i> <a href="">{{ __('routine.download') }}</a> </td>
                            <td><i class="fa fa-download" aria-hidden="true"></i> <a href="">{{ __('routine.download') }}</a> </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection