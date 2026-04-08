<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState24CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 569,
'name' => 'Asen'
],[
'state_id' => 569,
'name' => 'Chirpan'
],[
'state_id' => 569,
'name' => 'Gurkovo'
],[
'state_id' => 569,
'name' => 'Gŭlŭbovo'
],[
'state_id' => 569,
'name' => 'Kazanlak'
],[
'state_id' => 569,
'name' => 'Maglizh'
],[
'state_id' => 569,
'name' => 'Nikolaevo'
],[
'state_id' => 569,
'name' => 'Obshtina Bratya Daskalovi'
],[
'state_id' => 569,
'name' => 'Obshtina Chirpan'
],[
'state_id' => 569,
'name' => 'Obshtina Galabovo'
],[
'state_id' => 569,
'name' => 'Obshtina Gurkovo'
],[
'state_id' => 569,
'name' => 'Obshtina Kazanlŭk'
],[
'state_id' => 569,
'name' => 'Obshtina Maglizh'
],[
'state_id' => 569,
'name' => 'Obshtina Nikolaevo'
],[
'state_id' => 569,
'name' => 'Obshtina Opan'
],[
'state_id' => 569,
'name' => 'Obshtina Pavel Banya'
],[
'state_id' => 569,
'name' => 'Obshtina Radnevo'
],[
'state_id' => 569,
'name' => 'Obshtina Stara Zagora'
],[
'state_id' => 569,
'name' => 'Pavel Banya'
],[
'state_id' => 569,
'name' => 'Radnevo'
],[
'state_id' => 569,
'name' => 'Shipka'
],[
'state_id' => 569,
'name' => 'Stara Zagora'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
