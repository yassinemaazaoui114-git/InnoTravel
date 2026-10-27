<p align="center">
  <img src="public/frontoffice/images/InnoTravelLOGO.png" alt="InnoTravel" width="160">
</p>

# InnoTravel

InnoTravel is a travel platform for Tunisia: travellers plan trips, discover events, book hotels,
reserve vehicles and share stories, while administrators run everything from a back office.

It was built as a **team project for the PIDEV course (Projet Intégré de Développement) at
[Esprit School of Engineering](https://esprit.tn), 2025**, with Symfony 6.4.

> **About this repository.** This is an enhanced, cleaned-up version maintained by Yassine Maazaoui.
> The original team repository is
> [oumaymasaddouri/InnoTravel-PiDev-Symfony](https://github.com/oumaymasaddouri/InnoTravel-PiDev-Symfony).
> This version fixes the security issues listed below, updates dependencies, removes committed
> secrets and user uploads, and makes the project installable from scratch.

## Screenshots

| Front office | |
|---|---|
| ![Home](docs/screenshots/home.png) | ![Events](docs/screenshots/events.png) |
| ![Hotels](docs/screenshots/hotels.png) | ![Transport](docs/screenshots/transport.png) |
| ![Blog](docs/screenshots/blog.png) | |

| Back office | |
|---|---|
| ![Admin dashboard](docs/screenshots/admin-dashboard.png) | ![Transport management](docs/screenshots/admin-transport.png) |
| ![Events management](docs/screenshots/admin-events.png) | |

<sub>Screenshots use local demo data.</sub>

## Features

**Accounts**
- Registration with profile picture and country-specific phone validation, login, account editing and deletion
- Password reset by a 6-digit code sent by email
- Admin user management: list, statistics, ban/unban, delete (plus an EasyAdmin user CRUD)

**Trips & itineraries**
- Travellers create trips (dates, budget, status) and attach itineraries chosen from a catalogue
- Admins manage all trips and the itinerary catalogue; trip statistics page
- Email notification to the admin when a trip is created

**Events**
- Event catalogue with category filters, organizers and event detail pages
- Event participation with ticket codes, cancellation, and ticket verification for admins
- Admin event and organizer management; optional AI-generated event descriptions (Hugging Face)

**Hotels & bookings**
- Hotel catalogue with search, price filters, sorting, SEO-friendly slugs and currency conversion
- Bookings paid in cash or by card through Stripe Checkout (with webhook), PDF invoices (Dompdf)
- Admin hotel and booking management with charts

**Transport & reservations**
- Vehicle catalogue (car, taxi, minibus, truck) with search and filters
- Users reserve a vehicle, edit or cancel the reservation and download a PDF ticket (Dompdf)
- Admin vehicle management with image upload and statistics; reservation management with a status workflow

**Blog & community**
- Posts with images, comments with mentions, and reactions
- Admin moderation of posts and comments
- Feedback form with an admin analytics page

**Travel assistant**
- Chatbot widget backed by Google Gemini

## Tech stack

| Layer | Technologies |
|---|---|
| Backend | PHP 8.2, Symfony 6.4 LTS, Doctrine ORM 3, Symfony Security, Messenger, Mailer |
| Admin | AdminLTE 3, EasyAdmin 4 |
| Frontend | Twig, Bootstrap, Webpack Encore, Stimulus / Symfony UX (Chart.js, Turbo) |
| Database | MySQL 8 / MariaDB 10.4+ |
| Libraries | VichUploader, KnpPaginator, Gedmo (slugs), Dompdf, Endroid QR Code, Stripe PHP |
| External APIs (optional) | Google Gemini, Stripe, Hugging Face Inference, exchangerate.host |

## Getting started (Windows + XAMPP)

### Prerequisites

- [XAMPP 8.2](https://www.apachefriends.org/) (PHP 8.2 + MariaDB), e.g. `winget install ApacheFriends.Xampp.8.2`
- [Composer 2](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) 18+ and npm
- In `C:\xampp\php\php.ini`, enable `extension=intl`, `extension=gd`, `extension=zip` and `extension=sodium`

### Install

```bash
git clone https://github.com/yassinemaazaoui114-git/InnoTravel.git
cd InnoTravel

composer install
npm install
npm run build          # or: npm run dev
```

### Configure

Copy the template twice. `.env` holds non-secret defaults; `.env.local` holds your real values
and is git-ignored. Never commit it.

```bash
cp .env.example .env
cp .env.example .env.local
```

In `.env.local`, set at least:

```dotenv
APP_SECRET=<32 random hex characters>
DATABASE_URL="mysql://innotravel:<password>@127.0.0.1:3306/innotravel?serverVersion=10.4.32-MariaDB&charset=utf8mb4"
MAILER_DSN=null://null              # or smtp://127.0.0.1:1025 with a local catcher such as Mailpit
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD=<12+ characters>
```

### Database

Start MySQL from the XAMPP control panel, create a database user, then:

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load            # countries, Tunisian events and organizers
php bin/console app:add-tunisia-itineraries       # optional demo itineraries
php bin/console app:insert-tunisia-posts          # optional demo blog posts
php bin/console app:create-admin                  # admin account from ADMIN_EMAIL / ADMIN_PASSWORD
```

### Run

```bash
php -S 127.0.0.1:8000 -t public     # or: symfony server:start
```

Open <http://127.0.0.1:8000/login>. The back office is at `/admin/dashboard`.

### Optional API keys

Every key goes in `.env.local`. Without one, the app still runs and the feature degrades as described:

| Variable | Feature | Without a real key |
|---|---|---|
| `GEMINI_API_KEY` | Travel chatbot | The chatbot returns no answer |
| `STRIPE_SECRET_KEY`, `STRIPE_PUBLISHABLE_KEY`, `STRIPE_WEBHOOK_SECRET` | Card payments for bookings | Card payment fails; cash bookings still work |
| `HUGGINGFACE_API_KEY` | AI event descriptions | A built-in template description is used |
| `CURRENCY_API_KEY` | Live exchange rates | Built-in fallback rates are used |
| `MAILER_DSN` | All emails (reset codes, notifications, tickets) | With `null://null`, emails are discarded |

## Team & credits

InnoTravel was designed and built by six students. Each member developed their modules on their
own branch, and the modules were then integrated into `main`.

| Member | Modules |
|---|---|
| **Aziz Messaoud** | Hotels (catalogue, filters, slugs, currency conversion), bookings with Stripe Checkout and PDF invoices, feedback, user management (EasyAdmin, traveller statistics), and the final integration of all modules |
| **Oumayma Saddouri** | Initial project setup, trips & itineraries (traveller trip planner and admin management), Gemini travel chatbot, email notifications |
| **Eya Laourine** | Blog: posts, comments, reactions and admin moderation |
| **Ranim Ben Salem** | Events and organizers |
| **Fares Ben Kacem** | Team member |
| **Yassine Maazaoui** | Transport and reservations: vehicle catalogue, front-office and admin CRUDs for vehicles and reservations, reservation PDF tickets, QR code service, back-office layout. Maintainer of this enhanced version |

Features that first appear in the integrated `main` branch, such as event participations,
ticket verification and feedback analytics, have no separate branch history.

## Security improvements in this version

- **No secrets in the repository.** Hardcoded API keys, SMTP credentials and app secrets were moved to
  environment variables (`.env.local`, git-ignored) with placeholders in `.env.example`.
- **Admin authentication goes through Symfony Security.** Admins are regular users with `ROLE_ADMIN`
  and a hashed password. The plaintext admin password check, its hardcoded fallback and the
  session-flag "admin" voter were removed.
- **Back office locked down.** An `access_control` rule now requires `ROLE_ADMIN` for every `/admin`
  route, and `#[IsGranted]` was added to controllers that had no check.
- **Safe file uploads.** Profile pictures, blog, event and organizer images must be real JPEG, PNG,
  WebP or GIF images under 2 MB. They are stored under random names whose extension comes from the
  detected MIME type, never the client filename. `public/uploads/.htaccess` blocks script and HTML
  files under Apache.
- **CSRF protection on destructive actions.** Deleting users, accounts, trips, itineraries and
  feedback now requires `POST` with a CSRF token, and user deletion also requires an admin.
- **Password reset hardened.** Codes are stored hashed, expire after 10 minutes and allow 5 attempts,
  and the form no longer reveals whether an email is registered.
- **Dependencies updated.** Symfony 6.4.48, Twig 3.30, EasyAdmin 4.29, Dompdf 3.1.6 and Doctrine ORM 3.7: `composer audit`
  went from 50 advisories (1 critical, 13 high) to 0. `npm audit` went from 25 to 6, all in
  build-time tooling.
- **Repository cleanup.** Removed committed user uploads, unused AdminLTE demo files and source
  maps (the checkout went from 2,886 files / 140 MB to 880 files / 41 MB), and replaced 8
  inconsistent migrations with one baseline migration.

## Known limitations

- Reservation module (fix in progress):
  - opening `/reservation/new` when no vehicle is active creates a "Demo Car" in the database;
  - the back-office reservation statistics page (`/admin/reservation/statistics`) returns an error;
  - the back-office "new reservation" page (`/admin/reservation/new`) returns an error.
- The event category filter (`/events/category/{id}`) returns an error.
- Event participation QR codes use the retired Google Charts API, so the QR images don't render.
- The project uses both AssetMapper and Webpack Encore configuration; templates use Encore.

## License

The InnoTravel team's code is released under the [MIT License](LICENSE). Third-party assets
(AdminLTE, the front-office HTML theme, fonts and icons) remain under their own licenses.
