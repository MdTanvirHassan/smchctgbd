<?php

use App\Http\Controllers\ClassResultController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryImageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NoticeEventController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\VideoGalleryController;
use App\Http\Controllers\MBBSCOURSEController;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\InstallController;

Auth::routes();

Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');


Route::get('/install', [InstallController::class, 'showForm']);
Route::post('/install', [InstallController::class, 'install']);
Route::get('/update', [InstallController::class, 'update'])->name('system.update');


Route::get('/cache-clear', function () {
    Artisan::call('optimize:clear');
    return back()->with('success', 'Cache cleared successfully!');
})->name('cache');


Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');

    Route::get('/head_master', 'head_master')->name('head_master');
    Route::get('/teacher_team', 'teacher_team')->name('teacher_team');
    Route::get('/managing_committee', 'managing_committee')->name('managing_committee');
    Route::get('/governing_body', 'governing_body')->name('governing_body');
    Route::get('/total_students', 'total_students')->name('total_students');
    Route::get('/class_summery', 'class_summery')->name('class_summery');
    Route::get('/admission_info', 'admission_info')->name('admission_info');
    Route::get('/routine', 'routine')->name('routine');
    Route::get('/exam_result', 'exam_result')->name('exam_result');
    Route::get('/notice', 'notice')->name('notice');
    Route::get('/meeting_minutes', 'meetingMinutes')->name('meeting_minutes');
    Route::get('/event', 'event')->name('event');
    Route::get('/image-category', 'image_category')->name('image_category');
    Route::get('/image_gallery/{id}', 'image_gallery')->name('image_gallery');
    Route::get('/video-category', 'video_category')->name('video_category');
    Route::get('/video_gallery/{id}', 'video_gallery')->name('video_gallery');
    Route::get('/contact_us', 'contact_us')->name('contact_us');
    Route::get('/online_class_link', 'online_class_link')->name('online_class_link');
    Route::get('/mbbs-course-new-curriculum', 'mbbsCourseNewCurriculum')->name('mbbs_course_new_curriculum');
});

Route::controller(DashboardController::class)->group(function () {
    Route::post('/change-password', 'updatePassword')->name('change.password.update');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
});

