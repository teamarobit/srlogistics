<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateBBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1741,
'name' => 'Kabupaten Bangka'
],[
'state_id' => 1741,
'name' => 'Kabupaten Bangka Barat'
],[
'state_id' => 1741,
'name' => 'Kabupaten Bangka Selatan'
],[
'state_id' => 1741,
'name' => 'Kabupaten Bangka Tengah'
],[
'state_id' => 1741,
'name' => 'Kabupaten Belitung'
],[
'state_id' => 1741,
'name' => 'Kabupaten Belitung Timur'
],[
'state_id' => 1741,
'name' => 'Kota Pangkal Pinang'
],[
'state_id' => 1741,
'name' => 'Manggar'
],[
'state_id' => 1741,
'name' => 'Muntok'
],[
'state_id' => 1741,
'name' => 'Pangkalpinang'
],[
'state_id' => 1741,
'name' => 'Sungailiat'
],[
'state_id' => 1741,
'name' => 'Tanjung Pandan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
