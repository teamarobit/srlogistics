<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIStateDNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 919,
'name' => 'Folon'
],[
'state_id' => 919,
'name' => 'Kabadougou'
],[
'state_id' => 919,
'name' => 'Odienné'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
