<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState12CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 680,
'name' => 'Khan 7 Makara'
],[
'state_id' => 680,
'name' => 'Khan Châmkar Mon'
],[
'state_id' => 680,
'name' => 'Khan Duŏn Pénh'
],[
'state_id' => 680,
'name' => 'Khan Dângkaô'
],[
'state_id' => 680,
'name' => 'Khan Méan Chey'
],[
'state_id' => 680,
'name' => 'Khan Russey Keo'
],[
'state_id' => 680,
'name' => 'Khan Saen Sokh'
],[
'state_id' => 680,
'name' => 'Phnom Penh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
