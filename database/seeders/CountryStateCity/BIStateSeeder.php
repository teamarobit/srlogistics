<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BIStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 36,
'name' => 'Rumonge Province',
'iso2' => 'RM'
],[
'country_id' => 36,
'name' => 'Muyinga Province',
'iso2' => 'MY'
],[
'country_id' => 36,
'name' => 'Mwaro Province',
'iso2' => 'MW'
],[
'country_id' => 36,
'name' => 'Makamba Province',
'iso2' => 'MA'
],[
'country_id' => 36,
'name' => 'Rutana Province',
'iso2' => 'RT'
],[
'country_id' => 36,
'name' => 'Cibitoke Province',
'iso2' => 'CI'
],[
'country_id' => 36,
'name' => 'Ruyigi Province',
'iso2' => 'RY'
],[
'country_id' => 36,
'name' => 'Kayanza Province',
'iso2' => 'KY'
],[
'country_id' => 36,
'name' => 'Muramvya Province',
'iso2' => 'MU'
],[
'country_id' => 36,
'name' => 'Karuzi Province',
'iso2' => 'KR'
],[
'country_id' => 36,
'name' => 'Kirundo Province',
'iso2' => 'KI'
],[
'country_id' => 36,
'name' => 'Bubanza Province',
'iso2' => 'BB'
],[
'country_id' => 36,
'name' => 'Gitega Province',
'iso2' => 'GI'
],[
'country_id' => 36,
'name' => 'Bujumbura Mairie Province',
'iso2' => 'BM'
],[
'country_id' => 36,
'name' => 'Ngozi Province',
'iso2' => 'NG'
],[
'country_id' => 36,
'name' => 'Bujumbura Rural Province',
'iso2' => 'BL'
],[
'country_id' => 36,
'name' => 'Cankuzo Province',
'iso2' => 'CA'
],[
'country_id' => 36,
'name' => 'Bururi Province',
'iso2' => 'BR'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
