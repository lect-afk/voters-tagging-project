<?php

namespace App\Http\Controllers;

use App\Models\VotersProfile;
use App\Models\Sitio;
use App\Models\Purok;
use App\Models\Barangay;
use App\Models\Precinct;
use App\Models\Tagging;
use App\Models\Candidate;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDF;
use setasign\Fpdi\Fpdi;

class AdminController extends Controller
{
    public function dashboard()
    {
        $barangays = Barangay::all();
        return view('admin.pages.dashboard', compact('barangays'));
    }

    public function getBarangayData(Request $request)
    {
        $barangayId = $request->input('barangay_id');

        if (!$barangayId) {
            return response()->json(['error' => 'No barangay selected'], 400);
        }

        // Fetch data for the selected barangay
        $barangay = Barangay::find($barangayId);
        
        $allied = VotersProfile::where('barangay', $barangayId)
            ->where('alliances_status', 'Green')
            ->count();

        $prospectiveally = VotersProfile::where('barangay', $barangayId)
            ->where('alliances_status', 'Yellow')
            ->count();

        $unlikelyally = VotersProfile::where('barangay', $barangayId)
            ->where('alliances_status', 'Orange')
            ->count();

        $nonparticipant = VotersProfile::where('barangay', $barangayId)
            ->where('alliances_status', 'None')
            ->count();

        $nonsupporter = VotersProfile::where('barangay', $barangayId)
            ->where('alliances_status', 'Red')
            ->count();

        $inc = VotersProfile::where('barangay', $barangayId)
            ->where('alliances_status', 'White')
            ->count();

        $unidentified = VotersProfile::where('barangay', $barangayId)
            ->where('alliances_status', 'Black')
            ->count();

        $totalVotersCount = VotersProfile::where('barangay', $barangayId)->count();

        $data = [
            'barangay' => $barangay->name,
            'allied' => $allied,
            'prospectiveally' => $prospectiveally,
            'unlikelyally' => $unlikelyally,
            'nonparticipant' => $nonparticipant,
            'nonsupporter' => $nonsupporter,
            'inc' => $inc,
            'unidentified' => $unidentified,
            'total' => $totalVotersCount,
        ];

        return response()->json($data);
    }

}
