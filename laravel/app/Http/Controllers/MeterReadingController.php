<?php

namespace App\Http\Controllers;

use App\Models\MeterReading;
use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    public function index(Request $request)
    {
        $query = MeterReading::query();

        // กรองตามวันที่เริ่มต้น
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // กรองตามวันที่สิ้นสุด
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // กรองตาม meter_id
        if ($request->has('meter_id') && $request->meter_id) {
            $query->where('meter_id', $request->meter_id);
        }

        return $query->orderBy('created_at', 'desc')->paginate(15);
    }

    public function dashboard()
    {
        return view('meter.dashboard');
    }

    public function store(Request $request)
    { // ยังไม่ได้ใช้
        $validated = $request->validate([
            'meter_id' => 'required|string',
            'voltage' => 'nullable|numeric',
            'current' => 'nullable|numeric',
            'power' => 'nullable|numeric',
            'energy' => 'nullable|numeric',
            'frequency' => 'nullable|numeric',
            'power_factor' => 'nullable|numeric',
        ]);

        $reading = MeterReading::create($validated);
        return response()->json($reading, 201);
    }
}
