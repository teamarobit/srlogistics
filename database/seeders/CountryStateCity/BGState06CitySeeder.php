<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 573,
'name' => 'Borovan'
],[
'state_id' => 573,
'name' => 'Byala Slatina'
],[
'state_id' => 573,
'name' => 'Hayredin'
],[
'state_id' => 573,
'name' => 'Kozloduy'
],[
'state_id' => 573,
'name' => 'Krivodol'
],[
'state_id' => 573,
'name' => 'Mezdra'
],[
'state_id' => 573,
'name' => 'Mizia'
],[
'state_id' => 573,
'name' => 'Obshtina Borovan'
],[
'state_id' => 573,
'name' => 'Obshtina Hayredin'
],[
'state_id' => 573,
'name' => 'Obshtina Kozloduy'
],[
'state_id' => 573,
'name' => 'Obshtina Krivodol'
],[
'state_id' => 573,
'name' => 'Obshtina Mezdra'
],[
'state_id' => 573,
'name' => 'Obshtina Mizia'
],[
'state_id' => 573,
'name' => 'Obshtina Oryahovo'
],[
'state_id' => 573,
'name' => 'Obshtina Roman'
],[
'state_id' => 573,
'name' => 'Obshtina Vratsa'
],[
'state_id' => 573,
'name' => 'Oryahovo'
],[
'state_id' => 573,
'name' => 'Roman'
],[
'state_id' => 573,
'name' => 'Vratsa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
