@extends('inc.app')

@section('title', 'NEBULA | Intake Creation')

@section('content')
      <div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center mb-4">Create New Intake</h2>
            <hr>
            <form id="intakeForm">
    @csrf
<div class="mb-3 row mx-3">
                    <label for="location" class="col-sm-2 col-form-label">Location <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-select" id="location" name="location" required>
                            <option selected disabled value="">Choose a location...</option>
                            <option value="Welisara">Nebula Institute of Technology - Welisara</option>
                            <option value="Moratuwa">Nebula Institute of Technology - Moratuwa</option>
                            <option value="Peradeniya">Nebula Institute of Technology - Peradeniya</option>
    </select>
                    </div>
                    </div>
                <div class="mb-3 row mx-3">
                    <label for="course_name" class="col-sm-2 col-form-label">Course <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-select" id="course_name" name="course_name" required>
                            <option selected disabled value="">Choose a course...</option>
                            @foreach($courses as $course)
                                <option value="{{ $course }}">{{ $course }}</option>
                            @endforeach
                        </select>
                  </div>
                </div>
                <div id="courseDetailsBox" class="mb-3 row mx-3" style="display:none;">
                    <div class="col-sm-12">
                        <div style="background:#ededed; border-radius:10px; padding:18px;">
                            <div><b>Duration</b> <span id="cd_duration"></span></div>
                            <div><b>Minimum credits</b> <span id="cd_min_credits"></span></div>
                            <div><b>Training</b> <span id="cd_training"></span></div>
                            <div><b>Entry Qualification</b> <span id="cd_entry_qualification"></span></div>
                            <div><b>Medium</b> <span id="cd_medium"></span></div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row mx-3">
                    <label for="batch" class="col-sm-2 col-form-label">Batch Name / Code <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="batch" name="batch" placeholder="e.g., 2024-Sep-CS" required>
                    </div>
                    </div>
                <div class="mb-3 row mx-3">
                    <label for="batch_size" class="col-sm-2 col-form-label">Batch Size <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="batch_size" name="batch_size" placeholder="Enter number of students" min="1" required>
                  </div>
                </div>
                <div class="mb-3 row mx-3">
                    <label for="intake_mode" class="col-sm-2 col-form-label">Intake Mode <span class="text-danger">*</span></label>
    <div class="col-sm-10">
                        <select class="form-select" id="intake_mode" name="intake_mode" required>
                            <option selected disabled value="">Choose a mode...</option>
                            <option value="Physical">Physical</option>
                            <option value="Online">Online</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>
    </div>
  </div>
                <div class="mb-3 row mx-3">
                    <label for="intake_type" class="col-sm-2 col-form-label">Intake Type <span class="text-danger">*</span></label>
    <div class="col-sm-10">
                        <select class="form-select" id="intake_type" name="intake_type" required>
                            <option selected disabled value="">Choose a type...</option>
                            <option value="Fulltime">Full Time</option>
                            <option value="Parttime">Part Time</option>
                        </select>
                  </div>
                </div>
                <div class="mb-3 row mx-3">
                    <label for="registration_fee" class="col-sm-2 col-form-label">Registration Fee (LKR) <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="registration_fee" name="registration_fee" placeholder="e.g., 5000.00" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="row mb-3 align-items-center mx-3">
                    <label for="franchise_payment" class="col-sm-3 col-form-label fw-bold">Franchise Payment <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <select class="form-select" id="franchise_payment_currency" name="franchise_payment_currency" style="max-width:90px; flex-shrink:0;">
                                <option value="LKR">LKR</option>
                                <option value="USD">USD</option>
                                <option value="GBP">GBP</option>
                                <option value="EUR">EUR</option>
                            </select>
                            <input type="number" class="form-control" id="franchise_payment" name="franchise_payment" placeholder="e.g., 10000.00" step="0.01" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row mx-3">
                    <label for="course_fee" class="col-sm-2 col-form-label">Course Fee (LKR) <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="course_fee" name="course_fee" placeholder="e.g., 250000.00" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="mb-3 row mx-3">
                    <label for="sscl_tax" class="col-sm-2 col-form-label">SSCL Tax Percentage <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="number" class="form-control" id="sscl_tax" name="sscl_tax" placeholder="e.g., 15.00" step="0.01" min="0" max="100" required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row mx-3">
                    <label for="bank_charges" class="col-sm-2 col-form-label">Bank Charges (LKR)</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="bank_charges" name="bank_charges" placeholder="e.g., 500.00" step="0.01" min="0">
                    </div>
                </div>
                <div class="mb-3 row mx-3">
                    <label for="start_date" class="col-sm-2 col-form-label">Start Date <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                </div>
                <div class="mb-3 row mx-3">
                    <label for="end_date" class="col-sm-2 col-form-label">End Date <span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
                </div>
                <div class="mb-3 row mx-3">
                    <label for="enrollment_end_date" class="col-sm-2 col-form-label">Enrollment End Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="enrollment_end_date" name="enrollment_end_date">
                        <small class="form-text text-muted">Last date for students to enroll in this intake (optional)</small>
                    </div>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">Create Intake</button>
                </div>
            </form>
        </div>
      </div>

    <div class="card mt-4">
        <div class="card-body existing-intakes-card">
            <h2 class="text-center mb-4">Existing Intakes</h2>
            <hr>
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto; overflow-x: auto; width: 100%;">
                <table class="table table-striped table-bordered" style="table-layout: fixed; width: max-content; min-width: 900px;">
                    <thead style="position: sticky; top: 0; background: #fff; z-index: 2;">
                        <tr>
                            <th style="position: sticky; top: 0; background: #fff; width: 180px; max-width: 180px;">Course Name</th>
                            <th style="position: sticky; top: 0; background: #fff;">Batch</th>
                            <th style="position: sticky; top: 0; background: #fff;">Location</th>
                            <th style="position: sticky; top: 0; background: #fff;">Mode</th>
                            <th style="position: sticky; top: 0; background: #fff;">Type</th>
                            <th style="position: sticky; top: 0; background: #fff;">Start Date</th>
                            <th style="position: sticky; top: 0; background: #fff;">End Date</th>
                            <th style="position: sticky; top: 0; background: #fff;">Enrollment End</th>
                            <th style="position: sticky; top: 0; background: #fff;">Capacity</th>
                            <th style="position: sticky; top: 0; background: #fff;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="intake-table-body">
                        @forelse($intakes as $intake)
                        <tr id="intake-row-{{$intake->intake_id}}">
                            <td style="width: 180px; max-width: 180px; word-break: break-word;">{{ $intake->course_name }}</td>
                            <td>{{ $intake->batch }}</td>
                            <td>{{ $intake->location }}</td>
                            <td>{{ $intake->intake_mode }}</td>
                            <td>{{ $intake->intake_type }}</td>
                            <td>{{ $intake->start_date ? (is_string($intake->start_date) ? \Carbon\Carbon::parse($intake->start_date)->format('Y-m-d') : $intake->start_date->format('Y-m-d')) : '' }}</td>
                            <td>{{ $intake->end_date ? (is_string($intake->end_date) ? \Carbon\Carbon::parse($intake->end_date)->format('Y-m-d') : $intake->end_date->format('Y-m-d')) : '' }}</td>
                            <td>{{ $intake->enrollment_end_date ? (is_string($intake->enrollment_end_date) ? \Carbon\Carbon::parse($intake->enrollment_end_date)->format('Y-m-d') : $intake->enrollment_end_date->format('Y-m-d')) : '-' }}</td>
                            <td>{{ $intake->registrations->count() }} / {{ $intake->batch_size }}</td>
                            <td>
                                @if($intake->isPast())
                                    <span class="badge bg-danger">Finished</span>
                                @elseif($intake->isCurrent())
                                    <span class="badge bg-success">Ongoing</span>
                                @else
                                    <span class="badge bg-warning">Upcoming</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No intakes found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>

