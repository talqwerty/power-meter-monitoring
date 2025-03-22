<!-- resources/views/meter/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Meter Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .header-bg {
            background-color: #3498db;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }

        .meter-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s;
        }

        .meter-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
            font-weight: bold;
        }

        .pv31-icon {
            width: 40px;
            height: 40px;
            background-color: #2c3e50;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: white;
        }
    </style>
</head>

<body>
    <div class="header-bg">
        <div class="container">
            <div class="d-flex align-items-center">
                <h1>
                    <span class="pv31-icon">PV</span>
                    Power Meter Monitoring System
                </h1>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row">
            <!-- Card สรุปข้อมูล PV31_01 -->
            <div class="col-md-6">
                <div class="card meter-card">
                    <div class="card-header bg-primary text-white">
                        Power Meter PV31 Ai205 - #1
                    </div>
                    <div class="card-body">
                        <div class="row" id="meter1-summary">
                            <div class="col-6">
                                <h5>voltage: <span id="meter1-voltage">0</span> V</h5>
                                <h5>current: <span id="meter1-current">0</span> A</h5>
                                <h5>power: <span id="meter1-power">0</span> W</h5>
                            </div>
                            <div class="col-6">
                                {{-- <h5>energy: <span id="meter1-energy">0</span> kWh</h5>
                                <h5>frequency: <span id="meter1-frequency">0</span> Hz</h5>
                                <h5>PF: <span id="meter1-pf">0</span></h5> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card สรุปข้อมูล PV31_02 -->
            <div class="col-md-6">
                <div class="card meter-card">
                    <div class="card-header bg-success text-white">
                        Power Meter PV31 Ai205 - #2
                    </div>
                    <div class="card-body">
                        <div class="row" id="meter2-summary">
                            <div class="col-6">
                                <h5>voltage: <span id="meter2-voltage">0</span> V</h5>
                                <h5>current: <span id="meter2-current">0</span> A</h5>
                                <h5>power: <span id="meter2-power">0</span> W</h5>
                            </div>
                            <div class="col-6">
                                {{-- <h5>energy: <span id="meter2-energy">0</span> kWh</h5>
                                <h5>frequency: <span id="meter2-frequency">0</span> Hz</h5>
                                <h5>PF: <span id="meter2-pf">0</span></h5> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card meter-card">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <span>Meter Readings Data</span>
                        <button id="refresh-data" class="btn btn-sm btn-light">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                    </div>
                    <div class="card-body">
                        <!-- Date Range Filter -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">วันที่เริ่มต้น</span>
                                    <input type="date" id="date-start" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">วันที่สิ้นสุด</span>
                                    <input type="date" id="date-end" class="form-control">
                                    <button id="apply-date-filter" class="btn btn-primary">ค้นหา</button>
                                    <button id="clear-date-filter" class="btn btn-secondary">ล้าง</button>
                                </div>
                            </div>
                        </div>
                        <!-- Meter selector filter -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">เลือกมิเตอร์</span>
                                    <select id="meter-filter" class="form-select">
                                        <option value="">ทั้งหมด</option>
                                        <option value="PV31_01">PV31_01</option>
                                        <option value="PV31_02">PV31_02</option>
                                    </select>
                                    <button id="apply-meter-filter" class="btn btn-primary">กรอง</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="meter-readings-table" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Meter ID</th>
                                        <th>Voltage1 (V)</th>
                                        <th>Voltage2 (V)</th>
                                        <th>Voltage3 (V)</th>
                                        <th>Current1 (A)</th>
                                        <th>Current2 (A)</th>
                                        <th>Current3 (A)</th>
                                        <th>Power1 (W)</th>
                                        <th>Power2 (W)</th>
                                        <th>Power3 (W)</th>
                                        <th>Energy (kWh)</th>
                                        <th>Frequency (Hz)</th>
                                        <th>Power Factor</th>
                                        <th>Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- DataTable จะเติมข้อมูลที่นี่ -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // กำหนดค่าเริ่มต้นสำหรับตัวกรองวันที่
            var today = new Date();
            var oneWeekAgo = new Date();
            oneWeekAgo.setDate(today.getDate() - 7);

            $('#date-start').val(oneWeekAgo.toISOString().split('T')[0]);
            $('#date-end').val(today.toISOString().split('T')[0]);

            // ตั้งค่า DataTable
            var table = $('#meter-readings-table').DataTable({
                processing: true,
                serverSide: false, // เปลี่ยนเป็น true หากต้องการใช้ server-side processing
                ajax: {
                    url: '/readings',
                    dataSrc: 'data',
                    data: function(d) {
                        // เพิ่มพารามิเตอร์สำหรับการกรองวันที่และมิเตอร์
                        d.start_date = $('#date-start').val();
                        d.end_date = $('#date-end').val();
                        d.meter_id = $('#meter-filter').val();
                        return d;
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'meter_id'
                    },
                    {
                        data: 'voltage1'
                    },
                    {
                        data: 'voltage2'
                    },
                    {
                        data: 'voltage3'
                    },
                    {
                        data: 'current1'
                    },
                    {
                        data: 'current2'
                    },
                    {
                        data: 'current3'
                    },
                    {
                        data: 'power1'
                    },
                    {
                        data: 'power2'
                    },
                    {
                        data: 'power3'
                    },
                    {
                        data: 'energy'
                    },
                    {
                        data: 'frequency'
                    },
                    {
                        data: 'power_factor'
                    },
                    {
                        data: 'created_at',
                        render: function(data) {
                            return new Date(data).toLocaleString('th-TH', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            });
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ], // เรียงตาม ID ล่าสุด
                pageLength: 10,
                language: {
                    search: "ค้นหา:",
                    lengthMenu: "แสดง _MENU_ รายการ",
                    info: "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    infoEmpty: "แสดง 0 ถึง 0 จาก 0 รายการ",
                    infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
                    paginate: {
                        first: "หน้าแรก",
                        last: "หน้าสุดท้าย",
                        next: "ถัดไป",
                        previous: "ก่อนหน้า"
                    }
                }
            });

            // ฟังก์ชันสำหรับกรองตามวันที่
            function filterByDate() {
                table.ajax.reload();
            }

            // เหตุการณ์คลิกปุ่มค้นหาตามวันที่
            $('#apply-date-filter').click(function() {
                filterByDate();
            });

            // เหตุการณ์คลิกปุ่มล้างตัวกรองวันที่
            $('#clear-date-filter').click(function() {
                $('#date-start').val('');
                $('#date-end').val('');
                filterByDate();
            });

            // เหตุการณ์คลิกปุ่มกรองตามมิเตอร์
            $('#apply-meter-filter').click(function() {
                filterByDate();
            });

            // ฟังก์ชันการกรองแบบกำหนดเอง (client-side)
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex, rowData, counter) {
                    // ตรวจสอบก่อนว่ามีการกำหนดวันที่หรือไม่
                    var startDate = $('#date-start').val();
                    var endDate = $('#date-end').val();
                    var meterFilter = $('#meter-filter').val();

                    if (!startDate && !endDate && !meterFilter) {
                        return true; // ไม่มีการกรอง ให้แสดงทั้งหมด
                    }

                    var valid = true;

                    // กรองตามวันที่
                    if (startDate || endDate) {
                        var dateCreated = new Date(rowData.created_at);
                        dateCreated.setHours(0, 0, 0, 0); // เซ็ตเวลาให้เป็น 00:00:00

                        if (startDate) {
                            var minDate = new Date(startDate);
                            minDate.setHours(0, 0, 0, 0);
                            if (dateCreated < minDate) {
                                valid = false;
                            }
                        }

                        if (valid && endDate) {
                            var maxDate = new Date(endDate);
                            maxDate.setHours(23, 59, 59, 999); // เซ็ตเวลาให้เป็น 23:59:59.999
                            if (dateCreated > maxDate) {
                                valid = false;
                            }
                        }
                    }

                    // กรองตามมิเตอร์
                    if (valid && meterFilter && rowData.meter_id !== meterFilter) {
                        valid = false;
                    }

                    return valid;
                }
            );

            // อัปเดตข้อมูลสรุปสำหรับแต่ละมิเตอร์
            function updateMeterSummary() {
                $.ajax({
                    url: '/readings',
                    method: 'GET',
                    success: function(response) {
                        let meter1Data = null;
                        console.log(response.data);
                        let meter2Data = null;

                        // ค้นหาข้อมูลล่าสุดสำหรับแต่ละมิเตอร์
                        response.data.forEach(function(reading) {
                            if (reading.meter_id === 'PV31_01' && !meter1Data) {
                                meter1Data = reading;
                            } else if (reading.meter_id === 'PV31_02' && !meter2Data) {
                                meter2Data = reading;
                            }

                            // หากพบข้อมูลของทั้งสองมิเตอร์แล้ว ก็หยุดการวนลูป
                            if (meter1Data && meter2Data) {
                                return false;
                            }
                        });
                        console.log(meter2Data);



                        // อัปเดตข้อมูลสำหรับ Meter 1
                        if (meter1Data) {
                            const voltage1 = parseFloat(meter1Data.voltage1);
                            const voltage2 = parseFloat(meter1Data.voltage2);
                            const voltage3 = parseFloat(meter1Data.voltage3);
                            const voltage = (voltage1 + voltage2 + voltage3) / 3;
                            $('#meter1-voltage').text(voltage.toFixed(2));


                            const current1 = parseFloat(meter1Data.current1);
                            const current2 = parseFloat(meter1Data.current2);
                            const current3 = parseFloat(meter1Data.current3);
                            const current = (current1 + current2 + current3) / 3;
                            $('#meter1-current').text(current.toFixed(2));

                            const power1 = parseFloat(meter1Data.power1);
                            const power2 = parseFloat(meter1Data.power2);
                            const power3 = parseFloat(meter1Data.power3);
                            const power = (power1 + power2 + power3) / 3;
                            $('#meter1-power').text(power.toFixed(2));

                            // $('#meter1-energy').text(meter1Data.energy);
                            // $('#meter1-frequency').text(meter1Data.frequency);
                            // $('#meter1-pf').text(meter1Data.power_factor);
                        }

                        // อัปเดตข้อมูลสำหรับ Meter 2
                        if (meter2Data) {
                           const voltage1 = parseFloat(meter2Data.voltage1);
                            const voltage2 = parseFloat(meter2Data.voltage2);
                            const voltage3 = parseFloat(meter2Data.voltage3);
                            const voltage = (voltage1 + voltage2 + voltage3) / 3;
                            $('#meter2-voltage').text(voltage.toFixed(2));


                            const current1 = parseFloat(meter2Data.current1);
                            const current2 = parseFloat(meter2Data.current2);
                            const current3 = parseFloat(meter2Data.current3);
                            const current = (current1 + current2 + current3) / 3;
                            $('#meter2-current').text(current.toFixed(2));

                            const power1 = parseFloat(meter2Data.power1);
                            const power2 = parseFloat(meter2Data.power2);
                            const power3 = parseFloat(meter2Data.power3);
                            const power = (power1 + power2 + power3) / 3;
                            $('#meter2-power').text(power.toFixed(2));

                            // $('#meter2-energy').text(meter2Data.energy);
                            // $('#meter2-frequency').text(meter2Data.frequency);
                            // $('#meter2-pf').text(meter2Data.power_factor);
                        }
                    }
                });
            }

            // เรียกใช้ฟังก์ชันเมื่อโหลดหน้า
            updateMeterSummary();

            // รีเฟรชข้อมูลเมื่อคลิกปุ่ม Refresh
            $('#refresh-data').click(function() {
                table.ajax.reload();
                updateMeterSummary();
            });

            // รีเฟรชอัตโนมัติทุก 30 วินาที
            setInterval(function() {
                table.ajax.reload(null, false); // 'false' เพื่อไม่ให้รีเซ็ตการแบ่งหน้า
                updateMeterSummary();
            }, 30000);
        });
    </script>
</body>

</html>
