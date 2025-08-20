<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentOtherInformation;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentOtherInformationController extends Controller
{
    // View
    public function showStudentOtherInformation()
    {
        return view('student_other_information');
    }

    // Search by NIC or reg no (unchanged)
    public function getStudentDetails(Request $request)
    {
        try {
            $identificationType = $request->input('identificationType');
            $idValue = $request->input('idValue');

            if ($identificationType === 'nic') {
                $student = Student::where('id_value', $idValue)->first();
            } elseif ($identificationType === 'registration_number') {
                $student = Student::join('course_registration', 'students.student_id', '=', 'course_registration.student_id')
                    ->where('course_registration.id', $idValue)
                    ->select('students.*')
                    ->first();
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid identification type']);
            }

            if ($student) {
                return response()->json([
                    'success' => true,
                    'message' => 'Student found',
                    'data' => [
                        'student_id'       => $student->student_id,
                        'student_name'     => $student->full_name,
                        'academic_status'  => $student->academic_status
                    ],
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Student not found']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }

    public function reinstateStudent(Request $request)
    {
        try {
            $request->validate([
                'studentID' => 'required|string',
                'reason'    => 'required|string',
                'document'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            ]);

            $student = Student::where('student_id', $request->input('studentID'))->first();
            if (!$student) {
                return response()->json(['success' => false, 'message' => 'Student not found'], 404);
            }

            $docPath = null;
            if ($request->hasFile('document')) {
                $docPath = $request->file('document')->store('public/academic_status_docs');
            }

            $student->academic_status            = 'active';
            $student->academic_status_reason     = 'Reinstated: ' . $request->input('reason');
            if ($docPath) {
                $student->academic_status_document = $docPath;
            }
            $student->academic_status_changed_at = now();
            $student->save();

            return response()->json([
                'success'          => true,
                'message'          => 'Student reinstated successfully',
                'academic_status'  => $student->academic_status,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }




    // Save other info + (optionally) terminate
    public function storeOtherInformations(Request $request)
    {
        try {
            $request->validate([
                'studentName'         => 'required|string',
                'studentID'           => 'required|string',
                'disciplinaryIssues'  => 'nullable|string',
                'continueStudies'     => 'required|in:true,false',
                'institute'           => 'nullable|string',
                'fieldOfStudy'        => 'nullable|string',
                'currentlyEmployee'   => 'required|in:true,false',
                'jobTitle'            => 'nullable|string',
                'workplace'           => 'nullable|string',
                'otherInformation'    => 'nullable|string',
                'disciplinary_issue_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',

                // Termination fields (sent only if terminating)
                'terminateStudent'    => 'nullable|in:true,false',
                'terminationReason'   => 'required_if:terminateStudent,true|string',
                'termination_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            ]);

            $student = Student::where('student_id', $request->input('studentID'))
                ->where('full_name', $request->input('studentName'))
                ->first();

            if (!$student) {
                return response()->json(['success' => false, 'message' => 'Student information does not exist'], Response::HTTP_BAD_REQUEST);
            }

            // file uploads
            $disciplinaryIssueDocumentPath = null;
            if ($request->hasFile('disciplinary_issue_document')) {
                $disciplinaryIssueDocumentPath = $request->file('disciplinary_issue_document')->store('public/disciplinary_issues');
            }

            $terminationDocumentPath = null;
            if ($request->hasFile('termination_document')) {
                $terminationDocumentPath = $request->file('termination_document')->store('public/termination_docs');
            }

            DB::transaction(function () use ($request, $student, $disciplinaryIssueDocumentPath, $terminationDocumentPath) {

                // 1) upsert "other information"
                StudentOtherInformation::updateOrCreate(
                    ['student_id' => $request->input('studentID')],
                    [
                        'student_id'                 => $request->input('studentID'),
                        'disciplinary_issues'        => $request->input('disciplinaryIssues'),
                        'disciplinary_issue_document' => $disciplinaryIssueDocumentPath,
                        'continue_higher_studies'    => $request->input('continueStudies') === 'true',
                        'institute'                  => $request->input('institute'),
                        'field_of_study'             => $request->input('fieldOfStudy'),
                        'currently_employee'         => $request->input('currentlyEmployee') === 'true',
                        'job_title'                  => $request->input('jobTitle'),
                        'workplace'                  => $request->input('workplace'),
                        'other_information'          => $request->input('otherInformation'),
                    ]
                );

                // 2) if terminate flag on, update academic status on students
                if ($request->input('terminateStudent') === 'true') {
                    $student->update([
                        'academic_status'            => 'terminated',
                        'academic_status_reason'     => $request->input('terminationReason'),
                        'academic_status_document'   => $terminationDocumentPath,
                        'academic_status_changed_at' => now(),
                    ]);
                }
            });

            $msg = $request->input('terminateStudent') === 'true'
                ? 'Data stored and student terminated successfully'
                : 'Data stored successfully';

            return response()->json(['success' => true, 'message' => $msg, 'redirect' => route('student.other.information')], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json(['success' => false, 'message' => 'Database error: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
