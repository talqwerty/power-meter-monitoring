# Power Meter Monitoring System

ระบบตรวจสอบและแสดงผลข้อมูลมิเตอร์ไฟฟ้า PV31 Ai205 แบบเรียลไทม์ ด้วย Laravel, Docker, Node-RED และ MySQL

## คุณสมบัติหลัก

- ติดตามข้อมูลจากมิเตอร์ไฟฟ้า PV31 Ai205
- รองรับการแสดงผลระบบไฟฟ้า 3 เฟส
- แสดงผลค่าพลังงานแบบเรียลไทม์ในรูปแบบ Dashboard ที่ใช้งานง่าย
- บันทึกประวัติข้อมูลลงฐานข้อมูลสำหรับการวิเคราะห์ย้อนหลัง
- กรองข้อมูลตามเวลาและรหัสมิเตอร์
- แสดงข้อมูลแบบตาราง พร้อมระบบค้นหาและการแบ่งหน้า

## สารบัญ

1. [ภาพรวมระบบ](#ภาพรวมระบบ)
2. [การติดตั้ง](#การติดตั้ง)
3. [การใช้งาน](#การใช้งาน)
4. [โครงสร้างโปรเจค](#โครงสร้างโปรเจค)
5. [API Endpoints](#api-endpoints)
6. [การจำลองมิเตอร์](#การจำลองมิเตอร์)
7. [การเชื่อมต่อมิเตอร์จริง](#การเชื่อมต่อมิเตอร์จริง)

## ภาพรวมระบบ

ระบบประกอบด้วยส่วนประกอบหลักดังนี้:

- **Laravel**: แอปพลิเคชันหลักสำหรับแสดงผล Dashboard และจัดการ API
- **Node-RED**: สำหรับการเชื่อมต่อกับมิเตอร์ผ่าน Modbus และประมวลผลข้อมูล
- **MySQL**: ฐานข้อมูลสำหรับเก็บประวัติการอ่านค่ามิเตอร์
- **Docker**: จัดการสภาพแวดล้อมการทำงานทั้งหมด

## การติดตั้ง

### ขั้นตอนที่ 1: Clone โปรเจค

```bash
git clone https://github.com/your-username/power-meter-monitoring.git
cd power-meter-monitoring
```

### ขั้นตอนที่ 2: เริ่มต้น Docker Containers

```bash
docker-compose up -d
```

### ขั้นตอนที่ 3: ติดตั้ง Laravel Dependencies

```bash
docker-compose exec app composer install
cp .env.example .env
docker-compose exec app php artisan key:generate
```

### ขั้นตอนที่ 4: ตั้งค่าฐานข้อมูล

```bash
docker-compose exec app php artisan migrate
```

### ขั้นตอนที่ 5: นำเข้า Flow ใน Node-RED

1. เปิด Node-RED ที่ http://localhost:1880
2. คลิกที่เมนู (≡) > Import
3. คัดลอกเนื้อหาจากไฟล์ `node-red-flows.json` และวางลงในช่อง Import
4. คลิก Import
5. node-red-contrib-modbus.
6. node-red-node-mysql

## การใช้งาน

- **Laravel Dashboard**: http://localhost:8000/meter-dashboard
- **Node-RED**: http://localhost:1880
- **API Endpoint**: http://localhost:8000/api/readings

### การเข้าถึง Dashboard

Dashboard จะแสดงข้อมูลจากมิเตอร์ตามเวลาจริง และมีฟีเจอร์ต่างๆ เช่น:

- แสดงข้อมูลแยกตามเฟส (L1, L2, L3)
- แสดงค่าแรงดันไฟฟ้า กระแสไฟฟ้า และกำลังไฟฟ้าเฉลี่ย
- กราฟแสดงแนวโน้มข้อมูลตามเวลา
- ตารางแสดงประวัติข้อมูลพร้อมตัวกรอง

### คำสั่งที่ใช้บ่อย

ลบข้อมูลในตาราง meter_readings:
```bash
docker-compose exec mysql mysql -u power_user -p power_meter_db -e "DELETE FROM meter_readings; ALTER TABLE meter_readings AUTO_INCREMENT = 1;"
```

รีเซ็ตฐานข้อมูลทั้งหมด:
```bash
docker-compose exec app php artisan migrate:fresh
```

## โครงสร้างโปรเจค

```
power-meter-monitoring/
├── docker/                  # ไฟล์การตั้งค่า Docker
│   ├── nginx/               # การตั้งค่า Nginx
│   └── php/                 # Dockerfile สำหรับ PHP
├── laravel/                 # โค้ด Laravel
│   ├── app/                 # โค้ดหลักของแอปพลิเคชัน
│   │   ├── Http/Controllers/  # Controllers
│   │   └── Models/          # Models
│   ├── database/            # Migrations และ seeds
│   ├── resources/           # Views และ assets
│   └── routes/              # การกำหนดเส้นทาง
├── node-red-flows.json      # Flow สำหรับ Node-RED
└── docker-compose.yml       # การตั้งค่า Docker Compose
```

## API Endpoints

### GET /api/readings

ดึงข้อมูลการอ่านมิเตอร์ทั้งหมด

พารามิเตอร์ที่รองรับ:
- `meter_id` - กรองตามรหัสมิเตอร์ (เช่น PV31_01)
- `start_date` - วันที่เริ่มต้น (YYYY-MM-DD)
- `end_date` - วันที่สิ้นสุด (YYYY-MM-DD)

ตัวอย่าง: `GET /api/readings?meter_id=PV31_01&start_date=2025-03-01&end_date=2025-03-22`

### POST /api/readings

บันทึกข้อมูลการอ่านมิเตอร์ใหม่

ตัวอย่างข้อมูล:
```json
{
  "meter_id": "PV31_01",
  "voltage": 220.5,
  "current": 5.2,
  "power": 1147.0,
  "frequency": 50.0,
  "power_factor": 0.95,
  "energy": 0.01,
  "voltage1": 220.1,
  "voltage2": 221.2,
  "voltage3": 220.2,
  "current1": 5.1,
  "current2": 5.3,
  "current3": 5.2,
  "power1": 380.0,
  "power2": 390.0,
  "power3": 377.0
}
```

## การจำลองมิเตอร์

Node-RED มี flow สำหรับจำลองข้อมูลจากมิเตอร์ PV31 Ai205 ซึ่งจะสร้างข้อมูลสุ่มและส่งไปยังฐานข้อมูลทุก 10 วินาที

การเปิด/ปิดการจำลอง:
1. ไปที่ Node-RED (http://localhost:1880)
2. คลิกที่ node "Generate reading every 10s"
3. คลิกที่ปุ่มสีแดงด้านขวาเพื่อปิดการทำงาน หรือคลิกอีกครั้งเพื่อเปิดใช้งาน

## การเชื่อมต่อมิเตอร์จริง

ระบบรองรับการเชื่อมต่อกับมิเตอร์ PV31 Ai205 จริงผ่าน Modbus

### ฮาร์ดแวร์ที่จำเป็น:
- มิเตอร์ PV31 Ai205
- RS485 to Ethernet converter
- สาย RS485
- สาย Ethernet

### ขั้นตอนการเชื่อมต่อ:
1. เชื่อมต่อมิเตอร์กับ RS485 to Ethernet converter
2. เชื่อมต่อ converter กับเครือข่าย
3. ปรับการตั้งค่าใน Node-RED:
   - ปรับ IP address และพอร์ตของ converter
   - ตั้งค่า Unit ID และ Register addresses ตามคู่มือของมิเตอร์
   - ตั้งค่า TCP Type เป็น TELNET
4. ปิดการทำงานของ node จำลองข้อมูล และเปิดการทำงานของ node เชื่อมต่อกับมิเตอร์จริง

---

พัฒนาโดย [Kananon]
