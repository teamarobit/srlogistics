<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState08CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 942,
'name' => 'Bakar'
],[
'state_id' => 942,
'name' => 'Banjol'
],[
'state_id' => 942,
'name' => 'Baška'
],[
'state_id' => 942,
'name' => 'Bribir'
],[
'state_id' => 942,
'name' => 'Buzdohanj'
],[
'state_id' => 942,
'name' => 'Cernik'
],[
'state_id' => 942,
'name' => 'Cres'
],[
'state_id' => 942,
'name' => 'Crikvenica'
],[
'state_id' => 942,
'name' => 'Delnice'
],[
'state_id' => 942,
'name' => 'Dražice'
],[
'state_id' => 942,
'name' => 'Drenova'
],[
'state_id' => 942,
'name' => 'Fužine'
],[
'state_id' => 942,
'name' => 'Grad Crikvenica'
],[
'state_id' => 942,
'name' => 'Grad Delnice'
],[
'state_id' => 942,
'name' => 'Grad Krk'
],[
'state_id' => 942,
'name' => 'Grad Opatija'
],[
'state_id' => 942,
'name' => 'Grad Rijeka'
],[
'state_id' => 942,
'name' => 'Grad Vrbovsko'
],[
'state_id' => 942,
'name' => 'Grad Čabar'
],[
'state_id' => 942,
'name' => 'Hreljin'
],[
'state_id' => 942,
'name' => 'Jadranovo'
],[
'state_id' => 942,
'name' => 'Kampor'
],[
'state_id' => 942,
'name' => 'Kastav'
],[
'state_id' => 942,
'name' => 'Klana'
],[
'state_id' => 942,
'name' => 'Kraljevica'
],[
'state_id' => 942,
'name' => 'Krasica'
],[
'state_id' => 942,
'name' => 'Krk'
],[
'state_id' => 942,
'name' => 'Lopar'
],[
'state_id' => 942,
'name' => 'Lovran'
],[
'state_id' => 942,
'name' => 'Mali Lošinj'
],[
'state_id' => 942,
'name' => 'Malinska-Dubašnica'
],[
'state_id' => 942,
'name' => 'Marinići'
],[
'state_id' => 942,
'name' => 'Marčelji'
],[
'state_id' => 942,
'name' => 'Matulji'
],[
'state_id' => 942,
'name' => 'Mihotići'
],[
'state_id' => 942,
'name' => 'Mrkopalj'
],[
'state_id' => 942,
'name' => 'Njivice'
],[
'state_id' => 942,
'name' => 'Novi Vinodolski'
],[
'state_id' => 942,
'name' => 'Omišalj'
],[
'state_id' => 942,
'name' => 'Opatija'
],[
'state_id' => 942,
'name' => 'Podhum'
],[
'state_id' => 942,
'name' => 'Punat'
],[
'state_id' => 942,
'name' => 'Rab'
],[
'state_id' => 942,
'name' => 'Rijeka'
],[
'state_id' => 942,
'name' => 'Rubeši'
],[
'state_id' => 942,
'name' => 'Selce'
],[
'state_id' => 942,
'name' => 'Skrad'
],[
'state_id' => 942,
'name' => 'Supetarska Draga'
],[
'state_id' => 942,
'name' => 'Vinodolska općina'
],[
'state_id' => 942,
'name' => 'Viškovo'
],[
'state_id' => 942,
'name' => 'Vrbnik'
],[
'state_id' => 942,
'name' => 'Vrbovsko'
],[
'state_id' => 942,
'name' => 'Čavle'
],[
'state_id' => 942,
'name' => 'Škrljevo'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
