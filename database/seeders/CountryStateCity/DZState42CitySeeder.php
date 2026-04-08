<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState42CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 98,
'name' => 'Baraki'
],[
'state_id' => 98,
'name' => 'Bou Ismaïl'
],[
'state_id' => 98,
'name' => 'Cheraga'
],[
'state_id' => 98,
'name' => 'Douera'
],[
'state_id' => 98,
'name' => 'El Affroun'
],[
'state_id' => 98,
'name' => 'Hadjout'
],[
'state_id' => 98,
'name' => 'Kolea'
],[
'state_id' => 98,
'name' => 'Mouzaïa'
],[
'state_id' => 98,
'name' => 'Oued el Alleug'
],[
'state_id' => 98,
'name' => 'Saoula'
],[
'state_id' => 98,
'name' => 'Tipasa'
],[
'state_id' => 98,
'name' => 'Zeralda'
],[
'state_id' => 98,
'name' => '’Aïn Benian'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
