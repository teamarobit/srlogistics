<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState18CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1091,
'name' => 'Altamira'
],[
'state_id' => 1091,
'name' => 'Cabarete'
],[
'state_id' => 1091,
'name' => 'Estero Hondo'
],[
'state_id' => 1091,
'name' => 'Guananico'
],[
'state_id' => 1091,
'name' => 'Imbert'
],[
'state_id' => 1091,
'name' => 'Los Hidalgos'
],[
'state_id' => 1091,
'name' => 'Luperón'
],[
'state_id' => 1091,
'name' => 'Monte Llano'
],[
'state_id' => 1091,
'name' => 'Puerto Plata'
],[
'state_id' => 1091,
'name' => 'Río Grande'
],[
'state_id' => 1091,
'name' => 'Sosúa'
],[
'state_id' => 1091,
'name' => 'Villa Isabela'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
