<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class LAStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 119,
'name' => 'Luang Prabang Province',
'iso2' => 'LP'
],[
'country_id' => 119,
'name' => 'Vientiane Prefecture',
'iso2' => 'VT'
],[
'country_id' => 119,
'name' => 'Vientiane Province',
'iso2' => 'VI'
],[
'country_id' => 119,
'name' => 'Salavan Province',
'iso2' => 'SL'
],[
'country_id' => 119,
'name' => 'Attapeu Province',
'iso2' => 'AT'
],[
'country_id' => 119,
'name' => 'Xaisomboun Province',
'iso2' => 'XS'
],[
'country_id' => 119,
'name' => 'Sekong Province',
'iso2' => 'XE'
],[
'country_id' => 119,
'name' => 'Bolikhamsai Province',
'iso2' => 'BL'
],[
'country_id' => 119,
'name' => 'Khammouane Province',
'iso2' => 'KH'
],[
'country_id' => 119,
'name' => 'Phongsaly Province',
'iso2' => 'PH'
],[
'country_id' => 119,
'name' => 'Oudomxay Province',
'iso2' => 'OU'
],[
'country_id' => 119,
'name' => 'Houaphanh Province',
'iso2' => 'HO'
],[
'country_id' => 119,
'name' => 'Savannakhet Province',
'iso2' => 'SV'
],[
'country_id' => 119,
'name' => 'Bokeo Province',
'iso2' => 'BK'
],[
'country_id' => 119,
'name' => 'Luang Namtha Province',
'iso2' => 'LM'
],[
'country_id' => 119,
'name' => 'Sainyabuli Province',
'iso2' => 'XA'
],[
'country_id' => 119,
'name' => 'Xaisomboun',
'iso2' => 'XN'
],[
'country_id' => 119,
'name' => 'Xiangkhouang Province',
'iso2' => 'XI'
],[
'country_id' => 119,
'name' => 'Champasak Province',
'iso2' => 'CH'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
