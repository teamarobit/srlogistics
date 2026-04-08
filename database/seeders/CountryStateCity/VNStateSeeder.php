<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class VNStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 240,
'name' => 'Hưng Yên',
'iso2' => '66'
],[
'country_id' => 240,
'name' => 'Đồng Tháp',
'iso2' => '45'
],[
'country_id' => 240,
'name' => 'Bà Rịa-Vũng Tàu',
'iso2' => '43'
],[
'country_id' => 240,
'name' => 'Thanh Hóa',
'iso2' => '21'
],[
'country_id' => 240,
'name' => 'Kon Tum',
'iso2' => '28'
],[
'country_id' => 240,
'name' => 'Điện Biên',
'iso2' => '71'
],[
'country_id' => 240,
'name' => 'Vĩnh Phúc',
'iso2' => '70'
],[
'country_id' => 240,
'name' => 'Thái Bình',
'iso2' => '20'
],[
'country_id' => 240,
'name' => 'Quảng Nam',
'iso2' => '27'
],[
'country_id' => 240,
'name' => 'Hậu Giang',
'iso2' => '73'
],[
'country_id' => 240,
'name' => 'Cà Mau',
'iso2' => '59'
],[
'country_id' => 240,
'name' => 'Hà Giang',
'iso2' => '03'
],[
'country_id' => 240,
'name' => 'Nghệ An',
'iso2' => '22'
],[
'country_id' => 240,
'name' => 'Tiền Giang',
'iso2' => '46'
],[
'country_id' => 240,
'name' => 'Cao Bằng',
'iso2' => '04'
],[
'country_id' => 240,
'name' => 'Hải Phòng',
'iso2' => 'HP'
],[
'country_id' => 240,
'name' => 'Yên Bái',
'iso2' => '06'
],[
'country_id' => 240,
'name' => 'Bình Dương',
'iso2' => '57'
],[
'country_id' => 240,
'name' => 'Ninh Bình',
'iso2' => '18'
],[
'country_id' => 240,
'name' => 'Bình Thuận',
'iso2' => '40'
],[
'country_id' => 240,
'name' => 'Ninh Thuận',
'iso2' => '36'
],[
'country_id' => 240,
'name' => 'Nam Định',
'iso2' => '67'
],[
'country_id' => 240,
'name' => 'Vĩnh Long',
'iso2' => '49'
],[
'country_id' => 240,
'name' => 'Bắc Ninh',
'iso2' => '56'
],[
'country_id' => 240,
'name' => 'Lạng Sơn',
'iso2' => '09'
],[
'country_id' => 240,
'name' => 'Khánh Hòa',
'iso2' => '34'
],[
'country_id' => 240,
'name' => 'An Giang',
'iso2' => '44'
],[
'country_id' => 240,
'name' => 'Tuyên Quang',
'iso2' => '07'
],[
'country_id' => 240,
'name' => 'Bến Tre',
'iso2' => '50'
],[
'country_id' => 240,
'name' => 'Bình Phước',
'iso2' => '58'
],[
'country_id' => 240,
'name' => 'Thừa Thiên-Huế',
'iso2' => '26'
],[
'country_id' => 240,
'name' => 'Hòa Bình',
'iso2' => '14'
],[
'country_id' => 240,
'name' => 'Kiên Giang',
'iso2' => '47'
],[
'country_id' => 240,
'name' => 'Phú Thọ',
'iso2' => '68'
],[
'country_id' => 240,
'name' => 'Hà Nam',
'iso2' => '63'
],[
'country_id' => 240,
'name' => 'Quảng Trị',
'iso2' => '25'
],[
'country_id' => 240,
'name' => 'Bạc Liêu',
'iso2' => '55'
],[
'country_id' => 240,
'name' => 'Trà Vinh',
'iso2' => '51'
],[
'country_id' => 240,
'name' => 'Đà Nẵng',
'iso2' => 'DN'
],[
'country_id' => 240,
'name' => 'Thái Nguyên',
'iso2' => '69'
],[
'country_id' => 240,
'name' => 'Long An',
'iso2' => '41'
],[
'country_id' => 240,
'name' => 'Quảng Bình',
'iso2' => '24'
],[
'country_id' => 240,
'name' => 'Hà Nội',
'iso2' => 'HN'
],[
'country_id' => 240,
'name' => 'Hồ Chí Minh',
'iso2' => 'SG'
],[
'country_id' => 240,
'name' => 'Sơn La',
'iso2' => '05'
],[
'country_id' => 240,
'name' => 'Gia Lai',
'iso2' => '30'
],[
'country_id' => 240,
'name' => 'Quảng Ninh',
'iso2' => '13'
],[
'country_id' => 240,
'name' => 'Bắc Giang',
'iso2' => '54'
],[
'country_id' => 240,
'name' => 'Hà Tĩnh',
'iso2' => '23'
],[
'country_id' => 240,
'name' => 'Lào Cai',
'iso2' => '02'
],[
'country_id' => 240,
'name' => 'Lâm Đồng',
'iso2' => '35'
],[
'country_id' => 240,
'name' => 'Sóc Trăng',
'iso2' => '52'
],[
'country_id' => 240,
'name' => 'Đồng Nai',
'iso2' => '39'
],[
'country_id' => 240,
'name' => 'Bắc Kạn',
'iso2' => '53'
],[
'country_id' => 240,
'name' => 'Đắk Nông',
'iso2' => '72'
],[
'country_id' => 240,
'name' => 'Phú Yên',
'iso2' => '32'
],[
'country_id' => 240,
'name' => 'Lai Châu',
'iso2' => '01'
],[
'country_id' => 240,
'name' => 'Tây Ninh',
'iso2' => '37'
],[
'country_id' => 240,
'name' => 'Hải Dương',
'iso2' => '61'
],[
'country_id' => 240,
'name' => 'Quảng Ngãi',
'iso2' => '29'
],[
'country_id' => 240,
'name' => 'Đắk Lắk',
'iso2' => '33'
],[
'country_id' => 240,
'name' => 'Bình Định',
'iso2' => '31'
],[
'country_id' => 240,
'name' => 'Cần Thơ',
'iso2' => 'CT'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
