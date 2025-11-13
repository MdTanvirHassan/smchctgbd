<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Teacher;
use App\Models\Designation;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class TeacherController extends Controller
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

    // Notice Page  
    public function designation()
    {
        // $designations = Designation::paginate(15);
        $designations = Designation::get();
        return view('backend.teacher.designation', compact('designations'));
    }

    public function designationStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        Designation::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('designation.index')->with('success', 'Designation added successfully!');
    }

    public function designationUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $designation = Designation::findOrFail($id);

        $designation->name = $validated['name'];
        $designation->save();

        return redirect()->route('designation.index')->with('success', 'Designation updated successfully.');
    }

    public function designationDestroy($id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();

        return redirect()->back()->with('error', 'Designation deleted successfully.');
    }


    // Teacher Page  
    public function teacher()
    {
        $teachers = Teacher::get();
        $designations = Designation::all();
        return view('backend.teacher.teacher', compact('teachers', 'designations'));
    }

    public function teacherStore(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'designation' => 'nullable|integer',
            'biography' => 'nullable|string',
            'join_date' => 'nullable|date',
            'photo_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if (!empty($validated['email'])) {
            $teacher = Teacher::where('email', $validated['email'])->first();
            if ($teacher) {
                return redirect()->back()->with('error', 'Teacher with this email already exists.');
            }
        }

        // Handle file upload
        $photo_path = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/img/teacher'), $fileName);
            $photo_path = 'public/assets/img/teacher/' . $fileName; // relative path
        }

        // Save to DB
        Teacher::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'qualification' => $validated['qualification'],
            'designation_id' => $validated['designation'],
            'biography' => $validated['biography'],
            'join_date' => $validated['join_date'],
            'photo_path' => $photo_path
        ]);

        return redirect()->route('teacher.index')->with('success', 'Teacher added successfully!');
    }

    public function teacherUpdate(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'designation' => 'nullable|integer',
            'biography' => 'nullable|string',
            'join_date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // 🔹 Use a different variable for uniqueness check
        if (!empty($validated['email'])) {
            $exists = Teacher::where('email', $validated['email'])
                ->where('id', '!=', $id)
                ->first();

            if ($exists) {
                return redirect()->back()->with('error', 'Teacher with this email already exists.');
            }
        }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            $oldPhotoPath = public_path(str_replace('public/', '', $teacher->photo_path));
            if ($teacher->photo_path && file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }

            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/img/teacher'), $fileName);

            // Save without extra 'public/' since public_path already points to public/
            $photo_path = 'public/assets/img/teacher/' . $fileName;
        } else {
            $photo_path = $teacher->photo_path;
        }

        $teacher->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'qualification' => $validated['qualification'],
            'designation_id' => $validated['designation'],
            'biography' => $validated['biography'],
            'join_date' => $validated['join_date'],
            'photo_path' => $photo_path,
        ]);

        return redirect()->route('teacher.index')->with('success', 'Teacher updated successfully!');
    }



    public function teacherDestroy($id)
    {
        $Teacher = Teacher::findOrFail($id);
        $Teacher->delete();

        return redirect()->back()->with('error', 'Teacher deleted successfully.');
    }


    // Committee Page  
    public function committee()
    {
        $committees = Committee::get();
        return view('backend.teacher.committee', compact('committees'));
    }

    // Store new committee
    public function committeeStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'designation' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'join_date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        if (!empty($validated['email'])) {
            $committee = Committee::where('email', $validated['email'])->first();
            if ($committee) {
                return redirect()->back()->with('error', 'Committee Member with this email already exists.');
            }
        }

        $photo_path = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/img/teacher'), $fileName);
            $photo_path = 'public/assets/img/teacher/' . $fileName;
        }

        Committee::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'designation' => $validated['designation'],
            'biography' => $validated['biography'],
            'join_date' => $validated['join_date'],
            'photo_path' => $photo_path
        ]);

        return redirect()->route('committee.index')->with('success', 'Committee Member added successfully!');
    }

    // Update existing committee
    public function committeeUpdate(Request $request, $id)
    {
        $committee = Committee::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'designation' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'join_date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // 🔹 Use a different variable name here

        if (!empty($validated['email'])) {
            $exists = Committee::where('email', $validated['email'])
                ->where('id', '!=', $id)
                ->first();

            if ($exists) {
                return redirect()->back()->with('error', 'Committee Member with this email already exists.');
            }
        }


        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($committee->photo_path && file_exists(public_path($committee->photo_path))) {
                unlink(public_path($committee->photo_path));
            }

            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/img/teacher'), $fileName);
            $photo_path = 'public/assets/img/teacher/' . $fileName; // no need "public/"
        } else {
            $photo_path = $committee->photo_path;
        }

        $committee->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'designation' => $validated['designation'],
            'biography' => $validated['biography'],
            'join_date' => $validated['join_date'],
            'photo_path' => $photo_path,
        ]);

        return redirect()->route('committee.index')->with('success', 'Committee member updated successfully!');
    }


    // Delete committee
    public function committeeDestroy($id)
    {
        $committee = Committee::findOrFail($id);

        // Delete photo file
        if ($committee->photo_path && file_exists(public_path($committee->photo_path))) {
            unlink(public_path($committee->photo_path));
        }

        $committee->delete();

        return redirect()->back()->with('error', 'Committee Member deleted successfully.');
    }
}
