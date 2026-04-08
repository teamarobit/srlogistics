<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
                  [                 'name' => "Afghanistan",
                  'iso2' => "AF",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                 'name' => "Aland Islands",
                  'iso2' => "AX",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                 'name' => "Albania",
                  'iso2' => "AL",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                 'name' => "Algeria",
                  'iso2' => "DZ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                 'name' => "American Samoa",
                  'iso2' => "AS",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                 'name' => "Andorra",
                  'iso2' => "AD",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                 'name' => "Angola",
                  'iso2' => "AO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                 'name' => "Anguilla",
                  'iso2' => "AI",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                 'name' => "Antarctica",
                  'iso2' => "AQ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Antigua And Barbuda",
                  'iso2' => "AG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Argentina",
                  'iso2' => "AR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Armenia",
                  'iso2' => "AM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Aruba",
                  'iso2' => "AW",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Australia",
                  'iso2' => "AU",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Austria",
                  'iso2' => "AT",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Azerbaijan",
                  'iso2' => "AZ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "The Bahamas",
                  'iso2' => "BS",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Bahrain",
                  'iso2' => "BH",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Bangladesh",
                  'iso2' => "BD",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Barbados",
                  'iso2' => "BB",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Belarus",
                  'iso2' => "BY",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Belgium",
                  'iso2' => "BE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Belize",
                  'iso2' => "BZ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Benin",
                  'iso2' => "BJ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Bermuda",
                  'iso2' => "BM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Bhutan",
                  'iso2' => "BT",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Bolivia",
                  'iso2' => "BO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Bosnia and Herzegovina",
                  'iso2' => "BA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Botswana",
                  'iso2' => "BW",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Bouvet Island",
                  'iso2' => "BV",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Brazil",
                  'iso2' => "BR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "British Indian Ocean Territory",
                  'iso2' => "IO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Brunei",
                  'iso2' => "BN",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Bulgaria",
                  'iso2' => "BG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Burkina Faso",
                  'iso2' => "BF",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Burundi",
                  'iso2' => "BI",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Cambodia",
                  'iso2' => "KH",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Cameroon",
                  'iso2' => "CM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Canada",
                  'iso2' => "CA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Cape Verde",
                  'iso2' => "CV",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Cayman Islands",
                  'iso2' => "KY",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Central African Republic",
                  'iso2' => "CF",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Chad",
                  'iso2' => "TD",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Chile",
                  'iso2' => "CL",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "China",
                  'iso2' => "CN",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Christmas Island",
                  'iso2' => "CX",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Cocos (Keeling) Islands",
                  'iso2' => "CC",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Colombia",
                  'iso2' => "CO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Comoros",
                  'iso2' => "KM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Congo",
                  'iso2' => "CG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Democratic Republic of the Congo",
                  'iso2' => "CD",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Cook Islands",
                  'iso2' => "CK",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Costa Rica",
                  'iso2' => "CR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Cote D'Ivoire (Ivory Coast)",
                  'iso2' => "CI",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Croatia",
                  'iso2' => "HR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Cuba",
                  'iso2' => "CU",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Cyprus",
                  'iso2' => "CY",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Czech Republic",
                  'iso2' => "CZ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Denmark",
                  'iso2' => "DK",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Djibouti",
                  'iso2' => "DJ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Dominica",
                  'iso2' => "DM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Dominican Republic",
                  'iso2' => "DO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "East Timor",
                  'iso2' => "TL",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Ecuador",
                  'iso2' => "EC",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Egypt",
                  'iso2' => "EG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "El Salvador",
                  'iso2' => "SV",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Equatorial Guinea",
                  'iso2' => "GQ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Eritrea",
                  'iso2' => "ER",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Estonia",
                  'iso2' => "EE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Ethiopia",
                  'iso2' => "ET",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Falkland Islands",
                  'iso2' => "FK",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Faroe Islands",
                  'iso2' => "FO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Fiji Islands",
                  'iso2' => "FJ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Finland",
                  'iso2' => "FI",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "France",
                  'iso2' => "FR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "French Guiana",
                  'iso2' => "GF",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "French Polynesia",
                  'iso2' => "PF",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "French Southern Territories",
                  'iso2' => "TF",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Gabon",
                  'iso2' => "GA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Gambia The",
                  'iso2' => "GM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Georgia",
                  'iso2' => "GE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Germany",
                  'iso2' => "DE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Ghana",
                  'iso2' => "GH",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Gibraltar",
                  'iso2' => "GI",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Greece",
                  'iso2' => "GR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Greenland",
                  'iso2' => "GL",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Grenada",
                  'iso2' => "GD",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Guadeloupe",
                  'iso2' => "GP",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Guam",
                  'iso2' => "GU",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Guatemala",
                  'iso2' => "GT",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Guernsey and Alderney",
                  'iso2' => "GG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Guinea",
                  'iso2' => "GN",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Guinea-Bissau",
                  'iso2' => "GW",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Guyana",
                  'iso2' => "GY",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Haiti",
                  'iso2' => "HT",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Heard Island and McDonald Islands",
                  'iso2' => "HM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Honduras",
                  'iso2' => "HN",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Hong Kong S.A.R.",
                  'iso2' => "HK",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [                  'name' => "Hungary",
                  'iso2' => "HU",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Iceland",
                  'iso2' => "IS",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "India",
                  'iso2' => "IN",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Indonesia",
                  'iso2' => "ID",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Iran",
                  'iso2' => "IR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Iraq",
                  'iso2' => "IQ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Ireland",
                  'iso2' => "IE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Israel",
                  'iso2' => "IL",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Italy",
                  'iso2' => "IT",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Jamaica",
                  'iso2' => "JM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Japan",
                  'iso2' => "JP",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Jersey",
                  'iso2' => "JE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Jordan",
                  'iso2' => "JO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Kazakhstan",
                  'iso2' => "KZ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Kenya",
                  'iso2' => "KE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Kiribati",
                  'iso2' => "KI",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "North Korea",
                  'iso2' => "KP",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "South Korea",
                  'iso2' => "KR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Kuwait",
                  'iso2' => "KW",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Kyrgyzstan",
                  'iso2' => "KG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Laos",
                  'iso2' => "LA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Latvia",
                  'iso2' => "LV",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Lebanon",
                  'iso2' => "LB",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Lesotho",
                  'iso2' => "LS",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Liberia",
                  'iso2' => "LR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Libya",
                  'iso2' => "LY",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Liechtenstein",
                  'iso2' => "LI",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Lithuania",
                  'iso2' => "LT",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Luxembourg",
                  'iso2' => "LU",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Macau S.A.R.",
                  'iso2' => "MO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "North Macedonia",
                  'iso2' => "MK",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Madagascar",
                  'iso2' => "MG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Malawi",
                  'iso2' => "MW",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Malaysia",
                  'iso2' => "MY",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Maldives",
                  'iso2' => "MV",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Mali",
                  'iso2' => "ML",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Malta",
                  'iso2' => "MT",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Man (Isle of)",
                  'iso2' => "IM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Marshall Islands",
                  'iso2' => "MH",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Martinique",
                  'iso2' => "MQ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Mauritania",
                  'iso2' => "MR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Mauritius",
                  'iso2' => "MU",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Mayotte",
                  'iso2' => "YT",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Mexico",
                  'iso2' => "MX",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Micronesia",
                  'iso2' => "FM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Moldova",
                  'iso2' => "MD",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Monaco",
                  'iso2' => "MC",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Mongolia",
                  'iso2' => "MN",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Montenegro",
                  'iso2' => "ME",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Montserrat",
                  'iso2' => "MS",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Morocco",
                  'iso2' => "MA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Mozambique",
                  'iso2' => "MZ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Myanmar",
                  'iso2' => "MM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Namibia",
                  'iso2' => "NA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Nauru",
                  'iso2' => "NR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Nepal",
                  'iso2' => "NP",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Bonaire, Sint Eustatius and Saba",
                  'iso2' => "BQ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Netherlands",
                  'iso2' => "NL",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "New Caledonia",
                  'iso2' => "NC",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "New Zealand",
                  'iso2' => "NZ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Nicaragua",
                  'iso2' => "NI",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Niger",
                  'iso2' => "NE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Nigeria",
                  'iso2' => "NG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Niue",
                  'iso2' => "NU",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Norfolk Island",
                  'iso2' => "NF",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Northern Mariana Islands",
                  'iso2' => "MP",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Norway",
                  'iso2' => "NO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Oman",
                  'iso2' => "OM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Pakistan",
                  'iso2' => "PK",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Palau",
                  'iso2' => "PW",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Palestinian Territory Occupied",
                  'iso2' => "PS",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Panama",
                  'iso2' => "PA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Papua new Guinea",
                  'iso2' => "PG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Paraguay",
                  'iso2' => "PY",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Peru",
                  'iso2' => "PE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Philippines",
                  'iso2' => "PH",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Pitcairn Island",
                  'iso2' => "PN",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Poland",
                  'iso2' => "PL",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Portugal",
                  'iso2' => "PT",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Puerto Rico",
                  'iso2' => "PR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Qatar",
                  'iso2' => "QA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Reunion",
                  'iso2' => "RE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Romania",
                  'iso2' => "RO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Russia",
                  'iso2' => "RU",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Rwanda",
                  'iso2' => "RW",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Saint Helena",
                  'iso2' => "SH",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Saint Kitts And Nevis",
                  'iso2' => "KN",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Saint Lucia",
                  'iso2' => "LC",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Saint Pierre and Miquelon",
                  'iso2' => "PM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Saint Vincent And The Grenadines",
                  'iso2' => "VC",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Saint-Barthelemy",
                  'iso2' => "BL",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Saint-Martin (French part)",
                  'iso2' => "MF",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Samoa",
                  'iso2' => "WS",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "San Marino",
                  'iso2' => "SM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Sao Tome and Principe",
                  'iso2' => "ST",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Saudi Arabia",
                  'iso2' => "SA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Senegal",
                  'iso2' => "SN",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Serbia",
                  'iso2' => "RS",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Seychelles",
                  'iso2' => "SC",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Sierra Leone",
                  'iso2' => "SL",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Singapore",
                  'iso2' => "SG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Slovakia",
                  'iso2' => "SK",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Slovenia",
                  'iso2' => "SI",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Solomon Islands",
                  'iso2' => "SB",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Somalia",
                  'iso2' => "SO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "South Africa",
                  'iso2' => "ZA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "South Georgia",
                  'iso2' => "GS",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "South Sudan",
                  'iso2' => "SS",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Spain",
                  'iso2' => "ES",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Sri Lanka",
                  'iso2' => "LK",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Sudan",
                  'iso2' => "SD",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Suriname",
                  'iso2' => "SR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Svalbard And Jan Mayen Islands",
                  'iso2' => "SJ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Swaziland",
                  'iso2' => "SZ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Sweden",
                  'iso2' => "SE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Switzerland",
                  'iso2' => "CH",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Syria",
                  'iso2' => "SY",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Taiwan",
                  'iso2' => "TW",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Tajikistan",
                  'iso2' => "TJ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Tanzania",
                  'iso2' => "TZ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Thailand",
                  'iso2' => "TH",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Togo",
                  'iso2' => "TG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Tokelau",
                  'iso2' => "TK",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Tonga",
                  'iso2' => "TO",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Trinidad And Tobago",
                  'iso2' => "TT",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Tunisia",
                  'iso2' => "TN",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Turkey",
                  'iso2' => "TR",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Turkmenistan",
                  'iso2' => "TM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Turks And Caicos Islands",
                  'iso2' => "TC",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Tuvalu",
                  'iso2' => "TV",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Uganda",
                  'iso2' => "UG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Ukraine",
                  'iso2' => "UA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "United Arab Emirates",
                  'iso2' => "AE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "United Kingdom",
                  'iso2' => "GB",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "United States",
                  'iso2' => "US",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "United States Minor Outlying Islands",
                  'iso2' => "UM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Uruguay",
                  'iso2' => "UY",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Uzbekistan",
                  'iso2' => "UZ",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Vanuatu",
                  'iso2' => "VU",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Vatican City State (Holy See)",
                  'iso2' => "VA",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Venezuela",
                  'iso2' => "VE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Vietnam",
                  'iso2' => "VN",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Virgin Islands (British)",
                  'iso2' => "VG",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Virgin Islands (US)",
                  'iso2' => "VI",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Wallis And Futuna Islands",
                  'iso2' => "WF",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Western Sahara",
                  'iso2' => "EH",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Yemen",
                  'iso2' => "YE",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Zambia",
                  'iso2' => "ZM",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Zimbabwe",
                  'iso2' => "ZW",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Kosovo",
                  'iso2' => "XK",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Curaçao",
                  'iso2' => "CW",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ],
                  [
                  'name' => "Sint Maarten (Dutch part)",
                  'iso2' => "SX",
                  'phone_code' => NULL,
                  'flag_name' => NULL
                  ]
                ];
                        
        foreach($datas as $data){
            Country::create($data);
        }
        
    }
}
