<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState4CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 665,
'name' => 'Baribour'
],[
'state_id' => 665,
'name' => 'Kampong Chhnang'
],[
'state_id' => 665,
'name' => 'Rolea B\'ier'
],[
'state_id' => 665,
'name' => 'Srŏk Chol Kiri'
],[
'state_id' => 665,
'name' => 'Srŏk Sameakki Mean Chey'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
