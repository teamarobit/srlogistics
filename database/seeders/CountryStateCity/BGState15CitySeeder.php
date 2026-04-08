<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState15CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 568,
'name' => 'Belene'
],[
'state_id' => 568,
'name' => 'Cherven Bryag'
],[
'state_id' => 568,
'name' => 'Dolna Mitropolia'
],[
'state_id' => 568,
'name' => 'Dolni Dabnik'
],[
'state_id' => 568,
'name' => 'Gulyantsi'
],[
'state_id' => 568,
'name' => 'Iskar'
],[
'state_id' => 568,
'name' => 'Knezha'
],[
'state_id' => 568,
'name' => 'Koynare'
],[
'state_id' => 568,
'name' => 'Levski'
],[
'state_id' => 568,
'name' => 'Nikopol'
],[
'state_id' => 568,
'name' => 'Obshtina Belene'
],[
'state_id' => 568,
'name' => 'Obshtina Cherven Bryag'
],[
'state_id' => 568,
'name' => 'Obshtina Dolna Mitropolia'
],[
'state_id' => 568,
'name' => 'Obshtina Dolni Dabnik'
],[
'state_id' => 568,
'name' => 'Obshtina Gulyantsi'
],[
'state_id' => 568,
'name' => 'Obshtina Iskar'
],[
'state_id' => 568,
'name' => 'Obshtina Knezha'
],[
'state_id' => 568,
'name' => 'Obshtina Levski'
],[
'state_id' => 568,
'name' => 'Obshtina Nikopol'
],[
'state_id' => 568,
'name' => 'Obshtina Pleven'
],[
'state_id' => 568,
'name' => 'Obshtina Pordim'
],[
'state_id' => 568,
'name' => 'Pleven'
],[
'state_id' => 568,
'name' => 'Pordim'
],[
'state_id' => 568,
'name' => 'Slavyanovo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
