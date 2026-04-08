<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateNACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1788,
'name' => 'Al Mishkhāb'
],[
'state_id' => 1788,
'name' => 'Kufa'
],[
'state_id' => 1788,
'name' => 'Najaf'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
