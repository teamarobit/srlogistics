<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CMStateENCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 683,
'name' => 'Bogo'
],[
'state_id' => 683,
'name' => 'Kaélé'
],[
'state_id' => 683,
'name' => 'Kousséri'
],[
'state_id' => 683,
'name' => 'Koza'
],[
'state_id' => 683,
'name' => 'Makary'
],[
'state_id' => 683,
'name' => 'Maroua'
],[
'state_id' => 683,
'name' => 'Mayo-Sava'
],[
'state_id' => 683,
'name' => 'Mayo-Tsanaga'
],[
'state_id' => 683,
'name' => 'Mindif'
],[
'state_id' => 683,
'name' => 'Mokolo'
],[
'state_id' => 683,
'name' => 'Mora'
],[
'state_id' => 683,
'name' => 'Yagoua'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
