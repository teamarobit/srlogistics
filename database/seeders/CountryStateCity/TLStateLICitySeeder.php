<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TLStateLICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1117,
'name' => 'Bazartete'
],[
'state_id' => 1117,
'name' => 'Likisá'
],[
'state_id' => 1117,
'name' => 'Maubara'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
