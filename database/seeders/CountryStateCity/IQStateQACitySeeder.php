<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateQACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1782,
'name' => 'Ad Dīwānīyah'
],[
'state_id' => 1782,
'name' => 'Ash Shāmīyah'
],[
'state_id' => 1782,
'name' => 'Nahiyat Ghammas'
],[
'state_id' => 1782,
'name' => 'Nāḩiyat ash Shināfīyah'
],[
'state_id' => 1782,
'name' => '‘Afak'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
