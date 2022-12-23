<?php
/**
 * DeviantArtGalleryFormatter.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Services\PortfolioProviders;

use App\Models\AccessToken;
use App\Services\PortfolioProviders\Adapters\DeviationAdapter;
use App\Services\PortfolioProviders\Http\Requests\OAuthRequest;
use Illuminate\Support\Arr;

class DeviantArtGalleryFormatter
{
    protected array $galleryResults = [];
    protected array $metadata = [];

    protected ?AccessToken $accessToken;

    public function __construct(protected OAuthRequest $request)
    {

    }

    public function setGalleryResults(array $galleryResults): static
    {
        $this->galleryResults = $galleryResults;

        return $this;
    }

    public function setAccessToken(AccessToken $accessToken): static
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function getFormattedEntries(): array
    {
        // get all the extended metadata for all the deviations
        $this->metadata = $this->getMetadata();

        return array_filter(array_map(function(array $result) {
            if (Arr::get($result, 'category_path') !== 'visual_art') {
                return null;
            }

            return (new DeviationAdapter($result, $this->getMetadataForResult($result)))->convertFromSource();
        }, $this->galleryResults));
    }

    protected function getMetadataForResult(array $result): array
    {
        if (!$deviationId = Arr::get($result, 'deviationid')) {
            return [];
        }

        foreach($this->metadata as $deviationData) {
            if (Arr::get($deviationData, 'deviationid') === $deviationId) {
                return $deviationData;
            }
        }

        return [];
    }

    protected function getMetadata(): array
    {
        if (! $deviationIds = $this->parseDeviationIds()) {
            return [];
        }

        $response = $this->request->withToken($this->accessToken)
            ->get(
                'https://www.deviantart.com/api/v1/oauth2/deviation/metadata',
                [
                    'deviationids' => $deviationIds,
                    'ext_submission' => true,
                    'ext_camera' => false,
                    'ext_stats' => false,
                    'ext_collection' => false,
                    'ext_gallery' => true,
                    'with_session' => false,
                ]
            );

        $metadata = $response->json('metadata');

        return is_array($metadata) ? $metadata : [];
    }

    protected function parseDeviationIds(): array
    {
        return array_column($this->galleryResults, 'deviationid');
    }
}
