<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState28CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1098,
'name' => 'Bonao'
],[
'state_id' => 1098,
'name' => 'Juan Adrián'
],[
'state_id' => 1098,
'name' => 'Maimón'
],[
'state_id' => 1098,
'name' => 'Piedra Blanca'
],[
'state_id' => 1098,
'name' => 'Sabana del Puerto'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
