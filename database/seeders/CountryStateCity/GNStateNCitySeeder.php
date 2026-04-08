<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GNStateNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1534,
'name' => 'Beyla'
],[
'state_id' => 1534,
'name' => 'Beyla Prefecture'
],[
'state_id' => 1534,
'name' => 'Gueckedou'
],[
'state_id' => 1534,
'name' => 'Lola'
],[
'state_id' => 1534,
'name' => 'Macenta'
],[
'state_id' => 1534,
'name' => 'Nzerekore Prefecture'
],[
'state_id' => 1534,
'name' => 'Nzérékoré'
],[
'state_id' => 1534,
'name' => 'Préfecture de Guékédou'
],[
'state_id' => 1534,
'name' => 'Yomou'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
