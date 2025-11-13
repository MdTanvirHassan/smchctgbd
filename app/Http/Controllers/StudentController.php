<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Class;
use App\Models\Classes;
use App\Models\Fee;
use App\Models\Student;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // class Page  
    public function section()
    {
        $sectiones = Classes::paginate(15);
        return view('backend.student.section', compact('sections'));
    }

    public function sectionStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        Classes::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('section.index')->with('success', 'Section added successfully!');
    }

    public function sectionUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $section = Classes::findOrFail($id);

        $section->name = $validated['name'];
        $section->save();

        return redirect()->route('section.index')->with('success', 'Section updated successfully.');
    }

    public function sectionDestroy($id)
    {
        $section = Classes::findOrFail($id);
        $section->delete();

        return redirect()->back()->with('error', 'Section deleted successfully.');
    }




    // class Page  
    public function class()
    {
        $classes = Classes::get();
        return view('backend.student.class', compact('classes'));
    }

    public function classStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'section' => 'nullable|string|max:100',
            'shift' => 'nullable|string|max:100',
        ]);

        Classes::create([
            'name' => $validated['name'],
            'section' => $validated['name'],
            'shift' => $validated['name'],
        ]);

        return redirect()->route('class.index')->with('success', 'Class added successfully!');
    }

    public function classUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'section' => 'nullable|string|max:100',
            'shift' => 'nullable|string|max:100',
        ]);


        $class = Classes::findOrFail($id);

        $class->name = $validated['name'];
        $class->section = $validated['section'] ?? '';
        $class->shift = $validated['shift'] ?? '';
        $class->save();

        return redirect()->route('class.index')->with('success', 'Class updated successfully.');
    }

    public function classDestroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();

        return redirect()->back()->with('error', 'Class deleted successfully.');
    }



    /* =======================
     |  FEE CRUD
     ========================*/
    public function fee()
    {
        $classes = Classes::all();
        $fees = Fee::with('class')->paginate(15);
        return view('backend.student.fee', compact('fees', 'classes'));
    }

    public function feeStore(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'admission_fee' => 'required|numeric|min:0',
            'monthly_fee' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:0',
        ]);

        Fee::create($validated);

        return redirect()->route('fee.index')->with('success', 'Fee added successfully!');
    }

    public function feeUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'admission_fee' => 'required|numeric|min:0',
            'monthly_fee' => 'required|numeric|min:0',
            'total_seats' => 'required|integer|min:0',
        ]);

        $fee = Fee::findOrFail($id);
        $fee->update($validated);

        return redirect()->route('fee.index')->with('success', 'Fee updated successfully.');
    }

    public function feeDestroy($id)
    {
        $fee = Fee::findOrFail($id);
        $fee->delete();

        return redirect()->back()->with('error', 'Fee deleted successfully.');
    }




    // student Page  
    public function student()
    {
        $students = Student::paginate(15);
        $classes = Classes::all();
        return view('backend.student.student', compact('students', 'classes'));
    }


    public function studentStore(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'class' => 'required|integer',

            'photo_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Handle file upload
        $photo_path = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/img/student'), $fileName);
            $photo_path = 'public/assets/img/student/' . $fileName; // relative path
        }

        // Save to DB
        Teacher::create([
            'name' => $validated['name'],

            'class_id' => $validated['class'],

            'photo_path' => $photo_path
        ]);

        return redirect()->route('student.index')->with('success', 'Teacher added successfully!');
    }


    public function studentEdit($id)
    {
        $Teacher = Teacher::findOrFail($id);
        return view('backend.Teacher-edit', compact('Teacher'));
    }

    public function studentUpdate(Request $request, $id)
    {
        $student = Teacher::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'class' => 'required|integer',

            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            $oldPhotoPath = public_path(str_replace('public/', '', $student->photo_path));
            if ($student->photo_path && file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }

            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/img/student'), $fileName);

            // Save with 'public/' prefix as in DB
            $photo_path = 'public/assets/img/student/' . $fileName;
        } else {
            $photo_path = $student->photo_path;
        }

        $student->update([
            'name' => $validated['name'],

            'class_id' => $validated['class'],

            'photo_path' => $photo_path,
        ]);

        return redirect()->route('student.index')->with('success', 'Teacher updated successfully!');
    }


    public function studentDestroy($id)
    {
        $Teacher = Teacher::findOrFail($id);
        $Teacher->delete();

        return redirect()->back()->with('error', 'Teacher deleted successfully.');
    }
}
