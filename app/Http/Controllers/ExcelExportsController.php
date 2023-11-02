<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\DogInformation;
use App\Models\Livestock;
use App\Models\Machinery;
use App\Models\PersonalInformation;
use App\Models\Poultry;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;
use OpenSpout\Common\Entity\Style\Style;

class ExcelExportsController extends Controller
{
    //
    public function downloadAllFarmersRecord() {
        // Personal Informations
        $farmers = PersonalInformation::latest()->get();
        $farmer_array = [];
        foreach ($farmers as $farmer) {
            $farmer_array[] = [
                'RSBSA NO' => $farmer->RSBSA_No,
                'Surname' => $farmer->Surname,
                'First Name' => $farmer->First_Name,
                'Middle Name' => $farmer->Middle_Name,
                'Extension' => $farmer->Extension,
                'Address' => $farmer->Address,
                'Mobile No' => $farmer->Mobile_No,
                'Sex' => $farmer->Sex,
                'Date of Birth' => $farmer->Date_of_birth,
                'Religion' => $farmer->Religion,
                'Civl Status' => $farmer->Civil_Status,
                'Name of Spouse' => $farmer->Name_of_Spouse,
                'Education' => $farmer->Highest_education_qualification,
                'Livelihood' => $farmer->Main_livelihood,
            ];
        };

        // Areas
        $areas = Area::orderBy('RSBSA_No', 'asc')->get();
        $area_array = [];
        foreach ($areas as $area) {
            $area_array[] = [
                'Lot No' => $area->Lot_No,
                'RSBSA No' => $area->RSBSA_No,
                'Hectares' => $area->Hectares,
                'Area Type' => $area->Area_Type,
                'Commodity Planted' => $area->Commodity_planted,
                'Address' => $area->Address,
                'Lat' => $area->Lat,
                'Lon' => $area->Lon,
                'Ownership Type' => $area->Ownership_Type,
                'Tenant Name' => $area->Tenant_Name,
                'Owner Address' => $area->Owner_Address,
                'Farm Type' => $area->Farm_Type,
            ];
        };

        // Livestocks
        $livestocks = Livestock::orderBy('RSBSA_No', 'asc')->get();
        $livestock_array = [];
        foreach ($livestocks as $livestock) {
            $livestock_array[] = [
                'RSBSA No' => $livestock->RSBSA_No,
                'Livestock Animal' => $livestock->LSAnimals,
                'Sex' => $livestock->Sex_LS,
            ];
        };

        // Poultries
        $poultries = Poultry::orderBy('RSBSA_No', 'asc')->get();
        $poultries_array = [];
        foreach ($poultries as $poultry) {
            $poultries_array[] = [
                'RSBSA No' => $poultry->RSBSA_No,
                'Poultry Type' => $poultry->Poultry_Type,
                'Quantity' => $poultry->Quantity,
            ];
        };

        // Machineries
        $machineries = Machinery::orderBy('RSBSA_No', 'asc')->get();
        $machineries_array = [];
        foreach ($machineries as $machinery) {
            $machineries_array[] = [
                'RSBSA No' => $machinery->RSBSA_No,
                'Machine Name' => $machinery->MachineName,
                'Price' => $machinery->Price,
                'Mode Acqusition' => $machinery->Mode_Acqusition,
                'Use of Machinery' => $machinery->Use_of_Machinery,
            ];
        };

        // Dog Records
        $dogs = DogInformation::orderBy('RSBSA_No', 'asc')->get();
        $dogs_array = [];
        foreach ($dogs as $dog) {
            $dogs_array[] = [
                'RSBSA No' => $dog->RSBSA_No,
                'Dog Name' => $dog->Dog_Name,
                'Owner_Name' => $dog->Owner_Name,
                'Species' => $dog->Species,
                'Sex' => $dog->Sex,
                'Age' => $dog->Age,
                'Neutering' => $dog->Neutering,
                'Color' => $dog->Color,
                'Registration Date' => $dog->Date_of_Registration,
                'Last Vac Month' => $dog->Last_Vac_Month,
                'Remarks' => $dog->Remarks,
                
            ];
        };

        $sheets = new SheetCollection([
            'Farmers' => collect($farmer_array),
            'Areas' => collect($area_array),
            'Livestocks' => collect($livestock_array),
            'Poultries' => collect($poultries_array),
            'Machineries' => collect($machineries_array),
            'Dogs Information' => collect($dogs_array),
        ]);


        $header_style = (new Style())->setFontBold()->setCellAlignment('center');
        $rows_style = (new Style())->setBackgroundColor("EDEDED")->setCellAlignment('center');
        return (new FastExcel($sheets))->headerStyle($header_style)->rowsStyle($rows_style)->download('Barugo.xlsx');
    }
}
