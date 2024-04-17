<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\ReportService;


class ReportController
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function getAllReport(){
        return $this->reportService->getAllReport();
    }

    public function getUserReports(Request $request){
        $user_id = $request->user()->id;
        return $this->reportService->getUserReports($user_id);
    }

    public function getReportById($id){
        return $this->reportService->getTransactionReportById($id);
    }

    public function getYearlyReport(){
        return $this->reportService->getYearlyReport();
    }

    public function getMonthlyReport(){
        return $this->reportService->getMonthlyReport();
    }

    public function getWeeklyReport(){
        return $this->reportService->getWeeklyReport();
    }

    public function getDailyReport(){
        return $this->reportService->getDailyReport();
    }

    public function getCustomDayReport($day){
        return $this->reportService->getCustomDayReport($day);
    }

    public function getCustomMonthReport($month){
        return $this->reportService->getCustomMonthReport($month);
    }

    public function getCustomYearReport($year){
        return $this->reportService->getCustomYearReport($year);
    }

    public function getCustomTimeRangeReport($start, $end){
        return $this->reportService->getCustomTimeRangeReport($start, $end);
    }
}
