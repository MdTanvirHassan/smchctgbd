@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">Research, Protocol and Institutional Ethical Review Board (IERB)</h1>
    </div>
</section>

<!-- ✅ IERB Section -->
<section class="ierb-section container my-5">
    <div class="row">
        <div class="col-12">
            <!-- IERB Member Table -->
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-users me-2"></i>IERB Member</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60%;">Name and Affiliation</th>
                                    <th style="width: 40%;">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Prof. Dr. Dewan Asadullah, Head, Department of Community Medicine</td>
                                    <td>Chairman</td>
                                </tr>
                                <tr>
                                    <td>Prof. Dr. Dhananjay Majumdar, Head, Department of ENT</td>
                                    <td>Member</td>
                                </tr>
                                <tr>
                                    <td>Professor Dr. Md. Atiqul Islam Chowdhury, Professor, Department of Medicine</td>
                                    <td>Member</td>
                                </tr>
                                <tr>
                                    <td>Prof. Dr. Mehrun Kabir, Head, Department of Dermatology and Venereology</td>
                                    <td>Member</td>
                                </tr>
                                <tr>
                                    <td>Prof. Dr. Md. Motahhar Hossain, Head, Department of Surgery</td>
                                    <td>Member</td>
                                </tr>
                                <tr>
                                    <td>Prof. Dr. Mohammad Nasim Uddin Chowdhury, Head, Department of Physiology</td>
                                    <td>Member</td>
                                </tr>
                                <tr>
                                    <td>Professor Gias Uddin Talukder, (Religious Leader)</td>
                                    <td>Member (Religious Leader)</td>
                                </tr>
                                <tr>
                                    <td>Dr. Shafiqul Islam Chowdhury, Professor, Department of Islamic Studies, University of Chittagong</td>
                                    <td>Member (Lawyer)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- IERB Activities Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>IERB Activities</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 8%;">Sl. No.</th>
                                    <th style="width: 50%;">Topics</th>
                                    <th style="width: 25%;">Principal Investigator</th>
                                    <th style="width: 17%;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>Importance and challenges of medicolegal education: A questionnaire based study on medical under graduates</td>
                                    <td>Dr. Sabrina Karim</td>
                                    <td>30.07.2023</td>
                                </tr>
                                <tr>
                                    <td>02</td>
                                    <td>A comparative Study Between the Perception of Teaching Methodology among Phase I MBBS Students: Traditional Chalk and Board versus Power Point Presentation</td>
                                    <td>Dr. Rummana Khair</td>
                                    <td>10.01.2023</td>
                                </tr>
                                <tr>
                                    <td>03</td>
                                    <td>Prevalence of Chronic Complications of Type 2 Diabetes Mellitus: Results from a Hospital OPD and Personal Chamber Based Cross Sectional Study</td>
                                    <td>Dr. Md. Minhazul Alam</td>
                                    <td>22.12.2022</td>
                                </tr>
                                <tr>
                                    <td>04</td>
                                    <td>Study on spectrum of presentation of Covid-19 patient as clinical, biochemical and radiological findings at different Isolation centre & hospital in Chattogram</td>
                                    <td>Dr. Md. Atiquel Islam Chowdhury</td>
                                    <td>09.11.2021</td>
                                </tr>
                                <tr>
                                    <td>05</td>
                                    <td>Study on spectrum of presentation of Covid-19 patient as clinical, biochemical and radiological findings at different Isolation centre & hospital in Chattogram</td>
                                    <td>Dr. Dewan Asadullah</td>
                                    <td>07.09.2021</td>
                                </tr>
                                <tr>
                                    <td>06</td>
                                    <td>A study on morphometry of verlebral canal in lumbar region</td>
                                    <td>Dr. Rummana Khair</td>
                                    <td>11.07.2021</td>
                                </tr>
                                <tr>
                                    <td>07</td>
                                    <td>Incidence of Myopia among medical students attending online class during Covid-19 Pandemic</td>
                                    <td>Dr. Dewan Asadullah</td>
                                    <td>18.01.2021</td>
                                </tr>
                                <tr>
                                    <td>08</td>
                                    <td>Study of pedicles in dried human lumbar verlebra: a morphometric analysis</td>
                                    <td>Dr. Rummana Khair</td>
                                    <td>10.10.2020</td>
                                </tr>
                                <tr>
                                    <td>09</td>
                                    <td>Efficacy of the modified (local) version of ready to use therapeutic food (RUTF) in the severely malnourished children of urban slum</td>
                                    <td>Prof. Dr. Jhulan Das Sharma</td>
                                    <td>17.02.2019</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Clinicomycological study on onychomycosis</td>
                                    <td>Dr. Meherun Kabir</td>
                                    <td>05.02.2019</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>Outcome of Training on Doctor-Patient Communication skill for the Pre-intern Physicians</td>
                                    <td>Dr. Meherunnissa Khanom</td>
                                    <td>07.03.2017</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .ierb-section .table {
        font-size: 0.95rem;
    }
    
    .ierb-section .table thead th {
        font-weight: 600;
        vertical-align: middle;
        text-align: center;
    }
    
    .ierb-section .table tbody td {
        vertical-align: top;
        padding: 12px;
    }
    
    .ierb-section .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .ierb-section .card-header {
        border-bottom: 2px solid rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .ierb-section .table {
            font-size: 0.85rem;
        }
        
        .ierb-section .table tbody td {
            padding: 8px;
        }
    }
</style>

@endsection

