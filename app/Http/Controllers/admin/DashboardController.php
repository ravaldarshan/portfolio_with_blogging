<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\admin\Blog;
use App\Models\admin\Client;
use Illuminate\Http\Request;
use App\Models\admin\Project;
use App\Models\admin\Statistic;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        $Project = Project::all();
        $Blog = Blog::where('status', 1)->get();
        $Client = Client::all();
        $Statistic = Statistic::orderBy('visit_time', 'desc')->get();
    
        // Call the statistic functions
        $dailyStats = $this->statisticDaily();
        $weeklyStats = $this->statisticWeekly();
        $monthlyStats = $this->statisticMonthly();
        $yearlyStats = $this->statisticYearly();
    
        // Declare the variables
        $chartDataDaily = $dailyStats['chartData'];
        $chartLabelsDaily = $dailyStats['chartLabels'];
        $chartDataWeekly = $weeklyStats['chartData'];
        $chartLabelsWeekly = $weeklyStats['chartLabels'];
        $chartDataMonthly = $monthlyStats['chartData'];
        $chartLabelsMonthly = $monthlyStats['chartLabels'];
        $chartDataYearly = $yearlyStats['chartData'];
        $chartLabelsYearly = $yearlyStats['chartLabels'];
    
        return view('administrator.dashboard.index', compact(
            'Project',
            'Blog',
            'Client',
            'Statistic',
            'chartDataDaily',
            'chartLabelsDaily',
            'chartDataWeekly',
            'chartLabelsWeekly',
            'chartDataMonthly',
            'chartLabelsMonthly',
            'chartDataYearly',
            'chartLabelsYearly'
        ));
    }

    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $Project = Project::all();
        $Blog = Blog::where('status', 1)->get();
        $Client = Client::all();
        $Statistic = Statistic::orderBy('visit_time', 'desc')->get();
    
        // Call the statistic functions
        $dailyStats = $this->statisticDaily();
        $weeklyStats = $this->statisticWeekly();
        $monthlyStats = $this->statisticMonthly();
        $yearlyStats = $this->statisticYearly();
    
        // Declare the variables
        $chartDataDaily = $dailyStats['chartData'];
        $chartLabelsDaily = $dailyStats['chartLabels'];
        $chartDataWeekly = $weeklyStats['chartData'];
        $chartLabelsWeekly = $weeklyStats['chartLabels'];
        $chartDataMonthly = $monthlyStats['chartData'];
        $chartLabelsMonthly = $monthlyStats['chartLabels'];
        $chartDataYearly = $yearlyStats['chartData'];
        $chartLabelsYearly = $yearlyStats['chartLabels'];
    
        return view('administrator.dashboard.fetchData.index', compact(
            'Project',
            'Blog',
            'Client',
            'Statistic',
            'chartDataDaily',
            'chartLabelsDaily',
            'chartDataWeekly',
            'chartLabelsWeekly',
            'chartDataMonthly',
            'chartLabelsMonthly',
            'chartDataYearly',
            'chartLabelsYearly'
        ))->render();
        }
    }
    
    protected function statisticDaily() {
        // Controller logic
        $dailyStatistics = Statistic::selectRaw('DATE_FORMAT(visit_time, "%Y-%m-%d") as date, COUNT(*) as count')
            ->groupByRaw('date')
            ->orderBy('date')
            ->get();
    
        $chartDataDaily = [];
        $chartLabelsDaily = [];
    
        // Fill in the data for each day of the week
        $currentDate = Carbon::now()->addDay();
        for ($i = 0; $i < 7; $i++) {
            $date = $currentDate->subDays(1)->format('Y-m-d');
            $chartLabelsDaily[] = (date('d-M', strtotime($date))) . ' (' . ($dailyStatistics->where('date', $date)->first()->count ?? 0) . ')';
            $chartDataDaily[] = $dailyStatistics->where('date', $date)->first()->count ?? 0;
        }
    
        return [
            'chartData' => array_reverse($chartDataDaily),
            'chartLabels' => array_reverse($chartLabelsDaily),
        ];
    }
    
    protected function statisticWeekly() {
        // Get data for the past 7 weeks
        $weeklyStatistics = Statistic::selectRaw('YEAR(visit_time) as year, WEEK(visit_time) as week, COUNT(*) as count')
            ->groupByRaw('year, week')
            ->orderBy('year', 'desc')
            ->orderBy('week', 'desc')
            ->take(7) // Assuming you want the data for the past 7 weeks
            ->get();
    
        // Create an array with the labels for the past 7 weeks
        $chartLabelsWeekly = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subWeeks($i);
            $chartLabelsWeekly[] = "Week " . $date->week . ' (0)';
        }
    
        // Initialize data array with zeros
        $chartDataWeekly = array_fill(0, 7, 0);
    
        // Fill in data for existing weeks
        foreach ($weeklyStatistics as $key => $week) {
            $index = array_search("Week " . $week->week  . ' (0)', $chartLabelsWeekly);
            if ($index !== false) {
                $chartDataWeekly[$index] = $week->count;
                $chartLabelsWeekly[$index] = "Week " . $week->week  . ' (' . $week->count . ')';
            }
        }
    
        return [
            'chartData' => $chartDataWeekly,
            'chartLabels' => $chartLabelsWeekly,
        ];
    }
    
    protected function statisticMonthly() {
        // Get data for the past 12 months of the current year
        $monthlyStatistics = Statistic::selectRaw('DATE_FORMAT(visit_time, "%Y-%m") as month, COUNT(*) as count')
            ->whereYear('visit_time', now()->year)
            ->groupByRaw('month')
            ->orderBy('month', 'desc')
            ->take(12) // Display data for the past 12 months
            ->get();
    
        // Create an array with the labels for the past 12 months
        $chartLabelsMonthly = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $chartLabelsMonthly[] = $date->format('M') . ' (0)';
        }
    
        // Initialize data array with zeros
        $chartDataMonthly = array_fill(0, 12, 0);
    
        // Fill in data for existing months
        foreach ($monthlyStatistics as $month) {
            $index = array_search(date('M',strtotime($month->month)) . ' (0)', $chartLabelsMonthly);
            if ($index !== false) {
                $chartDataMonthly[$index] = $month->count;
                $chartLabelsMonthly[$index] = date('M',strtotime($month->month)) . ' (' . $month->count . ')';
            }
        }
    
        return [
            'chartData' => $chartDataMonthly,
            'chartLabels' => $chartLabelsMonthly,
        ];
    }

    protected function statisticYearly() {
        // Get data for the past 7 years
        $yearlyStatistics = Statistic::selectRaw('YEAR(visit_time) as year, COUNT(*) as count')
            ->groupByRaw('year')
            ->orderBy('year', 'desc')
            ->take(7) // Assuming you want the data for the past 7 years
            ->get();
    
        // Create an array with the labels for the past 7 years
        $chartLabelsYearly = [];
        for ($i = 6; $i >= 0; $i--) {
            $year = now()->subYears($i)->year;
            $chartLabelsYearly[] = $year . ' (0)';
        }
    
        // Initialize data array with zeros
        $chartDataYearly = array_fill(0, 7, 0);
    
        // Fill in data for existing years
        foreach ($yearlyStatistics as $year) {
            $index = array_search($year->year . ' (0)', $chartLabelsYearly);
            if ($index !== false) {
                $chartDataYearly[$index] = $year->count;
                $chartLabelsYearly[$index] = $year->year . ' (' . $year->count . ')';
            }
        }
    
        return [
            'chartData' => $chartDataYearly,
            'chartLabels' => $chartLabelsYearly,
        ];
    }
}
