<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GEStateSZCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1421,
'name' => 'Abasha'
],[
'state_id' => 1421,
'name' => 'Jvari'
],[
'state_id' => 1421,
'name' => 'Khobi'
],[
'state_id' => 1421,
'name' => 'Kveda Chkhorots’q’u'
],[
'state_id' => 1421,
'name' => 'Mart’vili'
],[
'state_id' => 1421,
'name' => 'Mest’ia'
],[
'state_id' => 1421,
'name' => 'Mest’iis Munitsip’alit’et’i'
],[
'state_id' => 1421,
'name' => 'Orsant’ia'
],[
'state_id' => 1421,
'name' => 'P’ot’i'
],[
'state_id' => 1421,
'name' => 'Senak’i'
],[
'state_id' => 1421,
'name' => 'Tsalenjikha'
],[
'state_id' => 1421,
'name' => 'Zugdidi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
