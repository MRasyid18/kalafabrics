<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\B2bDonationController;
use App\Http\Controllers\Api\B2bOrderController;
use App\Http\Controllers\Api\PointsController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\WorkshopController;
use App\Http\Controllers\Api\VolunteerController;
use App\Http\Controllers\Api\Admin\UserManagementController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\ImpactMetricController;

Route::prefix('v1')->group(function () {
    // Public Routes
    Route::get('/public/products', [ProductController::class, 'index']);
    Route::get('/public/products/{product}', [ProductController::class, 'show']);
    Route::get('/public/categories', [CategoryController::class, 'index']);
    Route::get('/public/leaderboard', [LeaderboardController::class, 'index']);
    Route::get('/public/impact-metrics', [ImpactMetricController::class, 'show']);
    Route::get('/public/workshops', [WorkshopController::class, 'index']);

    // Authentication Routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/auth/roles', [AuthController::class, 'getValidRoles']);

    // Protected Routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);

        // B2C Member Routes
        Route::middleware('api.role:b2c,admin')->group(function () {
            Route::apiResource('/orders', OrderController::class);
            Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice']);
            Route::get('/my-points', [PointsController::class, 'show']);
            Route::get('/workshops', [WorkshopController::class, 'userWorkshops']);
            Route::post('/workshops/{workshop}/register', [WorkshopController::class, 'register']);
            Route::delete('/workshops/{workshop}/unregister', [WorkshopController::class, 'unregister']);
        });

        // B2B Member Routes
        Route::middleware('role:b2b,admin')->group(function () {
            Route::get('/b2b/profile', [B2bDonationController::class, 'getProfile']);
            Route::post('/b2b/profile', [B2bDonationController::class, 'updateProfile']);
            Route::apiResource('/donations', B2bDonationController::class);
            Route::apiResource('/b2b-orders', B2bOrderController::class);
            Route::get('/b2b-orders/{order}/invoice', [B2bOrderController::class, 'invoice']);
            Route::get('/b2b/points-leaderboard', [LeaderboardController::class, 'b2bLeaderboard']);
        });

        // Ranger Routes
        Route::middleware('role:ranger,admin')->group(function () {
            Route::get('/volunteer-tasks', [VolunteerController::class, 'getTasks']);
            Route::post('/volunteer-tasks/{task}/assign', [VolunteerController::class, 'assignTask']);
            Route::post('/volunteer-tasks/{task}/complete', [VolunteerController::class, 'completeTask']);
            Route::get('/my-assignments', [VolunteerController::class, 'myAssignments']);
        });

        // Admin Routes
        Route::middleware('role:admin')->group(function () {
            Route::prefix('/admin')->group(function () {
                Route::apiResource('/users', UserManagementController::class);
                Route::post('/users/{user}/verify-b2b', [UserManagementController::class, 'verifyB2b']);
                Route::post('/users/{user}/reject-b2b', [UserManagementController::class, 'rejectB2b']);

                Route::get('/dashboard', [DashboardController::class, 'index']);

                Route::apiResource('/impact-metrics', ImpactMetricController::class);
                Route::post('/impact-metrics/update', [ImpactMetricController::class, 'update']);

                // Waste verification
                Route::get('/donations', [B2bDonationController::class, 'allDonations']);
                Route::post('/donations/{donation}/verify', [B2bDonationController::class, 'verifyDonation']);
                Route::post('/donations/{donation}/reject', [B2bDonationController::class, 'rejectDonation']);

                // Product management
                Route::apiResource('/products', ProductController::class);
                Route::apiResource('/categories', CategoryController::class);

                // Workshop management
                Route::apiResource('/workshops', WorkshopController::class);

                // Volunteer task management
                Route::apiResource('/volunteer-tasks', VolunteerController::class);
            });
        });

        // Common routes (all authenticated users)
        Route::get('/profile', [AuthController::class, 'me']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::post('/profile/change-password', [AuthController::class, 'changePassword']);
    });
});
