<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateBECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1716,
'name' => 'Bengkulu'
],[
'state_id' => 1716,
'name' => 'Curup'
],[
'state_id' => 1716,
'name' => 'Kabupaten Bengkulu Selatan'
],[
'state_id' => 1716,
'name' => 'Kabupaten Bengkulu Tengah'
],[
'state_id' => 1716,
'name' => 'Kabupaten Bengkulu Utara'
],[
'state_id' => 1716,
'name' => 'Kabupaten Kaur'
],[
'state_id' => 1716,
'name' => 'Kabupaten Kepahiang'
],[
'state_id' => 1716,
'name' => 'Kabupaten Lebong'
],[
'state_id' => 1716,
'name' => 'Kabupaten Mukomuko'
],[
'state_id' => 1716,
'name' => 'Kabupaten Rejang Lebong'
],[
'state_id' => 1716,
'name' => 'Kabupaten Seluma'
],[
'state_id' => 1716,
'name' => 'Kota Bengkulu'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
