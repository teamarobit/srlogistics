<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CMStateSWCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 685,
'name' => 'Bamusso'
],[
'state_id' => 685,
'name' => 'Bekondo'
],[
'state_id' => 685,
'name' => 'Buea'
],[
'state_id' => 685,
'name' => 'Fako Division'
],[
'state_id' => 685,
'name' => 'Fontem'
],[
'state_id' => 685,
'name' => 'Kumba'
],[
'state_id' => 685,
'name' => 'Lebialem'
],[
'state_id' => 685,
'name' => 'Limbe'
],[
'state_id' => 685,
'name' => 'Mamfe'
],[
'state_id' => 685,
'name' => 'Mundemba'
],[
'state_id' => 685,
'name' => 'Mutengene'
],[
'state_id' => 685,
'name' => 'Muyuka'
],[
'state_id' => 685,
'name' => 'Nguti'
],[
'state_id' => 685,
'name' => 'Tiko'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
