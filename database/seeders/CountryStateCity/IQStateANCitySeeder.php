<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IQStateANCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1790,
'name' => 'Al Fallūjah'
],[
'state_id' => 1790,
'name' => 'Ar Ruţbah'
],[
'state_id' => 1790,
'name' => 'Hīt'
],[
'state_id' => 1790,
'name' => 'Hīt District'
],[
'state_id' => 1790,
'name' => 'Ramadi'
],[
'state_id' => 1790,
'name' => 'Rāwah'
],[
'state_id' => 1790,
'name' => 'Ḩadīthah'
],[
'state_id' => 1790,
'name' => '‘Anah'
],[
'state_id' => 1790,
'name' => '‘Anat al Qadīmah'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
