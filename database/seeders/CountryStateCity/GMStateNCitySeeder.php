<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GMStateNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1409,
'name' => 'Bambali'
],[
'state_id' => 1409,
'name' => 'Barra'
],[
'state_id' => 1409,
'name' => 'Central Baddibu'
],[
'state_id' => 1409,
'name' => 'Chilla'
],[
'state_id' => 1409,
'name' => 'Daru Rilwan'
],[
'state_id' => 1409,
'name' => 'Essau'
],[
'state_id' => 1409,
'name' => 'Farafenni'
],[
'state_id' => 1409,
'name' => 'Gunjur'
],[
'state_id' => 1409,
'name' => 'Jokadu'
],[
'state_id' => 1409,
'name' => 'Katchang'
],[
'state_id' => 1409,
'name' => 'Kerewan'
],[
'state_id' => 1409,
'name' => 'Lamin'
],[
'state_id' => 1409,
'name' => 'Lower Baddibu District'
],[
'state_id' => 1409,
'name' => 'Lower Niumi District'
],[
'state_id' => 1409,
'name' => 'No Kunda'
],[
'state_id' => 1409,
'name' => 'Saba'
],[
'state_id' => 1409,
'name' => 'Sara Kunda'
],[
'state_id' => 1409,
'name' => 'Upper Baddibu'
],[
'state_id' => 1409,
'name' => 'Upper Niumi District'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
