<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState15CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1114,
'name' => 'Cana Chapetón'
],[
'state_id' => 1114,
'name' => 'Castañuelas'
],[
'state_id' => 1114,
'name' => 'Guayubín'
],[
'state_id' => 1114,
'name' => 'Hatillo Palma'
],[
'state_id' => 1114,
'name' => 'Las Matas de Santa Cruz'
],[
'state_id' => 1114,
'name' => 'Monte Cristi'
],[
'state_id' => 1114,
'name' => 'Pepillo Salcedo'
],[
'state_id' => 1114,
'name' => 'San Fernando de Monte Cristi'
],[
'state_id' => 1114,
'name' => 'Villa Elisa'
],[
'state_id' => 1114,
'name' => 'Villa Vásquez'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
