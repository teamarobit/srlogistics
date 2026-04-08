<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState17CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 560,
'name' => 'Isperih'
],[
'state_id' => 560,
'name' => 'Kubrat'
],[
'state_id' => 560,
'name' => 'Loznitsa'
],[
'state_id' => 560,
'name' => 'Medovene'
],[
'state_id' => 560,
'name' => 'Obshtina Isperih'
],[
'state_id' => 560,
'name' => 'Obshtina Kubrat'
],[
'state_id' => 560,
'name' => 'Obshtina Loznitsa'
],[
'state_id' => 560,
'name' => 'Obshtina Razgrad'
],[
'state_id' => 560,
'name' => 'Obshtina Samuil'
],[
'state_id' => 560,
'name' => 'Obshtina Tsar Kaloyan'
],[
'state_id' => 560,
'name' => 'Obshtina Zavet'
],[
'state_id' => 560,
'name' => 'Razgrad'
],[
'state_id' => 560,
'name' => 'Samuil'
],[
'state_id' => 560,
'name' => 'Tsar Kaloyan'
],[
'state_id' => 560,
'name' => 'Zavet'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
