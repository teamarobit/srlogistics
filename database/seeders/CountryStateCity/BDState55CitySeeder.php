<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BDState55CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 354,
'name' => 'Badarganj'
],[
'state_id' => 354,
'name' => 'Chilmāri'
],[
'state_id' => 354,
'name' => 'Dinajpur'
],[
'state_id' => 354,
'name' => 'Gaibandha'
],[
'state_id' => 354,
'name' => 'Kurigram'
],[
'state_id' => 354,
'name' => 'Lalmonirhat'
],[
'state_id' => 354,
'name' => 'Lalmonirhat District'
],[
'state_id' => 354,
'name' => 'Nageswari'
],[
'state_id' => 354,
'name' => 'Nilphamari Zila'
],[
'state_id' => 354,
'name' => 'Panchagarh'
],[
'state_id' => 354,
'name' => 'Parbatipur'
],[
'state_id' => 354,
'name' => 'Pīrgaaj'
],[
'state_id' => 354,
'name' => 'Rangpur'
],[
'state_id' => 354,
'name' => 'Thakurgaon'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
