<?php

namespace App\Services\Impl;

use App\Services\GithubServiceInterface;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;

class GithubService implements GithubServiceInterface
{

    public function getApiData($url){
        $installationId = env('GITHUB_INSTALLATION_ID');
        $appId = env('GITHUB_APP_ID');
        $privateKeyPath = storage_path(env('GITHUB_PRIVATE_KEY_PATH'));

        if (!file_exists($privateKeyPath)) {
            throw new \Exception('Private key not found at ' . $privateKeyPath);
        }

        $jwt = $this->generateGitHubJWT($appId, $privateKeyPath);

        if (!$jwt) {
            throw new \Exception('Failed to generate GitHub JWT' . $privateKeyPath);
        }

        $tokenResponse = Http::withHeaders([
            'Authorization' => "Bearer $jwt",
            'Accept' => 'application/vnd.github+json',
        ])->post("https://api.github.com/app/installations/$installationId/access_tokens");

        if ($tokenResponse->failed()) {
            throw new \Exception('Failed to fetch GitHub installation token' . $privateKeyPath);
        }

        $token = $tokenResponse->json()['token'] ?? null;
        if (!$token) {
            throw new \Exception('Token missing in response' . $privateKeyPath);
        }

        $response = Http::withToken($token)->get($url, [
            'is' => 'public'
        ]);

        return $response->successful() ? $response->json() : null;

    }


    /**
     * Generate a GitHub JWT for app authentication.
     */
    public function generateGitHubJWT($appId, $privateKeyPath)
    {
        if (!file_exists($privateKeyPath)) {
            return null;
        }

        $privateKey = file_get_contents($privateKeyPath);

        $payload = [
            'iat' => time(),
            'exp' => time() + 540,
            'iss' => (int) $appId,
        ];

        return JWT::encode($payload, $privateKey, 'RS256');
    }

    public function getAllLanguages()
    {
        $repositories = $this->getRepositories();

        $languages = [];
        $totalBytes = 0;

        foreach ($repositories as $repo) {
            $repoLanguages = $this->getApiData($repo['languages_url']);

            foreach ($repoLanguages as $language => $bytes) {
                if (!isset($languages[$language])) {
                    $languages[$language] = 0;
                }
                $languages[$language] += $bytes;
                $totalBytes += $bytes;
            }
        }

        $languagePercentages = [];
        foreach ($languages as $language => $bytes) {
            $languagePercentages[$language] = round(($bytes / $totalBytes) * 100, 2);
        }

        return [
            'total_repositories' => count($repositories),
            'languages' => $languagePercentages,
        ];
    }

    /**
     * Fetch repositories using GitHub App authentication.
     */
    public function getRepositories()
    {
        $repositories = $this->getApiData('https://api.github.com/installation/repositories');
        if(!$repositories) {
            throw new \Exception('Failed to fetch repositories');
        }

        return  collect($repositories['repositories'])->where('visibility', 'public');
    }

