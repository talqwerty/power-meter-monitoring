<!-- resources/views/meter/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Meter Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- DataTables Buttons CSS -->
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <style>
        .header-bg {
            background-color: black;
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

        .dt-buttons {
            margin-bottom: 15px;
        }

        .dt-button {
            margin-right: 5px;
        }

        button.dt-button:hover:not(.disabled) {
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }

        /* ลดขนาดของปุ่ม Export */
        div.dt-buttons {
            display: inline-block;
            margin-right: 10px;
        }

        /* จัดการ layout ของปุ่ม ExportButtons กับ Filter */
        .dataTables_filter {
            float: right;
        }
        .pagination {
            --bs-pagination-color: black;
        }

        .active>.page-link, .page-link.active {
            background-color: black;
            border-color: black;
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
                    <div class="card-header bg-black text-white">
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card สรุปข้อมูล PV31_02 -->
            <div class="col-md-6">
                <div class="card meter-card">
                    <div class="card-header bg-black text-white">
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
                        <div>
                            <span id="total-records" class="me-3">Total Records: 0</span>
                            <button id="refresh-data" class="btn btn-sm btn-light">
                                <i class="bi bi-arrow-clockwise"></i> Refresh
                            </button>
                        </div>
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
                                    <button id="apply-date-filter" class="btn btn-dark">ค้นหา</button>
                                    <button id="clear-date-filter" class="btn btn-light">ล้าง</button>
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
                                    <button id="apply-meter-filter" class="btn btn-dark">กรอง</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">จำนวนแถวต่อหน้า</span>
                                    <select id="page-length" class="form-select">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="-1">ทั้งหมด</option>
                                    </select>
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
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            // กำหนดค่าเริ่มต้นสำหรับตัวกรองวันที่
            var today = new Date();
            var oneWeekAgo = new Date();
            oneWeekAgo.setDate(today.getDate() - 7);

            $('#date-start').val(oneWeekAgo.toISOString().split('T')[0]);
            $('#date-end').val(today.toISOString().split('T')[0]);

            // กำหนดชื่อไฟล์สำหรับ export
            var getExportFileName = function() {
                var dateFilter = '';
                if ($('#date-start').val() && $('#date-end').val()) {
                    dateFilter = $('#date-start').val() + '_to_' + $('#date-end').val();
                }

                var meterFilter = $('#meter-filter').val() || 'All_Meters';

                return 'PowerMeterData_' + meterFilter + '_' + dateFilter;
            };

            // ตั้งค่า DataTable
            var table = $('#meter-readings-table').DataTable({
                processing: true,
                serverSide: false, // ใช้ client-side processing เพื่อให้ได้ข้อมูลทั้งหมด
                dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"p>>i',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                        className: 'btn btn-dark',
                        title: null,
                        filename: function() { return getExportFileName(); },
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="bi bi-file-earmark-text"></i> CSV',
                        className: 'btn btn-dark',
                        title: null,
                        filename: function() { return getExportFileName(); },
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],
                ajax: {
                    url: '/readings',
                    dataSrc: function(response) {
                        // แสดงจำนวนข้อมูลทั้งหมด
                        $('#total-records').text('Total Records: ' + response.data.length);
                        // ส่งกลับข้อมูลทั้งหมดเพื่อให้ DataTable จัดการ
                        return response.data;
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'meter_id'
                    },
                    {
                        data: 'voltage1',
                        render: function(data) {
                            return data ? parseFloat(data).toFixed(2) : '0.00';
                        }
                    },
                    {
                        data: 'voltage2',
                        render: function(data) {
                            return data ? parseFloat(data).toFixed(2) : '0.00';
                        }
                    },
                    {
                        data: 'voltage3',
                        render: function(data) {
                            return data ? parseFloat(data).toFixed(2) : '0.00';
                        }
                    },
                    {
                        data: 'current1',
                        render: function(data) {
                            return data ? parseFloat(data).toFixed(2) : '0.00';
                        }
                    },
                    {
                        data: 'current2',
                        render: function(data) {
                            return data ? parseFloat(data).toFixed(2) : '0.00';
                        }
                    },
                    {
                        data: 'current3',
                        render: function(data) {
                            return data ? parseFloat(data).toFixed(2) : '0.00';
                        }
                    },
                    {
                        data: 'power1',
                        render: function(data) {
                            return data ? parseFloat(data).toFixed(2) : '0.00';
                        }
                    },
                    {
                        data: 'power2',
                        render: function(data) {
                            return data ? parseFloat(data).toFixed(2) : '0.00';
                        }
                    },
                    {
                        data: 'power3',
                        render: function(data) {
                            return data ? parseFloat(data).toFixed(2) : '0.00';
                        }
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
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "ทั้งหมด"]
                ],
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

            // จัดการเปลี่ยนจำนวนแถวต่อหน้า
            $('#page-length').change(function() {
                table.page.len($(this).val()).draw();
            });

            // ฟังก์ชันสำหรับกรองข้อมูล
            function applyFilters() {
                const startDate = $('#date-start').val();
                const endDate = $('#date-end').val();
                const meterId = $('#meter-filter').val();

                // สร้าง URL สำหรับดึงข้อมูลใหม่พร้อมพารามิเตอร์
                let url = '/readings';
                const params = [];

                if (startDate) params.push(`start_date=${startDate}`);
                if (endDate) params.push(`end_date=${endDate}`);
                if (meterId) params.push(`meter_id=${meterId}`);

                if (params.length > 0) {
                    url += '?' + params.join('&');
                }

                // อัปเดต URL ของ Ajax request แล้วโหลดข้อมูลใหม่
                table.ajax.url(url).load();
            }

            // เหตุการณ์คลิกปุ่มค้นหาตามวันที่
            $('#apply-date-filter').click(function() {
                applyFilters();
            });

            // เหตุการณ์คลิกปุ่มล้างตัวกรองวันที่
            $('#clear-date-filter').click(function() {
                $('#date-start').val('');
                $('#date-end').val('');
                applyFilters();
            });

            // เหตุการณ์คลิกปุ่มกรองตามมิเตอร์
            $('#apply-meter-filter').click(function() {
                applyFilters();
            });

            // อัปเดตข้อมูลสรุปสำหรับแต่ละมิเตอร์
            function updateMeterSummary() {
                $.ajax({
                    url: '/readings/latest',  // ใช้ endpoint ใหม่สำหรับข้อมูลล่าสุดเท่านั้น
                    method: 'GET',
                    success: function(response) {
                        // อัปเดตข้อมูลสำหรับ Meter 1
                        if (response.meter1) {
                            const meter1Data = response.meter1;
                            const AvgVoltage = meter1Data.voltage1 + meter1Data.voltage2 + meter1Data.voltage3 / 3;
                            const AvgCurrent = meter1Data.current1 + meter1Data.current2 + meter1Data.current3 / 3;
                            const AvgPower = meter1Data.power1 + meter1Data.power2 + meter1Data.power3 / 3;

                            $('#meter1-voltage').text(AvgVoltage.toFixed(2) || 0);
                            $('#meter1-current').text(AvgCurrent.toFixed(2) || 0);
                            $('#meter1-power').text(AvgPower.toFixed(2) || 0);
                        }

                        // อัปเดตข้อมูลสำหรับ Meter 2
                        if (response.meter2) {
                            const meter2Data = response.meter2;
                            const AvgVoltage = meter2Data.voltage1 + meter2Data.voltage2 + meter2Data.voltage3 / 3;
                            const AvgCurrent = meter2Data.current1 + meter2Data.current2 + meter2Data.current3 / 3;
                            const AvgPower = meter2Data.power1 + meter2Data.power2 + meter2Data.power3 / 3;

                            $('#meter2-voltage').text(AvgVoltage.toFixed(2) || 0);
                            $('#meter2-current').text(AvgCurrent.toFixed(2) || 0);
                            $('#meter2-power').text(AvgPower.toFixed(2) || 0);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching meter data:', error);
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