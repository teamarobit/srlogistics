<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CLStateTACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 783,
'name' => 'Iquique'
],[
'state_id' => 783,
'name' => 'Alto Hospicio'
],[
'state_id' => 783,
'name' => 'Camiña'
],[
'state_id' => 783,
'name' => 'Colchane'
],[
'state_id' => 783,
'name' => 'Huara'
],[
'state_id' => 783,
'name' => 'Pica'
],[
'state_id' => 783,
'name' => 'Pozo Almonte'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
