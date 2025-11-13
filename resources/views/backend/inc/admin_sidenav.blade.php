<style>
    .nav-link {
        margin-top: 2px !important;
        margin-bottom: 2px !important;
    }

    .sidebar-nav {
        overflow-y: auto !important;
        /* enable vertical scroll */

    }
</style>
<div class="sidebar">
    <div class="sidebar-search">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search in menu" />
            <span class="input-group-text bg-transparent border-0">
                <i class="fas fa-search" style="color:white;"></i>
            </span>
        </div>
    </div>

    <div class="sidebar-nav">
        <ul class="nav flex-column" id="sidebarAccordion">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ is_active('dashboard') }}">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed {{ is_active(['appearence.setting', 'site.setting', 'seo.setting']) }}"
                    data-bs-toggle="collapse" href="#websiteMenu" role="button"
                    aria-expanded="{{ is_menu_open(['appearence.setting', 'site.setting', 'seo.setting']) ? 'true' : 'false' }}"
                    aria-controls="websiteMenu">
                    <i class="fas fa-globe"></i>
                    <span>Website Setup</span>
                    <i class="fas fa-chevron-down arrow ms-auto"></i>
                </a>
                <div class="collapse {{ is_menu_open(['appearence.setting', 'site.setting', 'seo.setting']) }}"
                    id="websiteMenu" data-bs-parent="#sidebarAccordion">
                    <div class="submenu">
                        <a href="{{ route('appearence.setting') }}"
                            class="nav-link {{ is_active('appearence.setting') }}">Appearance</a>
                        <a href="{{ route('site.setting') }}" class="nav-link {{ is_active('site.setting') }}">Site
                            Settings</a>
                        <a href="{{ route('seo.setting') }}" class="nav-link {{ is_active('seo.setting') }}">SEO</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed {{ is_active(['notice.*', 'event.*', 'officiallink.*', 'importantinformationlink.*', 'fileupload.*', 'faq.*', 'important.notice.*']) }}"
                    data-bs-toggle="collapse" href="#importantInfoMenu" role="button"
                    aria-expanded="{{ is_menu_open(['notice.*', 'event.*', 'officiallink.*', 'importantinformationlink.*', 'fileupload.*', 'faq.*', 'important.notice.*']) ? 'true' : 'false' }}"
                    aria-controls="importantInfoMenu">
                    <i class="fas fa-calendar"></i>
                    <span>Important Information</span>
                    <i class="fas fa-chevron-down arrow ms-auto"></i>
                </a>
                <div class="collapse {{ is_menu_open(['notice.*', 'event.*', 'officiallink.*', 'importantinformationlink.*', 'fileupload.*', 'faq.*', 'important.notice.*']) }}"
                    id="importantInfoMenu" data-bs-parent="#sidebarAccordion">
                    <div class="submenu">
                        <h6 class="text-light pt-2 mt-2 mb-2">Notices & Events</h6>
                        <a href="{{ route('important.notice.index') }}"
                            class="nav-link {{ is_active('important.notice.*') }}">Important Notices</a>
                        <a href="{{ route('notice.index') }}" class="nav-link {{ is_active('notice.*') }}">Notices</a>
                        <a href="{{ route('event.index') }}" class="nav-link {{ is_active('event.*') }}">Events</a>

                        <h6 class="text-light mt-3 mb-2">Resources</h6>
                        <a href="{{ route('officiallink.index') }}"
                            class="nav-link {{ is_active('officiallink.*') }}">Official Links</a>
                        <a href="{{ route('importantinformationlink.index') }}"
                            class="nav-link {{ is_active('importantinformationlink.*') }}">Important Information
                            Links</a>
                        <a href="{{ route('fileupload.index') }}"
                            class="nav-link {{ is_active('fileupload.*') }}">Files</a>
                        <a href="{{ route('faq.index') }}" class="nav-link {{ is_active('faq.*') }}">FAQs</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed {{ is_active(['gallerycategory.*', 'galleryimage.*']) }}"
                    data-bs-toggle="collapse" href="#imageGalleryMenu" role="button"
                    aria-expanded="{{ is_menu_open(['gallerycategory.*', 'galleryimage.*']) ? 'true' : 'false' }}"
                    aria-controls="imageGalleryMenu">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span>Image Gallery</span>
                    <i class="fas fa-chevron-down arrow ms-auto"></i>
                </a>
                <div class="collapse {{ is_menu_open(['gallerycategory.*', 'galleryimage.*']) }}" id="imageGalleryMenu"
                    data-bs-parent="#sidebarAccordion">
                    <div class="submenu">
                        <a href="{{ route('gallerycategory.index') }}"
                            class="nav-link {{ is_active('gallerycategory.*') }}">Category</a>
                        <a href="{{ route('galleryimage.index') }}"
                            class="nav-link {{ is_active('galleryimage.*') }}">Gallery</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed {{ is_active(['designation.*', 'teacher.*', 'committee.*']) }}"
                    data-bs-toggle="collapse" href="#teacherMenu" role="button"
                    aria-expanded="{{ is_menu_open(['designation.*', 'teacher.*', 'committee.*']) ? 'true' : 'false' }}"
                    aria-controls="teacherMenu">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span>Teachers & Committee</span>
                    <i class="fas fa-chevron-down arrow ms-auto"></i>
                </a>
                <div class="collapse {{ is_menu_open(['designation.*', 'teacher.*', 'committee.*']) }}" id="teacherMenu"
                    data-bs-parent="#sidebarAccordion">
                    <div class="submenu">
                        <a href="{{ route('designation.index') }}"
                            class="nav-link {{ is_active('designation.*') }}">Designation</a>
                        <a href="{{ route('teacher.index') }}" class="nav-link {{ is_active('teacher.*') }}">Teacher</a>
                        <a href="{{ route('committee.index') }}"
                            class="nav-link {{ is_active('committee.*') }}">Managing Committee</a>
                    </div>
                </div>
            </li>


            <!-- <li class="nav-item">
                <a class="nav-link collapsed {{ is_active(['student.*'])}}" data-bs-toggle="collapse"
                    href="#studentMenu" role="button"
                    aria-expanded="{{ is_menu_open(['student.*']) ? 'true' : 'false' }}" aria-controls="studentMenu">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Student Information</span>
                    <i class="fas fa-chevron-down arrow ms-auto"></i>
                </a>
                <div class="collapse {{ is_menu_open(['student.*']) }}" id="studentMenu"
                    data-bs-parent="#sidebarAccordion">
                    <div class="submenu">
                        <a href="{{ route('student.index') }}" class="nav-link {{ is_active('student.*') }}">Student</a>
                    </div>
                </div>
            </li> -->

            <li class="nav-item">
                <a class="nav-link collapsed {{ is_active(['classresult.*', 'classroutine.*', 'examroutine.*', 'class.*']) }}"
                    data-bs-toggle="collapse" href="#AcademyInformationMenu" role="button"
                    aria-expanded="{{ is_menu_open(['classresult.*', 'classroutine.*', 'examroutine.*', 'class.*']) ? 'true' : 'false' }}"
                    aria-controls="AcademyInformationMenu">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    <span>Academic Information</span>
                    <i class="fas fa-chevron-down arrow ms-auto"></i>
                </a>
                <div class="collapse {{ is_menu_open(['classresult.*', 'classroutine.*', 'examroutine.*', 'class.*']) }}"
                    id="AcademyInformationMenu" data-bs-parent="#sidebarAccordion">
                    <div class="submenu">
                        <a href="{{ route('class.index') }}" class="nav-link {{ is_active('class.*') }}">Class</a>
                        <a href="{{ route('classroutine.index') }}"
                            class="nav-link {{ is_active('classroutine.*') }}">Class Routine
                        </a>
                        <a href="{{ route('examroutine.index') }}"
                            class="nav-link {{ is_active('examroutine.*') }}">Exam Shedules
                        </a>
                        <a href="{{ route('classresult.index') }}"
                            class="nav-link {{ is_active('classresult.*') }}">Result
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item" style="margin-bottom: 150px;">

            </li>
        </ul>
    </div>
</div>