<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassRoutine;
use App\Models\Committee;
use App\Models\Content;
use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use App\Models\Teacher;
use App\Models\ClassResult;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * 
     * 
     */

    public function index()
    {
        $important_notices = Content::getLatestPublished('important_notice');
        $notices = Content::getLatestPublished('notice');
        $faqs = Content::getLatestPublished('faq');
        $officiallinks = Content::getLatestPublished('link');
        $files = Content::getLatestPublished('file');
        $importantinformationlinks = Content::getLatestPublished('important_information_link');

        $teachers = Teacher::all();
        $committees = Committee::all();


        return view('frontend.' . get_setting('template_name') . '.landing_page', compact('important_notices', 'notices', 'faqs', 'teachers', 'committees', 'officiallinks', 'importantinformationlinks', 'files'));
    }

    // Head Page  
    public function head_master()
    {
        return view('frontend.' . get_setting('template_name') . '.head_master');
    }

    // Teachers Page  
    public function teacher_team()
    {
        $teachers = Teacher::all();
        return view('frontend.' . get_setting('template_name') . '.teacher_team', compact('teachers'));
    }

    // Committees Page  
    public function managing_committee()
    {
        $committees = Committee::all();
        return view('frontend.' . get_setting('template_name') . '.managing_committee', compact('committees'));
    }

    // Total Student Page  
    public function total_students()
    {
        return view('frontend.' . get_setting('template_name') . '.total_students');
    }

    // Class Summery Page  
    public function class_summery()
    {
        return view('frontend.' . get_setting('template_name') . '.class_summery');
    }

    // Admission Info Page  
    public function admission_info()
    {
        return view('frontend.' . get_setting('template_name') . '.admission_info');
    }

    // Routine Page  
    public function routine()
    {
        $classes = Classes::all();
        $classroutines = ClassRoutine::where('type', 'class')->where('is_active', 1)->get();
        $examroutines = ClassRoutine::where('type', 'exam')->where('is_active', 1)->get();
        return view('frontend.' . get_setting('template_name') . '.routine', compact('classes', 'classroutines', 'examroutines'));
    }

    // Exam Result Page  
    public function exam_result()
    {
        $classes = Classes::all();
        $classresults = ClassResult::where('is_active', 1)->get();
        return view('frontend.' . get_setting('template_name') . '.exam_result', compact('classresults', 'classes'));
    }

    // Notice Page  
    public function notice()
    {
        $notices = Content::where('type', 'notice')->where('is_published', 1)->get();
        return view('frontend.' . get_setting('template_name') . '.notice', compact('notices'));
    }

    // Event Page  
    public function event()
    {
        $events = Content::where('type', 'event')->where('is_published', 1)->get();

        return view('frontend.' . get_setting('template_name') . '.event', compact('events'));
    }

    // Image Gallery Page  
    public function image_category()
    {
        $categories = GalleryCategory::all();
        return view('frontend.' . get_setting('template_name') . '.image_category', compact('categories'));
    }
    // Image Gallery Page  
    public function image_gallery($id)
    {
        $galleries = GalleryImage::where('category_id', $id)->get();
        $name = GalleryCategory::where('id', $id)->first(['name']);
        return view('frontend.' . get_setting('template_name') . '.image_gallery', compact('galleries', 'name'));
    }

    // Contact Us Page  
    public function contact_us()
    {
        return view('frontend.' . get_setting('template_name') . '.contact_us');
    }

}
