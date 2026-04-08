<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 111,
'name' => 'Akbou'
],[
'state_id' => 111,
'name' => 'Amizour'
],[
'state_id' => 111,
'name' => 'Barbacha'
],[
'state_id' => 111,
'name' => 'Bejaïa'
],[
'state_id' => 111,
'name' => 'El Kseur'
],[
'state_id' => 111,
'name' => 'Feraoun'
],[
'state_id' => 111,
'name' => 'Seddouk'
],[
'state_id' => 111,
'name' => 'el hed'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
