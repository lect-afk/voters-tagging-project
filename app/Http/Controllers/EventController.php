<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTagging;
use App\Models\VotersProfile;
use App\Models\Sitio;
use App\Models\Purok;
use App\Models\Barangay;
use App\Models\Precinct;
use App\Models\Tagging;
use App\Models\Candidate;
use Illuminate\Http\Request;
use PDF;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('id', 'asc')
        ->paginate(25);
        return view('admin.pages.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.pages.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Event::create($request->all());

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('admin.pages.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.pages.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    public function tagEvents(Request $request)
{
    $request->validate([
        'tagevent' => 'required|exists:events,id',
        'selected_profiles.*' => 'exists:voters_profile,id',
    ]);

    $eventId = $request->input('tagevent');
    $selectedProfiles = $request->input('selected_profiles', []);

    foreach ($selectedProfiles as $profileId) {
        $existingTagging = EventTagging::where('profile_id', $profileId)
            ->where('event_id', $eventId)
            ->first();

        if ($existingTagging) {
            // If the tagging already exists, delete it (untag)
            $existingTagging->delete();
        } else {
            // If the tagging does not exist, create it (tag)
            EventTagging::create([
                'profile_id' => $profileId,
                'event_id' => $eventId,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Attendace Status updated successfully.');
}


    public function eventstagging(Request $request)
    {
        $events = Event::orderBy('name', 'asc')
            ->paginate(50);

        return view('admin.pages.tagging.eventstagging', compact('events'));
    }

    public function manageevent(Request $request, Event $manageevent)
    {
        // Fetch all events, precincts, and barangays for the filters
        $events = Event::all();
        $precincts = Precinct::all(); // Changed from $precinct to $precincts
        $barangays = Barangay::all();

        // Get input values
        $precinctId = $request->input('precinct');
        $barangayId = $request->input('barangay');
        $attendanceStatus = $request->input('attendance_status'); // New input for attendance status
        $fullName = $request->input('full_name'); // New input for full name

        // Get all voters profiles with the specified filters
        $voters_profiles = VotersProfile::with(['sitios', 'puroks', 'barangays', 'precincts', 'events'])
            ->when($precinctId, function($queryBuilder) use ($precinctId) {
                return $queryBuilder->where('precinct', $precinctId);
            })
            ->when($barangayId, function($queryBuilder) use ($barangayId) {
                return $queryBuilder->where('barangay', $barangayId);
            })
            ->when($fullName, function($queryBuilder) use ($fullName) {
                // Filter by full name (first, middle, and last)
                $queryBuilder->where(function($query) use ($fullName) {
                    $query->where('firstname', 'like', '%' . $fullName . '%')
                        ->orWhere('middlename', 'like', '%' . $fullName . '%')
                        ->orWhere('lastname', 'like', '%' . $fullName . '%');
                });
            })
            ->orderBy('lastname', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(50);

        // Check attendance status for the specific event
        foreach ($voters_profiles as $voters_profile) {
            $voters_profile->attendance_status = EventTagging::where('profile_id', $voters_profile->id)
                ->where('event_id', $manageevent->id)
                ->exists() ? 'Present' : 'Absent';
        }

        return view('admin.pages.tagging.eventmanagement', compact('voters_profiles', 'precincts', 'barangays', 'events', 'manageevent'))
            ->with('precinctId', $precinctId)
            ->with('barangayId', $barangayId)
            ->with('attendanceStatus', $attendanceStatus)
            ->with('fullName', $fullName); // Pass full name to the view
    }

    public function eventoverview(Request $request)
    {
        $barangay = Barangay::all();
        $events = Event::all();
        $query = $request->input('query');
        $barangayId = $request->input('barangay');

        $eventoverviews = VotersProfile::with(['sitios', 'puroks', 'barangays', 'precincts', 'eventtaggings.event'])
            ->when($query, function($queryBuilder) use ($query) {
                return $queryBuilder->where(function($queryBuilder) use ($query) {
                    $queryBuilder->where('firstname', 'like', "%$query%")
                                ->orWhere('lastname', 'like', "%$query%");
                });
            })
            ->when($barangayId, function($queryBuilder) use ($barangayId) {
                return $queryBuilder->where('barangay', $barangayId);
            })
            ->orderBy('lastname', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(25);

        return view('admin.pages.events.overview', compact('events', 'barangay', 'eventoverviews'))
            ->with('query', $query)
            ->with('barangayId', $barangayId);

    }

    public function downloadEventOverviewPdf(Request $request)
    {
        ini_set('max_execution_time', 3600); // 1 hour
        ini_set('memory_limit', '5G'); // or higher if needed

        // Retrieve query parameters
        $query = $request->input('query');
        $barangayId = $request->input('barangay');

        // Define paths for temporary PDFs
        $pdfPaths = [];

        // Get distinct precinct numbers
        $precincts = VotersProfile::select('precinct')
            ->when($query, function($queryBuilder) use ($query) {
                return $queryBuilder->where(function($queryBuilder) use ($query) {
                    $queryBuilder->where('firstname', 'like', "%$query%")
                                ->orWhere('lastname', 'like', "%$query%");
                });
            })
            ->when($barangayId, function($queryBuilder) use ($barangayId) {
                return $queryBuilder->where('barangay', $barangayId);
            })
            ->groupBy('precinct')
            ->orderBy('precinct', 'asc')
            ->get();

        // Process each precinct
        foreach ($precincts as $precinct) {
            $eventoverviews = VotersProfile::with(['sitios', 'puroks', 'barangays', 'precincts', 'eventtaggings.event'])
                ->when($query, function ($queryBuilder) use ($query) {
                    return $queryBuilder->where(function ($queryBuilder) use ($query) {
                        $queryBuilder->where('firstname', 'like', "%$query%")
                            ->orWhere('lastname', 'like', "%$query%");
                    });
                })
                ->when($barangayId, function ($queryBuilder) use ($barangayId) {
                    return $queryBuilder->where('barangay', $barangayId);
                })
                ->where('precinct', $precinct->precinct)
                ->orderBy('lastname', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            // Fetch the precinct number
            $precinctNumber = $eventoverviews->first()->precincts->number ?? 'Unknown';
            $barangayName = $eventoverviews->first()->barangays->name ?? 'Unknown';

            // Generate the PDF
            $pdfPath = storage_path("app/public/events_overview_{$precinct->precinct}.pdf");
            $pdf = PDF::loadView('admin.pages.tagging.events_overview_pdf', [
                'eventoverviews' => $eventoverviews,
                'precinct_number' => $precinctNumber,
                'barangay_name' => $barangayName,
            ]);
            $pdf->save($pdfPath);
            $pdfPaths[] = $pdfPath;
        }
            
        // Merge the PDFs
        $finalPdf = new Fpdi();
        foreach ($pdfPaths as $path) {
            $pageCount = $finalPdf->setSourceFile($path);
            for ($i = 1; $i <= $pageCount; $i++) {
                $tplIdx = $finalPdf->importPage($i);
                $finalPdf->addPage();
                $finalPdf->useTemplate($tplIdx);
            }
        }

        // Output the final merged PDF
        $finalPdfPath = storage_path('app/public/events_overviewfinal.pdf');
        $finalPdf->Output($finalPdfPath, 'F');

        // Clean up temporary files
        foreach ($pdfPaths as $path) {
            unlink($path);
        }

        return response()->download($finalPdfPath)->deleteFileAfterSend(true);
    }





}

