<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContactSubmission;
use App\Models\Order;
use App\Models\Page;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'pages' => Page::count(),
            'contacts_new' => ContactSubmission::where('status', 'new')->count(),
            'orders_pending' => Order::where('status', 'pending')->count(),
            'posts' => BlogPost::published()->count(),
        ];

        $recentContacts = ContactSubmission::latest()->take(5)->get();
        $recentOrders = Order::with('product')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'recentOrders'));
    }
}
