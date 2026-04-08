<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CMStateNWCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 684,
'name' => 'Babanki'
],[
'state_id' => 684,
'name' => 'Bali'
],[
'state_id' => 684,
'name' => 'Bamenda'
],[
'state_id' => 684,
'name' => 'Batibo'
],[
'state_id' => 684,
'name' => 'Belo'
],[
'state_id' => 684,
'name' => 'Boyo'
],[
'state_id' => 684,
'name' => 'Fundong'
],[
'state_id' => 684,
'name' => 'Jakiri'
],[
'state_id' => 684,
'name' => 'Kumbo'
],[
'state_id' => 684,
'name' => 'Mbengwi'
],[
'state_id' => 684,
'name' => 'Mme-Bafumen'
],[
'state_id' => 684,
'name' => 'Njinikom'
],[
'state_id' => 684,
'name' => 'Wum'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
