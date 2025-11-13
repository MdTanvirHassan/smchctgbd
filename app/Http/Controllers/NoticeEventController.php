<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\type;

class NoticeEventController extends Controller
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

    public function importantNotice()
    {
        $importantnotices = Content::where('type', 'important_notice')->get();

        return view('backend.important_notice', compact('importantnotices'));
    }




    public function importantNoticeStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Content::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'type' => 'important_notice',
            'is_published' => 1,
        ]);

        return redirect()->route('important.notice.index')->with('success', 'Important Notice added successfully!');
    }

    public function importantNoticeEdit($id)
    {
        $importantnotice = Content::findOrFail($id);
        return view('backend.important-notice.edit', compact('importantnotice'));
    }

    public function importantNoticeUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $importantnotice = Content::findOrFail($id);
        $importantnotice->update($validated);

        return redirect()->route('important.notice.index')->with('success', 'Important Notice updated successfully.');
    }

    public function importantNoticeStatus($id)
    {
        $importantnotice = Content::findOrFail($id);
        $importantnotice->is_published = !$importantnotice->is_published;
        $importantnotice->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function importantNoticeDestroy($id)
    {
        $importantnotice = Content::findOrFail($id);
        $importantnotice->delete();

        return redirect()->back()->with('error', 'Important Notice deleted successfully.');
    }

    // Notice Page  
    public function notice()
    {
        $notices = Content::where('type', 'notice')->get();
        return view('backend.notice', compact('notices'));
    }

    public function noticeStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Content::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'type' => 'notice',
            'is_published' => 1,
        ]);

        return redirect()->route('notice.index')->with('success', 'Notice added successfully!');
    }

    public function noticeEdit($id)
    {
        $notice = Content::findOrFail($id);
        return view('backend.notice-edit', compact('notice'));
    }

    public function noticeUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $notice = Content::findOrFail($id);

        $notice->title = $validated['title'];
        $notice->description = $validated['description'];
        $notice->start_date = $validated['start_date'];
        $notice->end_date = $validated['end_date'];
        $notice->save();

        return redirect()->route('notice.index')->with('success', 'Notice updated successfully.');
    }


    public function noticeStatus($id)
    {
        $notice = Content::findOrFail($id);
        $notice->is_published = !$notice->is_published;
        $notice->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function noticeDestroy($id)
    {
        $notice = Content::findOrFail($id);
        $notice->delete();

        return redirect()->back()->with('error', 'Notice deleted successfully.');
    }


    // Event Page  
    public function event()
    {
        $events = Content::where('type', 'event')->get();
        return view('backend.event', compact('events'));
    }

    public function EventStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Content::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'type' => 'Event',
            'is_published' => 1,
        ]);

        return redirect()->route('event.index')->with('success', 'Event added successfully!');
    }

    public function eventEdit($id)
    {
        $Event = Content::findOrFail($id);
        return view('backend.Event-edit', compact('Event'));
    }

    public function eventUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $Event = Content::findOrFail($id);

        $Event->title = $validated['title'];
        $Event->description = $validated['description'];
        $Event->start_date = $validated['start_date'];
        $Event->end_date = $validated['end_date'];
        $Event->save();

        return redirect()->route('event.index')->with('success', 'Event updated successfully.');
    }


    public function eventStatus($id)
    {
        $Event = Content::findOrFail($id);
        $Event->is_published = !$Event->is_published;
        $Event->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function eventDestroy($id)
    {
        $Event = Content::findOrFail($id);
        $Event->delete();

        return redirect()->back()->with('error', 'Event deleted successfully.');
    }


    // Official link Page  
    public function officialLink()
    {
        $officiallinks = Content::where('type', 'link')->get();
        return view('backend.official_link', compact('officiallinks'));
    }

    public function officialLinkStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link_url' => 'required|string',
        ]);

        Content::create([
            'title' => $validated['title'],
            'link_url' => $validated['link_url'],
            'type' => 'Link',
            'is_published' => 1,
        ]);

        return redirect()->route('officiallink.index')->with('success', 'Official Link added successfully!');
    }

    public function officialLinkEdit($id)
    {
        $OfficialLink = Content::findOrFail($id);
        return view('backend.OfficialLink-edit', compact('OfficialLink'));
    }

    public function officialLinkUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link_url' => 'required|string',
        ]);

        $OfficialLink = Content::findOrFail($id);

        $OfficialLink->title = $validated['title'];
        $OfficialLink->link_url = $validated['link_url'];
        $OfficialLink->save();

        return redirect()->route('officiallink.index')->with('success', 'Official Link updated successfully.');
    }


    public function officialLinkStatus($id)
    {
        $OfficialLink = Content::findOrFail($id);
        $OfficialLink->is_published = !$OfficialLink->is_published;
        $OfficialLink->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function officialLinkDestroy($id)
    {
        $OfficialLink = Content::findOrFail($id);
        $OfficialLink->delete();

        return redirect()->back()->with('error', 'Official Link deleted successfully.');
    }

    // Important Information link Page  

    public function ImportantInformationLink()
    {
        $importantinformationlinks = Content::where('type', 'important_information_link')->get();
        return view('backend.important_information_link', compact('importantinformationlinks'));
    }

    public function ImportantInformationLinkStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link_url' => 'required|string',
        ]);

        Content::create([
            'title' => $validated['title'],
            'link_url' => $validated['link_url'],
            'type' => 'important_information_link',
            'is_published' => 1,
        ]);

        return redirect()->route('importantinformationlink.index')->with('success', 'important Information link added successfully!');
    }

    public function ImportantInformationLinkEdit($id)
    {
        $ImportantInformationLink = Content::findOrFail($id);
        return view('backend.ImportantInformationLink-edit', compact('ImportantInformationLink'));
    }

    public function ImportantInformationLinkUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link_url' => 'required|string',
        ]);

        $ImportantInformationLink = Content::findOrFail($id);

        $ImportantInformationLink->title = $validated['title'];
        $ImportantInformationLink->link_url = $validated['link_url'];
        $ImportantInformationLink->save();

        return redirect()->route('importantinformationlink.index')->with('success', 'Important Information Link updated successfully.');
    }


    public function ImportantInformationLinkStatus($id)
    {
        $ImportantInformationLink = Content::findOrFail($id);
        $ImportantInformationLink->is_published = !$ImportantInformationLink->is_published;
        $ImportantInformationLink->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function ImportantInformationLinkDestroy($id)
    {
        $ImportantInformationLink = Content::findOrFail($id);
        $ImportantInformationLink->delete();

        return redirect()->back()->with('error', 'Important Information Link deleted successfully.');
    }

    // File Upload File Page  

    public function FileUpload()
    {
        $fileuploads = Content::where('type', 'file')->get();
        return view('backend.file_upload', compact('fileuploads'));
    }

    public function FileUploadStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',
        ]);

        // Handle file upload
        $file_path = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/files'), $fileName);
            $file_path = 'public/assets/uploads/files/' . $fileName; // relative path
        }

        // Save in DB
        Content::create([
            'title' => $validated['title'],
            'file_path' => $file_path,
            'type' => 'file',
            'is_published' => 1,
        ]);

        return redirect()->route('fileupload.index')->with('success', 'File added successfully!');
    }


    public function FileUploadEdit($id)
    {
        $FileUpload = Content::findOrFail($id);
        return view('backend.file_upload_edit', compact('FileUpload'));
    }

    public function FileUploadUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',
        ]);

        $FileUpload = Content::findOrFail($id);

        if ($request->hasFile('file_path')) {
            // Delete old file if exists
            $oldFilePath = public_path(str_replace('public/', '', $FileUpload->file_path));
            if ($FileUpload->file_path && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            // Upload new file
            $file = $request->file('file_path');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/files'), $fileName);

            // Save with 'public/' prefix like in DB
            $file_path = 'public/assets/uploads/files/' . $fileName;
        } else {
            $file_path = $FileUpload->file_path;
        }

        $FileUpload->title = $validated['title'];
        $FileUpload->file_path = $file_path;
        $FileUpload->save();

        return redirect()->route('fileupload.index')->with('success', 'File updated successfully.');
    }


    public function FileUploadStatus($id)
    {
        $FileUpload = Content::findOrFail($id);
        $FileUpload->is_published = !$FileUpload->is_published;
        $FileUpload->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function FileUploadDownload($id)
    {
        $FileUpload = Content::findOrFail($id);

        if (!$FileUpload->file_path) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = public_path(str_replace('public/', '', $FileUpload->file_path));

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File does not exist on server.');
        }

        return response()->download($filePath);
    }



    public function FileUploadDestroy($id)
    {
        $FileUpload = Content::findOrFail($id);

        // Delete file from public folder
        if ($FileUpload->file_path) {
            $filePath = public_path(str_replace('public/', '', $FileUpload->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $FileUpload->delete();

        return redirect()->back()->with('error', 'File deleted successfully.');
    }

    // FAQ Page  
    public function FAQ()
    {
        $faqs = Content::where('type', 'faq')->get();
        return view('backend.faq', compact('faqs'));
    }

    public function FAQStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Content::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => 'faq',
            'is_published' => 1,
        ]);

        return redirect()->route('faq.index')->with('success', 'FAQ added successfully!');
    }

    public function FAQEdit($id)
    {
        $FAQ = Content::findOrFail($id);
        return view('backend.FAQ-edit', compact('FAQ'));
    }

    public function FAQUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $FAQ = Content::findOrFail($id);

        $FAQ->title = $validated['title'];
        $FAQ->description = $validated['description'];
        $FAQ->save();

        return redirect()->route('faq.index')->with('success', 'FAQ updated successfully.');
    }


    public function FAQStatus($id)
    {
        $FAQ = Content::findOrFail($id);
        $FAQ->is_published = !$FAQ->is_published;
        $FAQ->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function FAQDestroy($id)
    {
        $FAQ = Content::findOrFail($id);
        $FAQ->delete();

        return redirect()->back()->with('error', 'FAQ deleted successfully.');
    }
}