<div class="toast-container position-fixed bottom-0 end-0 p-3"></div>
@endsection

@push('scripts')
    <script>
$(document).ready(function() {
    $('#intakeForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: '{{ route("intake.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showToast(response.message, 'success');
                    $('#intakeForm')[0].reset();
                    
                    const intake = response.intake;
                    const newRow = `
                        <tr id="intake-row-${intake.intake_id}">
                            <td>${intake.course_name}</td>
                            <td>${intake.batch}</td>
                            <td>${intake.location}</td>
                            <td>${intake.intake_mode}</td>
                            <td>${intake.intake_type}</td>
                            <td>${formatDate(intake.start_date)}</td>
                            <td>${formatDate(intake.end_date)}</td>
                            <td>${intake.enrollment_end_date ? formatDate(intake.enrollment_end_date) : '-'}</td>
                            <td>${intake.registrations_count ?? 0} / ${intake.batch_size}</td>
                            <td>
                                ${intake.isPast ? '<span class="badge bg-danger">Finished</span>' : (intake.isCurrent ? '<span class="badge bg-success">Ongoing</span>' : '<span class="badge bg-warning">Upcoming</span>')}
                            </td>
                        </tr>
                    `;

                    if ($('#intake-table-body').find('td[colspan="10"]').length) {
                        $('#intake-table-body').html(newRow);
                    } else {
                        $('#intake-table-body').prepend(newRow);
                    }
                } else {
                    showToast(response.message, 'danger');
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while creating the intake.';
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    } else if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    if (xhr.responseJSON.errors) {
                        const errors = Object.values(xhr.responseJSON.errors).flat();
                        errorMessage += '<br>' + errors.join('<br>');
                    }
                }
                showToast(errorMessage, 'danger');
            }
        });
      });

    function showToast(message, type) {
        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`;
        $('.toast-container').append(toastHtml);
        const toastEl = $('.toast-container .toast').last();
        const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
        toast.show();
    }

    function formatDate(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr);
        if (isNaN(d)) return dateStr;
        return d.toISOString().slice(0, 10);
    }

    $('#course_name').on('change', function() {
        var courseName = $(this).val();
        if (!courseName) {
            $('#courseDetailsBox').hide();
            return;
        }
        // Try to find the course ID from the select option (if available)
        var courseId = $(this).find('option:selected').data('id');
        // If not available, fallback to course name search via API
        // You may need to adjust this if your course select uses IDs
        $.ajax({
            url: '/api/courses',
            type: 'GET',
            success: function(response) {
                if (Array.isArray(response)) {
                    var found = response.find(function(c) { return c.course_name === courseName; });
                    if (found) {
                        fetchCourseDetails(found.course_id);
                    } else {
                        $('#courseDetailsBox').hide();
                    }
                } else {
                    $('#courseDetailsBox').hide();
                }
            },
            error: function() {
                $('#courseDetailsBox').hide();
            }
        });
    });

    function fetchCourseDetails(courseId) {
        $.ajax({
            url: '/api/courses/' + courseId,
            type: 'GET',
            success: function(response) {
                if (response.success && response.course) {
                    var c = response.course;
                    $('#cd_duration').text(c.duration_formatted ? c.duration_formatted : '-');
                    $('#cd_min_credits').text(c.min_credits ? c.min_credits : '-');
                    $('#cd_training').text(c.training_period ? c.training_period : '-');
                    $('#cd_entry_qualification').html(c.entry_qualification ? c.entry_qualification.replace(/\n/g, '<br>') : '-');
                    $('#cd_medium').text(c.course_medium ? c.course_medium : '-');
                    $('#courseDetailsBox').show();
                } else {
                    $('#courseDetailsBox').hide();
                }
            },
            error: function() {
                $('#courseDetailsBox').hide();
            }
        });
    }

    function autofillPaymentPlan() {
        var courseName = $('#course_name').val();
        var location = $('#location').val();
        var courseType = $('#intake_type').val();
        if (!courseName || !location || !courseType) return;
        $.ajax({
            url: '/get-payment-plan-details',
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                course_name: courseName,
                location: location,
                course_type: courseType
            },
            success: function(response) {
                if (response.success) {
                    $('#registration_fee').val(response.registration_fee);
                    $('#course_fee').val(response.course_fee);
                    // If you want to autofill franchise_payment, add it to the response and here
                    // $('#franchise_payment').val(response.franchise_payment);
                }
            }
        });
    }

    $('#course_name, #location, #intake_type').on('change', autofillPaymentPlan);

    // Validate enrollment end date
    $('#enrollment_end_date').on('change', function() {
        const enrollmentEndDate = new Date($(this).val());
        const startDate = new Date($('#start_date').val());
        const endDate = new Date($('#end_date').val());
        
        if ($('#start_date').val() && enrollmentEndDate < startDate) {
            showToast('Enrollment end date cannot be before the start date.', 'danger');
            $(this).val('');
            return;
        }
        
        if ($('#end_date').val() && enrollmentEndDate > endDate) {
            showToast('Enrollment end date cannot be after the end date.', 'danger');
            $(this).val('');
            return;
        }
    });
});
    </script>
@endpush

<style>
    .existing-intakes-card {
        padding: 2rem 2.5rem !important;
    }
    .existing-intakes-card .table-responsive {
        padding: 0 1rem;
    }
    .existing-intakes-card .table th {
        font-size: 1.08rem !important;
        font-weight: 600;
        background: #f5f7fa;
    }
    .existing-intakes-card .table td {
        font-size: 0.95rem !important;
    }
</style>
