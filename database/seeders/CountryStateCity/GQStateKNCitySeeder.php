<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GQStateKNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1194,
'name' => 'Ebebiyin'
],[
'state_id' => 1194,
'name' => 'Mikomeseng'
],[
'state_id' => 1194,
'name' => 'Ncue'
],[
'state_id' => 1194,
'name' => 'Nsang'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
