<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateKRCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1728,
'name' => 'Kabupaten Bintan'
],[
'state_id' => 1728,
'name' => 'Kabupaten Karimun'
],[
'state_id' => 1728,
'name' => 'Kabupaten Kepulauan Anambas'
],[
'state_id' => 1728,
'name' => 'Kabupaten Lingga'
],[
'state_id' => 1728,
'name' => 'Kabupaten Natuna'
],[
'state_id' => 1728,
'name' => 'Kijang'
],[
'state_id' => 1728,
'name' => 'Kota Batam'
],[
'state_id' => 1728,
'name' => 'Kota Tanjung Pinang'
],[
'state_id' => 1728,
'name' => 'Tanjung Pinang'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
