<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState17CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1095,
'name' => 'Baní'
],[
'state_id' => 1095,
'name' => 'Matanzas'
],[
'state_id' => 1095,
'name' => 'Nizao'
],[
'state_id' => 1095,
'name' => 'Paya'
],[
'state_id' => 1095,
'name' => 'Pizarrete'
],[
'state_id' => 1095,
'name' => 'Sabana Buey'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
