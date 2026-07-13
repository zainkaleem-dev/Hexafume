<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\SentEmail;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('partials.admin_sidebar', function ($view) {
            $projectCount = 0;
            $teamCount = 0;
            $testimonialCount = 0;
            $messageCount = 0;

            if (Schema::hasTable('projects')) {
                $projectCount = Project::count();
            }
            if (Schema::hasTable('team_members')) {
                $teamCount = TeamMember::count();
            }
            if (Schema::hasTable('testimonials')) {
                $testimonialCount = Testimonial::count();
            }
            if (Schema::hasTable('sent_emails')) {
                $messageCount = SentEmail::count();
            }

            $view->with([
                'adminProjectCount' => $projectCount,
                'adminTeamCount' => $teamCount,
                'adminTestimonialCount' => $testimonialCount,
                'adminMessageCount' => $messageCount,
            ]);
        });

        View::composer('partials.admin_topbar', function ($view) {
            $adminNotifications = collect();
            $adminUnreadNotifications = 0;

            if (Schema::hasTable('admin_notifications')) {
                $adminNotifications = AdminNotification::query()
                    ->latest()
                    ->take(8)
                    ->get();

                $adminUnreadNotifications = AdminNotification::query()
                    ->where('is_read', false)
                    ->count();
            }

            $view->with([
                'adminNotifications' => $adminNotifications,
                'adminUnreadNotifications' => $adminUnreadNotifications,
            ]);
        });
    }
}
