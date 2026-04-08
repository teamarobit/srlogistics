<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateDACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1793,
'name' => 'Al ‘Amādīyah'
],[
'state_id' => 1793,
'name' => 'Batifa'
],[
'state_id' => 1793,
'name' => 'Dihok'
],[
'state_id' => 1793,
'name' => 'Sīnah'
],[
'state_id' => 1793,
'name' => 'Zaxo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
