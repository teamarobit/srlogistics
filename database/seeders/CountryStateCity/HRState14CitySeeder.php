<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState14CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 947,
'name' => 'Antunovac'
],[
'state_id' => 947,
'name' => 'Beli Manastir'
],[
'state_id' => 947,
'name' => 'Belišće'
],[
'state_id' => 947,
'name' => 'Bijelo Brdo'
],[
'state_id' => 947,
'name' => 'Bilje'
],[
'state_id' => 947,
'name' => 'Bistrinci'
],[
'state_id' => 947,
'name' => 'Bizovac'
],[
'state_id' => 947,
'name' => 'Brijest'
],[
'state_id' => 947,
'name' => 'Budrovci'
],[
'state_id' => 947,
'name' => 'Dalj'
],[
'state_id' => 947,
'name' => 'Darda'
],[
'state_id' => 947,
'name' => 'Donji Miholjac'
],[
'state_id' => 947,
'name' => 'Draž'
],[
'state_id' => 947,
'name' => 'Erdut'
],[
'state_id' => 947,
'name' => 'Ernestinovo'
],[
'state_id' => 947,
'name' => 'Feričanci'
],[
'state_id' => 947,
'name' => 'Gorjani'
],[
'state_id' => 947,
'name' => 'Grad Beli Manastir'
],[
'state_id' => 947,
'name' => 'Grad Donji Miholjac'
],[
'state_id' => 947,
'name' => 'Grad Našice'
],[
'state_id' => 947,
'name' => 'Grad Osijek'
],[
'state_id' => 947,
'name' => 'Grad Valpovo'
],[
'state_id' => 947,
'name' => 'Jagodnjak'
],[
'state_id' => 947,
'name' => 'Jelisavac'
],[
'state_id' => 947,
'name' => 'Josipovac'
],[
'state_id' => 947,
'name' => 'Karanac'
],[
'state_id' => 947,
'name' => 'Kneževi Vinogradi'
],[
'state_id' => 947,
'name' => 'Koška'
],[
'state_id' => 947,
'name' => 'Kuševac'
],[
'state_id' => 947,
'name' => 'Ladimirevci'
],[
'state_id' => 947,
'name' => 'Laslovo'
],[
'state_id' => 947,
'name' => 'Magadenovac'
],[
'state_id' => 947,
'name' => 'Marijanci'
],[
'state_id' => 947,
'name' => 'Marjanci'
],[
'state_id' => 947,
'name' => 'Markovac Našički'
],[
'state_id' => 947,
'name' => 'Martin'
],[
'state_id' => 947,
'name' => 'Našice'
],[
'state_id' => 947,
'name' => 'Osijek'
],[
'state_id' => 947,
'name' => 'Petlovac'
],[
'state_id' => 947,
'name' => 'Petrijevci'
],[
'state_id' => 947,
'name' => 'Piškorevci'
],[
'state_id' => 947,
'name' => 'Podgorač'
],[
'state_id' => 947,
'name' => 'Podravska Moslavina'
],[
'state_id' => 947,
'name' => 'Sarvaš'
],[
'state_id' => 947,
'name' => 'Satnica Đakovačka'
],[
'state_id' => 947,
'name' => 'Semeljci'
],[
'state_id' => 947,
'name' => 'Strizivojna'
],[
'state_id' => 947,
'name' => 'Tenja'
],[
'state_id' => 947,
'name' => 'Valpovo'
],[
'state_id' => 947,
'name' => 'Velimirovac'
],[
'state_id' => 947,
'name' => 'Viljevo'
],[
'state_id' => 947,
'name' => 'Viškovci'
],[
'state_id' => 947,
'name' => 'Višnjevac'
],[
'state_id' => 947,
'name' => 'Vladislavci'
],[
'state_id' => 947,
'name' => 'Vuka'
],[
'state_id' => 947,
'name' => 'Đurđenovac'
],[
'state_id' => 947,
'name' => 'Čeminac'
],[
'state_id' => 947,
'name' => 'Čepin'
],[
'state_id' => 947,
'name' => 'Đakovo'
],[
'state_id' => 947,
'name' => 'Široko Polje'
],[
'state_id' => 947,
'name' => 'Šodolovci'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
