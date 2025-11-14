@extends('backend.layouts.app')

@section('contents')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="facilityTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-dark" id="academic-facility-tab" data-bs-toggle="tab" data-bs-target="#academic-facility" type="button" role="tab">
                Academic Facility
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="teaching-activities-tab" data-bs-toggle="tab" data-bs-target="#teaching-activities" type="button" role="tab">
                Teaching Activities
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="activities-of-meu-tab" data-bs-toggle="tab" data-bs-target="#activities-of-meu" type="button" role="tab">
                Activities of MEU
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-dark" id="research-cell-tab" data-bs-toggle="tab" data-bs-target="#research-cell" type="button" role="tab">
                Research Cell
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="facilityTabsContent">
        <!-- Academic Facility -->
        <div class="tab-pane fade show active" id="academic-facility" role="tabpanel">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Academic Facility</h6>
                </div>
                <div class="card-body">
                    @php
                        $academicData = $academicFacility ? json_decode($academicFacility->description, true) : null;
                    @endphp
                    <form action="{{ $academicFacility ? route('facilities.update', ['section' => 'academic_facility', 'id' => $academicFacility->id]) : route('facilities.store', 'academic_facility') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($academicFacility)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Image 1</label>
                                <input type="file" name="image1" class="form-control" accept="image/*">
                                @if($academicData && isset($academicData['images'][0]))
                                    <div class="mt-2">
                                        <img src="{{ asset($academicData['images'][0]) }}" alt="Image 1" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Image 2</label>
                                <input type="file" name="image2" class="form-control" accept="image/*">
                                @if($academicData && isset($academicData['images'][1]))
                                    <div class="mt-2">
                                        <img src="{{ asset($academicData['images'][1]) }}" alt="Image 2" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ $academicData['description'] ?? '' }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Link URL</label>
                                <input type="url" name="link_url" class="form-control" value="{{ $academicFacility->link_url ?? '' }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Academic Calendar Image</label>
                                <input type="file" name="academic_calendar_image" class="form-control" accept="image/*">
                                @if($academicFacility && $academicFacility->file_path)
                                    <div class="mt-2">
                                        <img src="{{ asset($academicFacility->file_path) }}" alt="Academic Calendar" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ $academicFacility ? 'Update' : 'Save' }} Academic Facility
                                </button>
                                @if($academicFacility)
                                    <a href="{{ route('facilities.status', $academicFacility->id) }}" class="btn btn-{{ $academicFacility->is_published ? 'success' : 'secondary' }}">
                                        {{ $academicFacility->is_published ? 'Published' : 'Unpublished' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Teaching Activities -->
        <div class="tab-pane fade" id="teaching-activities" role="tabpanel">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Teaching Activities</h6>
                </div>
                <div class="card-body">
                    @php
                        $teachingData = $teachingActivities ? json_decode($teachingActivities->description, true) : null;
                    @endphp
                    <form action="{{ $teachingActivities ? route('facilities.update', ['section' => 'teaching_activities', 'id' => $teachingActivities->id]) : route('facilities.store', 'teaching_activities') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($teachingActivities)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            @for($i = 1; $i <= 4; $i++)
                                <div class="col-md-6">
                                    <label class="form-label">Image {{ $i }}</label>
                                    <input type="file" name="image{{ $i }}" class="form-control" accept="image/*">
                                    @if($teachingData && isset($teachingData['images'][$i-1]))
                                        <div class="mt-2">
                                            <img src="{{ asset($teachingData['images'][$i-1]) }}" alt="Image {{ $i }}" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif
                                </div>
                            @endfor

                            <div class="col-md-6">
                                <label class="form-label">Description 1 (for Images 1 & 2)</label>
                                <textarea name="description1" class="form-control" rows="3">{{ $teachingData['description1'] ?? '' }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Description 2 (for Images 3 & 4)</label>
                                <textarea name="description2" class="form-control" rows="3">{{ $teachingData['description2'] ?? '' }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Link URL</label>
                                <input type="url" name="link_url" class="form-control" value="{{ $teachingActivities->link_url ?? '' }}">
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ $teachingActivities ? 'Update' : 'Save' }} Teaching Activities
                                </button>
                                @if($teachingActivities)
                                    <a href="{{ route('facilities.status', $teachingActivities->id) }}" class="btn btn-{{ $teachingActivities->is_published ? 'success' : 'secondary' }}">
                                        {{ $teachingActivities->is_published ? 'Published' : 'Unpublished' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Activities of MEU -->
        <div class="tab-pane fade" id="activities-of-meu" role="tabpanel">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Activities of MEU</h6>
                </div>
                <div class="card-body">
                    @php
                        $meuData = $activitiesOfMeu ? json_decode($activitiesOfMeu->description, true) : null;
                    @endphp
                    <form action="{{ $activitiesOfMeu ? route('facilities.update', ['section' => 'activities_of_meu', 'id' => $activitiesOfMeu->id]) : route('facilities.store', 'activities_of_meu') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($activitiesOfMeu)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Image</label>
                                <input type="file" name="image1" class="form-control" accept="image/*">
                                @if($meuData && isset($meuData['images'][0]))
                                    <div class="mt-2">
                                        <img src="{{ asset($meuData['images'][0]) }}" alt="MEU Image" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ $meuData['description'] ?? '' }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Link URL</label>
                                <input type="url" name="link_url" class="form-control" value="{{ $activitiesOfMeu->link_url ?? '' }}">
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ $activitiesOfMeu ? 'Update' : 'Save' }} Activities of MEU
                                </button>
                                @if($activitiesOfMeu)
                                    <a href="{{ route('facilities.status', $activitiesOfMeu->id) }}" class="btn btn-{{ $activitiesOfMeu->is_published ? 'success' : 'secondary' }}">
                                        {{ $activitiesOfMeu->is_published ? 'Published' : 'Unpublished' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Research Cell -->
        <div class="tab-pane fade" id="research-cell" role="tabpanel">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold">Research Cell</h6>
                </div>
                <div class="card-body">
                    @php
                        $researchData = $researchCell ? json_decode($researchCell->description, true) : null;
                    @endphp
                    <form action="{{ $researchCell ? route('facilities.update', ['section' => 'research_cell', 'id' => $researchCell->id]) : route('facilities.store', 'research_cell') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($researchCell)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Image</label>
                                <input type="file" name="image1" class="form-control" accept="image/*">
                                @if($researchCell && $researchCell->file_path)
                                    <div class="mt-2">
                                        <img src="{{ asset($researchCell->file_path) }}" alt="Research Cell Image" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ $researchData['description'] ?? '' }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Link URL</label>
                                <input type="url" name="link_url" class="form-control" value="{{ $researchCell->link_url ?? '' }}">
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ $researchCell ? 'Update' : 'Save' }} Research Cell
                                </button>
                                @if($researchCell)
                                    <a href="{{ route('facilities.status', $researchCell->id) }}" class="btn btn-{{ $researchCell->is_published ? 'success' : 'secondary' }}">
                                        {{ $researchCell->is_published ? 'Published' : 'Unpublished' }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

