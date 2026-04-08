<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState14CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 660,
'name' => 'Prey Veng'
],[
'state_id' => 660,
'name' => 'Srŏk Kâmpóng Léav'
],[
'state_id' => 660,
'name' => 'Srŏk Mésang'
],[
'state_id' => 660,
'name' => 'Srŏk Preăh Sdéch'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
