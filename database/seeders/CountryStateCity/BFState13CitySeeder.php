<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState13CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 611,
'name' => 'Batié'
],[
'state_id' => 611,
'name' => 'Dano'
],[
'state_id' => 611,
'name' => 'Diébougou'
],[
'state_id' => 611,
'name' => 'Province de la Bougouriba'
],[
'state_id' => 611,
'name' => 'Province du Ioba'
],[
'state_id' => 611,
'name' => 'Province du Noumbièl'
],[
'state_id' => 611,
'name' => 'Province du Poni'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
