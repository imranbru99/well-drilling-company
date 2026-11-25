<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $openJobs = Project::query()->whereIn('status', ['quoted', 'scheduled', 'in_progress'])->count();
        $revenue = Invoice::query()->where('status', 'paid')->sum('total');
        $pipeline = Invoice::query()->whereIn('status', ['sent', 'partial', 'overdue'])->sum('total');

        return [
            Stat::make('Active Jobs', (string) $openJobs)
                ->description('Quoted / scheduled / in progress')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color('warning'),
            Stat::make('Customers', (string) Customer::query()->count())
                ->description('CRM accounts')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
            Stat::make('Paid Revenue', '$'.number_format((float) $revenue, 0))
                ->description('Collected invoices')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            Stat::make('Open Receivables', '$'.number_format((float) $pipeline, 0))
                ->description('Sent / partial / overdue')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('danger'),
            Stat::make('Upcoming Visits', (string) Appointment::query()->where('starts_at', '>=', now())->where('status', '!=', 'cancelled')->count())
                ->description('Scheduled appointments')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),
        ];
    }
}
