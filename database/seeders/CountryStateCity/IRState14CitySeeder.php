<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState14CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1754,
'name' => 'Ben'
],[
'state_id' => 1754,
'name' => 'Borujen'
],[
'state_id' => 1754,
'name' => 'Chelgard'
],[
'state_id' => 1754,
'name' => 'Farrokh Shahr'
],[
'state_id' => 1754,
'name' => 'Farsan'
],[
'state_id' => 1754,
'name' => 'Saman'
],[
'state_id' => 1754,
'name' => 'Shahrekord'
],[
'state_id' => 1754,
'name' => 'Kiar'
],[
'state_id' => 1754,
'name' => 'Kuhrang'
],[
'state_id' => 1754,
'name' => 'Lordegan'
],[
'state_id' => 1754,
'name' => 'Ardal'
],[
'state_id' => 1754,
'name' => 'Dashtak'
],[
'state_id' => 1754,
'name' => 'SarKhun'
],[
'state_id' => 1754,
'name' => 'Kaj'
],[
'state_id' => 1754,
'name' => 'Boroujen'
],[
'state_id' => 1754,
'name' => 'Boldaji'
],[
'state_id' => 1754,
'name' => 'Sefiddasht'
],[
'state_id' => 1754,
'name' => 'Faradonbeh'
],[
'state_id' => 1754,
'name' => 'Gandoman'
],[
'state_id' => 1754,
'name' => 'Naghneh'
],[
'state_id' => 1754,
'name' => 'Vardanjan '
],[
'state_id' => 1754,
'name' => 'Sudejan'
],[
'state_id' => 1754,
'name' => 'Sureshjan'
],[
'state_id' => 1754,
'name' => 'Taqanak'
],[
'state_id' => 1754,
'name' => 'Farrokhshahr'
],[
'state_id' => 1754,
'name' => 'ShahrKian'
],[
'state_id' => 1754,
'name' => 'Nafch'
],[
'state_id' => 1754,
'name' => 'Haarooni'
],[
'state_id' => 1754,
'name' => 'Hafshejan'
],[
'state_id' => 1754,
'name' => 'Babaheydar'
],[
'state_id' => 1754,
'name' => 'Pordanjan'
],[
'state_id' => 1754,
'name' => 'Junqan'
],[
'state_id' => 1754,
'name' => 'Choliche'
],[
'state_id' => 1754,
'name' => 'Gujan'
],[
'state_id' => 1754,
'name' => 'Bazoft'
],[
'state_id' => 1754,
'name' => 'Chelgerd'
],[
'state_id' => 1754,
'name' => 'Samsami'
],[
'state_id' => 1754,
'name' => 'Dastena'
],[
'state_id' => 1754,
'name' => 'Shalamzar '
],[
'state_id' => 1754,
'name' => 'Gahru'
],[
'state_id' => 1754,
'name' => 'Naghan'
],[
'state_id' => 1754,
'name' => 'Aluni'
],[
'state_id' => 1754,
'name' => 'Kal Geh-ye Sardasht'
],[
'state_id' => 1754,
'name' => 'Mal-e Khalifeh'
],[
'state_id' => 1754,
'name' => 'Menj'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
