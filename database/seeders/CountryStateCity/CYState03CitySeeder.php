<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CYState03CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 971,
'name' => 'Aradíppou'
],[
'state_id' => 971,
'name' => 'Athíenou'
],[
'state_id' => 971,
'name' => 'Dhromolaxia'
],[
'state_id' => 971,
'name' => 'Kofínou'
],[
'state_id' => 971,
'name' => 'Kolossi'
],[
'state_id' => 971,
'name' => 'Kíti'
],[
'state_id' => 971,
'name' => 'Kórnos'
],[
'state_id' => 971,
'name' => 'Larnaca'
],[
'state_id' => 971,
'name' => 'Livádia'
],[
'state_id' => 971,
'name' => 'Meneou'
],[
'state_id' => 971,
'name' => 'Mosfilotí'
],[
'state_id' => 971,
'name' => 'Perivólia'
],[
'state_id' => 971,
'name' => 'Psevdás'
],[
'state_id' => 971,
'name' => 'Pérgamos'
],[
'state_id' => 971,
'name' => 'Pýla'
],[
'state_id' => 971,
'name' => 'Tersefánou'
],[
'state_id' => 971,
'name' => 'Troúlloi'
],[
'state_id' => 971,
'name' => 'Voróklini'
],[
'state_id' => 971,
'name' => 'Xylofágou'
],[
'state_id' => 971,
'name' => 'Xylotymbou'
],[
'state_id' => 971,
'name' => 'Ágios Týchon'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
