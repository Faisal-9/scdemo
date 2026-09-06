<?php

namespace App\Console\Commands;

use App\Models\MediaPost;
use App\Models\Page;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Sector;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\SiteSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportLegacyContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statecorps:import-legacy-content {--fresh : Replace previously imported CMS content}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the existing PHP-array website content into the CMS database.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $legacyPath = base_path('../includes/data');
        if (! is_dir($legacyPath)) {
            $this->error('Legacy data directory was not found.');

            return self::FAILURE;
        }

        DB::transaction(function () use ($legacyPath): void {
            if ($this->option('fresh')) {
                ProjectImage::query()->delete();
                Project::query()->delete();
                ServiceItem::query()->delete();
                Service::query()->delete();
                MediaPost::query()->delete();
                Sector::query()->delete();
                Page::query()->delete();
                SiteSetting::query()->delete();
            }

            $services = $this->load($legacyPath.'/servicesdata.php', 'services');
            foreach ($services as $key => $serviceData) {
                $service = Service::updateOrCreate(
                    ['slug' => Str::slug((string) $key)],
                    [
                        'title' => $serviceData['title'],
                        'hero_text' => $serviceData['hero_text'] ?? null,
                        'hero_image' => $serviceData['hero_image'] ?? null,
                        'status' => 'published',
                    ],
                );
                foreach ($serviceData['sub_services'] ?? [] as $position => $item) {
                    $this->importServiceItem($service, $item, null, $position);
                }
            }

            $sectors = $this->load($legacyPath.'/sectorsdata.php', 'sectors');
            foreach ($sectors as $key => $sectorData) {
                $hero = $sectorData['hero'] ?? [];
                Sector::updateOrCreate(
                    ['slug' => Str::slug((string) $key)],
                    [
                        'title' => $sectorData['title'],
                        'hero_tag' => $hero['tag'] ?? null,
                        'hero_headline' => $hero['headline'] ?? null,
                        'hero_subtitle' => $hero['sub'] ?? null,
                        'hero_image' => $hero['image'] ?? null,
                        'stats' => $sectorData['stats'] ?? [],
                        'areas' => $sectorData['areas'] ?? [],
                        'why_choose_us' => $sectorData['why'] ?? [],
                        'description' => is_array($sectorData['description'] ?? null)
                            ? implode("\n\n", $sectorData['description'])
                            : ($sectorData['description'] ?? null),
                        'status' => 'published',
                    ],
                );
            }

            $sectorIds = Sector::query()->get()->keyBy(fn (Sector $sector) => $this->normalise($sector->title));
            $projects = $this->load($legacyPath.'/projectsdata.php', 'projects');
            foreach ($projects as $position => $projectData) {
                $title = trim((string) ($projectData['name'] ?? 'Untitled project'));
                $legacyId = (string) ($projectData['id'] ?? Str::slug($title));
                $sectorId = $sectorIds[$this->normalise((string) ($projectData['sector'] ?? ''))]->id ?? null;
                $project = Project::updateOrCreate(
                    ['slug' => Str::slug($legacyId)],
                    [
                        'sector_id' => $sectorId,
                        'title' => $title,
                        'client' => $projectData['client'] ?? null,
                        'location' => $projectData['location'] ?? null,
                        'category' => $projectData['category'] ?? null,
                        'project_status' => $projectData['status'] ?? null,
                        'completion_year' => $projectData['completion-year'] ?? null,
                        'description' => $projectData['description'] ?? null,
                        'scope' => $projectData['scope'] ?? [],
                        'thumbnail' => $projectData['thumbnail'] ?? null,
                        'is_featured' => ($projectData['catimage'] ?? '') === 'yes',
                        'is_home_featured' => ($projectData['inhome'] ?? '') === 'yes',
                        'status' => 'published',
                    ],
                );
                foreach ($projectData['images'] ?? [] as $imagePosition => $path) {
                    ProjectImage::updateOrCreate(
                        ['project_id' => $project->id, 'path' => $path],
                        ['sort_order' => $imagePosition],
                    );
                }
            }
            $projectVariables = $this->includeFile($legacyPath.'/projectsdata.php');
            if (array_key_exists('projecthero', $projectVariables)) {
                $this->saveSetting('projects', 'hero', $projectVariables['projecthero']);
            }

            $media = $this->load($legacyPath.'/mediadata.php', 'media');
            foreach ($media as $type => $items) {
                foreach ($items as $item) {
                    $slug = Str::slug((string) ($item['id'] ?? $item['title']));
                    MediaPost::updateOrCreate(
                        ['slug' => $slug],
                        [
                            'type' => $type,
                            'title' => $item['title'],
                            'description' => is_array($item['description'] ?? null) ? implode("\n\n", $item['description']) : ($item['description'] ?? null),
                            'tags' => $item['tags'] ?? [],
                            'featured_image' => $item['image'] ?? null,
                            'source_url' => $item['link'] ?? null,
                            'event_date' => $this->date($item['date'] ?? null),
                            'published_at' => now(),
                            'status' => 'published',
                        ],
                    );
                }
            }

            $home = $this->load($legacyPath.'/homedata.php', 'heroSlides');
            $this->saveSetting('homepage', 'hero_slides', $home);
            $homeVariables = $this->includeFile($legacyPath.'/homedata.php');
            foreach (['stats', 'whySC', 'clients', 'statsBg'] as $key) {
                if (array_key_exists($key, $homeVariables)) {
                    $this->saveSetting('homepage', Str::snake($key), $homeVariables[$key]);
                }
            }

            $about = $this->includeFile($legacyPath.'/aboutdata.php');
            foreach ($about as $key => $value) {
                $this->saveSetting('about', Str::snake($key), $value);
            }

            foreach ([
                'policiesdata.php' => ['variable' => 'policies', 'prefix' => 'policy'],
                'termsOfServicesData.php' => ['variable' => 'TermsOfService', 'prefix' => 'terms'],
            ] as $file => $definition) {
                foreach ($this->load($legacyPath.'/'.$file, $definition['variable']) as $key => $item) {
                    Page::updateOrCreate(
                        ['slug' => $definition['prefix'].'-'.Str::slug((string) $key)],
                        ['title' => $item['title'], 'content' => json_encode($item['sections'] ?? []), 'status' => 'published', 'published_at' => now()],
                    );
                }
            }
        });

        $this->info('Legacy content imported successfully.');

        return self::SUCCESS;
    }

    private function importServiceItem(Service $service, array $item, ?int $parentId, int $position): void
    {
        $title = $item['title'] ?? 'Untitled item';
        $record = ServiceItem::updateOrCreate(
            ['service_id' => $service->id, 'parent_id' => $parentId, 'slug' => Str::slug($title)],
            [
                'title' => $title,
                'short_description' => $item['short_desc'] ?? null,
                'why_choose_us' => $item['why'] ?? null,
                'features' => $item['features'] ?? [],
                'image' => $item['image'] ?? null,
                'sort_order' => $position,
                'status' => 'published',
            ],
        );
        foreach (($item['items'] ?? $item['subitems'] ?? []) as $childPosition => $child) {
            $this->importServiceItem($service, $child, $record->id, $childPosition);
        }
    }

    private function load(string $file, string $variable): array
    {
        $variables = $this->includeFile($file);

        return $variables[$variable] ?? [];
    }

    private function includeFile(string $file): array
    {
        return (static function (string $file): array { include $file; return get_defined_vars(); })($file);
    }

    private function saveSetting(string $group, string $key, mixed $value): void
    {
        SiteSetting::updateOrCreate(['key' => $group.'.'.$key], ['group' => $group, 'value' => $value]);
    }

    private function normalise(string $value): string
    {
        return Str::of($value)->lower()->replaceMatches('/[^a-z0-9]+/', '')->toString();
    }

    private function date(?string $value): ?string
    {
        $timestamp = strtotime(str_replace(',', ' ', (string) $value));

        return $timestamp ? date('Y-m-d H:i:s', $timestamp) : null;
    }
}