    /**
     * Fetch Projects
     */
    public function getProjects($withImage = false)
    {
        $repositories = $this->getRepositories();
        $projects = [];

        if (!$repositories) {
            throw new \Exception('Failed to fetch repositories');
        }
        $repositoriesArray = $repositories->toArray() ?? [];

        usort($repositoriesArray, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        foreach ($repositories ?? [] as $repository) {
            if ($repository['private']) {
                continue;
            }
            if(env('GITHUB_USERNAME') == trim($repository['name'])){
                continue;
            }

            $projects[] = [
                'id' => $repository['id'],
                'name' => $repository['name'],
                'url' => $repository['html_url'],
                'description' => $repository['description'],
                'language' => $repository['language'],
                'stars' => $repository['stargazers_count'],
                'created_at' => $repository['created_at'],
                'updated_at' => $repository['updated_at'],

            ];

            if ($withImage == true) {
                $readme_url = "https://api.github.com/repos/{$repository['owner']['login']}/{$repository['name']}/readme";

                $readme_data = $this->getApiData($readme_url);

                if (isset($readme_data['content'])) {
                    $readmeContent = base64_decode($readme_data['content']);
                    $owner = $repository['owner']['login'];
                    $repoName = $repository['name'];
                    $imgUrl = $this->extractFirstImageUrl($readmeContent, $owner, $repoName);

                    $projects[count($projects) - 1]['image'] = $imgUrl;
                }
            }
        }

        return $projects;
    }

    public function getPopularProjects($withImage = false){

    }

    /**
     * Fetch Lanuguages
     * @param int $projectId
     * @return array
     */
    public function getProjectLanguages($projectId)
    {

        $repositories = $this->getRepositories();
        foreach ($repositories ?? [] as $repository) {

            if ($repository['id'] == (int) $projectId) {
                $languages_url = $repository['languages_url'];

                $languages_data = $this->getApiData($languages_url);
                $total = array_sum($languages_data);
                $percentages = [];

                foreach ($languages_data as $key => $value) {
                    $percentages[$key] = round(($value / $total) * 100, 2);
                }

                return $percentages;
            }
        }
        return [];
    }

    function getRepositoryReadme($repoId)
    {

        $accessToken = env('GITHUB_PAT');

        $repositories = $this->getRepositories();

        foreach ($repositories as $repository) {
            if ($repository['id'] == $repoId) {
                $readme_url = "https://api.github.com/repos/{$repository['owner']['login']}/{$repository['name']}/readme";
                $readme_data = $this->getApiData($readme_url);

                if (isset($readme_data['content'])) {
                    $readmeContent = base64_decode($readme_data['content']);
                    $owner = $repository['owner']['login'];
                    $repoName = $repository['name'];
                    $readmeContent = $this->convertImageUrls($readmeContent, $owner, $repoName);

                    return $readmeContent;
                }
            }
        }
        return null;
    }

    function convertImageUrls($content, $owner, $repoName)
    {
        $baseUrl = "https://raw.githubusercontent.com/$owner/$repoName/main/";

        return preg_replace_callback('/<img\s+[^>]*src=["\']([^"\']+)["\']/i', function ($matches) use ($baseUrl) {
            $src = $matches[1];
            if (!preg_match('/^https?:\/\//', $src)) {
                $src = $baseUrl . ltrim($src, '/');
            }
            return str_replace($matches[1], $src, $matches[0]);
        }, $content);
    }

    private function extractFirstImageUrl($content, $owner, $repoName)
    {
        $baseUrl = "https://raw.githubusercontent.com/$owner/$repoName/main/";

        preg_match_all('/<img\s+[^>]*src=["\']([^"\']+)["\']/i', $content, $imgMatches);
        preg_match_all('/!\[[^\]]*\]\(([^)]+)\)/', $content, $mdMatches);

        $imageUrls = array_merge($imgMatches[1] ?? [], $mdMatches[1] ?? []);

        if (empty($imageUrls)) {
            return null;
        }

        $absoluteUrls = array_map(function ($url) use ($baseUrl) {
            return preg_match('/^https?:\/\//', $url) ? $url : $baseUrl . ltrim($url, '/');
        }, $imageUrls);

        $filteredImages = array_filter($absoluteUrls, fn($url) => stripos($url, 'oranbyte') !== false);

        return !empty($filteredImages) ? reset($filteredImages) : reset($absoluteUrls);
    }


    public function getProfileReadmeContent()
    {
        $githubUsername = env('GITHUB_USERNAME');
        $repoName = env('GITHUB_USERNAME');
        $readme_url = "https://api.github.com/repos/$githubUsername/$repoName/readme";

        $readme_data = $this->getApiData($readme_url);

        if (isset($readme_data['content'])) {
            $readmeContent = base64_decode($readme_data['content']);
            $readmeContent = $this->convertImageUrls($readmeContent, $githubUsername, $repoName);
            return $readmeContent;
        }
        return null;
    }

    public function getProjectById($projectId)
    {
        $repositories = $this->getRepositories();

        if (!$repositories) {
            throw new \Exception('Failed to fetch repositories');
        }
        foreach ($repositories as $repository) {
            if ($repository['id'] == $projectId) {

                $project = [
                    'id' => $repository['id'],
                    'name' => $repository['name'],
                    'url' => $repository['html_url'],
                    'description' => $repository['description'],
                    'language' => $repository['language'],
                    'stars' => $repository['stargazers_count'],
                    'created_at' => $repository['created_at'],
                    'updated_at' => $repository['updated_at'],

                ];
                return $project;
            }
        }
        throw new \Exception('Project not found');
    }
}
