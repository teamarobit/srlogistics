<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateVECitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1655,
'name' => 'Ajka'
],[
'state_id' => 1655,
'name' => 'Ajkai Járás'
],[
'state_id' => 1655,
'name' => 'Badacsonytomaj'
],[
'state_id' => 1655,
'name' => 'Balatonalmádi'
],[
'state_id' => 1655,
'name' => 'Balatonalmádi Járás'
],[
'state_id' => 1655,
'name' => 'Balatonfüred'
],[
'state_id' => 1655,
'name' => 'Balatonfüredi Járás'
],[
'state_id' => 1655,
'name' => 'Balatonkenese'
],[
'state_id' => 1655,
'name' => 'Berhida'
],[
'state_id' => 1655,
'name' => 'Csabrendek'
],[
'state_id' => 1655,
'name' => 'Csetény'
],[
'state_id' => 1655,
'name' => 'Csopak'
],[
'state_id' => 1655,
'name' => 'Devecser'
],[
'state_id' => 1655,
'name' => 'Devecseri Járás'
],[
'state_id' => 1655,
'name' => 'Hajmáskér'
],[
'state_id' => 1655,
'name' => 'Herend'
],[
'state_id' => 1655,
'name' => 'Litér'
],[
'state_id' => 1655,
'name' => 'Nemesvámos'
],[
'state_id' => 1655,
'name' => 'Pápa'
],[
'state_id' => 1655,
'name' => 'Pápai Járás'
],[
'state_id' => 1655,
'name' => 'Pétfürdő'
],[
'state_id' => 1655,
'name' => 'Révfülöp'
],[
'state_id' => 1655,
'name' => 'Szentkirályszabadja'
],[
'state_id' => 1655,
'name' => 'Sümeg'
],[
'state_id' => 1655,
'name' => 'Sümegi Járás'
],[
'state_id' => 1655,
'name' => 'Tapolca'
],[
'state_id' => 1655,
'name' => 'Tapolcai Járás'
],[
'state_id' => 1655,
'name' => 'Tihany'
],[
'state_id' => 1655,
'name' => 'Veszprém'
],[
'state_id' => 1655,
'name' => 'Veszprémi Járás'
],[
'state_id' => 1655,
'name' => 'Várpalota'
],[
'state_id' => 1655,
'name' => 'Várpalotai Járás'
],[
'state_id' => 1655,
'name' => 'Zirc'
],[
'state_id' => 1655,
'name' => 'Zirci Járás'
],[
'state_id' => 1655,
'name' => 'Zánka'
],[
'state_id' => 1655,
'name' => 'Úrkút'
],[
'state_id' => 1655,
'name' => 'Ősi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
