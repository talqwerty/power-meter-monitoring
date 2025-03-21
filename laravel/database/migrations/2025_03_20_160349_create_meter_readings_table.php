<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThreePhaseFieldsToMeterReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meter_readings', function (Blueprint $table) {
            // เพิ่มฟิลด์สำหรับข้อมูล 3 เฟส
            // แรงดันไฟฟ้า (Voltage) สำหรับแต่ละเฟส
            $table->float('voltage1')->nullable()->after('voltage');
            $table->float('voltage2')->nullable()->after('voltage1');
            $table->float('voltage3')->nullable()->after('voltage2');

            // กระแสไฟฟ้า (Current) สำหรับแต่ละเฟส
            $table->float('current1')->nullable()->after('current');
            $table->float('current2')->nullable()->after('current1');
            $table->float('current3')->nullable()->after('current2');

            // กำลังไฟฟ้า (Power) สำหรับแต่ละเฟส
            $table->float('power1')->nullable()->after('power');
            $table->float('power2')->nullable()->after('power1');
            $table->float('power3')->nullable()->after('power2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meter_readings', function (Blueprint $table) {
            // ลบฟิลด์สำหรับข้อมูล 3 เฟส
            $table->dropColumn([
                'voltage1',
                'voltage2',
                'voltage3',
                'current1',
                'current2',
                'current3',
                'power1',
                'power2',
                'power3'
            ]);
        });
    }
}
