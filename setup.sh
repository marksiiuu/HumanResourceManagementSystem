#!/bin/bash

# ============================================================
# HRMS Laravel Setup Script
# ============================================================
set -e

GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${BLUE}"
echo "  ╔═══════════════════════════════════════╗"
echo "  ║   HRMS — Human Resource Management   ║"
echo "  ║         Laravel 11 Setup              ║"
echo "  ╚═══════════════════════════════════════╝"
echo -e "${NC}"

# Check PHP
if ! command -v php &> /dev/null; then
    echo -e "${RED}✗ PHP not found. Install PHP 8.2+ first.${NC}"
    exit 1
fi

PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
echo -e "${GREEN}✓ PHP ${PHP_VERSION} found${NC}"

# Check Composer
if ! command -v composer &> /dev/null; then
    echo -e "${RED}✗ Composer not found. Install Composer first.${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Composer found${NC}"

# Install dependencies
echo -e "\n${BLUE}Installing PHP dependencies...${NC}"
composer install --no-interaction --prefer-dist

# Setup .env
if [ ! -f .env ]; then
    echo -e "\n${BLUE}Creating .env file...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✓ .env created${NC}"
fi

# Generate app key
echo -e "\n${BLUE}Generating application key...${NC}"
php artisan key:generate

# Prompt for DB credentials
echo -e "\n${YELLOW}Database Configuration${NC}"
read -p "DB Host [127.0.0.1]: " DB_HOST
DB_HOST=${DB_HOST:-127.0.0.1}
read -p "DB Port [3306]: " DB_PORT
DB_PORT=${DB_PORT:-3306}
read -p "DB Name [hrms_db]: " DB_NAME
DB_NAME=${DB_NAME:-hrms_db}
read -p "DB Username [root]: " DB_USER
DB_USER=${DB_USER:-root}
read -s -p "DB Password: " DB_PASS
echo

# Update .env
sed -i "s/DB_HOST=.*/DB_HOST=${DB_HOST}/" .env
sed -i "s/DB_PORT=.*/DB_PORT=${DB_PORT}/" .env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=${DB_NAME}/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=${DB_USER}/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=${DB_PASS}/" .env

echo -e "${GREEN}✓ Database credentials saved${NC}"

# Run migrations
echo -e "\n${BLUE}Running database migrations...${NC}"
php artisan migrate --seed --force

# Storage link
echo -e "\n${BLUE}Creating storage symlink...${NC}"
php artisan storage:link

# Create default avatar placeholder
mkdir -p public/images
echo -e "${GREEN}✓ Storage configured${NC}"

# Cache config for production
echo -e "\n${BLUE}Optimizing application...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo -e "\n${GREEN}"
echo "  ╔═══════════════════════════════════════╗"
echo "  ║          Setup Complete! 🎉            ║"
echo "  ╚═══════════════════════════════════════╝"
echo -e "${NC}"
echo -e "  Run: ${BLUE}php artisan serve${NC}"
echo -e "  URL: ${BLUE}http://localhost:8000${NC}"
echo ""
echo -e "  ${YELLOW}Demo Credentials:${NC}"
echo -e "  Admin:   admin@hrms.local / password"
echo -e "  HR:      hr@hrms.local / password"
echo -e "  Payroll: payroll@hrms.local / password"
echo ""
