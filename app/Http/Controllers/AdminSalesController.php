<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale; // Sale මොඩල් එක එකතු කිරීම

class AdminSalesController extends Controller
{
    public function index()
    {
        // සියලුම සේල්ස් රෙකෝඩ්ස්, ඒවාට අදාළ ලැප්ටොප් සහ යූසර් විස්තර සමඟ අලුත්ම ඒවාවේ සිට (Latest) ලබා ගැනීම
        $sales = Sale::with(['laptop', 'user'])->latest()->get();

        // ඩෑෂ්බෝඩ් කාඩ්ස් සඳහා සාරාංශ ගණනය කිරීම් (Summary Calculations)
        $totalSalesCount = $sales->count();
        $totalRevenue = $sales->sum('total_price');
        $totalLaptopsSold = $sales->sum('quantity');

        return view('admin.sales_report', compact('sales', 'totalSalesCount', 'totalRevenue', 'totalLaptopsSold'));
    }
}