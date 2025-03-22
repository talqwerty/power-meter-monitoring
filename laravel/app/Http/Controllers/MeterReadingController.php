<?php

namespace App\Http\Controllers;

use App\Models\MeterReading;
use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    /**
     * แสดงรายการข้อมูลการอ่านมิเตอร์
     */
    public function index(Request $request)
    {
        $query = MeterReading::query();

        // กรองตามวันที่เริ่มต้น
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        // กรองตามวันที่สิ้นสุด
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // กรองตาม meter_id
        if ($request->filled('meter_id')) {
            $query->where('meter_id', $request->meter_id);
        }

        // สั่งให้ไม่มีการจำกัดจำนวนแถวที่ดึงมา
        $readings = $query->orderBy('id', 'desc')->get();

        return response()->json([
            'data' => $readings
        ]);
    }
    /**
     * แสดงข้อมูลล่าสุดสำหรับแต่ละมิเตอร์
     */
    public function latest()
    {
        $meter1 = MeterReading::where('meter_id', 'PV31_01')
            ->orderBy('id', 'desc')
            ->first();

        $meter2 = MeterReading::where('meter_id', 'PV31_02')
            ->orderBy('id', 'desc')
            ->first();

        return response()->json([
            'meter1' => $meter1,
            'meter2' => $meter2
        ]);
    }
    /**
     * บันทึกข้อมูลการอ่านมิเตอร์
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'meter_id' => 'required|string',
            'voltage' => 'nullable|numeric',
            'current' => 'nullable|numeric',
            'power' => 'nullable|numeric',
            'energy' => 'nullable|numeric',
            'frequency' => 'nullable|numeric',
            'power_factor' => 'nullable|numeric',

            // เพิ่มฟิลด์สำหรับข้อมูล 3 เฟส
            'voltage1' => 'nullable|numeric',
            'voltage2' => 'nullable|numeric',
            'voltage3' => 'nullable|numeric',
            'current1' => 'nullable|numeric',
            'current2' => 'nullable|numeric',
            'current3' => 'nullable|numeric',
            'power1' => 'nullable|numeric',
            'power2' => 'nullable|numeric',
            'power3' => 'nullable|numeric',
        ]);

        $reading = MeterReading::create($validated);
        return response()->json($reading, 201);
    }

    /**
     * แสดงหน้า dashboard สำหรับข้อมูลมิเตอร์
     */
    public function dashboard()
    {
        // สามารถส่งข้อมูลเริ่มต้นไปยัง view ได้ (ถ้าต้องการ)
        // แต่เราจะใช้ AJAX เพื่อโหลดข้อมูลในภายหลัง
        return view('meter.dashboard');
    }
}
