<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BGState04CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 571,
'name' => 'Byala Cherkva'
],[
'state_id' => 571,
'name' => 'Debelets'
],[
'state_id' => 571,
'name' => 'Elena'
],[
'state_id' => 571,
'name' => 'Gorna Oryahovitsa'
],[
'state_id' => 571,
'name' => 'Kilifarevo'
],[
'state_id' => 571,
'name' => 'Lyaskovets'
],[
'state_id' => 571,
'name' => 'Obshtina Elena'
],[
'state_id' => 571,
'name' => 'Obshtina Gorna Oryahovitsa'
],[
'state_id' => 571,
'name' => 'Obshtina Lyaskovets'
],[
'state_id' => 571,
'name' => 'Obshtina Pavlikeni'
],[
'state_id' => 571,
'name' => 'Obshtina Polski Trambesh'
],[
'state_id' => 571,
'name' => 'Obshtina Strazhitsa'
],[
'state_id' => 571,
'name' => 'Obshtina Suhindol'
],[
'state_id' => 571,
'name' => 'Obshtina Svishtov'
],[
'state_id' => 571,
'name' => 'Obshtina Veliko Tŭrnovo'
],[
'state_id' => 571,
'name' => 'Obshtina Zlataritsa'
],[
'state_id' => 571,
'name' => 'Parvomaytsi'
],[
'state_id' => 571,
'name' => 'Pavlikeni'
],[
'state_id' => 571,
'name' => 'Polski Trambesh'
],[
'state_id' => 571,
'name' => 'Strazhitsa'
],[
'state_id' => 571,
'name' => 'Suhindol'
],[
'state_id' => 571,
'name' => 'Svishtov'
],[
'state_id' => 571,
'name' => 'Veliko Tŭrnovo'
],[
'state_id' => 571,
'name' => 'Zlataritsa'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
