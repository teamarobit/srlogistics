<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MGStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 130,
'name' => 'Fianarantsoa Province',
'iso2' => 'F'
],[
'country_id' => 130,
'name' => 'Toliara Province',
'iso2' => 'U'
],[
'country_id' => 130,
'name' => 'Antsiranana Province',
'iso2' => 'D'
],[
'country_id' => 130,
'name' => 'Antananarivo Province',
'iso2' => 'T'
],[
'country_id' => 130,
'name' => 'Toamasina Province',
'iso2' => 'A'
],[
'country_id' => 130,
'name' => 'Mahajanga Province',
'iso2' => 'M'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
