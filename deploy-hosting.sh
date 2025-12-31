#!/bin/bash
# ==================================================================
# SCRIPT DEPLOYMENT WALKATWALLCLOUDS
# ==================================================================
# Script untuk deploy dan fix live search di hosting
# Jalankan dengan: bash deploy-hosting.sh
# ==================================================================

echo ""
echo "╔════════════════════════════════════════════════════════════╗"
echo "║     DEPLOYMENT SCRIPT - WALK AT WALL CLOUDS                ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_info() {
    echo -e "${BLUE}ℹ ${NC}$1"
}

print_success() {
    echo -e "${GREEN}✓${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

print_error() {
    echo -e "${RED}✗${NC} $1"
}

print_step() {
    echo ""
    echo -e "${BLUE}═══════════════════════════════════════════════════════${NC}"
    echo -e "${BLUE}  $1${NC}"
    echo -e "${BLUE}═══════════════════════════════════════════════════════${NC}"
}

# ==================================================================
# STEP 1: Update Code
# ==================================================================
print_step "STEP 1: Update Code dari Repository"

if [ -d ".git" ]; then
    print_info "Pulling latest code from git..."
    git pull origin dev
    if [ $? -eq 0 ]; then
        print_success "Code updated successfully"
    else
        print_error "Failed to pull code. Please check git status."
        read -p "Continue anyway? (y/n): " continue
        if [ "$continue" != "y" ]; then
            exit 1
        fi
    fi
else
    print_warning "Not a git repository. Skipping git pull."
fi

# ==================================================================
# STEP 2: Install Dependencies
# ==================================================================
print_step "STEP 2: Install/Update Dependencies"

if command -v composer &> /dev/null; then
    print_info "Running composer install..."
    composer install --optimize-autoloader --no-dev
    if [ $? -eq 0 ]; then
        print_success "Composer packages installed"
    else
        print_error "Composer install failed"
        exit 1
    fi
else
    print_error "Composer not found. Please install composer first."
    exit 1
fi

# ==================================================================
# STEP 3: Build Frontend Assets
# ==================================================================
print_step "STEP 3: Build Frontend Assets"

if command -v npm &> /dev/null; then
    print_info "Installing npm packages..."
    npm install
    
    print_info "Building assets..."
    npm run build
    
    if [ -d "public/build" ]; then
        print_success "Assets built successfully"
    else
        print_error "Build failed - public/build directory not found"
        exit 1
    fi
else
    print_warning "npm not found. Skipping asset build."
    print_warning "Please build assets locally and upload public/build folder"
fi

# ==================================================================
# STEP 4: Environment Configuration
# ==================================================================
print_step "STEP 4: Check Environment Configuration"

if [ -f ".env" ]; then
    print_success ".env file exists"
    
    print_warning "Please verify these settings in your .env file:"
    echo ""
    echo "  APP_ENV=production"
    echo "  APP_DEBUG=false"
    echo "  APP_URL=https://your-domain.com"
    echo ""
    echo "  DB_CONNECTION=mysql"
    echo "  DB_HOST=localhost"
    echo "  DB_DATABASE=your_database"
    echo "  DB_USERNAME=your_username"
    echo "  DB_PASSWORD=your_password"
    echo ""
    echo "  SESSION_DRIVER=database"
    echo "  SESSION_SECURE_COOKIE=true"
    echo "  SESSION_DOMAIN=.your-domain.com"
    echo ""
    
    read -p "Have you configured .env properly? (y/n): " env_configured
    if [ "$env_configured" != "y" ]; then
        print_warning "Please configure .env file first, then run this script again."
        exit 1
    fi
else
    print_error ".env file not found!"
    print_info "Copying from .env.example..."
    cp .env.example .env
    print_warning "Please edit .env file with your production settings"
    exit 1
fi

# ==================================================================
# STEP 5: Generate Application Key
# ==================================================================
print_step "STEP 5: Generate Application Key"

if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=\"\"" .env; then
    print_info "Generating application key..."
    php artisan key:generate --force
    print_success "Application key generated"
else
    print_info "Application key already exists"
fi

# ==================================================================
# STEP 6: Clear All Caches
# ==================================================================
print_step "STEP 6: Clear All Caches"

print_info "Clearing configuration cache..."
php artisan config:clear

print_info "Clearing route cache..."
php artisan route:clear

print_info "Clearing view cache..."
php artisan view:clear

print_info "Clearing application cache..."
php artisan cache:clear

print_info "Clearing compiled classes..."
php artisan clear-compiled

print_success "All caches cleared"

# ==================================================================
# STEP 7: Rebuild Caches
# ==================================================================
print_step "STEP 7: Rebuild Caches for Production"

print_info "Caching configuration..."
php artisan config:cache

print_info "Caching routes..."
php artisan route:cache

print_info "Caching views..."
php artisan view:cache

print_success "Caches rebuilt for production"

# ==================================================================
# STEP 8: Database Migration
# ==================================================================
print_step "STEP 8: Database Migration"

print_warning "This will run database migrations."
read -p "Continue with migration? (y/n): " run_migration

if [ "$run_migration" == "y" ]; then
    print_info "Running migrations..."
    php artisan migrate --force
    if [ $? -eq 0 ]; then
        print_success "Migrations completed"
    else
        print_error "Migration failed"
        exit 1
    fi
else
    print_warning "Skipped database migration"
fi

# ==================================================================
# STEP 9: Storage Link
# ==================================================================
print_step "STEP 9: Create Storage Symlink"

if [ -L "public/storage" ]; then
    print_info "Storage link already exists"
else
    print_info "Creating storage symlink..."
    php artisan storage:link
    print_success "Storage link created"
fi

# ==================================================================
# STEP 10: Set Permissions
# ==================================================================
print_step "STEP 10: Set File Permissions"

print_info "Setting permissions for storage..."
chmod -R 755 storage

print_info "Setting permissions for bootstrap/cache..."
chmod -R 755 bootstrap/cache

print_info "Setting writable permissions for logs..."
chmod -R 775 storage/logs

print_info "Setting writable permissions for cache..."
chmod -R 775 bootstrap/cache

print_success "Permissions set successfully"

# ==================================================================
# STEP 11: Optimize for Production
# ==================================================================
print_step "STEP 11: Final Optimization"

print_info "Optimizing autoloader..."
composer dump-autoload --optimize --no-dev

print_info "Running optimization command..."
php artisan optimize

print_success "Application optimized for production"

# ==================================================================
# DEPLOYMENT COMPLETE
# ==================================================================
echo ""
echo "╔════════════════════════════════════════════════════════════╗"
echo "║                 DEPLOYMENT COMPLETED! ✓                    ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo ""

print_success "Deployment completed successfully!"
echo ""
print_info "Next Steps:"
echo "  1. Visit your website: https://your-domain.com"
echo "  2. Login to admin panel: https://your-domain.com/admin/dashboard"
echo "  3. Test live search functionality"
echo "  4. Check browser console (F12) for any JavaScript errors"
echo ""

print_warning "Testing Commands:"
echo "  • Test search endpoint:"
echo "    curl https://your-domain.com/admin/search?q=test"
echo ""
echo "  • Check Laravel logs:"
echo "    tail -f storage/logs/laravel.log"
echo ""
echo "  • Test database connection:"
echo "    php artisan tinker"
echo "    >>> App\\Models\\User::first()"
echo ""

print_info "If you encounter issues:"
echo "  - Check storage/logs/laravel.log for errors"
echo "  - Verify .env configuration"
echo "  - Check browser console for JavaScript errors"
echo "  - Ensure public/build folder is uploaded"
echo ""

print_success "Happy coding! 🚀"
echo ""
