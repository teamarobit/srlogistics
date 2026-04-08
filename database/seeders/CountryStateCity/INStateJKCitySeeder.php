<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateJKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1702,
'name' => 'Akhnur'
],[
'state_id' => 1702,
'name' => 'Anantnag'
],[
'state_id' => 1702,
'name' => 'Awantipur'
],[
'state_id' => 1702,
'name' => 'Badgam'
],[
'state_id' => 1702,
'name' => 'Bandipore'
],[
'state_id' => 1702,
'name' => 'Banihal'
],[
'state_id' => 1702,
'name' => 'Batoti'
],[
'state_id' => 1702,
'name' => 'Bhadarwah'
],[
'state_id' => 1702,
'name' => 'Bijbehara'
],[
'state_id' => 1702,
'name' => 'Bishnah'
],[
'state_id' => 1702,
'name' => 'Baramula'
],[
'state_id' => 1702,
'name' => 'Doda'
],[
'state_id' => 1702,
'name' => 'Ganderbal'
],[
'state_id' => 1702,
'name' => 'Gho Brahmanan de'
],[
'state_id' => 1702,
'name' => 'Hiranagar'
],[
'state_id' => 1702,
'name' => 'Hajan'
],[
'state_id' => 1702,
'name' => 'Jammu'
],[
'state_id' => 1702,
'name' => 'Jaurian'
],[
'state_id' => 1702,
'name' => 'Kathua'
],[
'state_id' => 1702,
'name' => 'Katra'
],[
'state_id' => 1702,
'name' => 'Khaur'
],[
'state_id' => 1702,
'name' => 'Kishtwar'
],[
'state_id' => 1702,
'name' => 'Kulgam'
],[
'state_id' => 1702,
'name' => 'Kupwara'
],[
'state_id' => 1702,
'name' => 'Kud'
],[
'state_id' => 1702,
'name' => 'Ladakh'
],[
'state_id' => 1702,
'name' => 'Magam'
],[
'state_id' => 1702,
'name' => 'Nawanshahr'
],[
'state_id' => 1702,
'name' => 'Noria'
],[
'state_id' => 1702,
'name' => 'Padam'
],[
'state_id' => 1702,
'name' => 'Pahlgam'
],[
'state_id' => 1702,
'name' => 'Parol'
],[
'state_id' => 1702,
'name' => 'Pattan'
],[
'state_id' => 1702,
'name' => 'Pulwama'
],[
'state_id' => 1702,
'name' => 'Punch'
],[
'state_id' => 1702,
'name' => 'Qazigund'
],[
'state_id' => 1702,
'name' => 'Rajaori'
],[
'state_id' => 1702,
'name' => 'Ramban'
],[
'state_id' => 1702,
'name' => 'Riasi'
],[
'state_id' => 1702,
'name' => 'Rajauri'
],[
'state_id' => 1702,
'name' => 'Ramgarh'
],[
'state_id' => 1702,
'name' => 'Ramnagar'
],[
'state_id' => 1702,
'name' => 'Samba'
],[
'state_id' => 1702,
'name' => 'Shupiyan'
],[
'state_id' => 1702,
'name' => 'Sopur'
],[
'state_id' => 1702,
'name' => 'Soyibug'
],[
'state_id' => 1702,
'name' => 'Srinagar'
],[
'state_id' => 1702,
'name' => 'Sumbal'
],[
'state_id' => 1702,
'name' => 'Thang'
],[
'state_id' => 1702,
'name' => 'Thanna Mandi'
],[
'state_id' => 1702,
'name' => 'Tral'
],[
'state_id' => 1702,
'name' => 'Tsrar Sharif'
],[
'state_id' => 1702,
'name' => 'Udhampur'
],[
'state_id' => 1702,
'name' => 'Uri'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
