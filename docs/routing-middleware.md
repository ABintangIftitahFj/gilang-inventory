# Route Definitions & Middleware Documentation

## Overview

This document provides information about the route definitions and middleware implemented for the Inventory Management System. It outlines the authentication, authorization, and data validation systems implemented to secure the application.

## Web Routes

Web routes are defined in `routes/web.php` and are organized as follows:

### Public Routes

-   **Welcome Page**: '/' - The main landing page, no authentication required.

### Protected Routes (authentication required)

-   **Dashboard**: '/dashboard' - Main dashboard for authenticated users.
-   **Barcode Scanning**: '/scan' - Interface for scanning product barcodes.
-   **Section Views**: '/section/product' - Product section view.

### Inventory Management Routes (authentication + inventory.access middleware)

-   **Products Management**: CRUD operations for products.
-   **Transactions Management**: CRUD operations for transactions.
-   **Stock Levels**: '/inventory/stock-levels' - View current stock levels.
-   **Activity Log**: '/inventory/activity-log' - View transaction activity logs.

### Admin Routes (authentication + admin.access middleware)

-   **User Management**: '/admin/users' - Manage system users.
-   **System Settings**: '/admin/settings' - Configure system settings.
-   **Admin Logs**: '/admin/logs' - View system logs.

## API Routes

API routes are defined in `routes/api.php` and are protected by Sanctum authentication. They follow a standard structure:

### Public API Endpoints

-   Authentication endpoints for registration and login.

### Protected API Endpoints (Sanctum auth required)

-   **Product Endpoints**: CRUD operations for products via API.
-   **Transaction Endpoints**: CRUD operations for inventory transactions.
-   **Inventory Endpoints**: Stock levels, activity logs, and barcode scanning functionality.

## Middleware

### Core Middleware

-   **Authentication (`auth`)**: Handles user authentication across the application.
-   **API Authentication (`auth:sanctum`)**: Handles API token authentication via Laravel Sanctum.

### Custom Middleware

1. **InventoryAccess (`inventory.access`)**:

    - Controls access to inventory management features.
    - Ensures user is authenticated and has appropriate permissions.

2. **AdminAccess (`admin.access`)**:

    - Controls access to administrative features.
    - Ensures user is authenticated and has admin privileges.

3. **ApiRateLimiter (`api.rate.limit`)**:

    - Implements rate limiting for API requests.
    - Prevents abuse by limiting the number of requests per minute.

4. **ValidateApiAuthentication (`api.auth`)**:

    - Extends Sanctum authentication with additional validation.
    - Adds user information to request headers for logging.

5. **ValidateInventoryData (`inventory.data`)**:
    - Validates inventory-related data before processing.
    - Ensures barcode formats, measurements, and transaction details meet business requirements.

### Middleware Groups

1. **Web Middleware (`web`)**:

    - Standard Laravel web middleware stack.
    - Includes session handling, CSRF protection, etc.

2. **API Middleware (`api`)**:

    - API-focused middleware stack.
    - Includes Sanctum stateful authentication, rate limiting, etc.

3. **Inventory API Middleware (`inventory.api`)**:
    - Specialized middleware for inventory API endpoints.
    - Includes authentication, data validation, and rate limiting.

## Authentication Flow

1. **Web Authentication**:

    - Users log in through the standard Laravel authentication system.
    - Session-based authentication maintains user state.

2. **API Authentication**:
    - Users receive a token via login endpoint.
    - Token is included in subsequent requests in the Authorization header.
    - Tokens can have specific abilities for fine-grained access control.

## Implementation Details

-   Authentication is implemented using Laravel's native authentication system and Laravel Sanctum for API authentication.
-   Middleware are registered in `app/Http/Kernel.php`.
-   Route configurations are defined in `routes/web.php` and `routes/api.php`.
-   Rate limiting is configured in `app/Providers/RouteServiceProvider.php`.
