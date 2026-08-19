<?php

namespace App\Filament\Widgets;

use App\Enums\ConsultationStatus;
use App\Enums\SubmissionStatus;
use App\Enums\UserRole;
use App\Filament\Resources\Consultations\ConsultationResource;
use App\Filament\Resources\Organizations\OrganizationResource;
use App\Filament\Resources\Resources\ResourceResource;
use App\Filament\Resources\ResourceSubmissions\ResourceSubmissionResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\Consultation;
use App\Models\Organization;
use App\Models\Resource as ResourceModel;
use App\Models\ResourceSubmission;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = -4;

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $pendingSubmissions = ResourceSubmission::query()
            ->where('status', SubmissionStatus::Pending)
            ->count();

        $openConsultations = Consultation::query()
            ->whereIn('status', [ConsultationStatus::Open, ConsultationStatus::InProgress])
            ->count();

        $pendingProfessionals = User::query()
            ->where('role', UserRole::Professional)
            ->whereNull('verified_at')
            ->count();

        return [
            Stat::make(__('admin.stats.published_resources'), ResourceModel::published()->count())
                ->description(__('admin.stats.published_resources_desc'))
                ->descriptionIcon(Heroicon::OutlinedGlobeAlt)
                ->icon(Heroicon::OutlinedRectangleStack)
                ->color('success')
                ->url(ResourceResource::getUrl('index')),
            Stat::make(__('admin.stats.organizations'), Organization::published()->count())
                ->description(__('admin.stats.organizations_desc'))
                ->descriptionIcon(Heroicon::OutlinedBuildingOffice2)
                ->icon(Heroicon::OutlinedBuildingOffice)
                ->color('primary')
                ->url(OrganizationResource::getUrl('index')),
            Stat::make(__('admin.stats.pending_submissions'), $pendingSubmissions)
                ->description(__('admin.stats.pending_submissions_desc'))
                ->descriptionIcon(Heroicon::OutlinedClock)
                ->icon(Heroicon::OutlinedInboxArrowDown)
                ->color($pendingSubmissions > 0 ? 'warning' : 'gray')
                ->url(ResourceSubmissionResource::getUrl('index')),
            Stat::make(__('admin.stats.open_consultations'), $openConsultations)
                ->description(__('admin.stats.open_consultations_desc'))
                ->descriptionIcon(Heroicon::OutlinedChatBubbleLeftRight)
                ->icon(Heroicon::OutlinedChatBubbleOvalLeftEllipsis)
                ->color($openConsultations > 0 ? 'info' : 'gray')
                ->url(ConsultationResource::getUrl('index')),
            Stat::make(__('admin.stats.professionals_to_verify'), $pendingProfessionals)
                ->description(__('admin.stats.professionals_to_verify_desc'))
                ->descriptionIcon(Heroicon::OutlinedShieldCheck)
                ->icon(Heroicon::OutlinedUserGroup)
                ->color($pendingProfessionals > 0 ? 'danger' : 'gray')
                ->url(UserResource::getUrl('index')),
        ];
    }
}
