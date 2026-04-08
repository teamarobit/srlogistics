<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CFStateLBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 733,
'name' => 'Boda'
],[
'state_id' => 733,
'name' => 'Boganangone'
],[
'state_id' => 733,
'name' => 'Mbaiki'
],[
'state_id' => 733,
'name' => 'Mongoumba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
