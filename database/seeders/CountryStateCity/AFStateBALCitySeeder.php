<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStateBALCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 15,
'name' => 'Balkh'
],[
'state_id' => 15,
'name' => 'Dowlatābād'
],[
'state_id' => 15,
'name' => 'Khulm'
],[
'state_id' => 15,
'name' => 'Lab-Sar'
],[
'state_id' => 15,
'name' => 'Mazār-e Sharīf'
],[
'state_id' => 15,
'name' => 'Qarchī Gak'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
