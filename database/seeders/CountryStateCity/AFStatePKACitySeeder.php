<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AFStatePKACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 8,
'name' => 'Saṟōbī'
],[
'state_id' => 8,
'name' => 'Zarghūn Shahr'
],[
'state_id' => 8,
'name' => 'Zaṟah Sharan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
