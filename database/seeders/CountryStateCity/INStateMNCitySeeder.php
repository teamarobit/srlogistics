<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateMNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1683,
'name' => 'Bishnupur'
],[
'state_id' => 1683,
'name' => 'Churachandpur'
],[
'state_id' => 1683,
'name' => 'Imphal'
],[
'state_id' => 1683,
'name' => 'Kakching'
],[
'state_id' => 1683,
'name' => 'Mayang Imphal'
],[
'state_id' => 1683,
'name' => 'Moirang'
],[
'state_id' => 1683,
'name' => 'Phek'
],[
'state_id' => 1683,
'name' => 'Senapati'
],[
'state_id' => 1683,
'name' => 'Tamenglong'
],[
'state_id' => 1683,
'name' => 'Thoubal'
],[
'state_id' => 1683,
'name' => 'Ukhrul'
],[
'state_id' => 1683,
'name' => 'Wangjing'
],[
'state_id' => 1683,
'name' => 'Yairipok'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
