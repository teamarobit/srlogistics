<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateNBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 777,
'name' => 'Bulnes'
],[
'state_id' => 777,
'name' => 'Chillán'
],[
'state_id' => 777,
'name' => 'Coihueco'
],[
'state_id' => 777,
'name' => 'Quirihue'
],[
'state_id' => 777,
'name' => 'San Carlos'
],[
'state_id' => 777,
'name' => 'Chillán Viejo'
],[
'state_id' => 777,
'name' => 'Cobquecura'
],[
'state_id' => 777,
'name' => 'Coelemu'
],[
'state_id' => 777,
'name' => 'El Carmen'
],[
'state_id' => 777,
'name' => 'Ninhue'
],[
'state_id' => 777,
'name' => 'Ñiquén'
],[
'state_id' => 777,
'name' => 'Pemuco'
],[
'state_id' => 777,
'name' => 'Pinto'
],[
'state_id' => 777,
'name' => 'Portezuelo'
],[
'state_id' => 777,
'name' => 'Quillón'
],[
'state_id' => 777,
'name' => 'Ránquil'
],[
'state_id' => 777,
'name' => 'San Fabián'
],[
'state_id' => 777,
'name' => 'San Ignacio'
],[
'state_id' => 777,
'name' => 'San Nicolás'
],[
'state_id' => 777,
'name' => 'Treguaco'
],[
'state_id' => 777,
'name' => 'Yungay'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
