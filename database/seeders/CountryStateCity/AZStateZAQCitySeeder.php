<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateZAQCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 271,
'name' => 'Aliabad'
],[
'state_id' => 271,
'name' => 'Faldarlı'
],[
'state_id' => 271,
'name' => 'Mamrux'
],[
'state_id' => 271,
'name' => 'Qandax'
],[
'state_id' => 271,
'name' => 'Zaqatala'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
