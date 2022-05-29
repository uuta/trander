<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MCountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['id' => '1', 'name' => 'Afghanistan', 'country_code' => 'AF', 'created_at' => now()],
            ['id' => '2', 'name' => 'Aland Islands', 'country_code' => 'AX', 'created_at' => now()],
            ['id' => '3', 'name' => 'Albania', 'country_code' => 'AL', 'created_at' => now()],
            ['id' => '4', 'name' => 'Algeria', 'country_code' => 'DZ', 'created_at' => now()],
            ['id' => '5', 'name' => 'American Samoa', 'country_code' => 'AS', 'created_at' => now()],
            ['id' => '6', 'name' => 'Andorra', 'country_code' => 'AD', 'created_at' => now()],
            ['id' => '7', 'name' => 'Angola', 'country_code' => 'AO', 'created_at' => now()],
            ['id' => '8', 'name' => 'Anguilla', 'country_code' => 'AI', 'created_at' => now()],
            ['id' => '9', 'name' => 'Antarctica', 'country_code' => 'AQ', 'created_at' => now()],
            ['id' => '10', 'name' => 'Antigua And Barbuda', 'country_code' => 'AG', 'created_at' => now()],
            ['id' => '11', 'name' => 'Argentina', 'country_code' => 'AR', 'created_at' => now()],
            ['id' => '12', 'name' => 'Armenia', 'country_code' => 'AM', 'created_at' => now()],
            ['id' => '13', 'name' => 'Aruba', 'country_code' => 'AW', 'created_at' => now()],
            ['id' => '14', 'name' => 'Australia', 'country_code' => 'AU', 'created_at' => now()],
            ['id' => '15', 'name' => 'Austria', 'country_code' => 'AT', 'created_at' => now()],
            ['id' => '16', 'name' => 'Azerbaijan', 'country_code' => 'AZ', 'created_at' => now()],
            ['id' => '17', 'name' => 'Bahamas', 'country_code' => 'BS', 'created_at' => now()],
            ['id' => '18', 'name' => 'Bahrain', 'country_code' => 'BH', 'created_at' => now()],
            ['id' => '19', 'name' => 'Bangladesh', 'country_code' => 'BD', 'created_at' => now()],
            ['id' => '20', 'name' => 'Barbados', 'country_code' => 'BB', 'created_at' => now()],
            ['id' => '21', 'name' => 'Belarus', 'country_code' => 'BY', 'created_at' => now()],
            ['id' => '22', 'name' => 'Belgium', 'country_code' => 'BE', 'created_at' => now()],
            ['id' => '23', 'name' => 'Belize', 'country_code' => 'BZ', 'created_at' => now()],
            ['id' => '24', 'name' => 'Benin', 'country_code' => 'BJ', 'created_at' => now()],
            ['id' => '25', 'name' => 'Bermuda', 'country_code' => 'BM', 'created_at' => now()],
            ['id' => '26', 'name' => 'Bhutan', 'country_code' => 'BT', 'created_at' => now()],
            ['id' => '27', 'name' => 'Bolivia', 'country_code' => 'BO', 'created_at' => now()],
            ['id' => '28', 'name' => 'Bosnia And Herzegovina', 'country_code' => 'BA', 'created_at' => now()],
            ['id' => '29', 'name' => 'Botswana', 'country_code' => 'BW', 'created_at' => now()],
            ['id' => '30', 'name' => 'Bouvet Island', 'country_code' => 'BV', 'created_at' => now()],
            ['id' => '31', 'name' => 'Brazil', 'country_code' => 'BR', 'created_at' => now()],
            ['id' => '32', 'name' => 'British Indian Ocean Territory', 'country_code' => 'IO', 'created_at' => now()],
            ['id' => '33', 'name' => 'Brunei Darussalam', 'country_code' => 'BN', 'created_at' => now()],
            ['id' => '34', 'name' => 'Bulgaria', 'country_code' => 'BG', 'created_at' => now()],
            ['id' => '35', 'name' => 'Burkina Faso', 'country_code' => 'BF', 'created_at' => now()],
            ['id' => '36', 'name' => 'Burundi', 'country_code' => 'BI', 'created_at' => now()],
            ['id' => '37', 'name' => 'Cambodia', 'country_code' => 'KH', 'created_at' => now()],
            ['id' => '38', 'name' => 'Cameroon', 'country_code' => 'CM', 'created_at' => now()],
            ['id' => '39', 'name' => 'Canada', 'country_code' => 'CA', 'created_at' => now()],
            ['id' => '40', 'name' => 'Cape Verde', 'country_code' => 'CV', 'created_at' => now()],
            ['id' => '41', 'name' => 'Cayman Islands', 'country_code' => 'KY', 'created_at' => now()],
            ['id' => '42', 'name' => 'Central African Republic', 'country_code' => 'CF', 'created_at' => now()],
            ['id' => '43', 'name' => 'Chad', 'country_code' => 'TD', 'created_at' => now()],
            ['id' => '44', 'name' => 'Chile', 'country_code' => 'CL', 'created_at' => now()],
            ['id' => '45', 'name' => 'China', 'country_code' => 'CN', 'created_at' => now()],
            ['id' => '46', 'name' => 'Christmas Island', 'country_code' => 'CX', 'created_at' => now()],
            ['id' => '47', 'name' => 'Cocos (Keeling) Islands', 'country_code' => 'CC', 'created_at' => now()],
            ['id' => '48', 'name' => 'Colombia', 'country_code' => 'CO', 'created_at' => now()],
            ['id' => '49', 'name' => 'Comoros', 'country_code' => 'KM', 'created_at' => now()],
            ['id' => '50', 'name' => 'Congo', 'country_code' => 'CG', 'created_at' => now()],
            ['id' => '51', 'name' => 'Congo, Democratic Republic', 'country_code' => 'CD', 'created_at' => now()],
            ['id' => '52', 'name' => 'Cook Islands', 'country_code' => 'CK', 'created_at' => now()],
            ['id' => '53', 'name' => 'Costa Rica', 'country_code' => 'CR', 'created_at' => now()],
            ['id' => '54', 'name' => 'Cote D\Ivoire"', 'country_code' => 'CI', 'created_at' => now()],
            ['id' => '55', 'name' => 'Croatia', 'country_code' => 'HR', 'created_at' => now()],
            ['id' => '56', 'name' => 'Cuba', 'country_code' => 'CU', 'created_at' => now()],
            ['id' => '57', 'name' => 'Cyprus', 'country_code' => 'CY', 'created_at' => now()],
            ['id' => '58', 'name' => 'Czech Republic', 'country_code' => 'CZ', 'created_at' => now()],
            ['id' => '59', 'name' => 'Denmark', 'country_code' => 'DK', 'created_at' => now()],
            ['id' => '60', 'name' => 'Djibouti', 'country_code' => 'DJ', 'created_at' => now()],
            ['id' => '61', 'name' => 'Dominica', 'country_code' => 'DM', 'created_at' => now()],
            ['id' => '62', 'name' => 'Dominican Republic', 'country_code' => 'DO', 'created_at' => now()],
            ['id' => '63', 'name' => 'Ecuador', 'country_code' => 'EC', 'created_at' => now()],
            ['id' => '64', 'name' => 'Egypt', 'country_code' => 'EG', 'created_at' => now()],
            ['id' => '65', 'name' => 'El Salvador', 'country_code' => 'SV', 'created_at' => now()],
            ['id' => '66', 'name' => 'Equatorial Guinea', 'country_code' => 'GQ', 'created_at' => now()],
            ['id' => '67', 'name' => 'Eritrea', 'country_code' => 'ER', 'created_at' => now()],
            ['id' => '68', 'name' => 'Estonia', 'country_code' => 'EE', 'created_at' => now()],
            ['id' => '69', 'name' => 'Ethiopia', 'country_code' => 'ET', 'created_at' => now()],
            ['id' => '70', 'name' => 'Falkland Islands (Malvinas)', 'country_code' => 'FK', 'created_at' => now()],
            ['id' => '71', 'name' => 'Faroe Islands', 'country_code' => 'FO', 'created_at' => now()],
            ['id' => '72', 'name' => 'Fiji', 'country_code' => 'FJ', 'created_at' => now()],
            ['id' => '73', 'name' => 'Finland', 'country_code' => 'FI', 'created_at' => now()],
            ['id' => '74', 'name' => 'France', 'country_code' => 'FR', 'created_at' => now()],
            ['id' => '75', 'name' => 'French Guiana', 'country_code' => 'GF', 'created_at' => now()],
            ['id' => '76', 'name' => 'French Polynesia', 'country_code' => 'PF', 'created_at' => now()],
            ['id' => '77', 'name' => 'French Southern Territories', 'country_code' => 'TF', 'created_at' => now()],
            ['id' => '78', 'name' => 'Gabon', 'country_code' => 'GA', 'created_at' => now()],
            ['id' => '79', 'name' => 'Gambia', 'country_code' => 'GM', 'created_at' => now()],
            ['id' => '80', 'name' => 'Georgia', 'country_code' => 'GE', 'created_at' => now()],
            ['id' => '81', 'name' => 'Germany', 'country_code' => 'DE', 'created_at' => now()],
            ['id' => '82', 'name' => 'Ghana', 'country_code' => 'GH', 'created_at' => now()],
            ['id' => '83', 'name' => 'Gibraltar', 'country_code' => 'GI', 'created_at' => now()],
            ['id' => '84', 'name' => 'Greece', 'country_code' => 'GR', 'created_at' => now()],
            ['id' => '85', 'name' => 'Greenland', 'country_code' => 'GL', 'created_at' => now()],
            ['id' => '86', 'name' => 'Grenada', 'country_code' => 'GD', 'created_at' => now()],
            ['id' => '87', 'name' => 'Guadeloupe', 'country_code' => 'GP', 'created_at' => now()],
            ['id' => '88', 'name' => 'Guam', 'country_code' => 'GU', 'created_at' => now()],
            ['id' => '89', 'name' => 'Guatemala', 'country_code' => 'GT', 'created_at' => now()],
            ['id' => '90', 'name' => 'Guernsey', 'country_code' => 'GG', 'created_at' => now()],
            ['id' => '91', 'name' => 'Guinea', 'country_code' => 'GN', 'created_at' => now()],
            ['id' => '92', 'name' => 'Guinea-Bissau', 'country_code' => 'GW', 'created_at' => now()],
            ['id' => '93', 'name' => 'Guyana', 'country_code' => 'GY', 'created_at' => now()],
            ['id' => '94', 'name' => 'Haiti', 'country_code' => 'HT', 'created_at' => now()],
            ['id' => '95', 'name' => 'Heard Island & Mcdonald Islands', 'country_code' => 'HM', 'created_at' => now()],
            ['id' => '96', 'name' => 'Holy See (Vatican City State)', 'country_code' => 'VA', 'created_at' => now()],
            ['id' => '97', 'name' => 'Honduras', 'country_code' => 'HN', 'created_at' => now()],
            ['id' => '98', 'name' => 'Hong Kong', 'country_code' => 'HK', 'created_at' => now()],
            ['id' => '99', 'name' => 'Hungary', 'country_code' => 'HU', 'created_at' => now()],
            ['id' => '100', 'name' => 'Iceland', 'country_code' => 'IS', 'created_at' => now()],
            ['id' => '101', 'name' => 'India', 'country_code' => 'IN', 'created_at' => now()],
            ['id' => '102', 'name' => 'Indonesia', 'country_code' => 'ID', 'created_at' => now()],
            ['id' => '103', 'name' => 'Iran, Islamic Republic Of', 'country_code' => 'IR', 'created_at' => now()],
            ['id' => '104', 'name' => 'Iraq', 'country_code' => 'IQ', 'created_at' => now()],
            ['id' => '105', 'name' => 'Ireland', 'country_code' => 'IE', 'created_at' => now()],
            ['id' => '106', 'name' => 'Isle Of Man', 'country_code' => 'IM', 'created_at' => now()],
            ['id' => '107', 'name' => 'Israel', 'country_code' => 'IL', 'created_at' => now()],
            ['id' => '108', 'name' => 'Italy', 'country_code' => 'IT', 'created_at' => now()],
            ['id' => '109', 'name' => 'Jamaica', 'country_code' => 'JM', 'created_at' => now()],
            ['id' => '110', 'name' => 'Japan', 'country_code' => 'JP', 'created_at' => now()],
            ['id' => '111', 'name' => 'Jersey', 'country_code' => 'JE', 'created_at' => now()],
            ['id' => '112', 'name' => 'Jordan', 'country_code' => 'JO', 'created_at' => now()],
            ['id' => '113', 'name' => 'Kazakhstan', 'country_code' => 'KZ', 'created_at' => now()],
            ['id' => '114', 'name' => 'Kenya', 'country_code' => 'KE', 'created_at' => now()],
            ['id' => '115', 'name' => 'Kiribati', 'country_code' => 'KI', 'created_at' => now()],
            ['id' => '116', 'name' => 'Korea', 'country_code' => 'KR', 'created_at' => now()],
            ['id' => '117', 'name' => 'North Korea', 'country_code' => 'KP', 'created_at' => now()],
            ['id' => '118', 'name' => 'Kuwait', 'country_code' => 'KW', 'created_at' => now()],
            ['id' => '119', 'name' => 'Kyrgyzstan', 'country_code' => 'KG', 'created_at' => now()],
            ['id' => '120', 'name' => 'Lao People\s Democratic Republic"', 'country_code' => 'LA', 'created_at' => now()],
            ['id' => '121', 'name' => 'Latvia', 'country_code' => 'LV', 'created_at' => now()],
            ['id' => '122', 'name' => 'Lebanon', 'country_code' => 'LB', 'created_at' => now()],
            ['id' => '123', 'name' => 'Lesotho', 'country_code' => 'LS', 'created_at' => now()],
            ['id' => '124', 'name' => 'Liberia', 'country_code' => 'LR', 'created_at' => now()],
            ['id' => '125', 'name' => 'Libyan Arab Jamahiriya', 'country_code' => 'LY', 'created_at' => now()],
            ['id' => '126', 'name' => 'Liechtenstein', 'country_code' => 'LI', 'created_at' => now()],
            ['id' => '127', 'name' => 'Lithuania', 'country_code' => 'LT', 'created_at' => now()],
            ['id' => '128', 'name' => 'Luxembourg', 'country_code' => 'LU', 'created_at' => now()],
            ['id' => '129', 'name' => 'Macao', 'country_code' => 'MO', 'created_at' => now()],
            ['id' => '130', 'name' => 'Macedonia', 'country_code' => 'MK', 'created_at' => now()],
            ['id' => '131', 'name' => 'Madagascar', 'country_code' => 'MG', 'created_at' => now()],
            ['id' => '132', 'name' => 'Malawi', 'country_code' => 'MW', 'created_at' => now()],
            ['id' => '133', 'name' => 'Malaysia', 'country_code' => 'MY', 'created_at' => now()],
            ['id' => '134', 'name' => 'Maldives', 'country_code' => 'MV', 'created_at' => now()],
            ['id' => '135', 'name' => 'Mali', 'country_code' => 'ML', 'created_at' => now()],
            ['id' => '136', 'name' => 'Malta', 'country_code' => 'MT', 'created_at' => now()],
            ['id' => '137', 'name' => 'Marshall Islands', 'country_code' => 'MH', 'created_at' => now()],
            ['id' => '138', 'name' => 'Martinique', 'country_code' => 'MQ', 'created_at' => now()],
            ['id' => '139', 'name' => 'Mauritania', 'country_code' => 'MR', 'created_at' => now()],
            ['id' => '140', 'name' => 'Mauritius', 'country_code' => 'MU', 'created_at' => now()],
            ['id' => '141', 'name' => 'Mayotte', 'country_code' => 'YT', 'created_at' => now()],
            ['id' => '142', 'name' => 'Mexico', 'country_code' => 'MX', 'created_at' => now()],
            ['id' => '143', 'name' => 'Micronesia, Federated States Of', 'country_code' => 'FM', 'created_at' => now()],
            ['id' => '144', 'name' => 'Moldova', 'country_code' => 'MD', 'created_at' => now()],
            ['id' => '145', 'name' => 'Monaco', 'country_code' => 'MC', 'created_at' => now()],
            ['id' => '146', 'name' => 'Mongolia', 'country_code' => 'MN', 'created_at' => now()],
            ['id' => '147', 'name' => 'Montenegro', 'country_code' => 'ME', 'created_at' => now()],
            ['id' => '148', 'name' => 'Montserrat', 'country_code' => 'MS', 'created_at' => now()],
            ['id' => '149', 'name' => 'Morocco', 'country_code' => 'MA', 'created_at' => now()],
            ['id' => '150', 'name' => 'Mozambique', 'country_code' => 'MZ', 'created_at' => now()],
            ['id' => '151', 'name' => 'Myanmar', 'country_code' => 'MM', 'created_at' => now()],
            ['id' => '152', 'name' => 'Namibia', 'country_code' => 'NA', 'created_at' => now()],
            ['id' => '153', 'name' => 'Nauru', 'country_code' => 'NR', 'created_at' => now()],
            ['id' => '154', 'name' => 'Nepal', 'country_code' => 'NP', 'created_at' => now()],
            ['id' => '155', 'name' => 'Netherlands', 'country_code' => 'NL', 'created_at' => now()],
            ['id' => '156', 'name' => 'Netherlands Antilles', 'country_code' => 'AN', 'created_at' => now()],
            ['id' => '157', 'name' => 'New Caledonia', 'country_code' => 'NC', 'created_at' => now()],
            ['id' => '158', 'name' => 'New Zealand', 'country_code' => 'NZ', 'created_at' => now()],
            ['id' => '159', 'name' => 'Nicaragua', 'country_code' => 'NI', 'created_at' => now()],
            ['id' => '160', 'name' => 'Niger', 'country_code' => 'NE', 'created_at' => now()],
            ['id' => '161', 'name' => 'Nigeria', 'country_code' => 'NG', 'created_at' => now()],
            ['id' => '162', 'name' => 'Niue', 'country_code' => 'NU', 'created_at' => now()],
            ['id' => '163', 'name' => 'Norfolk Island', 'country_code' => 'NF', 'created_at' => now()],
            ['id' => '164', 'name' => 'Northern Mariana Islands', 'country_code' => 'MP', 'created_at' => now()],
            ['id' => '165', 'name' => 'Norway', 'country_code' => 'NO', 'created_at' => now()],
            ['id' => '166', 'name' => 'Oman', 'country_code' => 'OM', 'created_at' => now()],
            ['id' => '167', 'name' => 'Pakistan', 'country_code' => 'PK', 'created_at' => now()],
            ['id' => '168', 'name' => 'Palau', 'country_code' => 'PW', 'created_at' => now()],
            ['id' => '169', 'name' => 'Palestinian Territory, Occupied', 'country_code' => 'PS', 'created_at' => now()],
            ['id' => '170', 'name' => 'Panama', 'country_code' => 'PA', 'created_at' => now()],
            ['id' => '171', 'name' => 'Papua New Guinea', 'country_code' => 'PG', 'created_at' => now()],
            ['id' => '172', 'name' => 'Paraguay', 'country_code' => 'PY', 'created_at' => now()],
            ['id' => '173', 'name' => 'Peru', 'country_code' => 'PE', 'created_at' => now()],
            ['id' => '174', 'name' => 'Philippines', 'country_code' => 'PH', 'created_at' => now()],
            ['id' => '175', 'name' => 'Pitcairn', 'country_code' => 'PN', 'created_at' => now()],
            ['id' => '176', 'name' => 'Poland', 'country_code' => 'PL', 'created_at' => now()],
            ['id' => '177', 'name' => 'Portugal', 'country_code' => 'PT', 'created_at' => now()],
            ['id' => '178', 'name' => 'Puerto Rico', 'country_code' => 'PR', 'created_at' => now()],
            ['id' => '179', 'name' => 'Qatar', 'country_code' => 'QA', 'created_at' => now()],
            ['id' => '180', 'name' => 'Reunion', 'country_code' => 'RE', 'created_at' => now()],
            ['id' => '181', 'name' => 'Romania', 'country_code' => 'RO', 'created_at' => now()],
            ['id' => '182', 'name' => 'Russian Federation', 'country_code' => 'RU', 'created_at' => now()],
            ['id' => '183', 'name' => 'Rwanda', 'country_code' => 'RW', 'created_at' => now()],
            ['id' => '184', 'name' => 'Saint Barthelemy', 'country_code' => 'BL', 'created_at' => now()],
            ['id' => '185', 'name' => 'Saint Helena', 'country_code' => 'SH', 'created_at' => now()],
            ['id' => '186', 'name' => 'Saint Kitts And Nevis', 'country_code' => 'KN', 'created_at' => now()],
            ['id' => '187', 'name' => 'Saint Lucia', 'country_code' => 'LC', 'created_at' => now()],
            ['id' => '188', 'name' => 'Saint Martin', 'country_code' => 'MF', 'created_at' => now()],
            ['id' => '189', 'name' => 'Saint Pierre And Miquelon', 'country_code' => 'PM', 'created_at' => now()],
            ['id' => '190', 'name' => 'Saint Vincent And Grenadines', 'country_code' => 'VC', 'created_at' => now()],
            ['id' => '191', 'name' => 'Samoa', 'country_code' => 'WS', 'created_at' => now()],
            ['id' => '192', 'name' => 'San Marino', 'country_code' => 'SM', 'created_at' => now()],
            ['id' => '193', 'name' => 'Sao Tome And Principe', 'country_code' => 'ST', 'created_at' => now()],
            ['id' => '194', 'name' => 'Saudi Arabia', 'country_code' => 'SA', 'created_at' => now()],
            ['id' => '195', 'name' => 'Senegal', 'country_code' => 'SN', 'created_at' => now()],
            ['id' => '196', 'name' => 'Serbia', 'country_code' => 'RS', 'created_at' => now()],
            ['id' => '197', 'name' => 'Seychelles', 'country_code' => 'SC', 'created_at' => now()],
            ['id' => '198', 'name' => 'Sierra Leone', 'country_code' => 'SL', 'created_at' => now()],
            ['id' => '199', 'name' => 'Singapore', 'country_code' => 'SG', 'created_at' => now()],
            ['id' => '200', 'name' => 'Slovakia', 'country_code' => 'SK', 'created_at' => now()],
            ['id' => '201', 'name' => 'Slovenia', 'country_code' => 'SI', 'created_at' => now()],
            ['id' => '202', 'name' => 'Solomon Islands', 'country_code' => 'SB', 'created_at' => now()],
            ['id' => '203', 'name' => 'Somalia', 'country_code' => 'SO', 'created_at' => now()],
            ['id' => '204', 'name' => 'South Africa', 'country_code' => 'ZA', 'created_at' => now()],
            ['id' => '205', 'name' => 'South Georgia And Sandwich Isl.', 'country_code' => 'GS', 'created_at' => now()],
            ['id' => '206', 'name' => 'Spain', 'country_code' => 'ES', 'created_at' => now()],
            ['id' => '207', 'name' => 'Sri Lanka', 'country_code' => 'LK', 'created_at' => now()],
            ['id' => '208', 'name' => 'Sudan', 'country_code' => 'SD', 'created_at' => now()],
            ['id' => '209', 'name' => 'Suriname', 'country_code' => 'SR', 'created_at' => now()],
            ['id' => '210', 'name' => 'Svalbard And Jan Mayen', 'country_code' => 'SJ', 'created_at' => now()],
            ['id' => '211', 'name' => 'Swaziland', 'country_code' => 'SZ', 'created_at' => now()],
            ['id' => '212', 'name' => 'Sweden', 'country_code' => 'SE', 'created_at' => now()],
            ['id' => '213', 'name' => 'Switzerland', 'country_code' => 'CH', 'created_at' => now()],
            ['id' => '214', 'name' => 'Syrian Arab Republic', 'country_code' => 'SY', 'created_at' => now()],
            ['id' => '215', 'name' => 'Taiwan', 'country_code' => 'TW', 'created_at' => now()],
            ['id' => '216', 'name' => 'Tajikistan', 'country_code' => 'TJ', 'created_at' => now()],
            ['id' => '217', 'name' => 'Tanzania', 'country_code' => 'TZ', 'created_at' => now()],
            ['id' => '218', 'name' => 'Thailand', 'country_code' => 'TH', 'created_at' => now()],
            ['id' => '219', 'name' => 'Timor-Leste', 'country_code' => 'TL', 'created_at' => now()],
            ['id' => '220', 'name' => 'Togo', 'country_code' => 'TG', 'created_at' => now()],
            ['id' => '221', 'name' => 'Tokelau', 'country_code' => 'TK', 'created_at' => now()],
            ['id' => '222', 'name' => 'Tonga', 'country_code' => 'TO', 'created_at' => now()],
            ['id' => '223', 'name' => 'Trinidad And Tobago', 'country_code' => 'TT', 'created_at' => now()],
            ['id' => '224', 'name' => 'Tunisia', 'country_code' => 'TN', 'created_at' => now()],
            ['id' => '225', 'name' => 'Turkey', 'country_code' => 'TR', 'created_at' => now()],
            ['id' => '226', 'name' => 'Turkmenistan', 'country_code' => 'TM', 'created_at' => now()],
            ['id' => '227', 'name' => 'Turks And Caicos Islands', 'country_code' => 'TC', 'created_at' => now()],
            ['id' => '228', 'name' => 'Tuvalu', 'country_code' => 'TV', 'created_at' => now()],
            ['id' => '229', 'name' => 'Uganda', 'country_code' => 'UG', 'created_at' => now()],
            ['id' => '230', 'name' => 'Ukraine', 'country_code' => 'UA', 'created_at' => now()],
            ['id' => '231', 'name' => 'United Arab Emirates', 'country_code' => 'AE', 'created_at' => now()],
            ['id' => '232', 'name' => 'United Kingdom', 'country_code' => 'GB', 'created_at' => now()],
            ['id' => '233', 'name' => 'United States', 'country_code' => 'US', 'created_at' => now()],
            ['id' => '234', 'name' => 'United States Outlying Islands', 'country_code' => 'UM', 'created_at' => now()],
            ['id' => '235', 'name' => 'Uruguay', 'country_code' => 'UY', 'created_at' => now()],
            ['id' => '236', 'name' => 'Uzbekistan', 'country_code' => 'UZ', 'created_at' => now()],
            ['id' => '237', 'name' => 'Vanuatu', 'country_code' => 'VU', 'created_at' => now()],
            ['id' => '238', 'name' => 'Venezuela', 'country_code' => 'VE', 'created_at' => now()],
            ['id' => '239', 'name' => 'Vietnam', 'country_code' => 'VN', 'created_at' => now()],
            ['id' => '240', 'name' => 'Virgin Islands, British', 'country_code' => 'VG', 'created_at' => now()],
            ['id' => '241', 'name' => 'Virgin Islands, U.S.', 'country_code' => 'VI', 'created_at' => now()],
            ['id' => '242', 'name' => 'Wallis And Futuna', 'country_code' => 'WF', 'created_at' => now()],
            ['id' => '243', 'name' => 'Western Sahara', 'country_code' => 'EH', 'created_at' => now()],
            ['id' => '244', 'name' => 'Yemen', 'country_code' => 'YE', 'created_at' => now()],
            ['id' => '245', 'name' => 'Zambia', 'country_code' => 'ZM', 'created_at' => now()],
            ['id' => '246', 'name' => 'Zimbabwe', 'country_code' => 'ZW', 'created_at' => now()],
        ];
        DB::table('m_countries')->insert($countries);
    }
}