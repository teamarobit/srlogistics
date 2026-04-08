<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DKState81CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1068,
'name' => 'Aalborg'
],[
'state_id' => 1068,
'name' => 'Aars'
],[
'state_id' => 1068,
'name' => 'Arden'
],[
'state_id' => 1068,
'name' => 'Brovst'
],[
'state_id' => 1068,
'name' => 'Brønderslev'
],[
'state_id' => 1068,
'name' => 'Brønderslev Kommune'
],[
'state_id' => 1068,
'name' => 'Dronninglund'
],[
'state_id' => 1068,
'name' => 'Farsø'
],[
'state_id' => 1068,
'name' => 'Fjerritslev'
],[
'state_id' => 1068,
'name' => 'Frederikshavn'
],[
'state_id' => 1068,
'name' => 'Frederikshavn Kommune'
],[
'state_id' => 1068,
'name' => 'Frejlev'
],[
'state_id' => 1068,
'name' => 'Gistrup'
],[
'state_id' => 1068,
'name' => 'Hadsund'
],[
'state_id' => 1068,
'name' => 'Hals'
],[
'state_id' => 1068,
'name' => 'Hanstholm'
],[
'state_id' => 1068,
'name' => 'Hirtshals'
],[
'state_id' => 1068,
'name' => 'Hjallerup'
],[
'state_id' => 1068,
'name' => 'Hjørring'
],[
'state_id' => 1068,
'name' => 'Hjørring Kommune'
],[
'state_id' => 1068,
'name' => 'Hobro'
],[
'state_id' => 1068,
'name' => 'Hurup'
],[
'state_id' => 1068,
'name' => 'Jammerbugt Kommune'
],[
'state_id' => 1068,
'name' => 'Klarup'
],[
'state_id' => 1068,
'name' => 'Kås'
],[
'state_id' => 1068,
'name' => 'Læso Kommune'
],[
'state_id' => 1068,
'name' => 'Løgstør'
],[
'state_id' => 1068,
'name' => 'Løkken'
],[
'state_id' => 1068,
'name' => 'Mariager'
],[
'state_id' => 1068,
'name' => 'Mariagerfjord Kommune'
],[
'state_id' => 1068,
'name' => 'Morsø Kommune'
],[
'state_id' => 1068,
'name' => 'Nibe'
],[
'state_id' => 1068,
'name' => 'Nykøbing Mors'
],[
'state_id' => 1068,
'name' => 'Nørresundby'
],[
'state_id' => 1068,
'name' => 'Pandrup'
],[
'state_id' => 1068,
'name' => 'Rebild Kommune'
],[
'state_id' => 1068,
'name' => 'Sindal'
],[
'state_id' => 1068,
'name' => 'Skagen'
],[
'state_id' => 1068,
'name' => 'Skørping'
],[
'state_id' => 1068,
'name' => 'Storvorde'
],[
'state_id' => 1068,
'name' => 'Strandby'
],[
'state_id' => 1068,
'name' => 'Støvring'
],[
'state_id' => 1068,
'name' => 'Svenstrup'
],[
'state_id' => 1068,
'name' => 'Sæby'
],[
'state_id' => 1068,
'name' => 'Thisted'
],[
'state_id' => 1068,
'name' => 'Thisted Kommune'
],[
'state_id' => 1068,
'name' => 'Tårs'
],[
'state_id' => 1068,
'name' => 'Vadum'
],[
'state_id' => 1068,
'name' => 'Vestbjerg'
],[
'state_id' => 1068,
'name' => 'Vester Hassing'
],[
'state_id' => 1068,
'name' => 'Vesthimmerland Kommune'
],[
'state_id' => 1068,
'name' => 'Vodskov'
],[
'state_id' => 1068,
'name' => 'Vrå'
],[
'state_id' => 1068,
'name' => 'Åbybro'
],[
'state_id' => 1068,
'name' => 'Ålborg Kommune'
],[
'state_id' => 1068,
'name' => 'Ålestrup'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
