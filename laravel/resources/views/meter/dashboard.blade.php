<!-- resources/views/meter/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Meter Dashboard - 3 Phase</title>
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        .phase-tab {
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 5px 5px 0 0;
            margin-right: 5px;
        }
        .phase-tab.active {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-bottom: none;
            font-weight: bold;
        }
        .phase-content {
            display: none;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 0 5px 5px 5px;
            border: 1px solid #dee2e6;
        }
        .phase-content.active {
            display: block;
        }
        .phase-badge {
            font-size: 0.8rem;
            padding: 3px 8px;
            border-radius: 10px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="header-bg">
        <div class="container">
            <div class="d-flex align-items-center">
                <h1>
                    <span class="pv31-icon">PV</span>
                    Power Meter Monitoring System - 3 Phase
                </h1>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <!-- Meter 1 Card with 3-Phase Data -->
        <div class="row">
            <div class="col-12">
                <div class="card meter-card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <span>Power Meter PV31 Ai205 - #1</span>
                        <div>
                            <span class="badge bg-light text-dark">Last Update: <span id="meter1-time">-</span></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Summary Values -->
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter1-voltage">0</h3>
                                        <p class="text-muted">Avg Voltage (V)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter1-current">0</h3>
                                        <p class="text-muted">Avg Current (A)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter1-power">0</h3>
                                        <p class="text-muted">Total Power (W)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phase Tabs -->
                        <div class="d-flex mb-2 meter1-phase-tabs">
                            <div class="phase-tab active" data-phase="all" data-meter="1">All Phases</div>
                            <div class="phase-tab" data-phase="1" data-meter="1">Phase 1</div>
                            <div class="phase-tab" data-phase="2" data-meter="1">Phase 2</div>
                            <div class="phase-tab" data-phase="3" data-meter="1">Phase 3</div>
                        </div>

                        <!-- Phase Content -->
                        <div class="phase-content active" id="meter1-all-phases">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>Phase 1 <span class="badge bg-primary phase-badge">L1</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter1-voltage1">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter1-current1">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter1-power1">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Phase 2 <span class="badge bg-success phase-badge">L2</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter1-voltage2">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter1-current2">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter1-power2">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Phase 3 <span class="badge bg-danger phase-badge">L3</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter1-voltage3">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter1-current3">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter1-power3">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h6>Frequency: <span id="meter1-frequency">0</span> Hz</h6>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Power Factor: <span id="meter1-pf">0</span></h6>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Energy: <span id="meter1-energy">0</span> kWh</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter1-phase1">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 1 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter1-voltage1-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter1-current1-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter1-power1-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter1-phase2">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 2 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter1-voltage2-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter1-current2-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter1-power2-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter1-phase3">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 3 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter1-voltage3-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter1-current3-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter1-power3-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meter 2 Card with 3-Phase Data -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card meter-card">
                    <div class="card-header bg-success text-white d-flex justify-content-between">
                        <span>Power Meter PV31 Ai205 - #2</span>
                        <div>
                            <span class="badge bg-light text-dark">Last Update: <span id="meter2-time">-</span></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Summary Values -->
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter2-voltage">0</h3>
                                        <p class="text-muted">Avg Voltage (V)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter2-current">0</h3>
                                        <p class="text-muted">Avg Current (A)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter2-power">0</h3>
                                        <p class="text-muted">Total Power (W)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phase Tabs -->
                        <div class="d-flex mb-2 meter2-phase-tabs">
                            <div class="phase-tab active" data-phase="all" data-meter="2">All Phases</div>
                            <div class="phase-tab" data-phase="1" data-meter="2">Phase 1</div>
                            <div class="phase-tab" data-phase="2" data-meter="2">Phase 2</div>
                            <div class="phase-tab" data-phase="3" data-meter="2">Phase 3</div>
                        </div>

                        <!-- Phase Content -->
                        <div class="phase-content active" id="meter2-all-phases">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>Phase 1 <span class="badge bg-primary phase-badge">L1</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter2-voltage1">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter2-current1">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter2-power1">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Phase 2 <span class="badge bg-success phase-badge">L2</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter2-voltage2">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter2-current2">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter2-power2">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Phase 3 <span class="badge bg-danger phase-badge">L3</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter2-voltage3">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter2-current3">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter2-power3">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h6>Frequency: <span id="meter2-frequency">0</span> Hz</h6>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Power Factor: <span id="meter2-pf">0</span></h6>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Energy: <span id="meter2-energy">0</span> kWh</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter2-phase1">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 1 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter2-voltage1-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter2-current1-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter2-power1-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter2-phase2">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 2 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter2-voltage2-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter2-current2-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter2-power2-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter2-phase3">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 3 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter2-voltage3-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter2-current3-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter2-power3-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Section -->
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
                                        <th>Avg Voltage (V)</th>
                                        <th>Avg Current (A)</th>
                                        <th>Total Power (W)</th>
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
                columns: [
                    { data: 'id' },
                    { data: 'meter_id' },
                    { data: 'voltage' },
                    { data: 'current' },
                    { data: 'power' },
                    { data: 'energy' },
                    { data: 'frequency' },
                    { data: 'power_factor' },
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
                order: [[0, 'desc']], // เรียงตาม ID ล่าสุด
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

            // จัดการกับแท็บเฟส
            $('.phase-tab').click(function<!-- resources/views/meter/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Meter Dashboard - 3 Phase</title>
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        .phase-tab {
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 5px 5px 0 0;
            margin-right: 5px;
        }
        .phase-tab.active {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-bottom: none;
            font-weight: bold;
        }
        .phase-content {
            display: none;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 0 5px 5px 5px;
            border: 1px solid #dee2e6;
        }
        .phase-content.active {
            display: block;
        }
        .phase-badge {
            font-size: 0.8rem;
            padding: 3px 8px;
            border-radius: 10px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="header-bg">
        <div class="container">
            <div class="d-flex align-items-center">
                <h1>
                    <span class="pv31-icon">PV</span>
                    Power Meter Monitoring System - 3 Phase
                </h1>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <!-- Meter 1 Card with 3-Phase Data -->
        <div class="row">
            <div class="col-12">
                <div class="card meter-card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <span>Power Meter PV31 Ai205 - #1</span>
                        <div>
                            <span class="badge bg-light text-dark">Last Update: <span id="meter1-time">-</span></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Summary Values -->
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter1-voltage">0</h3>
                                        <p class="text-muted">Avg Voltage (V)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter1-current">0</h3>
                                        <p class="text-muted">Avg Current (A)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter1-power">0</h3>
                                        <p class="text-muted">Total Power (W)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phase Tabs -->
                        <div class="d-flex mb-2 meter1-phase-tabs">
                            <div class="phase-tab active" data-phase="all" data-meter="1">All Phases</div>
                            <div class="phase-tab" data-phase="1" data-meter="1">Phase 1</div>
                            <div class="phase-tab" data-phase="2" data-meter="1">Phase 2</div>
                            <div class="phase-tab" data-phase="3" data-meter="1">Phase 3</div>
                        </div>

                        <!-- Phase Content -->
                        <div class="phase-content active" id="meter1-all-phases">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>Phase 1 <span class="badge bg-primary phase-badge">L1</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter1-voltage1">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter1-current1">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter1-power1">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Phase 2 <span class="badge bg-success phase-badge">L2</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter1-voltage2">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter1-current2">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter1-power2">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Phase 3 <span class="badge bg-danger phase-badge">L3</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter1-voltage3">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter1-current3">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter1-power3">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h6>Frequency: <span id="meter1-frequency">0</span> Hz</h6>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Power Factor: <span id="meter1-pf">0</span></h6>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Energy: <span id="meter1-energy">0</span> kWh</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter1-phase1">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 1 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter1-voltage1-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter1-current1-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter1-power1-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter1-phase2">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 2 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter1-voltage2-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter1-current2-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter1-power2-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter1-phase3">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 3 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter1-voltage3-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter1-current3-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter1-power3-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meter 2 Card with 3-Phase Data -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card meter-card">
                    <div class="card-header bg-success text-white d-flex justify-content-between">
                        <span>Power Meter PV31 Ai205 - #2</span>
                        <div>
                            <span class="badge bg-light text-dark">Last Update: <span id="meter2-time">-</span></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Summary Values -->
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter2-voltage">0</h3>
                                        <p class="text-muted">Avg Voltage (V)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter2-current">0</h3>
                                        <p class="text-muted">Avg Current (A)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="mb-0" id="meter2-power">0</h3>
                                        <p class="text-muted">Total Power (W)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phase Tabs -->
                        <div class="d-flex mb-2 meter2-phase-tabs">
                            <div class="phase-tab active" data-phase="all" data-meter="2">All Phases</div>
                            <div class="phase-tab" data-phase="1" data-meter="2">Phase 1</div>
                            <div class="phase-tab" data-phase="2" data-meter="2">Phase 2</div>
                            <div class="phase-tab" data-phase="3" data-meter="2">Phase 3</div>
                        </div>

                        <!-- Phase Content -->
                        <div class="phase-content active" id="meter2-all-phases">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>Phase 1 <span class="badge bg-primary phase-badge">L1</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter2-voltage1">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter2-current1">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter2-power1">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Phase 2 <span class="badge bg-success phase-badge">L2</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter2-voltage2">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter2-current2">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter2-power2">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h5>Phase 3 <span class="badge bg-danger phase-badge">L3</span></h5>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Voltage:</span>
                                            <strong id="meter2-voltage3">0</strong> V
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Current:</span>
                                            <strong id="meter2-current3">0</strong> A
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Power:</span>
                                            <strong id="meter2-power3">0</strong> W
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h6>Frequency: <span id="meter2-frequency">0</span> Hz</h6>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Power Factor: <span id="meter2-pf">0</span></h6>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Energy: <span id="meter2-energy">0</span> kWh</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter2-phase1">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 1 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter2-voltage1-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter2-current1-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter2-power1-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter2-phase2">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 2 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter2-voltage2-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter2-current2-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter2-power2-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="phase-content" id="meter2-phase3">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Phase 3 Details</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>Voltage: <span id="meter2-voltage3-detail">0</span> V</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Current: <span id="meter2-current3-detail">0</span> A</h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5>Power: <span id="meter2-power3-detail">0</span> W</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Section -->
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
                                        <th>Avg Voltage (V)</th>
                                        <th>Avg Current (A)</th>
                                        <th>Total Power (W)</th>
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
                columns: [
                    { data: 'id' },
                    { data: 'meter_id' },
                    { data: 'voltage' },
                    { data: 'current' },
                    { data: 'power' },
                    { data: 'energy' },
                    { data: 'frequency' },
                    { data: 'power_factor' },
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
                order: [[0, 'desc']], // เรียงตาม ID ล่าสุด
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

            // จัดการกับแท็บเฟส
            $('.phase-tab').click(function() {
                var phase = $(this).data('phase');
                var meter = $(this).data('meter');

                // ลบคลาส active จากแท็บทั้งหมดของมิเตอร์นี้
                $('.meter' + meter + '-phase-tabs .phase-tab').removeClass('active');
                // เพิ่มคลาส active ให้กับแท็บที่คลิก
                $(this).addClass('active');

                // ซ่อนเนื้อหาทั้งหมดของมิเตอร์นี้
                $('#meter' + meter + '-all-phases, #meter' + meter + '-phase1, #meter' + meter + '-phase2, #meter' + meter + '-phase3').removeClass('active');

                // แสดงเนื้อหาที่เกี่ยวข้อง
                if (phase === 'all') {
                    $('#meter' + meter + '-all-phases').addClass('active');
                } else {
                    $('#meter' + meter + '-phase' + phase).addClass('active');
                }
            });

            // อัปเดตข้อมูลสรุปสำหรับแต่ละมิเตอร์
            function updateMeterSummary() {
                $.ajax({
                    url: '/readings',
                    method: 'GET',
                    success: function(response) {
                        let meter1Data = null;
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

                        // อัปเดตข้อมูลสำหรับ Meter 1
                        if (meter1Data) {
                            // ค่าเฉลี่ยและค่ารวม
                            $('#meter1-voltage').text(meter1Data.voltage || 0);
                            $('#meter1-current').text(meter1Data.current || 0);
                            $('#meter1-power').text(meter1Data.power || 0);
                            $('#meter1-frequency').text(meter1Data.frequency || 0);
                            $('#meter1-pf').text(meter1Data.power_factor || 0);
                            $('#meter1-energy').text(meter1Data.energy || 0);

                            // ข้อมูลแยกตามเฟส
                            $('#meter1-voltage1, #meter1-voltage1-detail').text(meter1Data.voltage1 || 0);
                            $('#meter1-voltage2, #meter1-voltage2-detail').text(meter1Data.voltage2 || 0);
                            $('#meter1-voltage3, #meter1-voltage3-detail').text(meter1Data.voltage3 || 0);

                            $('#meter1-current1, #meter1-current1-detail').text(meter1Data.current1 || 0);
                            $('#meter1-current2, #meter1-current2-detail').text(meter1Data.current2 || 0);
                            $('#meter1-current3, #meter1-current3-detail').text(meter1Data.current3 || 0);

                            $('#meter1-power1, #meter1-power1-detail').text(meter1Data.power1 || 0);
                            $('#meter1-power2, #meter1-power2-detail').text(meter1Data.power2 || 0);
                            $('#meter1-power3, #meter1-power3-detail').text(meter1Data.power3 || 0);

                            // แสดงเวลาอัปเดตล่าสุด
                            if (meter1Data.created_at) {
                                const date = new Date(meter1Data.created_at);
                                $('#meter1-time').text(date.toLocaleString('th-TH'));
                            }
                        }

                        // อัปเดตข้อมูลสำหรับ Meter 2
                        if (meter2Data) {
                            // ค่าเฉลี่ยและค่ารวม
                            $('#meter2-voltage').text(meter2Data.voltage || 0);
                            $('#meter2-current').text(meter2Data.current || 0);
                            $('#meter2-power').text(meter2Data.power || 0);
                            $('#meter2-frequency').text(meter2Data.frequency || 0);
                            $('#meter2-pf').text(meter2Data.power_factor || 0);
                            $('#meter2-energy').text(meter2Data.energy || 0);

                            // ข้อมูลแยกตามเฟส
                            $('#meter2-voltage1, #meter2-voltage1-detail').text(meter2Data.voltage1 || 0);
                            $('#meter2-voltage2, #meter2-voltage2-detail').text(meter2Data.voltage2 || 0);
                            $('#meter2-voltage3, #meter2-voltage3-detail').text(meter2Data.voltage3 || 0);

                            $('#meter2-current1, #meter2-current1-detail').text(meter2Data.current1 || 0);
                            $('#meter2-current2, #meter2-current2-detail').text(meter2Data.current2 || 0);
                            $('#meter2-current3, #meter2-current3-detail').text(meter2Data.current3 || 0);

                            $('#meter2-power1, #meter2-power1-detail').text(meter2Data.power1 || 0);
                            $('#meter2-power2, #meter2-power2-detail').text(meter2Data.power2 || 0);
                            $('#meter2-power3, #meter2-power3-detail').text(meter2Data.power3 || 0);

                            // แสดงเวลาอัปเดตล่าสุด
                            if (meter2Data.created_at) {
                                const date = new Date(meter2Data.created_at);
                                $('#meter2-time').text(date.toLocaleString('th-TH'));
                            }
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