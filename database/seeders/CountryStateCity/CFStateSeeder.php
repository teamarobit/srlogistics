<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class CFStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 42,
'name' => 'Sangha-Mbaéré',
'iso2' => 'SE'
],[
'country_id' => 42,
'name' => 'Nana-Grébizi Economic Prefecture',
'iso2' => 'KB'
],[
'country_id' => 42,
'name' => 'Ouham Prefecture',
'iso2' => 'AC'
],[
'country_id' => 42,
'name' => 'Ombella-M Poko Prefecture',
'iso2' => 'MP'
],[
'country_id' => 42,
'name' => 'Lobaye Prefecture',
'iso2' => 'LB'
],[
'country_id' => 42,
'name' => 'Mambéré-Kadéï',
'iso2' => 'HS'
],[
'country_id' => 42,
'name' => 'Haut-Mbomou Prefecture',
'iso2' => 'HM'
],[
'country_id' => 42,
'name' => 'Bamingui-Bangoran Prefecture',
'iso2' => 'BB'
],[
'country_id' => 42,
'name' => 'Nana-Mambéré Prefecture',
'iso2' => 'NM'
],[
'country_id' => 42,
'name' => 'Vakaga Prefecture',
'iso2' => 'VK'
],[
'country_id' => 42,
'name' => 'Bangui',
'iso2' => 'BGF'
],[
'country_id' => 42,
'name' => 'Kémo Prefecture',
'iso2' => 'KG'
],[
'country_id' => 42,
'name' => 'Basse-Kotto Prefecture',
'iso2' => 'BK'
],[
'country_id' => 42,
'name' => 'Ouaka Prefecture',
'iso2' => 'UK'
],[
'country_id' => 42,
'name' => 'Mbomou Prefecture',
'iso2' => 'MB'
],[
'country_id' => 42,
'name' => 'Ouham-Pendé Prefecture',
'iso2' => 'OP'
],[
'country_id' => 42,
'name' => 'Haute-Kotto Prefecture',
'iso2' => 'HK'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
