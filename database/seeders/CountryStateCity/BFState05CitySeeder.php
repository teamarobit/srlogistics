<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState05CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 598,
'name' => 'Boulsa'
],[
'state_id' => 598,
'name' => 'Kaya'
],[
'state_id' => 598,
'name' => 'Kongoussi'
],[
'state_id' => 598,
'name' => 'Province du Bam'
],[
'state_id' => 598,
'name' => 'Province du Namentenga'
],[
'state_id' => 598,
'name' => 'Province du Sanmatenga'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
