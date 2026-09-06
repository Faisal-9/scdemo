<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\MediaPost;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'drafts' => Project::where('status', 'draft')->count()
                + Service::where('status', 'draft')->count()
                + MediaPost::where('status', 'draft')->count(),
            'reviewItems' => Project::where('status', 'review')->count()
                + Service::where('status', 'review')->count()
                + MediaPost::where('status', 'review')->count(),
            'newInquiries' => ContactInquiry::where('status', 'new')->count(),
        ]);
    }
}
