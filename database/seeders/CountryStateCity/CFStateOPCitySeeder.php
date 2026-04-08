<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CFStateOPCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 744,
'name' => 'Bocaranga'
],[
'state_id' => 744,
'name' => 'Bozoum'
],[
'state_id' => 744,
'name' => 'Paoua'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
