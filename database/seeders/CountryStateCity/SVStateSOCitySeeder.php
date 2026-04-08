<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class SVStateSOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1192,
'name' => 'Acajutla'
],[
'state_id' => 1192,
'name' => 'Armenia'
],[
'state_id' => 1192,
'name' => 'Izalco'
],[
'state_id' => 1192,
'name' => 'Juayúa'
],[
'state_id' => 1192,
'name' => 'Nahuizalco'
],[
'state_id' => 1192,
'name' => 'San Antonio del Monte'
],[
'state_id' => 1192,
'name' => 'Sonsonate'
],[
'state_id' => 1192,
'name' => 'Sonzacate'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
