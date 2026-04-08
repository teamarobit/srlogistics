<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState09CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 564,
'name' => 'Ardino'
],[
'state_id' => 564,
'name' => 'Dzhebel'
],[
'state_id' => 564,
'name' => 'Kardzhali'
],[
'state_id' => 564,
'name' => 'Kirkovo'
],[
'state_id' => 564,
'name' => 'Krumovgrad'
],[
'state_id' => 564,
'name' => 'Obshtina Ardino'
],[
'state_id' => 564,
'name' => 'Obshtina Chernoochene'
],[
'state_id' => 564,
'name' => 'Obshtina Dzhebel'
],[
'state_id' => 564,
'name' => 'Obshtina Kardzhali'
],[
'state_id' => 564,
'name' => 'Obshtina Kirkovo'
],[
'state_id' => 564,
'name' => 'Obshtina Momchilgrad'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
