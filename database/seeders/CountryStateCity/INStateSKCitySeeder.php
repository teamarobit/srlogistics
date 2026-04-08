<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateSKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1706,
'name' => 'East District'
],[
'state_id' => 1706,
'name' => 'Gangtok'
],[
'state_id' => 1706,
'name' => 'Gyalshing'
],[
'state_id' => 1706,
'name' => 'Jorethang'
],[
'state_id' => 1706,
'name' => 'Mangan'
],[
'state_id' => 1706,
'name' => 'Namchi'
],[
'state_id' => 1706,
'name' => 'Naya Bazar'
],[
'state_id' => 1706,
'name' => 'North District'
],[
'state_id' => 1706,
'name' => 'Rangpo'
],[
'state_id' => 1706,
'name' => 'Singtam'
],[
'state_id' => 1706,
'name' => 'South District'
],[
'state_id' => 1706,
'name' => 'West District'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
