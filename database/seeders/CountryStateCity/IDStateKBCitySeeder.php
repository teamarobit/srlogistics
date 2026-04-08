<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateKBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1727,
'name' => 'Bengkayang'
],[
'state_id' => 1727,
'name' => 'Kapuas Hulu'
],[
'state_id' => 1727,
'name' => 'Kayong Utara'
],[
'state_id' => 1727,
'name' => 'Ketapang'
],[
'state_id' => 1727,
'name' => 'Kubu Raya'
],[
'state_id' => 1727,
'name' => 'Landak'
],[
'state_id' => 1727,
'name' => 'Manismata'
],[
'state_id' => 1727,
'name' => 'Melawi'
],[
'state_id' => 1727,
'name' => 'Mempawah'
],[
'state_id' => 1727,
'name' => 'Pemangkat'
],[
'state_id' => 1727,
'name' => 'Pontianak'
],[
'state_id' => 1727,
'name' => 'Sambas'
],[
'state_id' => 1727,
'name' => 'Sanggau'
],[
'state_id' => 1727,
'name' => 'Sekadau'
],[
'state_id' => 1727,
'name' => 'Singkawang'
],[
'state_id' => 1727,
'name' => 'Sintang'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
