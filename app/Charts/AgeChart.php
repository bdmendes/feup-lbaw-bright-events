<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class AgeChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $ages = [$request->age0, $request->age1, $request->age2, $request->age3];
        return Chartisan::build()
            ->labels(['18-30', '30-45', '45-65', '>65'])
            ->dataset('Number of people', $ages);
    }
}
