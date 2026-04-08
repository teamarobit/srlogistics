<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ILStateHACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1830,
'name' => 'Atlit'
],[
'state_id' => 1830,
'name' => 'Caesarea'
],[
'state_id' => 1830,
'name' => 'Daliyat al Karmel'
],[
'state_id' => 1830,
'name' => 'El Fureidīs'
],[
'state_id' => 1830,
'name' => 'Hadera'
],[
'state_id' => 1830,
'name' => 'Haifa'
],[
'state_id' => 1830,
'name' => 'Ibṭīn'
],[
'state_id' => 1830,
'name' => 'Nesher'
],[
'state_id' => 1830,
'name' => 'Qiryat Ata'
],[
'state_id' => 1830,
'name' => 'Qiryat Bialik'
],[
'state_id' => 1830,
'name' => 'Qiryat Moẕqin'
],[
'state_id' => 1830,
'name' => 'Qiryat Yam'
],[
'state_id' => 1830,
'name' => 'Rekhasim'
],[
'state_id' => 1830,
'name' => 'Tirat Karmel'
],[
'state_id' => 1830,
'name' => 'Umm el Faḥm'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
