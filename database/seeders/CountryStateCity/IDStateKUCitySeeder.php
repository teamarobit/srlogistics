<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateKUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1743,
'name' => 'Kabupaten Bulungan'
],[
'state_id' => 1743,
'name' => 'Kabupaten Malinau'
],[
'state_id' => 1743,
'name' => 'Kabupaten Nunukan'
],[
'state_id' => 1743,
'name' => 'Kabupaten Tana Tidung'
],[
'state_id' => 1743,
'name' => 'Tanjung Selor'
],[
'state_id' => 1743,
'name' => 'Tarakan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
