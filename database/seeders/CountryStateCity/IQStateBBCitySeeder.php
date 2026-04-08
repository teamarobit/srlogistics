<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateBBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1781,
'name' => 'Al Musayyib'
],[
'state_id' => 1781,
'name' => 'Al Ḩillah'
],[
'state_id' => 1781,
'name' => 'Imam Qasim'
],[
'state_id' => 1781,
'name' => 'Nāḩīyat Saddat al Hindīyah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
