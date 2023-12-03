<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;
use OpenSpout\Common\Entity\Style\Style;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Str;

class IssuanceExcelController extends Controller
{
    //

    public function seedIssuanceExportedExcel(Season $season) {
        set_time_limit(0);
        ini_set('memory_limit', '1G');

        $season_issuance_to_be_downloaded = $season->seedissuancehistory()->latest()->get();
        $issuance_array = [];
        foreach ($season_issuance_to_be_downloaded as $issuance) {

            $name = '';
            $initial = '';
            if($issuance->area->Tenant_Name == 'None') {
                if($issuance->area->personalinformation->Middle_Name) {
                    $initial = Str::upper(Str::substr($issuance->area->personalinformation->Middle_Name, 0, 1)) . '.';
                    $name = $issuance->area->personalinformation->First_Name . " " . $initial . " " . $issuance->area->personalinformation->Last_Name;
                } else {
                    $name = $issuance->area->personalinformation->First_Name . " " . $issuance->area->personalinformation->Surname;
                }
            } else {
                $name = $issuance->area->Tenant_Name;
            }
            
            $issuance_array[] = [
                'Season' => $issuance->season->Season,
                'Year' => $issuance->season->Year,
                'Name' => $name,
                'Seed Name' => $issuance->Seed_Variety,
                'Lot No' => $issuance->area->Lot_No,
                'Quantity' => $issuance->Quantity
            ];
        }

        $excel_file_name = $season->Season . '-' . $season->Year .' ' . 'Seed Issuance.xlsx';

        $header_style = (new Style())->setFontBold()->setCellAlignment('center');
        $rows_style = (new Style())->setBackgroundColor("EDEDED")->setCellAlignment('center');
        return (new FastExcel(collect($issuance_array)))->headerStyle($header_style)->rowsStyle($rows_style)->download($excel_file_name);
    }
}