Route::controller(NoticeEventController::class)->group(function () {

    // Important Notice routes
    Route::get('/dashboard/important-notice', 'importantNotice')->name('important.notice.index');
    Route::post('/dashboard/important-notice', 'importantNoticeStore')->name('important.notice.store');
    Route::put('/dashboard/important-notice-update/{id}', 'importantNoticeUpdate')->name('important.notice.update');
    Route::get('/dashboard/important-notice-status/{id}', 'importantNoticeStatus')->name('important.notice.status');
    Route::delete('/dashboard/important-notice/{id}', 'importantNoticeDestroy')->name('important.notice.destroy');


    // Notice routes
    Route::get('/dashboard/notice', 'notice')->name('notice.index');
    Route::post('/dashboard/notice', 'noticeStore')->name('notice.store');
    Route::put('/dashboard/notice-update/{id}', 'noticeUpdate')->name('notice.update');
    Route::get('/dashboard/notice-status/{id}', 'noticeStatus')->name('notice.status');
    Route::delete('/dashboard/notice/{id}', 'noticeDestroy')->name('notice.destroy');

    // Meeting & Minutes routes
    Route::get('/dashboard/meeting_minutes', 'meetingMinutes')->name('meeting_minutes.index');
    Route::post('/dashboard/meeting_minutes', 'meetingMinutesStore')->name('meeting_minutes.store');
    Route::put('/dashboard/meeting_minutes-update/{id}', 'meetingMinutesUpdate')->name('meeting_minutes.update');
    Route::get('/dashboard/meeting_minutes-status/{id}', 'meetingMinutesStatus')->name('meeting_minutes.status');
    Route::delete('/dashboard/meeting_minutes/{id}', 'meetingMinutesDestroy')->name('meeting_minutes.destroy');


    // Event routes
    Route::get('/dashboard/event', 'event')->name('event.index');
    Route::post('/dashboard/event', 'eventStore')->name('event.store');
    Route::put('/dashboard/event/{id}', 'eventUpdate')->name('event.update');
    Route::get('/dashboard/event-status/{id}', 'eventStatus')->name('event.status');
    Route::delete('/dashboard/event/{id}', 'eventDestroy')->name('event.destroy');

    // Officel routes
    Route::get('/dashboard/officiallink', 'officialLink')->name('officiallink.index');
    Route::post('/dashboard/officiallink', 'officialLinkStore')->name('officiallink.store');
    Route::put('/dashboard/officiallink/{id}', 'officialLinkUpdate')->name('officiallink.update');
    Route::get('/dashboard/officialLink-status/{id}', 'officialLinkStatus')->name('officiallink.status');
    Route::delete('/dashboard/officiallink/{id}', 'officialLinkDestroy')->name('officiallink.destroy');

    // Important Information Link routes
    Route::get('/dashboard/importantinformationlink', 'ImportantInformationLink')->name('importantinformationlink.index');
    Route::post('/dashboard/importantinformationlink', 'ImportantInformationLinkStore')->name('importantinformationlink.store');
    Route::get('/dashboard/importantinformationlink/{id}/edit', 'ImportantInformationLinkEdit')->name('importantinformationlink.edit');
    Route::put('/dashboard/importantinformationlink/{id}', 'ImportantInformationLinkUpdate')->name('importantinformationlink.update');
    Route::get('/dashboard/importantinformationlink-status/{id}', 'ImportantInformationLinkStatus')->name('importantinformationlink.status');
    Route::delete('/dashboard/importantinformationlink/{id}', 'ImportantInformationLinkDestroy')->name('importantinformationlink.destroy');

    // File Upload routes
    Route::get('/dashboard/fileupload', 'FileUpload')->name('fileupload.index');
    Route::post('/dashboard/fileupload', 'FileUploadStore')->name('fileupload.store');
    Route::get('/dashboard/fileupload/{id}/edit', 'FileUploadEdit')->name('fileupload.edit');
    Route::put('/dashboard/fileupload/{id}', 'FileUploadUpdate')->name('fileupload.update');
    Route::get('/dashboard/fileupload-status/{id}', 'FileUploadStatus')->name('fileupload.status');
    Route::delete('/dashboard/fileupload/{id}', 'FileUploadDestroy')->name('fileupload.destroy');
    Route::get('/dashboard/fileupload/{id}/download', 'FileUploadDownload')->name('fileupload.download');

    // Officel routes
    Route::get('/dashboard/faq', 'FAQ')->name('faq.index');
    Route::post('/dashboard/faq', 'FAQStore')->name('faq.store');
    Route::put('/dashboard/faq/{id}', 'FAQUpdate')->name('faq.update');
    Route::get('/dashboard/faq-status/{id}', 'FAQStatus')->name('faq.status');
    Route::delete('/dashboard/faq/{id}', 'FAQDestroy')->name('faq.destroy');
});


Route::controller(TeacherController::class)->group(function () {
    // designation routes   
    Route::get('/dashboard/designation', 'designation')->name('designation.index');
    Route::post('/dashboard/designation-store', 'designationStore')->name('designation.store');
    Route::put('/dashboard/designation/{id}', 'designationUpdate')->name('designation.update');
    Route::delete('/dashboard/designation/{id}', 'designationDestroy')->name('designation.destroy');


    // teacher routes
    Route::get('/dashboard/teacher', 'teacher')->name('teacher.index');
    Route::post('/dashboard/teacher-store', 'teacherStore')->name('teacher.store');
    // Route::get('/dashboard/teacher/{id}/edit', 'teacherEdit')->name('teacher.edit');
    Route::put('/dashboard/teacher/{id}', 'teacherUpdate')->name('teacher.update');
    Route::get('/dashboard/teacher-status/{id}', 'teacherStatus')->name('teacher.status');
    Route::delete('/dashboard/teacher/{id}', 'teacherDestroy')->name('teacher.destroy');

    // committee routes
    Route::get('/dashboard/committee', 'committee')->name('committee.index');
    Route::post('/dashboard/committee-store', 'committeeStore')->name('committee.store');
    // Route::get('/dashboard/committee/{id}/edit', 'committeeEdit')->name('committee.edit');
    Route::put('/dashboard/committee/{id}', 'committeeUpdate')->name('committee.update');
    Route::get('/dashboard/committee-status/{id}', 'committeeStatus')->name('committee.status');
    Route::delete('/dashboard/committee/{id}', 'committeeDestroy')->name('committee.destroy');
});

