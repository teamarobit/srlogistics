<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AMStateKTCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 205,
'name' => 'Abovyan'
],[
'state_id' => 205,
'name' => 'Aghavnadzor'
],[
'state_id' => 205,
'name' => 'Akunk’'
],[
'state_id' => 205,
'name' => 'Aramus'
],[
'state_id' => 205,
'name' => 'Argel'
],[
'state_id' => 205,
'name' => 'Arzakan'
],[
'state_id' => 205,
'name' => 'Arzni'
],[
'state_id' => 205,
'name' => 'Balahovit'
],[
'state_id' => 205,
'name' => 'Bjni'
],[
'state_id' => 205,
'name' => 'Buzhakan'
],[
'state_id' => 205,
'name' => 'Byureghavan'
],[
'state_id' => 205,
'name' => 'Dzoraghbyur'
],[
'state_id' => 205,
'name' => 'Fantan'
],[
'state_id' => 205,
'name' => 'Garrni'
],[
'state_id' => 205,
'name' => 'Goght’'
],[
'state_id' => 205,
'name' => 'Hrazdan'
],[
'state_id' => 205,
'name' => 'Kaputan'
],[
'state_id' => 205,
'name' => 'Kotayk’'
],[
'state_id' => 205,
'name' => 'Lerrnanist'
],[
'state_id' => 205,
'name' => 'Mayakovski'
],[
'state_id' => 205,
'name' => 'Meghradzor'
],[
'state_id' => 205,
'name' => 'Mrgashen'
],[
'state_id' => 205,
'name' => 'Nor Geghi'
],[
'state_id' => 205,
'name' => 'Nor Gyugh'
],[
'state_id' => 205,
'name' => 'Prroshyan'
],[
'state_id' => 205,
'name' => 'Ptghni'
],[
'state_id' => 205,
'name' => 'Solak'
],[
'state_id' => 205,
'name' => 'Tsaghkadzor'
],[
'state_id' => 205,
'name' => 'Yeghvard'
],[
'state_id' => 205,
'name' => 'Zarr'
],[
'state_id' => 205,
'name' => 'Zoravan'
],[
'state_id' => 205,
'name' => 'Zovaber'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
