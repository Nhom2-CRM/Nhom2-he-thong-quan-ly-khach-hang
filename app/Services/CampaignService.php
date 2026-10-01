<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CampaignService
{
    /**
     * Get paginated or listed campaigns with optional search and status filtering.
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllCampaigns(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Campaign::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Create a new campaign.
     *
     * @param array $data
     * @return Campaign
     */
    public function createCampaign(array $data): Campaign
    {
        return Campaign::create($data);
    }

    /**
     * Find a campaign by ID.
     *
     * @param int $id
     * @return Campaign
     */
    public function getCampaignById(int $id): Campaign
    {
        return Campaign::findOrFail($id);
    }

    /**
     * Update a campaign.
     *
     * @param Campaign|int $campaign
     * @param array $data
     * @return Campaign
     */
    public function updateCampaign(Campaign|int $campaign, array $data): Campaign
    {
        $campaignModel = $campaign instanceof Campaign ? $campaign : Campaign::findOrFail($campaign);
        $campaignModel->update($data);
        return $campaignModel;
    }

    /**
     * Delete a campaign.
     *
     * @param Campaign|int $campaign
     * @return bool
     */
    public function deleteCampaign(Campaign|int $campaign): bool
    {
        $campaignModel = $campaign instanceof Campaign ? $campaign : Campaign::findOrFail($campaign);
        return (bool) $campaignModel->delete();
    }
}
