<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AOStateHUICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 159,
'name' => 'Caconda'
],[
'state_id' => 159,
'name' => 'Caluquembe'
],[
'state_id' => 159,
'name' => 'Chibia'
],[
'state_id' => 159,
'name' => 'Chicomba'
],[
'state_id' => 159,
'name' => 'Chipindo'
],[
'state_id' => 159,
'name' => 'Cuvango'
],[
'state_id' => 159,
'name' => 'Gambos'
],[
'state_id' => 159,
'name' => 'Humpata'
],[
'state_id' => 159,
'name' => 'Jamba'
],[
'state_id' => 159,
'name' => 'Lubango'
],[
'state_id' => 159,
'name' => 'Matala'
],[
'state_id' => 159,
'name' => 'Quilengues'
],[
'state_id' => 159,
'name' => 'Quipungo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
