<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState16CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 127,
'name' => 'Algiers'
],[
'state_id' => 127,
'name' => 'Aïn Taya'
],[
'state_id' => 127,
'name' => 'Bab Ezzouar'
],[
'state_id' => 127,
'name' => 'Birkhadem'
],[
'state_id' => 127,
'name' => 'Bordj el Kiffan'
],[
'state_id' => 127,
'name' => 'Dar el Beïda'
],[
'state_id' => 127,
'name' => 'Rouiba'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
