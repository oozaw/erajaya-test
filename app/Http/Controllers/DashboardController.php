<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChartResource;
use App\Http\Resources\EmployeeResource;
use App\Models\Company;
use App\Models\Division;
use App\Models\Employee;
use App\Models\EmployeePeriod;
use App\Models\Gender;
use App\Models\Level;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = 'Dashboard';
        $employees = Employee::all();
        $divisions = Division::all();
        $companies = Company::all();
        $levels = Level::all();
        $genders = Gender::all();
        $employeePeriods = EmployeePeriod::getAllPeriods()->sortBy('period')->toArray();
        $periods = EmployeePeriod::all()->sortBy('period');

        $data = [
            'title' => $title,
            'employees' => $employees,
            'divisions' => $divisions,
            'companies' => $companies,
            'levels' => $levels,
            'genders' => $genders,
            'employeePeriods' => $employeePeriods,
            'periods' => $periods
        ];

        return view('dashboard.index', $data);
    }

    public function getEmployeeData(Request $request) {
        $query = EmployeePeriod::query()->with('employee', 'company', 'division', 'level', 'gender');

        if ($request->has('division') && $request->division) {
            $query->where('division_id', $request->input('division'));
        }

        if ($request->has('company') && $request->company) {
            $query->where('company_id', $request->input('company'));
        }

        if ($request->has('level') && $request->level) {
            $query->where('level_id', $request->input('level'));
        }

        if ($request->has('gender') && $request->gender) {
            $query->where('gender_id', $request->input('gender'));
        }

        if ($request->has('period') && $request->period) {
            $period = $request->input('period');
            $start = $period['start'];
            $end = $period['end'] ?? $start;

            if ($start && $end) {
                $query->whereBetween('period', [$start, $end]);
            }
        }

        $employees = $query->get()->sortBy('period');

        $chartData = $this->getChartData($employees);
        $employeeData = EmployeeResource::collection($employees);
        $viewBody = view('dashboard.components.table-body', ['periods' => $employees]);

        $result = [
            'employees' => $employeeData,
            'chart_data' => $chartData,
            'view_body' => $viewBody->render(),
        ];

        return response()->json($result);
    }

    private function getChartData($employees) {
        $employeeStackedChartData = $this->getEmployeeStackedChartData($employees);
        $divisionPieChartData = $this->getDivisionPieChartData($employees);

        return [
            'employee_stacked' => $employeeStackedChartData,
            'division_pie' => $divisionPieChartData,
        ];
    }

    private function getEmployeeStackedChartData($employees) {
        $companies = $employees->groupBy('company_id');
        $series = [];
        $categories = $employees->unique('period')->pluck('period')->toArray();

        foreach ($companies as $company) {
            $companyName = $company[0]->company->company_name;
            $data = [];

            foreach ($categories as $category) {
                $data[] = $company->where('period', $category)->count();
            }

            $series[] = [
                'name' => $companyName,
                'data' => $data
            ];
        }

        return [
            'series' => $series,
            'categories' => $categories,
        ];
    }

    private function getDivisionPieChartData($employees) {
        $divisions = $employees->groupBy('division_id');
        $series = [];
        $labels = [];

        foreach ($divisions as $division) {
            $labels[] = $division[0]->division->division_name;
            $series[] = $division->count();
        }

        return [
            'labels' => $labels,
            'series' => $series,
        ];
    }
}
