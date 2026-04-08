<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState11CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 572,
'name' => 'Apriltsi'
],[
'state_id' => 572,
'name' => 'Letnitsa'
],[
'state_id' => 572,
'name' => 'Lovech'
],[
'state_id' => 572,
'name' => 'Lukovit'
],[
'state_id' => 572,
'name' => 'Obshtina Lovech'
],[
'state_id' => 572,
'name' => 'Obshtina Teteven'
],[
'state_id' => 572,
'name' => 'Obshtina Ugarchin'
],[
'state_id' => 572,
'name' => 'Teteven'
],[
'state_id' => 572,
'name' => 'Troyan'
],[
'state_id' => 572,
'name' => 'Ugarchin'
],[
'state_id' => 572,
'name' => 'Yablanitsa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
