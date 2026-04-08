<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CMStateESCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 688,
'name' => 'Abong Mbang'
],[
'state_id' => 688,
'name' => 'Batouri'
],[
'state_id' => 688,
'name' => 'Bertoua'
],[
'state_id' => 688,
'name' => 'Bélabo'
],[
'state_id' => 688,
'name' => 'Bétaré Oya'
],[
'state_id' => 688,
'name' => 'Dimako'
],[
'state_id' => 688,
'name' => 'Doumé'
],[
'state_id' => 688,
'name' => 'Garoua Boulaï'
],[
'state_id' => 688,
'name' => 'Mbang'
],[
'state_id' => 688,
'name' => 'Ndelele'
],[
'state_id' => 688,
'name' => 'Yokadouma'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
