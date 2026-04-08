<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActmodelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('actmodels')->insert([
            ['id'=>1,'name'=>'Auth','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>2,'name'=>'Contact','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>3,'name'=>'Customer','parent_id'=>2,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>4,'name'=>'Load Vendor (Broker)','parent_id'=>2,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>5,'name'=>'Employee','parent_id'=>2,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>6,'name'=>'Driver','parent_id'=>2,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>7,'name'=>'Vehicle Vendor','parent_id'=>2,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>8,'name'=>'Contract Master','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>9,'name'=>'Department','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>10,'name'=>'Designation','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>11,'name'=>'Vehicle Master','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>12,'name'=>'Vehicle Management','parent_id'=>11,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>13,'name'=>'Vehicle Type','parent_id'=>11,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>14,'name'=>'Vehicle Group','parent_id'=>11,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>15,'name'=>'Vehicle Status','parent_id'=>11,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>16,'name'=>'Vehicle Group Tracking Master','parent_id'=>11,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>17,'name'=>'RTO','parent_id'=>11,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>18,'name'=>'Ownership Type','parent_id'=>11,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>19,'name'=>'Locations','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>20,'name'=>'Routes','parent_id'=>19,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>21,'name'=>'Branch','parent_id'=>19,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>22,'name'=>'Location Points','parent_id'=>19,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>23,'name'=>'Service Center Master','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>24,'name'=>'Service Center','parent_id'=>23,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>25,'name'=>'Services','parent_id'=>23,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>26,'name'=>'Service Key Points','parent_id'=>23,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>27,'name'=>'Spare Parts','parent_id'=>23,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>28,'name'=>'Maintenance Items','parent_id'=>23,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>29,'name'=>'Roles and Permission','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>30,'name'=>'Grievance Master','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>31,'name'=>'Finance Master','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>32,'name'=>'Account Groups','parent_id'=>31,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>33,'name'=>'Account Heads','parent_id'=>31,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>34,'name'=>'Expense Type Master','parent_id'=>31,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>35,'name'=>'Voucher Master','parent_id'=>31,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>36,'name'=>'Chart of Accounts','parent_id'=>31,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>37,'name'=>'Asset Master','parent_id'=>31,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>38,'name'=>'Miscellaneous Master','parent_id'=>0,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>39,'name'=>'Document','parent_id'=>38,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>40,'name'=>'Fuel Card','parent_id'=>38,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>41,'name'=>'Fuel Station','parent_id'=>38,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>42,'name'=>'Toll Station','parent_id'=>38,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>43,'name'=>'Border / RTO Checkpoint','parent_id'=>38,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>44,'name'=>'POD Master','parent_id'=>38,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>45,'name'=>'Customer Location','parent_id'=>3,'created_at'=>'2026-01-20 07:56:40'],
            ['id'=>46,'name'=>'Customer Contract','parent_id'=>3,'created_at'=>'2026-01-20 07:56:59'],
            ['id'=>47,'name'=>'Customer Contract Pricing','parent_id'=>3,'created_at'=>'2026-01-20 07:57:43'],
            ['id'=>49,'name'=>'Skill Set','parent_id'=>23,'created_at'=>'2026-02-04 09:58:21'],
            ['id'=>50,'name'=>'Jobrank','parent_id'=>0,'created_at'=>'2026-02-24 07:21:11'],
            ['id'=>51,'name'=>'Employee Asset','parent_id'=>5,'created_at'=>'2026-02-24 10:15:10'],
            ['id'=>52,'name'=>'Employee Work Experience','parent_id'=>5,'created_at'=>'2026-02-25 03:26:16'],
            ['id'=>53,'name'=>'Load Vendor Location','parent_id'=>4,'created_at'=>'2026-02-27 06:49:14'],
            ['id'=>54,'name'=>'Vehicle GPS','parent_id'=>0,'created_at'=>'2026-03-18 09:32:59'],
            ['id'=>55,'name'=>'Provider Master','parent_id'=>0,'created_at'=>'2026-03-27 06:28:52'],
            ['id'=>56,'name'=>'GPS Provider','parent_id'=>55,'created_at'=>'2026-03-27 06:29:14'],
            ['id'=>57,'name'=>'Fastag Provider','parent_id'=>55,'created_at'=>'2026-03-27 06:29:36'],
            ['id'=>58,'name'=>'Digital Lock Provider','parent_id'=>55,'created_at'=>'2026-03-27 06:29:54'],
            ['id'=>59,'name'=>'Tyre Vendor','parent_id'=>2,'created_at'=>'2025-07-22 17:07:46'],
            ['id'=>60,'name'=>'Vehicle Detail','parent_id'=>0,'created_at'=>'2026-03-30 09:40:50'],
            ['id'=>61,'name'=>'Vehicle Fasttag','parent_id'=>60,'created_at'=>'2026-03-30 09:41:33'],
            ['id'=>62,'name'=>'Vehicle GPS','parent_id'=>60,'created_at'=>'2026-03-30 09:41:47'],
            ['id'=>63,'name'=>'Vehicle Tyre','parent_id'=>60,'created_at'=>'2026-03-30 09:42:04'],
            ['id'=>64,'name'=>'Vehicle Battery','parent_id'=>60,'created_at'=>'2026-03-30 09:42:16'],
            ['id'=>65,'name'=>'Vehicle Digital Lock','parent_id'=>60,'created_at'=>'2026-03-30 09:42:28'],
            ['id'=>66,'name'=>'Tyre','parent_id'=>0,'created_at'=>'2026-03-30 09:42:04'],
            ['id'=>67,'name'=>'Vehicle EMI','parent_id'=>60,'created_at'=>'2026-03-31 15:18:48'],
            ['id'=>68,'name'=>'Finance Notes','parent_id'=>67,'created_at'=>'2026-04-02 06:45:39'],
            ['id'=>69,'name'=>'Battery Vendor','parent_id'=>2,'created_at'=>'2026-04-07 05:28:18'],
        ]);
    }
}
