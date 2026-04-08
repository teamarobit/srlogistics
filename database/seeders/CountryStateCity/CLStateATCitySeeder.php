<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateATCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 769,
'name' => 'Copiapó'
],[
'state_id' => 769,
'name' => 'Diego de Almagro'
],[
'state_id' => 769,
'name' => 'Chañaral'
],[
'state_id' => 769,
'name' => 'Huasco'
],[
'state_id' => 769,
'name' => 'Vallenar'
],[
'state_id' => 769,
'name' => 'Caldera'
],[
'state_id' => 769,
'name' => 'Tierra Amarilla'
],[
'state_id' => 769,
'name' => 'Alto del Carmen'
],[
'state_id' => 769,
'name' => 'Freirina'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
