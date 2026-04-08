<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateLRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 780,
'name' => 'Corral'
],[
'state_id' => 780,
'name' => 'La Unión'
],[
'state_id' => 780,
'name' => 'Panguipulli'
],[
'state_id' => 780,
'name' => 'Río Bueno'
],[
'state_id' => 780,
'name' => 'Valdivia'
],[
'state_id' => 780,
'name' => 'Futrono'
],[
'state_id' => 780,
'name' => 'Lago Ranco'
],[
'state_id' => 780,
'name' => 'Lanco'
],[
'state_id' => 780,
'name' => 'Los Lagos'
],[
'state_id' => 780,
'name' => 'Mariquina'
],[
'state_id' => 780,
'name' => 'Máfil'
],[
'state_id' => 780,
'name' => 'Paillaco'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
