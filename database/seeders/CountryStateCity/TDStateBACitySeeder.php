<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class TDStateBACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 765,
'name' => 'Ati'
],[
'state_id' => 765,
'name' => 'Oum Hadjer'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
