<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class MNStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 146,
'name' => 'Bulgan Province',
'iso2' => '067'
],[
'country_id' => 146,
'name' => 'Darkhan-Uul Province',
'iso2' => '037'
],[
'country_id' => 146,
'name' => 'Dornod Province',
'iso2' => '061'
],[
'country_id' => 146,
'name' => 'Khovd Province',
'iso2' => '043'
],[
'country_id' => 146,
'name' => 'Övörkhangai Province',
'iso2' => '055'
],[
'country_id' => 146,
'name' => 'Orkhon Province',
'iso2' => '035'
],[
'country_id' => 146,
'name' => 'Ömnögovi Province',
'iso2' => '053'
],[
'country_id' => 146,
'name' => 'Töv Province',
'iso2' => '047'
],[
'country_id' => 146,
'name' => 'Bayan-Ölgii Province',
'iso2' => '071'
],[
'country_id' => 146,
'name' => 'Dundgovi Province',
'iso2' => '059'
],[
'country_id' => 146,
'name' => 'Uvs Province',
'iso2' => '046'
],[
'country_id' => 146,
'name' => 'Govi-Altai Province',
'iso2' => '065'
],[
'country_id' => 146,
'name' => 'Arkhangai Province',
'iso2' => '073'
],[
'country_id' => 146,
'name' => 'Khentii Province',
'iso2' => '039'
],[
'country_id' => 146,
'name' => 'Khövsgöl Province',
'iso2' => '041'
],[
'country_id' => 146,
'name' => 'Bayankhongor Province',
'iso2' => '069'
],[
'country_id' => 146,
'name' => 'Sükhbaatar Province',
'iso2' => '051'
],[
'country_id' => 146,
'name' => 'Govisümber Province',
'iso2' => '064'
],[
'country_id' => 146,
'name' => 'Zavkhan Province',
'iso2' => '057'
],[
'country_id' => 146,
'name' => 'Selenge Province',
'iso2' => '049'
],[
'country_id' => 146,
'name' => 'Dornogovi Province',
'iso2' => '063'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
