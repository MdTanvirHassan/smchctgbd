@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">Application Process</h1>
    </div>
</section>

<!-- Application Process Section -->
<section class="application-process-section my-5">
    <div class="container">
        <!-- Main Title -->
        <div class="text-center mb-5">
            <h2 class="text-success fw-bold text-decoration-underline mb-4">
                ADMISSION PROCEDURE FOR LOCAL & FOREIGN STUDENTS
            </h2>
        </div>

        <!-- Local Students Section -->
        <div class="card shadow-sm border-0 rounded-3 mb-5">
            <div class="card-header bg-danger text-white text-center">
                <h3 class="mb-0 fw-bold text-decoration-underline">ADMISSION PROCEDURE FOR LOCAL STUDENTS</h3>
            </div>
            <div class="card-body p-4">
                <div class="admission-content">
                    <p class="mb-3">
                        Admission is based on the merit list position acquired in admission test conducted by the DGHS.
                    </p>
                    
                    <div class="mb-4">
                        <h5 class="text-danger fw-bold text-decoration-underline mb-3">Eligibility for local students:</h5>
                        <ol class="eligibility-list">
                            <li>The applicant must be a Bangladeshi Citizen</li>
                            <li>Passed SSC or Equivalent examination and HSC or equivalent with Physics, Chemistry and Biology.</li>
                            <li>Must have a minimum combined GPA 9.0, an individual minimum GPA 3.5 and minimum GPA 4.0 in Biology at HSC.</li>
                            <li>'O' and 'A' level examination candidates should submit equivalence certificates from the Director General of Health Services, Govt. of Bangladesh, along with the application.</li>
                        </ol>
                    </div>

                    <div class="mb-4">
                        <h5 class="text-danger fw-bold text-decoration-underline mb-3">Application Process:</h5>
                        <div class="application-links">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <a href="http://dgme.teletalk.com.bd" target="_blank" class="btn btn-outline-primary w-100 py-2">
                                        <i class="fas fa-external-link-alt me-2"></i>
                                        dgme.teletalk.com.bd
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="http://www.dghs.gov.bd" target="_blank" class="btn btn-outline-primary w-100 py-2">
                                        <i class="fas fa-external-link-alt me-2"></i>
                                        www.dghs.gov.bd
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="http://www.dghs.gov.bd" target="_blank" class="btn btn-outline-primary w-100 py-2">
                                        <i class="fas fa-external-link-alt me-2"></i>
                                        www.dghs.gov.bd
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="admission-test-info bg-light p-3 rounded">
                        <p class="mb-0">
                            Admission test conducted by the DGHS. The written admission test is of one hour's duration with MCQs on Biology (30%), 
                            Chemistry (25%), Physics (20%), English (15%) and General knowledge (10%). Result of examination on merit basis is published by 
                            DGHS.
                        </p>
                    </div>
                     <div class="card-header bg-info text-white text-center my-2">
                         <h6 class="mb-0 fw-bold">
                             @if(isset($applicationProcess) && $applicationProcess && $applicationProcess->link_url && $applicationProcess->title)
                                 <span class="text-white">Click Link: </span>
                                 <a href="{{ $applicationProcess->link_url }}" target="_blank" class="text-white text-decoration-underline hover-link">
                                     <i class="fas fa-external-link-alt me-2"></i>{{ $applicationProcess->title }}
                                 </a>
                             @elseif(isset($applicationProcess) && $applicationProcess && $applicationProcess->title)
                                 <span class="text-white">
                                     <i class="fas fa-info-circle me-2"></i>{{ $applicationProcess->title }}
                                 </span>
                             @else
                                 <span class="text-white">
                                     <i class="fas fa-link me-2"></i>Application Information - Please add data in admin panel
                                 </span>
                             @endif
                         </h6>
                     </div>
                </div>
            </div>
        </div>

        <!-- Foreign Students Section -->
        <div class="card shadow-sm border-0 rounded-3 mb-5">
            <div class="card-header bg-success text-white text-center">
                <h3 class="mb-0 fw-bold text-decoration-underline">ADMISSION PROCEDURE FOR FOREIGN STUDENTS</h3>
            </div>
            <div class="card-body p-4">
                <div class="admission-content">
                <p class="mb-3">
                Foreign Students may be admitted upto 50% of the total seat as per rules. The students will have to submit permission from their respective government. The interested applicants must fulfill the following criteria of eligibility for admission.
                    </p>
                    <ol class="eligibility-list">
                            <li>Applicants must have passed qualifying examinations i.e. 12th grade (10+2=12 years) of schooling at a public school/ board/ college or passed an examination in any foreign country which is recognized by the Government of Bangladesh as equivalent to the Higher Secondary Certificate Examination.</li>

                            <li>Applicants must have passed Higher Secondary Certificate Examination or equivalent examinations with Physics, Chemistry and Biology as their major/ compulsory subjects.</li>

                            <li>Applicants must have obtained at least 75% marks in average. In case of O-level examination marks grades of only six subjects (top 6 subjects on the basis of marks/ grades obtained) will be considered. In case of A-level examination, marks/grades of Physics, Chemistry and Biology will be considered for evaluation.</li>

                            <li>All academic certificate must be transferred to Bangladesh standard (through collection of Equivalence Certificate from DGHS Dhaka, Bangladesh) & Student Visa formalities through embassy of Bangladesh.</li>

                            <li>All certificates and mark-sheets must be attested by the Ministry of Foreign Affairs of the respective country of the applicant’s academic institution. No application will be accepted without such attestation.</li>

                            <li>The successful applicants will require to produce all academic certificates and mark-sheets in original during their admission.</li>
                        </ol>
                    <div class="mb-4">
                        <h5 class="text-success fw-bold text-decoration-underline mb-3">Eligibility for foreign students:</h5>
                        <p class="mb-3">
                        Seats are reserved for foreign students on First come First Service basis. Students interested to take admission in Southern Medical College, Chittagong Bangladesh must book their seats. There are certain procedure to be maintained. Every procedure must go through both embassy: Indian Medical Council (IMC), Nepal Medical Council (NMC), Director General Health Service DGHS (Dhaka) & Ministry of foreign Affairs.
                        </p>
                    </div>
                     <!-- Admin Uploaded Images Section -->
                     @if($applicationProcess && ($applicationProcess->file_path || ($applicationProcess->description && strpos($applicationProcess->description, 'public/uploads/') !== false)))
                     <div class="card shadow-sm border-0 rounded-3 mb-4">
                        
                         <div class="card-body p-4">
                             <div class="row g-4">
                                 <!-- Primary Image -->
                                 @if($applicationProcess->file_path)
                                 <div class="col-md-6">
                                     <div class="text-center">
                                         
                                         <div class="image-container">
                                             <img src="{{ asset($applicationProcess->file_path) }}" 
                                                  alt="Primary Application Information" 
                                                  class="img-fluid rounded shadow-sm border clickable-image" 
                                                  style="max-height: 400px; object-fit: contain; cursor: pointer;"
                                                  onclick="openImageModal(this.src, 'Primary Application Information')">
                                         </div>
                                     </div>
                                 </div>
                                 @endif

                                 <!-- Secondary Image -->
                                 @if($applicationProcess->description && strpos($applicationProcess->description, 'public/uploads/') !== false)
                                 <div class="col-md-6">
                                     <div class="text-center">
                                         
                                         <div class="image-container">
                                             <img src="{{ asset($applicationProcess->description) }}" 
                                                  alt="Additional Application Information" 
                                                  class="img-fluid rounded shadow-sm border clickable-image" 
                                                  style="max-height: 400px; object-fit: contain; cursor: pointer;"
                                                  onclick="openImageModal(this.src, 'Additional Application Information')">
                                         </div>
                                     </div>
                                 </div>
                                 @endif
                             </div>
                         </div>
                     </div>
                     @endif

                    <div class="card-header bg-info text-white text-center my-2">
                        <h3 class="mb-0 fw-bold">
                            <a href="#" class="text-white text-decoration-underline">
                                Students are requested to contact our Consultant in India, Nepal, Bangladesh –
                            </a>
                         </h3>
                     </div>


                     <div class="mb-4">
                         <h5 class="text-success fw-bold text-decoration-underline mb-3">Application Process:</h5>
                        <div class="application-links">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <a href="http://www.dghs.gov.bd" target="_blank" class="btn btn-outline-success w-100 py-2">
                                        <i class="fas fa-external-link-alt me-2"></i>
                                        DGHS Foreign Student Portal
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="mailto:admission@medicalcollege.edu.bd" class="btn btn-outline-success w-100 py-2">
                                        <i class="fas fa-envelope me-2"></i>
                                        Email Application
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="admission-test-info bg-light p-3 rounded">
                        <p class="mb-2">
                            <strong>Admission Requirements:</strong>
                        </p>
                        <ul class="mb-0">
                            <li>Written entrance examination</li>
                            <li>Interview by admission committee</li>
                            <li>Medical fitness certificate</li>
                            <li>Academic transcript verification</li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- Important Notice -->
        <div class="alert alert-warning border-0 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle text-warning me-3 fs-4"></i>
                <div>
                    <h6 class="mb-1 fw-bold">Important Notice:</h6>
                    <p class="mb-0">
                        All admission procedures are subject to change as per DGHS guidelines. Please check the official websites regularly for updates.
                        For any queries, contact the admission office directly.
                    </p>
                </div>
            </div>
        </div>

        <!-- Consultant Information Section -->
        <div class="card shadow-sm border-0 rounded-3 mb-5">
            
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- Consultant 1 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="consultant-card border rounded p-3 h-100">
                            <h5 class="text-primary fw-bold mb-3">1) Smile Education Consultancy</h5>
                            <div class="consultant-info">
                                <p class="mb-1"><strong class="text-success">Reepa Barai Biswas</strong></p>
                                <p class="mb-1">B265 Survey (1<sup>st</sup> Floor)</p>
                                <p class="mb-1"><strong>Kolkata – 700075 India.</strong></p>
                                <p class="mb-1">
                                    <i class="fas fa-mobile-alt text-primary me-2"></i>
                                    <a href="tel:+919903033033" class="text-decoration-none">+91-9903033033</a>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <a href="mailto:b.reepa@gmail.com" class="text-decoration-none">b.reepa@gmail.com</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Consultant 2 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="consultant-card border rounded p-3 h-100">
                            <h5 class="text-primary fw-bold mb-3">2) Needs Education</h5>
                            <div class="consultant-info">
                                <p class="mb-1"><strong class="text-success">Anwar Murshed & Mr. M Karim</strong></p>
                                <p class="mb-1">Sr. Executive</p>
                                <p class="mb-1">
                                    <i class="fas fa-mobile-alt text-primary me-2"></i>
                                    <a href="tel:+8801711135742" class="text-decoration-none">+88 01711 35742</a>
                                </p>
                                <p class="mb-1">69/C (5th floor), Green Road, Panthapath, Dhaka 1205, Bangladesh.</p>
                                <p class="mb-1">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <a href="mailto:needseducation@gmail.com" class="text-decoration-none">needseducation@gmail.com</a>
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    Hotline: <a href="tel:+8801712862669" class="text-decoration-none">+8801712 862 669</a>
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-globe text-primary me-2"></i>
                                    <a href="https://www.facebook.com/NeedsEducation.bd" target="_blank" class="text-decoration-none">facebook.com/NeedsEducation.bd</a>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-globe text-primary me-2"></i>
                                    <a href="http://www.needseducationbd.com" target="_blank" class="text-decoration-none">www.needseducationbd.com</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Consultant 3 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="consultant-card border rounded p-3 h-100">
                            <h5 class="text-primary fw-bold mb-3">3) Jyoti Deep International Education Consultancy</h5>
                            <div class="consultant-info">
                                <p class="mb-1"><strong class="text-success">Arun Kumar Chaudhary</strong></p>
                                <p class="mb-1">Managing Director</p>
                                <p class="mb-1">Old Bus park, Way to Shankar Dev Campus,</p>
                                <p class="mb-1"><strong>Kathmandu, Nepal.</strong></p>
                                <p class="mb-1">
                                    <i class="fas fa-mobile-alt text-primary me-2"></i>
                                    Mobile: <a href="tel:+9779841279554" class="text-decoration-none">+977984127955</a>; 
                                    <a href="tel:+9779851119513" class="text-decoration-none">+9779851119513</a>
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    Tel: <a href="tel:977014249142" class="text-decoration-none">977-01-4249142</a>, 
                                    <a href="tel:2001132" class="text-decoration-none">2001132</a>, 
                                    Mob: <a href="tel:9779841279554" class="text-decoration-none">977-9841279554</a>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <a href="mailto:jyoti_deep933@yahoo.com" class="text-decoration-none">jyoti_deep933@yahoo.com</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Consultant 4 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="consultant-card border rounded p-3 h-100">
                            <h5 class="text-primary fw-bold mb-3">4) Dronacharya Group</h5>
                            <div class="consultant-info">
                                <p class="mb-1"><strong class="text-success">Arun Bapna</strong></p>
                                <p class="mb-1">(Founder Director)</p>
                                <p class="mb-1">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    Voice | <a href="tel:+919214422499" class="text-decoration-none">+91-92144-22499</a>, 
                                    <a href="tel:+919001099110" class="text-decoration-none">+91-90010-99110</a> (WhatsApp/Viber/IMO)
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    Email ID | <a href="mailto:akbapna@gmail.com" class="text-decoration-none">akbapna@gmail.com</a>
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-globe text-primary me-2"></i>
                                    Website | <a href="http://www.mbbsnow.com" target="_blank" class="text-decoration-none">www.mbbsnow.com</a> | 
                                    <a href="http://www.DronacharyaGroup.com" target="_blank" class="text-decoration-none">www.DronacharyaGroup.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Uploaded Images Section -->
      
        <!-- Contact Information -->
        <!-- <div class="row g-4 mt-4">
            <div class="col-md-6">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Admission Office:</strong></p>
                        <p class="mb-1"><i class="fas fa-phone me-2 text-primary"></i>+880-2-XXXXXXXX</p>
                        <p class="mb-1"><i class="fas fa-envelope me-2 text-primary"></i>admission@medicalcollege.edu.bd</p>
                        <p class="mb-0"><i class="fas fa-clock me-2 text-primary"></i>Sunday - Thursday: 9:00 AM - 5:00 PM</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Important Dates</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Academic Session 2024-25:</strong></p>
                        <p class="mb-1"><i class="fas fa-calendar-alt me-2 text-info"></i>Application Deadline: March 31, 2024</p>
                        <p class="mb-1"><i class="fas fa-calendar-alt me-2 text-info"></i>Admission Test: April 15, 2024</p>
                        <p class="mb-0"><i class="fas fa-calendar-alt me-2 text-info"></i>Classes Begin: July 1, 2024</p>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</section>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Application Process Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid rounded">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a id="downloadLink" href="" download class="btn btn-primary">
                    <i class="fas fa-download me-1"></i>Download Image
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .application-process-section .admission-content {
        font-size: 1.05rem;
        line-height: 1.7;
    }
    
    .eligibility-list {
        padding-left: 1.5rem;
    }
    
    .eligibility-list li {
        margin-bottom: 0.75rem;
        line-height: 1.6;
    }
    
    .application-links .btn {
        transition: all 0.3s ease;
        border-width: 2px;
    }
    
    .application-links .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .admission-test-info {
        border-left: 4px solid #007bff;
    }
    
    .text-decoration-underline {
        text-decoration: underline !important;
    }
    
    .card-header h3 {
        letter-spacing: 0.5px;
    }
    
    .consultant-card {
        background: #f8f9fa;
        border: 2px solid #e9ecef !important;
        transition: all 0.3s ease;
    }
    
    .consultant-card:hover {
        border-color: #007bff !important;
        box-shadow: 0 4px 12px rgba(0,123,255,0.15);
        transform: translateY(-2px);
    }
    
    .consultant-info p {
        font-size: 0.95rem;
        line-height: 1.5;
    }
    
    .consultant-info a {
        color: #007bff;
        font-weight: 500;
    }
    
    .consultant-info a:hover {
        color: #0056b3;
        text-decoration: underline !important;
    }
    
    .consultant-info .text-success {
        color: #28a745 !important;
        font-weight: 600;
    }
    
     .consultant-info .fas {
         width: 16px;
         text-align: center;
     }
     
     .hover-link {
         transition: all 0.3s ease;
         position: relative;
     }
     
     .hover-link:hover {
         color: #fff !important;
         text-shadow: 0 0 10px rgba(255,255,255,0.8);
         transform: scale(1.05);
     }
     
     .hover-link::after {
         content: '';
         position: absolute;
         width: 0;
         height: 2px;
         bottom: -2px;
         left: 50%;
         background-color: #fff;
         transition: all 0.3s ease;
         transform: translateX(-50%);
     }
     
     .hover-link:hover::after {
         width: 100%;
     }
     
     .image-container {
         position: relative;
         overflow: hidden;
         border-radius: 8px;
     }
     
     .clickable-image {
         transition: all 0.3s ease;
     }
     
     .clickable-image:hover {
         transform: scale(1.05);
         box-shadow: 0 8px 25px rgba(0,0,0,0.15);
     }
     
     .image-container::after {
         content: '\f065';
         font-family: 'Font Awesome 5 Free';
         font-weight: 900;
         position: absolute;
         top: 10px;
         right: 10px;
         background: rgba(0,0,0,0.7);
         color: white;
         padding: 8px;
         border-radius: 50%;
         opacity: 0;
         transition: opacity 0.3s ease;
         pointer-events: none;
     }
     
     .image-container:hover::after {
         opacity: 1;
     }
     
     @media (max-width: 768px) {
         .application-links .btn {
             margin-bottom: 0.5rem;
         }
         
         .display-4 {
             font-size: 2rem;
         }
         
         .consultant-card {
             margin-bottom: 1rem;
         }
         
         .consultant-info p {
             font-size: 0.9rem;
         }
         
         .hover-link {
             font-size: 1.1rem;
         }
     }
 </style>

<script>
// Function to open image in modal
function openImageModal(imageSrc, imageTitle) {
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('imageModalLabel');
    const downloadLink = document.getElementById('downloadLink');
    
    modalImage.src = imageSrc;
    modalImage.alt = imageTitle;
    modalTitle.textContent = imageTitle;
    downloadLink.href = imageSrc;
    
    modal.show();
}

// Add click event listeners to all clickable images
document.addEventListener('DOMContentLoaded', function() {
    const clickableImages = document.querySelectorAll('.clickable-image');
    
    clickableImages.forEach(image => {
        image.addEventListener('click', function() {
            const imageSrc = this.src;
            const imageTitle = this.alt;
            openImageModal(imageSrc, imageTitle);
        });
    });
});
</script>
@endsection