Route::controller(StudentController::class)->group(function () {
    // section routes   
    Route::get('/dashboard/section', 'section')->name('section.index');
    Route::post('/dashboard/section-store', 'sectionStore')->name('section.store');
    Route::put('/dashboard/section/{id}', 'sectionUpdate')->name('section.update');
    Route::delete('/dashboard/section/{id}', 'sectionDestroy')->name('section.destroy');

    // class routes   
    Route::get('/dashboard/class', 'class')->name('class.index');
    Route::post('/dashboard/class-store', 'classStore')->name('class.store');
    Route::put('/dashboard/class/{id}', 'classUpdate')->name('class.update');
    Route::delete('/dashboard/class/{id}', 'classDestroy')->name('class.destroy');


    // fees info routes
    Route::get('/dashboard/fees', 'fee')->name('fee.index');
    Route::post('/dashboard/fees-store', 'feeStore')->name('fee.store');
    Route::put('/dashboard/fees/{id}', 'feeUpdate')->name('fee.update');
    Route::delete('/dashboard/fees/{id}', 'feeDestroy')->name('fee.destroy');

    // student routes
    Route::get('/dashboard/student', 'student')->name('student.index');
    Route::post('/dashboard/student', 'studentStore')->name('student.store');
    Route::get('/dashboard/student/{id}/edit', 'studentEdit')->name('student.edit');
    Route::put('/dashboard/student/{id}', 'studentUpdate')->name('student.update');
    Route::get('/dashboard/student-status/{id}', 'studentStatus')->name('student.status');
    Route::delete('/dashboard/student/{id}', 'studentDestroy')->name('student.destroy');
});

Route::controller(SettingController::class)->group(function () {
    // setting routes
    Route::get('/dashboard/site-setting', 'site_setting')->name('site.setting');
    Route::post('/dashboard/site-setting-update', 'site_setting_update')->name('site.setting.update');

    Route::get('/dashboard/seo-setting', 'seo_setting')->name('seo.setting');
    Route::post('/dashboard/seo-setting-update', 'seo_setting_update')->name('seo.setting.update');

    Route::get('/dashboard/appearence-setting', 'appearence_setting')->name('appearence.setting');
    Route::post('/dashboard/appearence-setting-update', 'appearence_setting_update')->name('appearence.setting.update');
});

Route::controller(GalleryImageController::class)->group(function () {
    // gallery category routes   
    Route::get('/dashboard/gallerycategory', 'gallerycategory')->name('gallerycategory.index');
    Route::post('/dashboard/gallerycategory-store', 'gallerycategoryStore')->name('gallerycategory.store');
    Route::put('/dashboard/gallerycategory/{id}', 'gallerycategoryUpdate')->name('gallerycategory.update');
    Route::get('/dashboard/gallerycategory-status/{id}', 'gallerycategoryStatus')->name('gallerycategory.status');
    Route::delete('/dashboard/gallerycategory/{id}', 'gallerycategoryDestroy')->name('gallerycategory.destroy');

    // gallery image routes   
    Route::get('/dashboard/galleryimage', 'galleryimage')->name('galleryimage.index');
    Route::post('/dashboard/galleryimage-store', 'galleryimageStore')->name('galleryimage.store');
    Route::put('/dashboard/galleryimage/{id}', 'galleryimageUpdate')->name('galleryimage.update');
    Route::get('/dashboard/galleryimage-status/{id}', 'galleryimageStatus')->name('galleryimage.status');
    Route::delete('/dashboard/galleryimage/{id}', 'galleryimageDestroy')->name('galleryimage.destroy');
});

