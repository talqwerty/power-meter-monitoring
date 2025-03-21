<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    use HasFactory;

    // กำหนดฟิลด์ที่สามารถเขียนได้
    protected $fillable = [
        'meter_id',
        'voltage',
        'current',
        'power',
        'energy',
        'frequency',
        'power_factor',

        // เพิ่มฟิลด์สำหรับข้อมูล 3 เฟส
        'voltage1',
        'voltage2',
        'voltage3',
        'current1',
        'current2',
        'current3',
        'power1',
        'power2',
        'power3',
    ];

    // คุณสามารถเพิ่ม accessors หรือ mutators เพื่อจัดการข้อมูลได้ตามต้องการ
    // ตัวอย่างเช่น:

    /**
     * คำนวณและคืนค่าแรงดันไฟฟ้าเฉลี่ยจาก 3 เฟส
     */
    public function getAverageVoltageAttribute()
    {
        // ตรวจสอบว่ามีข้อมูลครบทั้ง 3 เฟสหรือไม่
        if (isset($this->voltage1) && isset($this->voltage2) && isset($this->voltage3)) {
            return ($this->voltage1 + $this->voltage2 + $this->voltage3) / 3;
        }

        // ถ้าไม่มีข้อมูลแยกตามเฟส ให้ใช้ค่ารวม
        return $this->voltage;
    }

    /**
     * คำนวณและคืนค่ากระแสไฟฟ้าเฉลี่ยจาก 3 เฟส
     */
    public function getAverageCurrentAttribute()
    {
        // ตรวจสอบว่ามีข้อมูลครบทั้ง 3 เฟสหรือไม่
        if (isset($this->current1) && isset($this->current2) && isset($this->current3)) {
            return ($this->current1 + $this->current2 + $this->current3) / 3;
        }

        // ถ้าไม่มีข้อมูลแยกตามเฟส ให้ใช้ค่ารวม
        return $this->current;
    }

    /**
     * คำนวณและคืนค่ากำลังไฟฟ้ารวมจาก 3 เฟส
     */
    public function getTotalPowerAttribute()
    {
        // ตรวจสอบว่ามีข้อมูลครบทั้ง 3 เฟสหรือไม่
        if (isset($this->power1) && isset($this->power2) && isset($this->power3)) {
            return $this->power1 + $this->power2 + $this->power3;
        }

        // ถ้าไม่มีข้อมูลแยกตามเฟส ให้ใช้ค่ารวม
        return $this->power;
    }
}
