<?php

namespace App\Service;

use App\Models\Transaction;

class ReportService
{
    // Get all report function, increase and decrease are included all in one function
    public function getAllReport()
    {
        $transaction = Transaction::all();
        $totalIncrease = Transaction::where('type', 'increase')->sum('amount');
        $totalDecrease = Transaction::where('type', 'decrease')->sum('amount');
        return response()->json([
            'message' => 'All transaction report',
            'data' => [
                'total_increase' => $totalIncrease,
                'total_decrease' => $totalDecrease,
                'transactions' => $transaction
            ]
        ]);
    }

    public function getUserReports($user_id){
        $transaction = Transaction::where('user_id', $user_id)->get();
        $totalIncrease = Transaction::where('type', 'increase')->where('user_id', $user_id)->sum('amount');
        $totalDecrease = Transaction::where('type', 'decrease')->where('user_id', $user_id)->sum('amount');
        return response()->json([
            'message' => 'All transaction report',
            'data' => [
                'total_increase' => $totalIncrease,
                'total_decrease' => $totalDecrease,
                'transactions' => $transaction
            ]
        ]);
    }

    // Get spesific transaction report by id function
    public function getTransactionReportById($id)
    {
        $transaction = Transaction::find($id);
        return response()->json([
            'message' => 'Spesific transaction report',
            'data' => $transaction
        ]);
    }

    // Get yearly transaction report function
    public function getYearlyReport()
    {
        $year = today()->year;
        $transaction = Transaction::whereYear('created_at', $year)->get();
        $totalIncrease = Transaction::where('type', 'increase')->whereYear('created_at', $year)->sum('amount');
        $totalDecrease = Transaction::where('type', 'decrease')->whereYear('created_at', $year)->sum('amount');
        return response()->json([
            'message' => 'Yearly report for current year',
            'data' => [
                'total_increase' => $totalIncrease,
                'total_decrease' => $totalDecrease,
                'transactions' => $transaction
            ]
        ]);
    }

    // Get monthly transaction report function
    public function getMonthlyReport()
    {
        $startOfMonth = today()->startOfMonth();
        $endOfMonth = today()->endOfMonth();
        $transactions = Transaction::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        $totalDecrease = Transaction::where('type', 'decrease')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');
        $totalIncrease = Transaction::where('type', 'increase')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');
        return response()->json([
            'message' => 'Monthly report for current month',
            'data' => [
                'total_increase' => $totalIncrease,
                'total_decrease' => $totalDecrease,
                'transactions' => $transactions]
        ]);
    }

    // Get weekly transaction report function
    public function getWeeklyReport()
    {
        $startOfWeek = today()->startOfWeek();
        $endOfWeek = today()->endOfWeek();
        $transactions = Transaction::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $totalIncrease = Transaction::where('type', 'increase')->whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('amount');
        $totalDecrease = Transaction::where('type', 'decrease')->whereBetween('created_at', [$startOfWeek, $endOfWeek])->sum('amount');
        return response()->json([
            'message' => 'Weekly report for current week',
            'data' => [
                'total_increase' => $totalIncrease,
                'total_decrease' => $totalDecrease,
                'transactions' => $transactions
            ]
        ]);
    }

    // Get daily transaction report function
    public function getDailyReport()
    {
        $day = today();
        $transaction = Transaction::where('created_at', $day)->get();
        $totalIncrease = Transaction::where('type', 'increase')->where('created_at', $day)->sum('amount');
        $totalDecrease = Transaction::where('type', 'decrease')->where('created_at', $day)->sum('amount');
        return response()->json([
            'message' => 'Daily report for current day',
            'data' => [
                'total_increase' => $totalIncrease,
                'total_decrease' => $totalDecrease,
                'transactions' => $transaction]
        ]);
    }

    // Get custom year transaction report function
    public function getCustomYearReport($year)
    {
        $transactions = Transaction::whereYear('created_at', $year)->get();
        $totalIncrease = Transaction::where('type', 'increase')->whereYear('created_at', $year)->sum('amount');
        $totalDecrease = Transaction::where('type', 'decrease')->whereYear('created_at', $year)->sum('amount');
        return response()->json([
            'message' => 'Spesific report for the given year',
            'data' => [
                'total_increase' => $totalIncrease,
                'total_decrease' => $totalDecrease,
                'transactions' => $transactions
            ]
        ]);
    }

    // Get custom month transaction report function
    public function getCustomMonthReport($month)
    {
        $transactions = Transaction::whereMonth('created_at', $month)->get();
        $totalIncrease = Transaction::where('type', 'increase')->whereMonth('created_at', $month)->sum('amount');
        $totalDecrease = Transaction::where('type', 'decrease')->whereMonth('created_at', $month)->sum('amount');
        return response()->json([
            'message' => 'Spesific report for the given month',
            'data' => [
                'total_increase' => $totalIncrease,
                'total_decrease' => $totalDecrease,
                'transactions' => $transactions
            ]
        ]);
    }

    // Get custom day transaction report function
    public function getCustomDayReport($day)
    {
        $transaction = Transaction::where('created_at', $day)->get();
        $totalIncrease = Transaction::where('type', 'increase')->where('created_at', $day)->sum('amount');
        $totalDecrease = Transaction::where('type', 'decrease')->where('created_at', $day)->sum('amount');
        return response()->json([
            'message' => 'Spesific report for the given day',
            'data' => [
                'total_increase' => $totalIncrease,
                'total_decrease' => $totalDecrease,
                'transactions' => $transaction
            ]
        ]);
    }


    //Get custom time range report function
    public function getCustomTimeRangeReport($start, $end)
    {
        $transactions = Transaction::whereBetween('created_at', [$start, $end])->get();
        $totalIncrease = Transaction::where('type', 'increase')->whereBetween('created_at', [$start, $end])->sum('amount');
        $totalDecrease = Transaction::where('type', 'decrease')->whereBetween('created_at', [$start, $end])->sum('amount');
        return response()->json([
            'message' => 'Spesific report for the given time range',
            'data' => [
                'total_increase' => $totalIncrease,
                'total_decrease' => $totalDecrease,
                'transactions' => $transactions
            ]
        ]);
    }
}

