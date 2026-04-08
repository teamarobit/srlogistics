<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState59CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1217,
'name' => 'Aseri'
],[
'state_id' => 1217,
'name' => 'Haljala'
],[
'state_id' => 1217,
'name' => 'Haljala vald'
],[
'state_id' => 1217,
'name' => 'Kadrina'
],[
'state_id' => 1217,
'name' => 'Kadrina vald'
],[
'state_id' => 1217,
'name' => 'Kunda'
],[
'state_id' => 1217,
'name' => 'Pajusti'
],[
'state_id' => 1217,
'name' => 'Rakke'
],[
'state_id' => 1217,
'name' => 'Rakvere'
],[
'state_id' => 1217,
'name' => 'Rakvere vald'
],[
'state_id' => 1217,
'name' => 'Sõmeru'
],[
'state_id' => 1217,
'name' => 'Tamsalu'
],[
'state_id' => 1217,
'name' => 'Tapa'
],[
'state_id' => 1217,
'name' => 'Tapa vald'
],[
'state_id' => 1217,
'name' => 'Vaiatu'
],[
'state_id' => 1217,
'name' => 'Vinni'
],[
'state_id' => 1217,
'name' => 'Vinni vald'
],[
'state_id' => 1217,
'name' => 'Viru-Nigula vald'
],[
'state_id' => 1217,
'name' => 'Väike-Maarja'
],[
'state_id' => 1217,
'name' => 'Väike-Maarja vald'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
