<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateNANCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 13,
'name' => 'Bāsawul'
],[
'state_id' => 13,
'name' => 'Jalālābād'
],[
'state_id' => 13,
'name' => 'Markaz-e Woluswalī-ye Āchīn'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
