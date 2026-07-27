# BAD LAB — E-Commerce Platform

A full-featured e-commerce web application for **BAD LAB** men's grooming products (Bangladesh demo), built with Laravel 11 and a dark, brutalist brand aesthetic.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind-CDN-06B6D4?logo=tailwindcss&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?logo=alpinedotjs&logoColor=black)

---

## Features

### Storefront
- Dark-themed brand homepage with hero banner carousel, parallax sections and scroll animations
- Dynamic "Our Range" category grid (adaptive layout: 1 / 2 / 2+1 stacked)
- Category-wise product sections with interstitial brand content
- Product details with image gallery, variants, related / upsell / cross-sell products
- Live search with debounce, filters and sorting
- Cart & checkout (guest and authenticated flows)
- Wishlist, order history, order cancellation with stock restore
- Customer profile & address management

### Admin Panel
- Dashboard with sales/product/user stats
- Product management (CRUD, images, stock, flags)
- Category management (hierarchical, with images)
- Banner management

### Platform
- Email/phone + password authentication, role-based access (admin / customer / vendor)
- Social login scaffolding (Google, Facebook, Apple via Socialite)
- Stock tracking with decrement-on-order and restore-on-cancel
- Payment service layer with bKash gateway scaffolding
- Guest session service (cart/wishlist transfer on login)
- REST API via Laravel Sanctum

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 11, PHP 8.2+ |
| Frontend | Blade, Tailwind CSS (CDN), Alpine.js, Livewire |
| Database | MySQL / MariaDB |
| Auth | Laravel session auth + Sanctum (API) |
| Media | Spatie Media Library, custom upload service |
| Testing | Pest / PHPUnit |

---

## Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL / MariaDB

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/ShadmanAbir/Ecommerce-Badlab-.git
cd Ecommerce-Badlab-

# 2. Install dependencies
composer install

# 3. Environment setup
copy .env.example .env
php artisan key:generate

# 4. Configure the database in .env
# DB_DATABASE=badlab_ecom
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 5. Migrate & seed
php artisan migrate --seed

# 6. Link storage
php artisan storage:link

# 7. Run
php artisan serve
```

- Storefront: `http://127.0.0.1:8000`
- Admin panel: `http://127.0.0.1:8000/admin/dashboard`

### Running Tests

```bash
php artisan test
```

---

## Project Structure

```
app/
├── Helpers/            # ImageHelper (storage_asset)
├── Http/
│   ├── Controllers/
│   │   ├── Admin/      # Dashboard, Products, Categories, Banners
│   │   ├── Auth/       # Login, Register
│   │   ├── Shop/       # Products, Cart, Checkout
│   │   └── User/       # Customer dashboard
│   └── Middleware/     # AdminMiddleware
├── Models/             # Product, Category, Order, Cart, User, ...
├── Services/           # Cart, Order, Payment, Guest, ImageUpload
│   └── PaymentGateways/# BkashService
└── ViewModels/         # ProductViewModel, CartViewModel

resources/views/
├── layouts/            # app, admin, header, footer
├── shop/               # index, product-details, category, cart, checkout, search
├── admin/              # dashboard, products, categories, banners
├── auth/               # login, register
└── user/               # dashboard
```

---

## Roadmap Status

### ✅ Completed
- [x] Core storefront (home, category, product details, search)
- [x] Cart & checkout flow (guest + authenticated)
- [x] Authentication (email/phone login, registration, roles)
- [x] Admin panel (products, categories, banners, dashboard)
- [x] Stock management with order decrement & cancel restore
- [x] Wishlist & order history
- [x] BAD LAB brand redesign (parallax, animations, dynamic category grid)
- [x] Unit & feature test suite (Pest)
- [x] Product variants & boolean product flags

### 🔄 In Progress
- [ ] Payment gateway integration (bKash service scaffolded, sandbox pending)
- [ ] Social login (Socialite wired, provider credentials pending)

### 📋 Planned
- [ ] Vendor / multi-seller module
- [ ] Coupons & discount engine
- [ ] Product reviews & ratings
- [ ] Email notifications (order confirmation, shipping)
- [ ] Blog & content pages (placeholders exist)
- [ ] Production asset pipeline (replace Tailwind CDN with Vite build)
- [ ] Deployment pipeline & environment hardening

---

## License

This is a demo/portfolio project. BAD LAB brand assets belong to their respective owners.
