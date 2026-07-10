## About The Project

This is a modern Laravel website that allows users to organize and plan their ideas. This is a project recreation from the [Laravel From Scratch (2026 Edition)](https://laracasts.com/series/laravel-from-scratch-2026) series.

The project is optimized for two distinct environments:
- **Local Development:** Using [Laravel Herd](https://herd.laravel.com/) for a fast, local development experience.
- **Production Deployment:** Containerized using **Docker** and **Nginx**, specifically tailored for deployment on [Render](https://render.com/).

## Motivation
This project serves to teach and enhance my understanding of the Laravel framework, PHP 8.5, and modern development environments, while following industry best practices.

### Tech Stack

#### Core Frameworks
- **Backend:** PHP 8.5 & [Laravel 13.17](https://laravel.com/docs)
- **Frontend:** [Tailwind CSS 4.3](https://tailwindcss.com/) & [Alpine.js 3.15](https://alpinejs.dev/)
- **Build Tool:** [Vite](https://vitejs.dev/)
- **Testing:** [Pest 4.7](https://pestphp.com/)

#### Infrastructure & Tools
**Server** 
- Local Development: [Laravel Herd](https://herd.laravel.com/) 
- Production Development: [Docker](https://www.docker.com/) & [Nginx](https://www.nginx.com/)
**Hosting** 
- [Render](https://render.com/)
**Database**
- MySQL (via [Aiven](https://aiven.io/))
**DB Management**
- [Beekeeper Studio](https://www.beekeeperstudio.io/)
**File Storage** 
- [AWS S3](https://aws.amazon.com/s3/)

---

## Getting Started

### Local Development (Herd)

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/Hyper-Intelligent-Monkey/Idea-laravel.git
    cd idea-project
    ```
2.  **Install Dependencies:**
    ```bash
    composer install
    npm install
    ```
3.  **Database Setup:**
    - Create a MySQL database in your local environment or on Aiven.
    - Update the `DB_*` variables in your `.env` file.
    - Run migrations:
      ```bash
      php artisan migrate
      ```
4.  **Compile Assets:**
    ```bash
    npm run dev
    ```
6.  **Access the site:** If using Herd, make sure it is running in the background.
    - Go to project directory.
    - Open terminal on project.
    - Run herd:
    ```bash
      herd link
      ```

---

## Production Deployment (Render)

This project uses a multi-stage **Dockerfile** and a custom **Nginx** configuration (`.docker/nginx.conf`) for production.

### Render Configuration
1.  **Runtime:** Select **Docker**.
2.  **Environment Variables:** Configure these in the Render Dashboard:
    - `APP_ENV`: `production`
    - `APP_DEBUG`: `false`
    - `APP_KEY`: (Generate locally with `php artisan key:generate --show`)
    - `DB_CONNECTION`: `mysql`
    - `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: (From your Aiven MySQL console)
    - `FILESYSTEM_DISK`: `s3`
    - `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`: (From your AWS S3 Console)
3.  **Build:** Render will automatically use the `Dockerfile` in the root directory.

### Persistent Storage (AWS S3)
Unlike standard VPS deployments, this project is designed for **stateless deployment** on Render. Instead of using Render's local disk or persistent disks, it uses **AWS S3** for all user-uploaded images. This ensures:
- **Scalability:** Images are served independently of the application server.
- **Persistence:** Uploaded content is never lost when the Render container restarts or redeploys.

---

## Agentic Development

This project is optimized for AI coding agents (Model Context Protocol). It includes [Laravel Boost](https://github.com/laravel/boost) to provide specialized tools and context for agents like Cline, Cursor, and GitHub Copilot.

```bash
php artisan boost:mcp
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contact

Vinn Runkee Cañares - https://www.linkedin.com/in/vinn-runkee-ca%C3%B1ares-053867414 - vinnrunkee.c@gmail.com  
Project Link: https://idea-set.onrender.com
