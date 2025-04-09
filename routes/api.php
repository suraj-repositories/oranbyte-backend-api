<?php

use App\Http\Controllers\AppConfigController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\Github\GitHubController;
use App\Http\Controllers\Github\ProjectController;
use App\Http\Controllers\ProfessionalExperienceController;
use App\Http\Controllers\UserController;
use App\Models\Education;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::apiResource('educations', EducationController::class);
Route::apiResource('experience', ProfessionalExperienceController::class);
Route::apiResource('app-configs', AppConfigController::class);
Route::apiResource('contact', ContactController::class);

Route::get('/admin', [UserController::class, 'admin']);
Route::get('/languages', [GitHubController::class, 'fetchLanguages']);

Route::get('/repositories', [GitHubController::class, 'fetchRepositories']);
Route::get('/projects', [ProjectController::class, 'fetchProjects']);
Route::get('/project/readme', [ProjectController::class, 'fetchProfileReadmeContent']);
Route::get('/projects/popular', [ProjectController::class, 'fetchPopularProjects']);
Route::get('/project/{id}', [ProjectController::class, 'fetchProjectById']);
Route::get('/project/{id}/languages', [ProjectController::class, 'fetchProjectLanguages']);
Route::get('/project/{id}/readme', [ProjectController::class, 'fetchReadmeContent']);

