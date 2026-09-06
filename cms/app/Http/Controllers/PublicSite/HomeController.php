<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\MediaPost;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $settings = Schema::hasTable('site_settings')
            ? SiteSetting::query()->where('group', 'homepage')->get()->mapWithKeys(
                fn (SiteSetting $setting): array => [$setting->key => $setting->value]
            )
            : collect();

        $projects = Schema::hasTable('projects')
            ? Project::query()->publiclyVisible()->with('sector')->where('is_home_featured', true)->latest('completion_year')->get()
            : collect();

        $services = Schema::hasTable('services')
            ? Service::query()->where('status', 'published')->with(['items' => fn ($query) => $query->whereNull('parent_id')->orderBy('sort_order')])->orderBy('title')->get()
            : collect();

        $activities = Schema::hasTable('media_posts')
            ? MediaPost::query()->where('status', 'published')->whereIn('type', ['news', 'events'])->latest('event_date')->limit(3)->get()
            : collect();

        return view('public.home', [
            'heroSlides' => $settings->get('homepage.hero_slides', []),
            'stats' => $settings->get('homepage.stats', []),
            'whyStateCorps' => $settings->get('homepage.why_sc', []),
            'statsBackground' => $settings->get('homepage.stats_bg', 'assets/images/home/whybg1.jpg'),
            'clients' => $settings->get('homepage.clients', [])['items'] ?? [],
            'services' => $services,
            'projects' => $projects,
            'activities' => $activities,
        ]);
    }
}