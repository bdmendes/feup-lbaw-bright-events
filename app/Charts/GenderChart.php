<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class GenderChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $genders = [$request->male, $request->female, $request->other];
        return Chartisan::build()
            ->labels(['Male', 'Female', 'Other'])
            ->dataset('Ages', $genders);
    }
}
