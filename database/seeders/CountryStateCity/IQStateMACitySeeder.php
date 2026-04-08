<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateMACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1792,
'name' => 'Al ‘Amārah'
],[
'state_id' => 1792,
'name' => 'Al-Mejar Al-Kabi District'
],[
'state_id' => 1792,
'name' => '‘Alī al Gharbī'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
