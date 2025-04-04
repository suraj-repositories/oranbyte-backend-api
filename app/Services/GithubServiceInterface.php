<?php
namespace App\Services;

interface GithubServiceInterface
{
    public function getApiData($url);

    public function getAllLanguages();
    public function getRepositories();
    public function generateGitHubJWT($appId, $privateKeyPath);
    public function convertImageUrls($content, $owner, $repoName);

    public function getProjects($withImage = false);
    public function getPopularProjects($size = 5, $withImage = false);
    public function getProjectById($projectId);
    public function getProjectLanguages($projectId);
    public function getRepositoryReadme($repoId);
    public function getProfileReadmeContent();



    // public function getRepositoryDetails($accessToken, $username, $repoName);
    // public function getRepositoryLanguages($accessToken, $username, $repoName);
    // public function getRepositoryContributors($accessToken, $username, $repoName);
    // public function getRepositoryCommits($accessToken, $username, $repoName);
    // public function getRepositoryBranches($accessToken, $username, $repoName);
    // public function getRepositoryPullRequests($accessToken, $username, $repoName);
}
