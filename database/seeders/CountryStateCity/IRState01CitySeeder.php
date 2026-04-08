<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState01CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1753,
'name' => 'Bandar Anzali'
],[
'state_id' => 1753,
'name' => 'Hashtpar'
],[
'state_id' => 1753,
'name' => 'Langarud'
],[
'state_id' => 1753,
'name' => 'Manjil'
],[
'state_id' => 1753,
'name' => 'Rasht'
],[
'state_id' => 1753,
'name' => 'Rezvanshahr'
],[
'state_id' => 1753,
'name' => 'Rudsar'
],[
'state_id' => 1753,
'name' => 'Fuman'
],[
'state_id' => 1753,
'name' => 'Lahijan'
],[
'state_id' => 1753,
'name' => 'Masal'
],[
'state_id' => 1753,
'name' => 'Rudbar'
],[
'state_id' => 1753,
'name' => 'Siahkal'
],[
'state_id' => 1753,
'name' => 'Talesh'
],[
'state_id' => 1753,
'name' => 'astara'
],[
'state_id' => 1753,
'name' => 'Someh Sara'
],[
'state_id' => 1753,
'name' => 'Ziabar'
],[
'state_id' => 1753,
'name' => 'Astaneh-ye Ashrafiyeh'
],[
'state_id' => 1753,
'name' => 'Lavandvil'
],[
'state_id' => 1753,
'name' => 'Kiashahr'
],[
'state_id' => 1753,
'name' => 'Amlash'
],[
'state_id' => 1753,
'name' => 'Ranekouh'
],[
'state_id' => 1753,
'name' => 'Khoshkebijar'
],[
'state_id' => 1753,
'name' => 'Khomam'
],[
'state_id' => 1753,
'name' => 'Sangar'
],[
'state_id' => 1753,
'name' => 'Kuchesfahan'
],[
'state_id' => 1753,
'name' => 'Lasht-e Nesha'
],[
'state_id' => 1753,
'name' => 'Louleman'
],[
'state_id' => 1753,
'name' => 'Paresar'
],[
'state_id' => 1753,
'name' => 'Barehsar'
],[
'state_id' => 1753,
'name' => 'Tutkabon'
],[
'state_id' => 1753,
'name' => 'Jirindih'
],[
'state_id' => 1753,
'name' => 'Rostamabad'
],[
'state_id' => 1753,
'name' => 'Lowshan'
],[
'state_id' => 1753,
'name' => 'Chaboksar'
],[
'state_id' => 1753,
'name' => 'Rahimabad'
],[
'state_id' => 1753,
'name' => 'Kelachay'
],[
'state_id' => 1753,
'name' => 'Vajargah'
],[
'state_id' => 1753,
'name' => 'Deylaman'
],[
'state_id' => 1753,
'name' => 'Ahmadsargurab'
],[
'state_id' => 1753,
'name' => 'Shaft'
],[
'state_id' => 1753,
'name' => 'Gurab Zarmikh'
],[
'state_id' => 1753,
'name' => 'Marjaghal'
],[
'state_id' => 1753,
'name' => 'Asalem'
],[
'state_id' => 1753,
'name' => 'Choobar'
],[
'state_id' => 1753,
'name' => 'Haviq'
],[
'state_id' => 1753,
'name' => 'Lisar'
],[
'state_id' => 1753,
'name' => 'Masuleh'
],[
'state_id' => 1753,
'name' => 'Maklavan'
],[
'state_id' => 1753,
'name' => 'Rod Baneh'
],[
'state_id' => 1753,
'name' => 'Otaghvar'
],[
'state_id' => 1753,
'name' => 'Chaf and Chamkhaleh'
],[
'state_id' => 1753,
'name' => 'Shalman'
],[
'state_id' => 1753,
'name' => 'Kumeleh'
],[
'state_id' => 1753,
'name' => 'Bazar Jomeh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