Route::controller(VideoGalleryController::class)->group(function () {
    // video gallery category routes   
    Route::get('/dashboard/videogallerycategory', 'videogallerycategory')->name('videogallerycategory.index');
    Route::post('/dashboard/videogallerycategory-store', 'videogallerycategoryStore')->name('videogallerycategory.store');
    Route::put('/dashboard/videogallerycategory/{id}', 'videogallerycategoryUpdate')->name('videogallerycategory.update');
    Route::delete('/dashboard/videogallerycategory/{id}', 'videogallerycategoryDestroy')->name('videogallerycategory.destroy');

    // video gallery routes   
    Route::get('/dashboard/videogallery', 'videogallery')->name('videogallery.index');
    Route::post('/dashboard/videogallery-store', 'videogalleryStore')->name('videogallery.store');
    Route::put('/dashboard/videogallery/{id}', 'videogalleryUpdate')->name('videogallery.update');
    Route::delete('/dashboard/videogallery/{id}', 'videogalleryDestroy')->name('videogallery.destroy');
});

Route::controller(MBBSCOURSEController::class)->group(function () {
    // MBBS Course Category routes
    Route::get('/dashboard/mbbs-course', 'index')->name('mbbs-course.index');
    Route::get('/dashboard/mbbs-course/create', 'create')->name('mbbs-course.create');
    Route::post('/dashboard/mbbs-course', 'store')->name('mbbs-course.store');
    Route::get('/dashboard/mbbs-course/{id}/edit', 'edit')->name('mbbs-course.edit');
    Route::put('/dashboard/mbbs-course/{id}', 'update')->name('mbbs-course.update');
    Route::delete('/dashboard/mbbs-course/{id}', 'destroy')->name('mbbs-course.destroy');
});

Route::controller(ClassResultController::class)->group(function () {
    // Class Result File Upload routes
    Route::get('/dashboard/classresult', 'classresult')->name('classresult.index');
    Route::post('/dashboard/classresult', 'classresultStore')->name('classresult.store');
    Route::get('/dashboard/classresult/{id}/edit', 'classresultEdit')->name('classresult.edit');
    Route::put('/dashboard/classresult/{id}', 'classresultUpdate')->name('classresult.update');
    Route::get('/dashboard/classresult-status/{id}', 'classresultStatus')->name('classresult.status');
    Route::delete('/dashboard/classresult/{id}', 'classresultDestroy')->name('classresult.destroy');
    Route::get('/dashboard/classresult/{id}/download', 'classresultDownload')->name('classresult.download');
});

Route::controller(RoutineController::class)->group(function () {
    // Class Routine File Upload routes
    Route::get('/dashboard/classroutine', 'classroutine')->name('classroutine.index');
    Route::post('/dashboard/classroutine', 'classroutineStore')->name('classroutine.store');
    Route::get('/dashboard/classroutine/{id}/edit', 'classroutineEdit')->name('classroutine.edit');
    Route::put('/dashboard/classroutine/{id}', 'classroutineUpdate')->name('classroutine.update');
    Route::get('/dashboard/classroutine-status/{id}', 'classroutineStatus')->name('classroutine.status');
    Route::delete('/dashboard/classroutine/{id}', 'classroutineDestroy')->name('classroutine.destroy');
    Route::get('/dashboard/classroutine/{id}/download', 'classroutineDownload')->name('classroutine.download');



    // exam Routine File Upload routes
    Route::get('/dashboard/examroutine', 'examroutine')->name('examroutine.index');
    Route::post('/dashboard/examroutine', 'examroutineStore')->name('examroutine.store');
    Route::get('/dashboard/examroutine/{id}/edit', 'examroutineEdit')->name('examroutine.edit');
    Route::put('/dashboard/examroutine/{id}', 'examroutineUpdate')->name('examroutine.update');
    Route::get('/dashboard/examroutine-status/{id}', 'examroutineStatus')->name('examroutine.status');
    Route::delete('/dashboard/examroutine/{id}', 'examroutineDestroy')->name('examroutine.destroy');
    Route::get('/dashboard/examroutine/{id}/download', 'examroutineDownload')->name('examroutine.download');
});
