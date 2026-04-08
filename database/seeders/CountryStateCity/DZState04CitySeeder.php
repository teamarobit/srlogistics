<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState04CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 119,
'name' => 'Aïn Beïda'
],[
'state_id' => 119,
'name' => 'Aïn Fakroun'
],[
'state_id' => 119,
'name' => 'Aïn Kercha'
],[
'state_id' => 119,
'name' => 'El Aouinet'
],[
'state_id' => 119,
'name' => 'Meskiana'
],[
'state_id' => 119,
'name' => 'Oum el Bouaghi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
