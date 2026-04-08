<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class EGStateMNFCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1158,
'name' => 'Al Bājūr'
],[
'state_id' => 1158,
'name' => 'Ash Shuhadā’'
],[
'state_id' => 1158,
'name' => 'Ashmūn'
],[
'state_id' => 1158,
'name' => 'Munūf'
],[
'state_id' => 1158,
'name' => 'Quwaysinā'
],[
'state_id' => 1158,
'name' => 'Shibīn al Kawm'
],[
'state_id' => 1158,
'name' => 'Talā'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
