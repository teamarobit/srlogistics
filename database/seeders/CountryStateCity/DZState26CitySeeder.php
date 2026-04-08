<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState26CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 92,
'name' => 'Berrouaghia'
],[
'state_id' => 92,
'name' => 'Ksar el Boukhari'
],[
'state_id' => 92,
'name' => 'Médéa'
],[
'state_id' => 92,
'name' => '’Aïn Boucif'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
