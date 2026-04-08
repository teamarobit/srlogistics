<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EEState67CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1215,
'name' => 'Audru'
],[
'state_id' => 1215,
'name' => 'Kihnu vald'
],[
'state_id' => 1215,
'name' => 'Kilingi-Nõmme'
],[
'state_id' => 1215,
'name' => 'Lihula'
],[
'state_id' => 1215,
'name' => 'Linaküla'
],[
'state_id' => 1215,
'name' => 'Paikuse'
],[
'state_id' => 1215,
'name' => 'Pärnu'
],[
'state_id' => 1215,
'name' => 'Pärnu linn'
],[
'state_id' => 1215,
'name' => 'Pärnu-Jaagupi'
],[
'state_id' => 1215,
'name' => 'Saarde vald'
],[
'state_id' => 1215,
'name' => 'Sauga'
],[
'state_id' => 1215,
'name' => 'Sindi'
],[
'state_id' => 1215,
'name' => 'Tootsi'
],[
'state_id' => 1215,
'name' => 'Tori vald'
],[
'state_id' => 1215,
'name' => 'Uulu'
],[
'state_id' => 1215,
'name' => 'Vändra'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
