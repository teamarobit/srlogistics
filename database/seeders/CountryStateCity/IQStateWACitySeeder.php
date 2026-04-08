<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateWACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1796,
'name' => 'Al Kūt'
],[
'state_id' => 1796,
'name' => 'Al Ḩayy'
],[
'state_id' => 1796,
'name' => 'Al ‘Azīzīyah'
],[
'state_id' => 1796,
'name' => 'Aş Şuwayrah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
