<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateXCICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 229,
'name' => 'Askyaran'
],[
'state_id' => 229,
'name' => 'Xocalı'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
