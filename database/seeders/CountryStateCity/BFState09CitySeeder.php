<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState09CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 636,
'name' => 'Bobo-Dioulasso'
],[
'state_id' => 636,
'name' => 'Houndé'
],[
'state_id' => 636,
'name' => 'Province du Houet'
],[
'state_id' => 636,
'name' => 'Province du Kénédougou'
],[
'state_id' => 636,
'name' => 'Province du Tuy'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
