<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState13CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 90,
'name' => 'Beni Mester'
],[
'state_id' => 90,
'name' => 'Bensekrane'
],[
'state_id' => 90,
'name' => 'Chetouane'
],[
'state_id' => 90,
'name' => 'Hennaya'
],[
'state_id' => 90,
'name' => 'Mansoûra'
],[
'state_id' => 90,
'name' => 'Nedroma'
],[
'state_id' => 90,
'name' => 'Ouled Mimoun'
],[
'state_id' => 90,
'name' => 'Remchi'
],[
'state_id' => 90,
'name' => 'Sebdou'
],[
'state_id' => 90,
'name' => 'Sidi Abdelli'
],[
'state_id' => 90,
'name' => 'Sidi Senoussi سيدي سنوسي'
],[
'state_id' => 90,
'name' => 'Tlemcen'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
