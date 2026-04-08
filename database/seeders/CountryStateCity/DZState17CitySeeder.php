<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState17CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 81,
'name' => 'Aïn Oussera'
],[
'state_id' => 81,
'name' => 'Birine'
],[
'state_id' => 81,
'name' => 'Charef'
],[
'state_id' => 81,
'name' => 'Dar Chioukh'
],[
'state_id' => 81,
'name' => 'Djelfa'
],[
'state_id' => 81,
'name' => 'El Idrissia'
],[
'state_id' => 81,
'name' => 'Messaad'
],[
'state_id' => 81,
'name' => '’Aïn el Bell'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
