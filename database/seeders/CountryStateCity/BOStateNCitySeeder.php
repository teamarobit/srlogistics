<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BOStateNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 496,
'name' => 'Cobija'
],[
'state_id' => 496,
'name' => 'Provincia Abuná'
],[
'state_id' => 496,
'name' => 'Provincia General Federico Román'
],[
'state_id' => 496,
'name' => 'Provincia Madre de Dios'
],[
'state_id' => 496,
'name' => 'Provincia Manuripi'
],[
'state_id' => 496,
'name' => 'Provincia Nicolás Suárez'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
