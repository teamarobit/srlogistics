<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState22CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 673,
'name' => 'Samraong'
],[
'state_id' => 673,
'name' => 'Srŏk Bântéay Âmpĭl'
],[
'state_id' => 673,
'name' => 'Srŏk Sâmraông'
],[
'state_id' => 673,
'name' => 'Srŏk Trâpeăng Prasat'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
