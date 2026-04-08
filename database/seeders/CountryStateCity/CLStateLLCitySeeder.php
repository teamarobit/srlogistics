<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateLLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 781,
'name' => 'Ancud'
],[
'state_id' => 781,
'name' => 'Calbuco'
],[
'state_id' => 781,
'name' => 'Castro'
],[
'state_id' => 781,
'name' => 'Chaitén'
],[
'state_id' => 781,
'name' => 'Chonchi'
],[
'state_id' => 781,
'name' => 'Dalcahue'
],[
'state_id' => 781,
'name' => 'Futaleufú'
],[
'state_id' => 781,
'name' => 'Osorno'
],[
'state_id' => 781,
'name' => 'Palena'
],[
'state_id' => 781,
'name' => 'Llanquihue'
],[
'state_id' => 781,
'name' => 'Puerto Montt'
],[
'state_id' => 781,
'name' => 'Puerto Varas'
],[
'state_id' => 781,
'name' => 'Purranque'
],[
'state_id' => 781,
'name' => 'Quellón'
],[
'state_id' => 781,
'name' => 'Cochamó'
],[
'state_id' => 781,
'name' => 'Curaco de Vélez'
],[
'state_id' => 781,
'name' => 'Puyehue'
],[
'state_id' => 781,
'name' => 'Fresia'
],[
'state_id' => 781,
'name' => 'Frutillar'
],[
'state_id' => 781,
'name' => 'Hualaihué'
],[
'state_id' => 781,
'name' => 'Los Muermos'
],[
'state_id' => 781,
'name' => 'Maullín'
],[
'state_id' => 781,
'name' => 'Puerto Octay'
],[
'state_id' => 781,
'name' => 'Puqueldón'
],[
'state_id' => 781,
'name' => 'Queilén'
],[
'state_id' => 781,
'name' => 'Quemchi'
],[
'state_id' => 781,
'name' => 'Quinchao'
],[
'state_id' => 781,
'name' => 'Río Negro'
],[
'state_id' => 781,
'name' => 'San Juan de la Costa'
],[
'state_id' => 781,
'name' => 'San Pablo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
