<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateLOGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 28,
'name' => 'Baraki Barak'
],[
'state_id' => 28,
'name' => 'Pul-e ‘Alam'
],[
'state_id' => 28,
'name' => 'Ḩukūmatī Azrah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
