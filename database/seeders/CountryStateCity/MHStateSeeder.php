<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MHStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 137,
'name' => 'Ratak Chain',
'iso2' => 'T'
],[
'country_id' => 137,
'name' => 'Ralik Chain',
'iso2' => 'L'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
